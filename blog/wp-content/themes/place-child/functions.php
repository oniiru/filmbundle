<?php
class FilmBundleBlog_ThemeFunctions
{
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
        // to be implmented
    }

}

$fb_theme = FilmBundleBlog_ThemeFunctions::getInstance();
