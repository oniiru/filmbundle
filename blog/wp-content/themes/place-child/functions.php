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
        add_shortcode('youtube', array(&$this,'shortcodeYouTube'));
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
                ),
                $atts
            )
        );
        $embed = "<iframe src=\"http://player.vimeo.com/video/{$id}?";
        $embed .= "api=1&";
        $embed .= "title=0&byline=0&portrait=0\" width=\"500\" height=\"281\"";
        $embed .= "frameborder=\"0\"";
        $embed .= "webkitAllowFullScreen mozallowfullscreen allowFullScreen>";
        $embed .= "</iframe>";
        return $embed;
    }

    public function shortcodeYouTube($atts)
    {
        extract(
            shortcode_atts(
                array(
                    'id' => '',
                ),
                $atts
            )
        );

        $embed = "
            <div id=\"player_{$id}\" class=\"fit post_video_wrapper\"></div>
            <script>
                // Hides the player, until responsiveness is activated.
                jQuery('#player_{$id}').hide();

                // Setup a variable to keep track of initialization, to avoid
                // infinite responsive loops
                if (typeof yt_player_ready === 'undefined') {
                    var yt_player_ready = [];
                }
                yt_player_ready['{$id}'] = false;

                // Load the IFrame Player API code asynchronously.
                var tag = document.createElement('script');

                tag.src = \"https://www.youtube.com/iframe_api\";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                // Create the iframe after the API code is downloaded.
                var player_{$id};
                function onYouTubeIframeAPIReady() {
                    player_{$id} = new YT.Player('player_{$id}', {
                        height: '315',
                        width: '500',
                        videoId: '{$id}',
                        events: {
                            'onReady': onYTPlayerReady,
                            'onStateChange': onYTPlayerStateChange
                        }
                    });
                }
            </script>
        ";
        return $embed;
    }
}

$fb_theme = FilmBundleBlog_ThemeFunctions::getInstance();
