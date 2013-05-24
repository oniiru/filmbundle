<?php
class FilmBundleBlog_ThemeFunctions
{
    const VERSION = '1.0';
    private static $instance = false;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        add_action('wp_enqueue_scripts', array(&$this, 'scripts'));
    }

    public function scripts()
    {
        wp_enqueue_script(
            'filmbundle-social',
            get_stylesheet_directory_uri().'/assets/js/social.js',
            array('jquery'), 
            self::VERSION,
            true
        );
    }
}

$fb_theme = FilmBundleBlog_ThemeFunctions::getInstance();
