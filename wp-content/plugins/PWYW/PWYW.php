<?php
/*
  Plugin Name: PWYW
  Plugin URI: http://www.filmbundle.com
  Description: Plugin to allow users to pay what they want.
  Version: 0.1
  Author: OniWorks
  Author URI: http://www.oniworks.com
 */

//init code
//add_action('admin_init', 'PWYW_init1');

class pwyw {

    public function __construct() {
        global $wpdb;
        register_activation_hook(__FILE__, array(&$this, 'pwyw_install'));
        register_deactivation_hook(__FILE__, array(&$this, 'pwyw_uninstall'));
        
        //$wpdb->query("UPDATE `wp_pwyw_customers` SET `alias` = 'Anonymous' WHERE `alias` = 'Annonymous'");

        add_action("init", array(&$this, "PWYW_init"));
        add_action('admin_menu', array(&$this, 'PWYW_menu_pages'));
        add_action('pmpro_added_order', array(&$this, 'pwyw_add_payment'));
        add_action('wp_ajax_pwyw_bundle_update', array(&$this, 'pwyw_bundle_update'));

        $this->plugin_url = trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
        $this->plugin_name = plugin_basename(__FILE__);
        $this->bundles = $wpdb->prefix . "pwyw_bundles";
        $this->categories = $wpdb->prefix . "pwyw_categories";
        $this->bundle_categories = $wpdb->prefix . "pwyw_bundle_categories";
        $this->payment_info = $wpdb->prefix . "pwyw_payment_info";
        $this->price_allocation = $wpdb->prefix . "pwyw_price_allocation";
        $this->users = $wpdb->prefix . "pwyw_customers";
    }

