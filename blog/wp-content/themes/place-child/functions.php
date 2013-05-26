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
        add_shortcode('vimeo', array(&$this,'shortcodeVimeo'));
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

    // -------------------------------------------------------------------------
    // Shortcodes
    // -------------------------------------------------------------------------
    public function shortcodeVimeo($atts)
    {
        extract(
            shortcode_atts(
                array(
                    'id' => '',
                    'api' => '',
                ),
                $atts
            )
        );
        $embed = "<iframe src=\"http://player.vimeo.com/video/{$id}?";
        $embed .= ($api == true) ? "api=1&" : "";
        $embed .= "title=0&byline=0&portrait=0\" width=\"500\" height=\"281\"";
        $embed .= "frameborder=\"0\"";
        $embed .= "webkitAllowFullScreen mozallowfullscreen allowFullScreen>";
        $embed .= "</iframe>";
        return $embed;
    }
}

$fb_theme = FilmBundleBlog_ThemeFunctions::getInstance();
