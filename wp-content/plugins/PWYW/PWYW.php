<?php
/*
  Plugin Name: PWYW
  Plugin URI: http://www.filmbundle.com
  Description: Plugin to allow users to pay what they want.
  Version: 0.2
  Author: Filmbundle
  Author URI: http://www.filmbundle.com
 */

/** Load all of the necessary class files for the plugin */
spl_autoload_register('Pwyw::autoload');

class Pwyw
{
    /** Holds the plugin instance */
    protected static $instance;

    /** Define plugin constants */
    const FILE = __FILE__;

    /** Define PubNub setup */
    const PUBNUB_SUBSCRIBE_KEY = 'sub-c-ef114922-f1ea-11e2-b383-02ee2ddab7fe';
    const PUBNUB_PUBLISH_KEY   = 'pub-c-3f69d611-264c-477e-a751-48ebc60048fe';
    const PUBNUB_CHANNEL       = 'filmbundle';

    /** Singleton class */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->construct();
        }
        return self::$instance;
    }

    /** Singleton constructor */
    private function __construct()
    {
    }

    /** Custom constructor */
    private function construct()
    {
        global $wpdb;
        register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall'));

        add_action('admin_menu', array(&$this, 'PWYW_menu_pages'));

        $this->plugin_url = trailingslashit(WP_PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)));
        $this->plugin_name = plugin_basename(__FILE__);
        $this->bundles = $wpdb->prefix . "pwyw_bundles";
        $this->categories = $wpdb->prefix . "pwyw_categories";
        $this->bundle_categories = $wpdb->prefix . "pwyw_bundle_categories";
        $this->payment_info = $wpdb->prefix . "pwyw_payment_info";
        $this->price_allocation = $wpdb->prefix . "pwyw_price_allocation";
        $this->users = $wpdb->prefix . "pwyw_customers";

        // Boot up constructing classes
        Pwyw_Admin::instance();
        Pwyw_Charities::instance();
        Pwyw_Films::instance();
        Pwyw_Widgets::getInstance();
        Pwyw_Checkout::getInstance();
        Pwyw_Tip::getInstance();

        // Check if database needs upgrading
        if (is_admin()){
            Pwyw_Database::upgrade();
        }
    }


    /**
     * PSR-0 compliant autoloader to load classes as needed.
     *
     * @param  string  $classname  The name of the class
     * @return null    Return early if the class name does not start with the
     *                 correct prefix
     */
    public static function autoload($className)
    {
        if (!
           ('Pwyw' === mb_substr($className, 0, strlen('Pwyw')) ||
            'Pubnub' === mb_substr($className, 0, strlen('Pubnub'))
        )) {
            return;
        }
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
            $fileName .= DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        require 'lib'.DIRECTORY_SEPARATOR.$fileName;
    }


    // -------------------------------------------------------------------------
    // PubNub handling
    // -------------------------------------------------------------------------

    /**
     * Initialize the PubNub Admin view.
     *
     * @return void
     */
    public function pubNubSettings()
    {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to access this page.');
        }

        if ($_POST['submit']) {
            $this->pubNubPublish();
            $published = true;
        }

        $data = array(
            'published' => isset($published) ? true : false
        );

        echo Pwyw_View::make('admin-pubnub', $data);
    }

    public function pubNubPublish()
    {
        $pubnub = new Pubnub_Pubnub(
            self::PUBNUB_PUBLISH_KEY,
            self::PUBNUB_SUBSCRIBE_KEY
        );

        $data = $this->pwyw_get_bundle_info();

        // Create a streamlined array of top contributors
        $contributors = array();
        foreach ($data['top'] as $contributor) {
            $array = array(
                'name' => $contributor->display_name,
                'amount' => $contributor ->amount
            );
            $contributors[] = $array;
        }

        $pubnub->publish(
            array(
                'channel' => self::PUBNUB_CHANNEL,
                'message' => array(
                    'contributors'  => $contributors,
                    'minAmount'     => $data['min_amount'],
                    'totalSales'    => $data['payment_info']->total_sales,
                    'averagePrice'  => $data['payment_info']->avg_price,
                    'totalPayments' => $data['payment_info']->total_payments,
                    'server'        => php_uname('n'),
                    'server_time'   => date('Y-m-d H:i:s')
                )
            )
        );
    }


    // -------------------------------------------------------------------------
    // Original PWYW code from v0.1
    // -------------------------------------------------------------------------

    /**
     * When the plugin is activated.
     */
    public static function install()
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $bundles = $wpdb->prefix . "pwyw_bundles";
        $categories = $wpdb->prefix . "pwyw_categories";
        $bundle_categories = $wpdb->prefix . "pwyw_bundle_categories";
        $payment_info = $wpdb->prefix . "pwyw_payment_info";
        $price_allocation = $wpdb->prefix . "pwyw_price_allocation";
        $users = $wpdb->prefix . "pwyw_customers";


        if ($wpdb->get_var("SHOW TABLES LIKE '{$bundles}'") != $bundles) {
            $sql = "CREATE TABLE " . $bundles . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `title` varchar(255) NOT NULL ,
             `twitterstart` int(20) ,
             `facestart` int(20) ,
             `facegoal` int(20) ,
             `twittergoal` int(20) ,
             `twitterend` int(20) ,
             `faceend` int(20) ,
             `suggested_val_1` float(10,2),
             `suggested_val_2` float(10,2),
             `suggested_val_3` float(10,2),
             `pwyw_val` float(10,2),
             `facetitle` varchar(255) NOT NULL ,
             `facedescription` text ,
			 'face_image' varchar(255) NOT NULL ,
			 'twittermessage' text ,
             `order` mediumint(9),
             `belowaverage` mediumint(9),
             `aboveaverage` mediumint(9),
             `activated` smallint(1),
             UNIQUE KEY id (id)
             );";


            dbDelta($sql);

            if ($wpdb->get_var("SHOW TABLES LIKE '{$payment_info}'") != $payment_info) {
                $sql = "CREATE TABLE " . $payment_info . " (
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

            if ($wpdb->get_var("SHOW TABLES LIKE '{$users}'") != $users) {
                $sql = "CREATE TABLE " . $users . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `cid` mediumint(9) ,
             `is_twitter` smallint(1) DEFAULT 0,
             `alias` varchar(250),
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }

            if ($wpdb->get_var("SHOW TABLES LIKE '{$price_allocation}'") != $price_allocation) {
                $sql = "CREATE TABLE " . $price_allocation . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `payment_id` mediumint(9) ,
             `cat_id` mediumint(9),
             `bundle` mediumint(9),
             `allocate_percent` int(3),
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }

            if ($wpdb->get_var("SHOW TABLES LIKE '{$categories}'") != $categories) {
                $sql = "CREATE TABLE " . $categories . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `title` varchar(255) NOT NULL ,
             `parent` mediumint(3)DEFAULT 0,
             `order` mediumint(3),
              UNIQUE KEY id (id)
             );";

                dbDelta($sql);

                $wpdb->insert($categories, array('title' => 'Filmmakers',
                    'parent' => 0,
                    'order' => 1));

                $wpdb->insert($categories, array('title' => 'Charities',
                    'parent' => 0,
                    'order' => 2));

                $wpdb->insert($categories, array('title' => 'Bundle',
                    'parent' => 0,
                    'order' => 3));
            }



            if ($wpdb->get_var("SHOW TABLES LIKE '{$bundle_categories}'") != $bundle_categories) {
                $sql = "CREATE TABLE " . $bundle_categories . " (
             `id` mediumint(9) NOT NULL AUTO_INCREMENT,
             `cat_id` mediumint(9) ,
             `bundle_id` mediumint(9),
             `val` mediumint(3) DEFAULT 0,
             UNIQUE KEY id (id)
             );";

                dbDelta($sql);
            }
        }

        // Install tables
        Pwyw_Database::createTables();
    }

    /**
     * Fired when the plugin is uninstalled.
     */
    public function uninstall()
    {
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

        // Uninstall tables
        Pwyw_Database::dropTables();
    }

    public function PWYW_menu_pages()
    {
        // Add the top-level admin menu
        $page_title = 'PWYW Settings';
        $menu_title = 'PWYW';
        $capability = 'manage_options';
        $menu_slug = 'PWYW-settings';

        add_menu_page(
            $page_title,
            $menu_title,
            $capability,
            $menu_slug,
            array(&$this, 'pwyw_settings')
        );

        // Add submenu page with same slug as parent to ensure no duplicates
        $sub_menu_title = 'PWYW Settings';
        add_submenu_page(
            $menu_slug,
            $page_title,
            $sub_menu_title,
            $capability,
            $menu_slug,
            array(&$this, 'pwyw_settings')
        );

        // Now add the submenu page for Help
        $submenu_page_title = 'Customers';
        $submenu_title = 'Customers';
        $submenu_slug = 'PWYW-customers';
        $submenu_function = 'pwyw_customers';

        add_submenu_page(
            $menu_slug,
            $submenu_page_title,
            $submenu_title,
            $capability,
            $submenu_slug,
            array(&$this, $submenu_function)
        );

        // Let's add a page for some manual PubNub control
        add_submenu_page(
            $menu_slug,
            'PubNub',
            'PubNub',
            $capability,
            'PWYW-pubnub',
            array(&$this, 'pubNubSettings')
        );
    }

    function pwyw_settings()
    {

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
                    case 'new':
                        $this->pwyw_new_bundle();
                        break;
                    // These two are now handled from the admin class.
                    // case 'edit':
                    //     $this->pwyw_edit_bundle();
                    //     break;
                    // case 'create':
                    //     $this->pwyw_create_bundle();
                    //     break;
                }
            } else {
                screen_icon('options-general');
                ?>
                <h2><?php echo get_admin_page_title(); ?></h2>
                <a href="<?php echo sprintf('?page=%s&action=%s', $_REQUEST['page'], 'new'); ?>" class="add-new-h2">Add New Bundle </a>
                <?php
                require_once( ABSPATH . 'wp-content/plugins/PWYW/bundles.php' );
                echo "
                <script type='text/javascript'>
                    jQuery(document).ready(function($) {
                        $('.delete').click(function(){
                            return confirm('Are you sure you want to delete the bundle?');
                        });
                    });
                </script>
                ";

                $PWYWListTable = new PWYW_Bundles_List_Table();

                $PWYWListTable->prepare_items();
                $PWYWListTable->display();
            }
        }
    }

    function get_all_payment_info()
    {
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

    function pwyw_get_bundle_info($bid = '')
    {
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

            /**
             * Database table structure for customers / payments / orders
             *
             * payment_info: the main table. an entry here is used as-is. cid
             *               column is a foreign key for wp_users (hardcoded
             *               it seems).
             * customers:    if an entry exists in this column, it overrides the
             *               displayname provided by wp_users. This is optional
             *               but are probably created on each new user (will
             *               look more into that during the order process).
             *               cid column is a foreign key for wp_users.
             */
            $pwyw_top_contr = $wpdb->get_results(
                "SELECT DISTINCT p.`cid`,cu.`display_name`,{$amount_q} amount,u.`alias`,u.`is_twitter`
                 FROM `wp_users` cu
                 RIGHT JOIN {$this->payment_info} p ON cu.`ID` = p.`cid`
                 LEFT JOIN {$this->users} u ON cu.`ID` = u.`cid`
                 WHERE p.`bundle` = {$pwyw_bundle->id}
                 GROUP BY p.`cid`
                 ORDER BY amount DESC LIMIT 10"
            );

            foreach ($pwyw_top_contr as $top) {
                if (!empty($top->alias)) {
                    if ($top->is_twitter) {
                        $top->display_name = sprintf(
                            '<a target="_blank" href="%s">@%s</a>',
                            'http://twitter.com/'.$top->alias,
                            $top->alias
                        );
                    } else {
                        $top->display_name = $top->alias;
                    }
                } else {
                    // No alias/twitter submitted, set the user to anonymous
                    $top->display_name = 'Anonymous';
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

    function pwyw_edit_bundle()
    {
        global $wpdb;

        if (isset($_REQUEST['activate'])) {
            $sql = "UPDATE {$this->bundles} SET `activated` = 0";
            $wpdb->query($sql);
            $pwyw_bundle_active = $_REQUEST['activate'];
        } else {
            $pwyw_bundle_active = 0;
        }

        // Save the associated films and charities
        Pwyw_Films::save($_REQUEST['bundle']);
        Pwyw_Charities::save($_REQUEST['bundle']);

        $wpdb->query(
                $wpdb->prepare(
                        "
                    UPDATE {$this->bundles}
                        SET title = %s,
                            description = %s,
                            bg_image = %s,
                            end_time = %s,
                            facestart = %d,
                            twitterstart = %d,
                            facegoal = %d,
                            twittergoal = %d,
                            faceend = %d,
                            twitterend = %d,
                            suggested_val_1 = %f,
                            suggested_val_2 = %f,
                            suggested_val_3 = %f,
                            pwyw_val = %f,
                            facetitle = %s,
                            facedescription = %s,
                            face_image = %s,
                            twittermessage = %s,
                            belowaverage = %d,
                            aboveaverage = %d,
                            activated = %d
                        WHERE id = %d
                     ", $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['bg_image'], $_REQUEST['end_time'], $_REQUEST['facestart'] ,$_REQUEST['twitterstart'], $_REQUEST['facegoal'], $_REQUEST['twittergoal'], $_REQUEST['faceend'], $_REQUEST['twitterend'], $_REQUEST['suggested_val_1'], $_REQUEST['suggested_val_2'], $_REQUEST['suggested_val_3'], $_REQUEST['pwyw_val'], $_REQUEST['facetitle'], $_REQUEST['facedescription'], $_REQUEST['face_image'], $_REQUEST['twittermessage'], $_REQUEST['belowaverage'], $_REQUEST['aboveaverage'], $pwyw_bundle_active, $_REQUEST['bundle']
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

        // Return to the view bundle
        $url = admin_url(
            sprintf(
                'admin.php?page=PWYW-settings&action=view&bundle=%s',
                $_REQUEST['bundle']
            )
        );
        wp_redirect($url);
        exit;
    }

    function pwyw_view_bundle($id)
    {

        $pwyw_data = $this->pwyw_get_bundle_info($id);

        $pwyw_action = sprintf('?page=%s&action=%s&bundle=%s', $_REQUEST['page'], 'edit', $pwyw_data['bundle']->id);
        $pwyw_del = sprintf('?page=%s&action=%s&bundle=%s', $_REQUEST['page'], 'delete', $pwyw_data['bundle']->id);
        require_once( ABSPATH . 'wp-content/plugins/PWYW/bundle.php' );
    }

    function pwyw_delete_bundle($id)
    {
        global $wpdb;
        $wpdb->query($wpdb->prepare("DELETE FROM {$this->bundles} WHERE id = %d", $id));

        // Delete films and charities
        Pwyw_Films::delete($id);
        Pwyw_Charities::delete($id);

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

    function pwyw_new_bundle()
    {
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

    function pwyw_create_bundle()
    {
        global $wpdb;

        if (isset($_REQUEST['activate'])) {
            $sql = "UPDATE {$this->bundles} SET `activated` = 0";
            $wpdb->query($sql);
            $pwyw_bundle_active = $_REQUEST['activate'];
        } else {
            $pwyw_bundle_active = 0;
        }
        $wpdb->query(
                $wpdb->prepare("INSERT INTO {$this->bundles} (title,description,bg_image,end_time,facestart,twitterstart,facegoal,twittergoal,faceend,twitterend,suggested_val_1,suggested_val_2,suggested_val_3,pwyw_val,facetitle,facedescription,face_image,twittermessage,belowaverage,aboveaverage,activated)
                          VALUES (%s,%s,%s,%s,%d,%d,%f,%f,%f,%f,%d,%d,%d)
                     ", $_REQUEST['title'], $_REQUEST['description'], $_REQUEST['bg_image'], $_REQUEST['end_time'], $_REQUEST['facestart'], $_REQUEST['twitterstart'], $_REQUEST['facegoal'], $_REQUEST['twittergoal'], $_REQUEST['faceend'], $_REQUEST['twitterend'], $_REQUEST['suggested_val_1'], $_REQUEST['suggested_val_2'], $_REQUEST['suggested_val_3'], $_REQUEST['pwyw_val'],$_REQUEST['facetitle'], $_REQUEST['facedescription'], $_REQUEST['face_image'], $_REQUEST['twittermessage'], $_REQUEST['belowaverage'], $_REQUEST['aboveaverage'], $pwyw_bundle_active
                )
        );

        $bundle_id = $wpdb->insert_id;

        // Save the associated films and charities
        Pwyw_Films::save($bundle_id);
        Pwyw_Charities::save($bundle_id);

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

        // Return to the view bundle
        $url = admin_url(
            sprintf(
                'admin.php?page=PWYW-settings&action=view&bundle=%s',
                $bundle_id
            )
        );
        wp_redirect($url);
        exit;
    }

    function pwyw_customers()
    {
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
            <script type="text/javascript" >
                jQuery(document).ready(function($) {
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

// Go!
add_action('plugins_loaded', array('Pwyw', 'getInstance'));
register_activation_hook(__FILE__, array('Pwyw', 'install'));
