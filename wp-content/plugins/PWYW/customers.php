<?php
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class PWYW_Customer_List_Table extends WP_List_Table {

    public function __construct() {
        global $wpdb;

        parent::__construct(
            array(
                'singular' => 'customer', //singular name of the listed records
                'plural' => 'customers',  //plural name of the listed records
                'ajax' => false           //does this table support ajax?
            )
        );

        $this->pwyw_payment = $wpdb->prefix . "pwyw_payment_info";
        $this->pwyw_customers = $wpdb->prefix . "pwyw_customers";
        $this->users = $wpdb->prefix . 'users';
        $this->bundles = $wpdb->prefix . 'pwyw_bundles';
    }

    // -------------------------------------------------------------------------
    // Column output methods
    // -------------------------------------------------------------------------

    /**
     * Default method when not specific method for the column exist.
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'bundle':
            case 'payd':
            case 'date':
            case 'above_average':
                return $item[$column_name];

            default:
                return print_r($item, true);
        }
    }

    public function column_alias($item) {
        if (get_current_user_id() == $item['cid']) {
            $edit_link = esc_url(network_admin_url('profile.php'));
        } else {
            $edit_link = esc_url(network_admin_url(add_query_arg('wp_http_referer', urlencode(stripslashes($_SERVER['REQUEST_URI'])), 'user-edit.php?user_id=' . $item['cid'])));
        }

        if (!empty($item['alias'])) {
            if ($item['is_twitter']) {
                return sprintf('<a target="_blank" href="http://twitter.com/%s">@%s</a>', $item['alias'], $item['alias']);
            }
        }

        return sprintf('<strong><a href="%s" class="edit">%s</a></strong>', $edit_link, $item['alias']);
    }

    public function column_payd($item) {
        $html = '<span class="payment_amount">$ ' . $item['payd'] . '</span>';
        $html .= '<div class="totalsbox">';
        $html .= '<ul>';
        foreach ($this->payments[$item['ID']] as $key => $cat_obj) {

            switch ($key) {
                case 1:
                    $ctitle = 'Films';
                    break;
                case 2:
                    $ctitle = 'Charities';
                    break;
                case 3:
                    $ctitle = 'FilmBundle';
                    break;
            }
            $payment = number_format($cat_obj['info']['payment'], 2);

            $html .="<li>{$ctitle}: <span class='allocate_price'>\${$payment}</span>";
            if (isset($cat_obj['sub'])) {
                $html .= '<ul class="subs">';
                foreach ($cat_obj['sub'] as $key_s => $sub) {
                    $sub_payment = number_format($sub['info']['payment'], 2);
                    $html .= "<li>{$sub['info']['title']}: <span class='allocate_price'>\${$sub_payment}</span></li>";
                }
                $html .= "</ul>";
            }
            $html .= "</li>";
        }
        $html .= "</ul>";
        $html .= "</div>";
        return $html;
    }

    function column_customer($item) {
        if (get_current_user_id() == $item['cid']) {
            $edit_link = esc_url(network_admin_url('profile.php'));
        } else {
            $edit_link = esc_url(network_admin_url(add_query_arg('wp_http_referer', urlencode(stripslashes($_SERVER['REQUEST_URI'])), 'user-edit.php?user_id=' . $item['cid'])));
        }
        return sprintf('<strong><a href="%s" class="edit">%s</a></strong>', $edit_link, $item['customer']);
    }

    function column_above_average($item) {
        if ($item['above_average'] == 0) {
            return sprintf('<img class ="yes_" width="18" alt="Delete" src="%s?>" />', plugins_url('/PWYW/img/yes.png'));
        }

        return;
    }

    function column_bundle($item) {

        return sprintf('<a href="?page=PWYW-settings&action=view&bundle=%d">%s</a>', $item['bid'], $item['bundle']);
    }

    /**
     * Custom handler for the date column.
     *
     * @param array $item
     * @return string
     */
    public function column_date($item)
    {
        return $item['date'];
    }

    /**
     * Set column titles and slugs.
     */
    function get_columns() {
        $columns = array(
            'customer' => 'Customer',
            'alias' => 'Alias',
            'payd' => 'Payd',
            'bundle' => 'Bundle',
            'above_average' => 'Above Average',
            'date' => 'Date'
        );
        return $columns;
    }

    /**
     * Makes the column sortable.
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'customer' => array('customer', true),
            'payd' => array('payd', true),
            'bundle' => array('bundle', true), //true means its already sorted
        );
        return $sortable_columns;
    }


    // -------------------------------------------------------------------------
    // Handle Data
    // -------------------------------------------------------------------------

    /**
     * Prepare the data and pagination.
     */
    function prepare_items()
    {
        $per_page = 10;

        // Define column headers
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);


        // Handle pagination
        $current_page = $this->get_pagenum();
        $total_items = $this->get_data_total();

        $this->items = $this->get_data($current_page, $per_page);
        ?>

        <form method="post">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
            <?php $this->search_box('search', 'search_id');?>
        </form>

        <?php
        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page' => $per_page,
                'total_pages' => ceil($total_items / $per_page)
            )
        );
    }

    function get_data($current_page, $per_page) {
        global $wpdb;
        $offset = ($current_page - 1) * $per_page;
        $query = '';
        $order = '';

        if (isset($_POST['s'])) {
            $search = '%' . $_POST['s'] . '%';
            $query = "AND c.`display_name` LIKE %s OR b.`title` LIKE %s OR cu.`alias` LIKE %s";
            $query = $wpdb->prepare($query, $search, $search, $search);
        }

        if (isset($_REQUEST['orderby'])) {
            $order = "ORDER BY " . $_REQUEST['orderby'] . " " . $_REQUEST['order'];
        }else{
            $order = "ORDER BY p.`date` DESC";
        }
        
        $sql = "SELECT ";

        $sql =
            "SELECT p.`id`, c.`display_name` customer, p.`cid`, cu.`alias`, 
                cu.`is_twitter`, p.`sum` payd, b.`title` bundle, p.`bundle` bid,
                (p.`average_price`>p.`sum`) above_average, p.`date`
            FROM {$this->pwyw_payment} p
            RIGHT JOIN {$this->users} c  ON  p.`cid` = c.`id`
            RIGHT JOIN {$this->pwyw_customers} cu ON p.`cid` = cu.`cid`
            LEFT JOIN {$this->bundles} b ON p.`bundle` = b.`id`
            WHERE b.`title` IS NOT NULL
            {$query} {$order}
            LIMIT {$offset},{$per_page}";

        $results = $wpdb->get_results($sql);
        $data = array();
        foreach ($results as $customer) {
            // Load Data
            $data[] = array(
                'ID' => $customer->id,
                'customer' => $customer->customer,
                'payd' => $customer->payd,
                'cid' => $customer->cid,
                'bundle' => $customer->bundle,
                'above_average' => $customer->above_average,
                'bid' => $customer->bid,
                'date' => $customer->date,
                'alias' => $customer->alias,
                'is_twitter' => $customer->is_twitter
            );
        }
        return $data;
    }

    function get_data_total() {
        global $wpdb;
        $query = '';
        $order = '';
        if (isset($_POST['s'])) {
            $search = '%' . $_POST['s'] . '%';
            $query = "AND c.`display_name` LIKE %s OR b.`title` LIKE %s OR cu.`alias` LIKE %s";
            $query = $wpdb->prepare($query, $search, $search, $search);
        }

        if (isset($_REQUEST['orderby'])) {
            $order = "ORDER BY " . $_REQUEST['orderby'] . " " . $_REQUEST['order'];
        }

        $sql = "SELECT COUNT(p.`id`) FROM {$this->pwyw_payment}  p
                 RIGHT JOIN {$this->users} c  ON  p.`cid` = c.`id`
                 RIGHT JOIN {$this->pwyw_customers} cu ON p.`cid` = cu.`cid`
                 LEFT JOIN {$this->bundles} b ON p.`bundle` = b.`id` WHERE b.`title` IS NOT NULL {$query} {$order}";

        $results = (int)$wpdb->get_var($sql);

        return $results;
    }



//    function get_bulk_actions() {
//        $actions = array(
//            'delete' => 'Delete'
//        );
//        return $actions;
//    }

    function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
    }


    function usort_reorder($a, $b) {
        $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'customer'; //If no sort, default to title
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
        $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
        return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
    }
}