    function pwyw_install() {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        if ($wpdb->get_var("SHOW TABLES LIKE '{$this->bundles}'") != $this->bundles) {
            $sql = "CREATE TABLE " . $this->bundles . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `title` varchar(255) NOT NULL ,
             `suggested_val_1` float(10,2),
             `suggested_val_2` float(10,2),
             `suggested_val_3` float(10,2),
             `pwyw_val` float(10,2),
             `order` mediumint(9),
             `belowaverage` mediumint(9),
             `aboveaverage` mediumint(9),
             `activated` smallint(1),
             UNIQUE KEY id (id)
             );";


            dbDelta($sql);

            if ($wpdb->get_var("SHOW TABLES LIKE '{$this->payment_info}'") != $this->payment_info) {
                $sql = "CREATE TABLE " . $this->payment_info . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `cid` mediumint(9) ,
             `order_id` mediumint(9),
             `sum` float(10,2),
             `average_price` float(10,2),
             `bundle` mediumint(9),
             `bundle_level` mediumint(9),
             `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }

            if ($wpdb->get_var("SHOW TABLES LIKE '{$this->users}'") != $this->users) {
                $sql = "CREATE TABLE " . $this->users . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `cid` mediumint(9) ,
             `is_twitter` smallint(1) DEFAULT 0,
             `alias` varchar(250),
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }

            if ($wpdb->get_var("SHOW TABLES LIKE '{$this->price_allocation}'") != $this->price_allocation) {
                $sql = "CREATE TABLE " . $this->price_allocation . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `payment_id` mediumint(9) ,
             `cat_id` mediumint(9),
             `bundle` mediumint(9),
             `allocate_percent` int(3),
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }

            if ($wpdb->get_var("SHOW TABLES LIKE '{$this->categories}'") != $this->categories) {
                $sql = "CREATE TABLE " . $this->categories . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `title` varchar(255) NOT NULL ,
             `parent` mediumint(3)DEFAULT 0,
             `order` mediumint(3),
              UNIQUE KEY id (id)
             );";

                dbDelta($sql);

                $wpdb->insert($this->categories, array('title' => 'Filmmakers',
                    'parent' => 0,
                    'order' => 1));

                $wpdb->insert($this->categories, array('title' => 'Charities',
                    'parent' => 0,
                    'order' => 2));

                $wpdb->insert($this->categories, array('title' => 'Bundle',
                    'parent' => 0,
                    'order' => 3));
            }



            if ($wpdb->get_var("SHOW TABLES LIKE '{$this->bundle_categories}'") != $this->bundle_categories) {
                $sql = "CREATE TABLE " . $this->bundle_categories . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `cat_id` mediumint(9) ,
             `bundle_id` mediumint(9),
             `val` mediumint(3) DEFAULT 0,
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }
        }
    }

    function pwyw_uninstall() {
        global $wpdb;

        $sql = "DROP TABLE " . $this->bundles . "";
        $k = $wpdb->query($sql);

        $sql = "DROP TABLE " . $this->categories . "";
        $k = $wpdb->query($sql);

        $sql = "DROP TABLE " . $this->bundle_categories . "";
        $k = $wpdb->query($sql);

        $sql = "DROP TABLE " . $this->payment_info . "";
        $k = $wpdb->query($sql);

        $sql = "DROP TABLE " . $this->price_allocation . "";
        $k = $wpdb->query($sql);

        $sql = "DROP TABLE " . $this->users . "";
        $k = $wpdb->query($sql);
    }

    function PWYW_init() {

        if (is_admin()) {
            wp_enqueue_style('dashboard');
            wp_enqueue_script('dashboard');
            wp_enqueue_script('PWYW_admin', plugins_url('/js/jquery.js', __FILE__), array(), "screen");
            wp_enqueue_script('PWYW_admin2', plugins_url('/js/jquery.ui.js', __FILE__), array(), "screen");
            wp_enqueue_script('PWYW_admin4', plugins_url('/js/jquery.linkedsliders.js', __FILE__), array(), "screen");
            wp_enqueue_script('popover', plugins_url('/js/jquery.popover-1.1.2.js', __FILE__), array(), "screen");
            wp_enqueue_style('PWYW_admin', plugins_url('/pwyw.css', __FILE__), array(), "screen");
        }
    }

    function PWYW_menu_pages() {
        // Add the top-level admin menu
        $page_title = 'PWYW Settings';
        $menu_title = 'PWYW';
        $capability = 'manage_options';
        $menu_slug = 'PWYW-settings';

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, array(&$this, 'pwyw_settings'));

        // Add submenu page with same slug as parent to ensure no duplicates
        $sub_menu_title = 'PWYW Settings';
        add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array(&$this, 'pwyw_settings'));

        // Now add the submenu page for Help
        $submenu_page_title = 'Customers';
        $submenu_title = 'Customers';
        $submenu_slug = 'PWYW-customers';
        $submenu_function = 'pwyw_customers';
        add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array(&$this, $submenu_function));
    }

    function get_all_payment_info() {
        global $wpdb;
                    
        $sql = "SELECT pi.`id` pid,c.`id` cid,c.`title`,pi.`sum` payment,c.`parent`,pa.`allocate_percent`
                    FROM {$this->payment_info} pi
                    LEFT JOIN {$this->price_allocation} pa ON pi.`id` = pa.`payment_id`
                    RIGHT JOIN {$this->categories} c ON pa.`cat_id` = c.`id`";

        $pwyw_categories = $wpdb->get_results($sql);

        foreach ($pwyw_categories as $category) {
            if ($category->parent == 0) {
                $cat_info = &$pwyw_category[$category->pid][$category->cid]['info'];
                $cat_info['title'] = $category->title;
                $cat_info['payment'] = $category->payment * $category->allocate_percent / 100;
            }
        }

        foreach ($pwyw_categories as $category) {

            if ($category->parent != 0) {
                $sub_info = &$pwyw_category[$category->pid][$category->parent]['sub'][$category->cid]['info'];
                $sub_info['title'] = $category->title;
                $sub_info['payment'] = $pwyw_category[$category->pid][$category->parent]['info']['payment'] * $category->allocate_percent / 100;
            }
        }

        return $pwyw_category;
    }

    function pwyw_get_bundle_info($bid = '') {
        global $wpdb;

        if (!empty($bid)) {
            $condition = $wpdb->prepare("WHERE `id` = %d", $bid);
        } else {
            $active = $wpdb->query("SELECT `id` FROM `{$this->bundles}` WHERE `activated` = 1 ");
            if (empty($active)) {
                $condition = 'WHERE `id` = 1';
            } else {
                $condition = 'WHERE `activated` = 1';
            }
        }

        $sql = "SELECT * FROM {$this->bundles} {$condition} LIMIT 1";

        $pwyw_bundle = $wpdb->get_results($sql);

        if (!empty($pwyw_bundle)) {
            $pwyw_bundle = $pwyw_bundle[0];

            $sql = "SELECT c.`id`,c.`title`,c.`order`,c.`parent`,bu_c.`val` FROM {$this->bundle_categories} bu_c
                     LEFT JOIN {$this->categories} c ON bu_c.`cat_id` = c.`id`
                     WHERE bu_c.`bundle_id` = {$pwyw_bundle->id}  GROUP BY c.`id`";

            // $price_allocation = $wpdb->get_results("SELECT `cat_id`,AVG(`allocate_percent`) percent FROM {$this->price_allocation} WHERE `bundle`= {$pwyw_bundle->id} GROUP BY `cat_id`");



            $pay = $wpdb->get_results("SELECT pi.`id` payment_id,pa.`cat_id` , pa.`allocate_percent` , pi.`sum` , c.`parent`
                    FROM `{$this->payment_info}` pi
                    LEFT JOIN `{$this->price_allocation}` pa ON pi.`id` = pa.`payment_id`
                    RIGHT JOIN  `{$this->categories}` c ON pa.`cat_id` = c.`id`
                    WHERE pa.`bundle` ={$pwyw_bundle->id}
                    ORDER BY pi.`id`,pa.`cat_id`");


            if (!empty($pay)) {

                foreach ($pay as $res) {

                    $payment[$res->cat_id] = (float) $res->sum * (int) $res->allocate_percent / 100;

                    if (!isset($cat_pay[$res->cat_id])) {
                        $cat_pay[$res->cat_id] = 0;
                        if ($res->parent == 0 && !isset($pay_total)) {
                            $pay_total[$res->cat_id] = 0;
                            $ind = $res->cat_id;
                        }
                    }
                    if ($res->parent == 0) {
                        if ($res->cat_id == $ind) {
                            $pay_total[$res->cat_id] += $res->sum;
                        }
                        $cat_pay[$res->cat_id] += $payment[$res->cat_id];
                    } else {
                        $cat_pay[$res->cat_id] += ($payment[$res->parent] * (int) $res->allocate_percent / 100);
                    }
                }
            }

            if (!empty($price_allocation)) {
                foreach ($price_allocation as $allocate) {
                    $price_a[$allocate->cat_id] = $allocate->percent;
                }
            }

            $pwyw_levels = $wpdb->get_results("SELECT l.`id`,l.`name` FROM {$wpdb->pmpro_membership_levels} l");

            $pwyw_payment_info = $wpdb->get_results("SELECT COUNT(`id`) as total_sales, SUM(`sum`) as total_payments, AVG(`sum`) as avg_price
                                                            FROM {$this->payment_info} WHERE `bundle` = {$pwyw_bundle->id} GROUP BY `bundle`");

           // $avg_q = "(SELECT AVG(`sum`)  FROM `{$this->payment_info}`  WHERE `bundle`={$pwyw_bundle->id}) ";

            $amount_q = "(SELECT SUM(`sum`) FROM  {$this->payment_info} WHERE cid = cu.`ID` AND `bundle` = {$pwyw_bundle->id})";

            $pwyw_top_contr = $wpdb->get_results("SELECT DISTINCT p.`cid`,cu.`display_name`,{$amount_q} amount,u.`alias`,u.`is_twitter`  FROM `wp_users` cu
                                                        RIGHT JOIN {$this->payment_info} p ON cu.`ID` = p.`cid`
                                                        LEFT JOIN {$this->users} u ON cu.`ID` = u.`cid`
                                                        WHERE p.`bundle` = {$pwyw_bundle->id}
                                                        GROUP BY p.`cid`
                                                        ORDER BY amount DESC LIMIT 10");

            foreach ($pwyw_top_contr as $top) {
                if (!empty($top->alias)) {
                    if ($top->is_twitter) {
                        $top->display_name = sprintf('<a target="_blank" href="http://twitter.com/%s">@%s</a>', $top->alias, $top->alias);
                    } else {
                        $top->display_name = $top->alias;
                    }
                }
                if (!isset($min_amount)) {
                    $min_amount = $top->amount;
                } elseif ($top->amount < $min_amount) {
                    $min_amount = $top->amount;
                }
            }
        }

        $pwyw_categoriees = $wpdb->get_results($sql);

        foreach ($pwyw_categoriees as $category) {
            if ($category->parent == 0) {
                $pwyw_category[$category->id]['info']['title'] = $category->title;
                $pwyw_category[$category->id]['info']['val'] = $category->val;
                $pwyw_category[$category->id]['info']['order'] = $category->order;
                if (!empty($price_a)) {
                    $pwyw_category[$category->id]['info']['allocate'] = (int) $price_a[$category->id];
                } else {
                    $pwyw_category[$category->id]['info']['allocate'] = (int) $category->val;
                }

                if (!empty($pwyw_payment_info)) {
                    $pwyw_category[$category->id]['info']['payment'] = $cat_pay[$category->id];
                } else {
                    $pwyw_category[$category->id]['info']['payment'] = 0;
                }
            }
        }

        $prev_id = '';

        foreach ($pwyw_categoriees as $category) {


            if ($category->parent != 0) {
                if (isset($curr_id) && $curr_id != $category->parent) {
                    $prev_id = $curr_id;
                    if (isset($js_line)) {
                        foreach ($js_line as $prev_cat) {
                            foreach ($prev_cat as $key => $data) {
                                $js_line[$category->parent][$key]['title'] = $data['title'];
                                $js_line[$category->parent][$key]['allocate'] = 0;
                            }
                        }
                    }
                }

                if (!empty($prev_id) && isset($js_line[$prev_id])) {
                    $js_line[$prev_id][$category->id]['title'] = $category->title;
                    $js_line[$prev_id][$category->id]['allocate'] = 0;
                }

                $pwyw_category[$category->parent]['sub'][$category->id]['info']['val'] = $category->val;
                $pwyw_category[$category->parent]['sub'][$category->id]['info']['title'] = $category->title;
                $pwyw_category[$category->parent]['sub'][$category->id]['info']['order'] = $category->order;
                if (!empty($price_a)) {
                    $pwyw_category[$category->parent]['sub'][$category->id]['info']['allocate'] = (int) $price_a[$category->id];
                } else {
                    $pwyw_category[$category->parent]['sub'][$category->id]['info']['allocate'] = (int) $category->val;
                }

                if (isset($cat_pay[$category->id])) {
                  //  var_dump($pay_total[$ind],$cat_pay[$category->id]);
                    $pwyw_category[$category->parent]['sub'][$category->id]['info']['payment'] = $cat_pay[$category->id];
                    $js_line[$category->parent][$category->id]['allocate'] = (int) (($cat_pay[$category->id]/$pay_total[$ind])*100);
                } else {
                    $pwyw_category[$category->parent]['sub'][$category->id]['info']['payment'] = 0;
                    $js_line[$category->parent][$category->id]['allocate'] = $category->val;
                }
//                if (!empty($category->allocate_percent)) {
                $js_line[$category->parent][$category->id]['title'] = $category->title;
                if (empty($pwyw_category[$category->parent]['info']['payment']) && !empty($pwyw_payment_info)) {
                    unset($js_line[$category->parent]);
                }

//                }

                $curr_id = $category->parent;
            }
        }

        $data = array();

        $data['categories'] = $pwyw_category;
        $data['bundle'] = $pwyw_bundle;
        $data['levels'] = $pwyw_levels;
        $data['payment_info'] = isset($pwyw_payment_info[0]) ? $pwyw_payment_info[0] : null;
        $data['top'] = $pwyw_top_contr;
        $data['min_amount'] = isset($min_amount) ? $min_amount : $pwyw_bundle->suggested_val_1;
        $data['js_line'] = isset($js_line) ? $js_line : null;

        return $data;
    }

    function pwyw_edit_bundle() {
        global $wpdb;

        if (isset($_REQUEST['activate'])) {
            $sql = "UPDATE {$this->bundles} SET `activated` = 0";
            $wpdb->query($sql);
            $pwyw_bundle_active = $_REQUEST['activate'];
        } else {
            $pwyw_bundle_active = 0;
        }
        $wpdb->query(
                $wpdb->prepare(
                        "
                    UPDATE {$this->bundles}
                        SET title = %s,
                            suggested_val_1 = %f,
                            suggested_val_2 = %f,
                            suggested_val_3 = %f,
                            pwyw_val = %f,
                            belowaverage = %d,
                            aboveaverage = %d,
                            activated = %d
                        WHERE id = %d
                     ", $_REQUEST['title'], $_REQUEST['suggested_val_1'], $_REQUEST['suggested_val_2'], $_REQUEST['suggested_val_3'], $_REQUEST['pwyw_val'], $_REQUEST['belowaverage'], $_REQUEST['aboveaverage'], $pwyw_bundle_active, $_REQUEST['bundle']
                )
        );

        foreach ($_REQUEST['parent_category_val'] as $key => $val) {
            $wpdb->query($wpdb->prepare("UPDATE {$this->bundle_categories} SET val = %d WHERE bundle_id = %d AND cat_id = %d", $val, $_REQUEST['bundle'], $key));

            if (isset($_REQUEST['pwyw_sub_val'][$key])) {
                foreach ($_REQUEST['pwyw_sub_val'][$key] as $s_key => $val) {
                    if (!empty($_REQUEST['pwyw_sub_name'][$key][$s_key])) {

                        $wpdb->query($wpdb->prepare("UPDATE {$this->categories} SET title = %s WHERE id = %d", $_REQUEST['pwyw_sub_name'][$key][$s_key], $s_key));
                        $wpdb->query($wpdb->prepare("UPDATE {$this->bundle_categories} SET val = %d WHERE bundle_id = %d AND cat_id = %d", $val, $_REQUEST['bundle'], $s_key));
                    }
                }
            }

            if (isset($_REQUEST['del_sub'])) {
                foreach ($_REQUEST['del_sub'] as $d_key => $val) {
                    if ($val) {
                        $wpdb->query($wpdb->prepare("DELETE FROM {$this->bundle_categories} WHERE bundle_id=%d AND cat_id=%d", $_REQUEST['bundle'], $d_key));
                    }
                }
            }

            if (isset($_REQUEST['pwyw_new_sub_val'][$key])) {
                foreach ($_REQUEST['pwyw_new_sub_val'][$key] as $s_key => $val) {
                    if (!empty($_REQUEST['pwyw_new_sub_val'][$key][$s_key])) {
                        $insert_cat = $wpdb->query($wpdb->prepare("INSERT INTO {$this->categories} (title,parent) VALUES (%s,%d)", $_REQUEST['pwyw_new_sub_name'][$key][$s_key], $key));

                        if ($insert_cat) {
                            $wpdb->query($wpdb->prepare("INSERT INTO {$this->bundle_categories} (cat_id,bundle_id,val) VALUES (%d,%d,%d)", $wpdb->insert_id, $_REQUEST['bundle'], $val));
                        }
                    }
                }
            }
        }

        screen_icon('options-general');
        ?>
        <h2><?php echo get_admin_page_title(); ?></h2>
        <a href="<?php echo sprintf('?page=%s&action=%s', $_REQUEST['page'], 'new'); ?>" class="add-new-h2">Add New Bundle </a>
        <?php
        require_once( ABSPATH . 'wp-content/plugins/PWYW/bundles.php' );

        $PWYWListTable = new PWYW_Bundles_List_Table();

        $PWYWListTable->prepare_items();
        $PWYWListTable->display();
    }

    function pwyw_view_bundle($id) {

        $pwyw_data = $this->pwyw_get_bundle_info($id);

        $pwyw_action = sprintf('?page=%s&action=%s&bundle=%s', $_REQUEST['page'], 'edit', $pwyw_data['bundle']->id);
        $pwyw_del = sprintf('?page=%s&action=%s&bundle=%s', $_REQUEST['page'], 'delete', $pwyw_data['bundle']->id);
        require_once( ABSPATH . 'wp-content/plugins/PWYW/bundle.php' );
    }

    function pwyw_delete_bundle($id) {
        global $wpdb;
        $wpdb->query($wpdb->prepare("DELETE FROM {$this->bundles} WHERE id = %d", $id));
        require_once( ABSPATH . 'wp-content/plugins/PWYW/bundles.php' );
        screen_icon('options-general');
        ?>
        <h2><?php echo get_admin_page_title(); ?></h2>
        <a href="<?php echo sprintf('?page=%s&action=%s', $_REQUEST['page'], 'new'); ?>" class="add-new-h2">Add New Bundle </a>
        <?php
        $PWYWListTable = new PWYW_Bundles_List_Table();
        $PWYWListTable->prepare_items();
        $PWYWListTable->display();
    }

    function pwyw_new_bundle() {
        global $wpdb;

        $pwyw_levels = $wpdb->get_results("SELECT l.`id`,l.`name` FROM {$wpdb->pmpro_membership_levels} l");

        $sql = "SELECT c.`id`,c.`title`,c.`order`,c.`parent` FROM {$this->categories} c WHERE `parent` = 0";
        $pwyw_categories = $wpdb->get_results($sql);
        $pwyw_levels = $wpdb->get_results("SELECT l.`id`,l.`name` FROM {$wpdb->pmpro_membership_levels} l");
        foreach ($pwyw_categories as $category) {
            if ($category->parent == 0) {
                $pwyw_category[$category->id]['info']['title'] = $category->title;
                $pwyw_category[$category->id]['info']['val'] = 0;
                $pwyw_category[$category->id]['info']['order'] = $category->order;
            }
           // $val += $category->val;
        }
        $pwyw_data['levels'] = $pwyw_levels;

        $pwyw_data['categories'] = $pwyw_category;
        $pwyw_action = sprintf('?page=%s&action=%s', $_REQUEST['page'], 'create');
        require_once( ABSPATH . 'wp-content/plugins/PWYW/bundle.php' );
    }

    function pwyw_create_bundle() {
        global $wpdb;

        if (isset($_REQUEST['activate'])) {
            $sql = "UPDATE {$this->bundles} SET `activated` = 0";
            $wpdb->query($sql);
            $pwyw_bundle_active = $_REQUEST['activate'];
        } else {
            $pwyw_bundle_active = 0;
        }
        $wpdb->query(
                $wpdb->prepare("INSERT INTO {$this->bundles} (title,suggested_val_1,suggested_val_2,suggested_val_3,pwyw_val,belowaverage,aboveaverage,activated)
                          VALUES (%s,%f,%f,%f,%f,%d,%d,%d)
                     ", $_REQUEST['title'], $_REQUEST['suggested_val_1'], $_REQUEST['suggested_val_2'], $_REQUEST['suggested_val_3'], $_REQUEST['pwyw_val'], $_REQUEST['belowaverage'], $_REQUEST['aboveaverage'], $pwyw_bundle_active
                )
        );

        $bundle_id = $wpdb->insert_id;

        if ($bundle_id) {
            foreach ($_REQUEST['parent_category_val'] as $key => $val) {
                $wpdb->query($wpdb->prepare("INSERT INTO {$this->bundle_categories} (val,bundle_id,cat_id) VALUES (%d,%d,%d) ", $val, $bundle_id, $key));

                if (isset($_REQUEST['pwyw_new_sub_val'][$key])) {
                    foreach ($_REQUEST['pwyw_new_sub_val'][$key] as $s_key => $val) {
                        if (!empty($_REQUEST['pwyw_new_sub_val'][$key][$s_key])) {
                            $insert_cat = $wpdb->query($wpdb->prepare("INSERT INTO {$this->categories} (title,parent) VALUES (%s,%d)", $_REQUEST['pwyw_new_sub_name'][$key][$s_key], $key));

                            if ($insert_cat) {
                                $wpdb->query($wpdb->prepare("INSERT INTO {$this->bundle_categories} (cat_id,bundle_id,val) VALUES (%d,%d,%d)", $wpdb->insert_id, $bundle_id, $val));
                            }
                        }
                    }
                }
            }
        }
        //   die;
        screen_icon('options-general');
        ?>
        <h2><?php echo get_admin_page_title(); ?></h2>
        <a href="<?php echo sprintf('?page=%s&action=%s', $_REQUEST['page'], 'new'); ?>" class="add-new-h2">Add New Bundle </a>
        <?php
        require_once( ABSPATH . 'wp-content/plugins/PWYW/bundles.php' );

        $PWYWListTable = new PWYW_Bundles_List_Table();

        $PWYWListTable->prepare_items();
        $PWYWListTable->display();
    }

    function pwyw_settings() {

        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        } else {
            if (isset($_REQUEST['action'])) {
                switch ($_REQUEST['action']) {
                    case 'view':
                        $this->pwyw_view_bundle($_REQUEST['bundle']);
                        break;
                    case 'delete':
                        $this->pwyw_delete_bundle($_REQUEST['bundle']);
                        break;
                    case 'edit':
                        $this->pwyw_edit_bundle();
                        break;
                    case 'new':
                        $this->pwyw_new_bundle();
                        break;
                    case 'create':
                        $this->pwyw_create_bundle();
                        break;
                }
            } else {
                screen_icon('options-general');
                ?>
                <h2><?php echo get_admin_page_title(); ?></h2>
                <a href="<?php echo sprintf('?page=%s&action=%s', $_REQUEST['page'], 'new'); ?>" class="add-new-h2">Add New Bundle </a>
                <?php
                require_once( ABSPATH . 'wp-content/plugins/PWYW/bundles.php' );

                $PWYWListTable = new PWYW_Bundles_List_Table();

                $PWYWListTable->prepare_items();
                $PWYWListTable->display();
            }
        }
    }

    function pwyw_add_payment($order) {
        global $wpdb;
        require_once( ABSPATH . 'wp-content/plugins/PWYW/Pubnub.php' );
        $pubnub = new Pubnub('pub-055f1968-8c42-4146-80b1-195d34e6c4c5', 'sub-5f5a6c30-278a-11e2-964e-034399c6c504');

        if ($order->status == 'success') {


            $sql = "SELECT `id` FROM {$this->users} WHERE `cid`=%d";
            $user = $wpdb->query($wpdb->prepare($sql, $order->user_id));

            if (!$user) {
                if (isset($_SESSION['pwyw_user_alias']) && !empty($_SESSION['pwyw_user_alias'])) {
                    if (!empty($_SESSION['is_twitter_alias'])) {
                        $wpdb->query($wpdb->prepare("INSERT INTO {$this->users} (cid,alias,is_twitter) VALUES (%d,%s,1) ", $order->user_id, $_SESSION['pwyw_user_alias']));
                    } else {
                        $wpdb->query($wpdb->prepare("INSERT INTO {$this->users} (cid,alias) VALUES (%d,%s) ", $order->user_id, $_SESSION['pwyw_user_alias']));
                    }
                } else {
                    $wpdb->query($wpdb->prepare("INSERT INTO {$this->users} (cid) VALUES (%d) ", $order->user_id));
                }
            } else {
                if (isset($_SESSION['pwyw_user_alias']) && !empty($_SESSION['pwyw_user_alias'])) {
                    if (!empty($_SESSION['is_twitter_alias'])) {
                        $wpdb->query($wpdb->prepare("UPDATE {$this->users} SET alias = %s,is_twitter=1 WHERE `cid`= {$order->user_id}", $_SESSION['pwyw_user_alias']));
                    } else {
                        $wpdb->query($wpdb->prepare("UPDATE {$this->users} SET alias = %s,is_twitter=0 WHERE `cid`= {$order->user_id}", $_SESSION['pwyw_user_alias']));
                    }
                }
            }

            foreach ($_SESSION['pwyw_bundle'] as $key => $data) {
//                $pubnub->publish(array(
//                    'channel' => 'my_test_channel',
//                    'message' => $this->pwyw_get_bundle_info($key)
//                ));
                $res = $wpdb->query($wpdb->prepare("INSERT INTO {$this->payment_info} (cid,order_id,sum,average_price,bundle,bundle_level)
                                        VALUES (%d,%d,%f,%f,%d,%d) ", $order->user_id, $order->id, $order->InitialPayment, $data['avg_price'], $key, $data['bundle_level']));
                $payment_id = $wpdb->insert_id;

                if ($res) {
                    foreach ($_SESSION['pwyw_bundle'][$key]['categories'] as $id => $val) {
                        $wpdb->query($wpdb->prepare("INSERT INTO {$this->price_allocation} (payment_id,cat_id,bundle,allocate_percent)
                                        VALUES (%d,%d,%d,%d) ", $payment_id, $id, $key, $val));
                    }
                }
            }
        }

        $_SESSION['pwyw_bundle'] = '';
    }

    function pwyw_bundle_update() {
        if (check_ajax_referer('pwyw_ajax')) {
            if (isset($_REQUEST['bid']) && (int) $_REQUEST['bid'] > 0) {

                $pwyw_info = $this->pwyw_get_bundle_info($bid);
                if (!empty($pwyw_info)) {
                    echo json_encode($pwyw_info);
                    exit;
                }
            }
        }
        echo 'ERROR';
    }

    function pwyw_customers() {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        } else {
            screen_icon('options-general');
            ?>
            <h2><?php echo get_admin_page_title(); ?></h2>


            <?php
            require_once( ABSPATH . 'wp-content/plugins/PWYW/customers.php' );
            $PWYWListTable = new PWYW_Customer_List_Table();
            $PWYWListTable->prepare_items();
            $PWYWListTable->payments = $this->get_all_payment_info();
            ?>
            <script type="text/javascript">
                $(function(){
                    $('.payment_amount').live('click',function(){

                        var content = $(this).parents('td').find('.totalsbox').html();
                        $(this).popover({
                            animation:true,
                            placement:'right',
                            title:'Breakdown',
                            content:content
                            //                            fadeSpeed:800
                        })
                        $(this).popover('show');

                    })
                })
            </script>
            <?php
            $PWYWListTable->display();
        }
    }

}

global $pwyw_obj;
$pwyw_obj = new pwyw();
?>