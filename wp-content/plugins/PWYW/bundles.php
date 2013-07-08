<?php

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class PWYW_Bundles_List_Table extends WP_List_Table
{

    public function __construct()
    {
        global $status, $page;
                
        //Set parent defaults
        parent::__construct(
            array(
                'singular' => 'bundle', //singular name of the listed records
                'plural' => 'bundles', //plural name of the listed records
                'ajax' => false        //does this table support ajax?
            )
        );
        global $wpdb;
        $this->_pwyw_bundles = $wpdb->prefix . "pwyw_bundles";
    }

    function get_data($current_page, $per_page) {
        global $wpdb;
        $offset = ($current_page - 1) * $per_page;
        $query = '';

        if (isset($_POST['s'])) {
            $bundle = '%' . $_POST['s'] . '%';
            $query = "WHERE `title` LIKE %s";
            $query = $wpdb->prepare($query, $bundle);
        }

        $sql = "SELECT * FROM {$this->_pwyw_bundles}  {$query} LIMIT {$offset},{$per_page}";

        $results = $wpdb->get_results($sql);
        $data = array();
        foreach ($results as $bundle) {
            // Load Data
            $data[] = array(
                'ID' => $bundle->id,
                'bundle' => $bundle->title,
                'description' => $bundle->description,
                'activated' => $bundle->activated
            );
        }
        return $data;
    }

    function get_data_total() {
        global $wpdb;
        $query = '';
        if (isset($_POST['s'])) {
            $bundle = '%' . $_POST['s'] . '%';
            $query = "WHERE `title` LIKE %s";
            $query = $wpdb->prepare($query, $bundle);
        }

        $sql = "SELECT count(id) FROM {$this->_pwyw_bundles} {$query}";

        $results = (int) $wpdb->get_var($sql);

        return $results;
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'bundle':
                return $item[$column_name];
            case 'description':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function column_cb($item) {
        return sprintf(
                        '<input type="checkbox" name="bundle[]" value="%s"  />', $item['ID']
        );
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'bundle' => 'Bundle',
            'description' => 'Description',
            'active' => 'Activated'
        );
        return $columns;
    }

    function column_active($item){
        if($item['activated']){
            return sprintf('<span class="active_bundle">active</span>');
        }
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'bundle' => array('bundle', true), //true means its already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }
    
    

    function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ('delete' === $this->current_action()) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
    }

    function column_bundle($item) {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&bundle=%s">Edit</a>', $_REQUEST['page'], 'view', $item['ID']),
            'delete' => sprintf('<a href="?page=%s&action=%s&bundle=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['ID']),
        );
        return sprintf('%1$s %2$s', $item['bundle'], $this->row_actions($actions));
    }

    function prepare_items() {

        $per_page = 10;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);


        $current_page = $this->get_pagenum();

        $total_items = $this->get_data_total();

        $current_page = $this->get_pagenum();
  //      $total_items = $this->get_data_total();
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page
        ));
        $this->items = $this->get_data($current_page, $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page, //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
        ));
    }

}