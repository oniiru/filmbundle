<?php
/**
 * Class to handle films.
 */
class Pwyw_Films
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
    private function __construct($id = 0)
    {
        add_action('wp_ajax_pwyw_add_film', array(&$this, 'addFilm'));
        add_action('wp_ajax_pwyw_add_review', array(&$this, 'addReview'));
        add_action('wp_ajax_pwyw_add_feature', array(&$this, 'addFeature'));
    }

    // -------------------------------------------------------------------------
    // Ajax Handling
    // -------------------------------------------------------------------------
    public function addReview()
    {
        $array_id = $_POST['array_id'];
        $id = $_POST['id'];

        // Create a default, empty review object
        $review = new stdClass;

        $data = array('array_id' => $array_id, 'id' => $id, 'review' => $review);
        $review = Pwyw_View::make('review', $data);
        echo $review;
        die();
    }

    public function addFeature()
    {
        $array_id = $_POST['array_id'];
        $id = $_POST['id'];

        // Create a default, empty feature object
        $feature = new stdClass;
        $feature->id       = '';
        $feature->film_id  = '';
        $feature->image    = '';
        $feature->title    = '';
        $feature->subtitle = '';

        $data = array('array_id' => $array_id, 'id' => $id, 'feature' => $feature);
        $feature = Pwyw_View::make('feature', $data);
        echo $feature;
        die();
    }

    public function addFilm()
    {
        $array_id = $_POST['array_id'];

        // Create a default, empty film object
        $film = new stdClass;
        $film->id           = '';
        $film->bundle_id    = '';
        $film->title        = '';
        $film->image        = '';
        $film->rating       = 'above';
        $film->embed        = '';
        $film->logline      = '';
        $film->genre        = '';
        $film->runtime      = '';
        $film->director     = '';
        $film->writers      = '';
        $film->stars        = '';
        $film->website      = '';
        $film->note         = '';
        $film->user_reviews = 0;

        // Create a new film view to send to the front
        $data = array('array_id' => $array_id, 'film' => $film);
        $film = Pwyw_View::make('film', $data);
        echo $film;
        die();
    }

    // -------------------------------------------------------------------------
    // Static methods
    // -------------------------------------------------------------------------

    public static function save($bundle_id)
    {
        $films = isset($_POST['films']) ? $_POST['films'] : array();

        var_dump($films);
        die();
 

        foreach ($films as $film) {
            $film = stripslashes_deep($film);

            if (!$film['id']) {
                if ($film['deleted'] == 'true') {
                    continue;
                }
                $obj = Pwyw_Film::create(
                    $bundle_id,
                    $film['title'],
                    $film['image'],
                    $film['rating'],
                    $film['embed'],
                    $film['logline'],
                    $film['genre'],
                    $film['runtime'],
                    $film['director'],
                    $film['writers'],
                    $film['stars'],
                    $film['website'],
                    $film['note'],
                    isset($film['user_reviews']) ? 1 : 0
                );
            } else {
                if ($film['deleted'] == 'true') {
                    Pwyw_Film::delete($film['id']);
                    continue;
                }
                $obj = new Pwyw_Film($film['id']);
                $obj->bundle_id = $bundle_id;
                $obj->title = $film['title'];
                $obj->image = $film['image'];
                $obj->rating = $film['rating'];
                $obj->embed = $film['embed'];
                $obj->logline = $film['logline'];
                $obj->genre = $film['genre'];
                $obj->runtime = $film['runtime'];
                $obj->director = $film['director'];
                $obj->writers = $film['writers'];
                $obj->stars = $film['stars'];
                $obj->website = $film['website'];
                $obj->note = $film['note'];
                $obj->user_reviews = isset($film['user_reviews']) ? 1 : 0;
            }
            $obj->save();
        }
    }

    /**
     * Returns an object with all films for specified bundle.
     */
    public static function all($bundle_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FILMS;
        $sql = "SELECT * FROM {$table}
                WHERE bundle_id = {$bundle_id}
                ORDER BY title ASC";

        return $wpdb->get_results($sql, OBJECT);
    }

    /**
     * Deletes all charities associated with the bundle.
     */
    public static function delete($bundle_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FILMS;

        $result = $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$table}
                 WHERE bundle_id = %d",
                $bundle_id
            )
        );
        return $result;
    }
}
