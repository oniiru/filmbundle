<?php

class Pwyw_Admin
{
    /** Holds the class instance */
    private static $instance = false;

    /** Singleton class */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** Singleton Constructor */
    private function __construct()
    {
        // $this->handlePostData();
        add_action('init', array(&$this, 'handlePostData'));
        add_action('admin_enqueue_scripts', array(&$this, 'scripts'));
    }

    /**
     * Queue scripts to be loaded in the admin
     */
    public function scripts()
    {
        // Get plugin version, to use for script loading
        $plugin = get_plugin_data(Pwyw::FILE, false, false);
        $version = $plugin['Version'];

        wp_enqueue_style('dashboard');
        wp_enqueue_script('dashboard');
        wp_enqueue_script(
            'PWYW_admin4',
            plugins_url('/js/jquery.linkedsliders.js', Pwyw::FILE),
            array('jquery-ui-slider'),
            $version
        );
        wp_enqueue_script(
            'popover',
            plugins_url('/js/jquery.popover-1.1.2.js', Pwyw::FILE),
            array(),
            $version
        );

        wp_enqueue_style(
            'PWYW_admin',
            plugins_url('/assets/stylesheets/admin.css', Pwyw::FILE),
            array(),
            $version
        );

        // Unregister WordPress postbox script, and register our own if we
        // are on the plugin admin.
        $screen = get_current_screen();
        if ($screen->id == 'toplevel_page_PWYW-settings') {
            wp_deregister_script('postbox');
            wp_enqueue_script(
                'pwyw-postbox',
                plugins_url('/assets/javascripts/pwyw-postbox.js', Pwyw::FILE),
                array('jquery-ui-sortable', 'underscore'),
                $version
            );
        }
    }

    /**
     * Handles form submissions.
     */
    public function handlePostData()
    {
        // See so we are in the PWYW section
        $page = (isset($_GET['page'])) ? $_GET['page'] : '';
        if ($page != 'PWYW-settings') {
            return;
        }

        if (isset($_REQUEST['action'])) {
            $pwyw = Pwyw::getInstance();
            switch ($_REQUEST['action']) {
                case 'edit':
                    $pwyw->pwyw_edit_bundle();
                    break;
                case 'create':
                    $pwyw->pwyw_create_bundle();
                    break;
            }
        }
    }
}
