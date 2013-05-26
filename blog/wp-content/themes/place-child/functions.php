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
            <div id=\"player\"></div>
            <script>
              // Load the IFrame Player API code asynchronously.
              var tag = document.createElement('script');

              tag.src = \"https://www.youtube.com/iframe_api\";
              var firstScriptTag = document.getElementsByTagName('script')[0];
              firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

              // Create the iframe after the API code is downloaded.
              var player;
              function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                  height: '315',
                  width: '500',
                  videoId: '{$id}',
                  events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                  }
                });
              }




      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }

            </script>
        ";
        return $embed;
    }


/*
<iframe width="500" height="315" src="http://www.youtube.com/embed/lRTJ1spSgd4" frameborder="0" allowfullscreen></iframe>
*/
}

$fb_theme = FilmBundleBlog_ThemeFunctions::getInstance();
