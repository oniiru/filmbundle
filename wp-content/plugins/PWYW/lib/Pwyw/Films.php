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
        $review->id          = '';
        $review->film_id     = '';
        $review->review      = '';
        $review->linkedpage      = '';

        $review->author      = '';
        $review->publication = '';
        $review->image       = '';
        $review->link        = '';

        $data = array(
            'array_id' => $array_id,
            'id' => $id,
            'review' => $review
        );
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
        $feature->runtime  = '';

        $data = array(
            'array_id' => $array_id,
            'id' => $id,
            'feature' => $feature
        );
        $feature = Pwyw_View::make('feature', $data);
        echo $feature;
        die();
    }

    public function addFilm()
    {
        $array_id = $_POST['array_id'];

        // Create a default, empty film object
        $film = new stdClass;
        $film->id              = '';
        $film->bundle_id       = '';
        $film->sort            = '';
        $film->title           = '';
        $film->image           = '';
        $film->altimage           = '';
		
        $film->rating          = 'above';
        $film->linkedpage      = '';
        $film->embed           = '';
        $film->logline         = '';
        $film->genre           = '';
        $film->runtime         = '';
        $film->director        = '';
        $film->writers         = '';
        $film->stars           = '';
        $film->website         = '';
        $film->filmmaker_note  = '';
        $film->filmmaker_image = '';
        $film->filmmaker_name  = '';
        $film->curator_note    = '';
        $film->curator_image   = '';
        $film->curator_name    = '';
        $film->user_reviews    = 0;
        $film->meta            = '';

        // Create a new film view to send to the front
        $data = array(
            'array_id' => $array_id,
            'film' => $film,
            'features' => array(),
            'reviews' => array()
        );
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

        foreach ($films as $film) {
            $film = stripslashes_deep($film);

            if (!$film['id']) {
                if ($film['deleted'] == 'true') {
                    continue;
                }
                $obj = Pwyw_Film::create(
                    $bundle_id,
                    $film['sort'],
                    $film['title'],
                    $film['image'],
                    $film['altimage'],
					
                    $film['rating'],
                    $film['linkedpage'],

                    $film['embed'],
                    $film['logline'],
                    $film['genre'],
                    $film['runtime'],
                    $film['director'],
                    $film['writers'],
                    $film['stars'],
                    $film['website'],
                    $film['filmmaker_note'],
                    $film['filmmaker_image'],
                    $film['filmmaker_name'],
                    $film['curator_note'],
                    $film['curator_image'],
                    $film['curator_name'],
                    isset($film['user_reviews']) ? 1 : 0,
                    serialize($film['meta'])
                );
                $obj->save();
            } else {
                if ($film['deleted'] == 'true') {
                    Pwyw_Film::delete($film['id']);
                    continue;
                }
                $obj = new Pwyw_Film($film['id']);
                $obj->bundle_id       = $bundle_id;
                $obj->sort            = $film['sort'];
                $obj->title           = $film['title'];
                $obj->image           = $film['image'];
                $obj->altimage           = $film['altimage'];
				
                $obj->rating          = $film['rating'];
                $obj->linkedpage          = $film['linkedpage'];

                $obj->embed           = $film['embed'];
                $obj->logline         = $film['logline'];
                $obj->genre           = $film['genre'];
                $obj->runtime         = $film['runtime'];
                $obj->director        = $film['director'];
                $obj->writers         = $film['writers'];
                $obj->stars           = $film['stars'];
                $obj->website         = $film['website'];
                $obj->filmmaker_note  = $film['filmmaker_note'];
                $obj->filmmaker_image = $film['filmmaker_image'];
                $obj->filmmaker_name  = $film['filmmaker_name'];
                $obj->curator_note    = $film['curator_note'];
                $obj->curator_image   = $film['curator_image'];
                $obj->curator_name    = $film['curator_name'];
                $obj->user_reviews    = isset($film['user_reviews']) ? 1 : 0;
                $obj->meta            = serialize($film['meta']);
                $obj->save();
            }

            if (array_key_exists('features', $film)) {
                self::saveFeatures($obj->id, $film['features']);
            }

            if (array_key_exists('reviews', $film)) {
                self::saveReviews($obj->id, $film['reviews']);
            }
        }
    }

    public static function saveFeatures($film_id, $features)
    {
        foreach ($features as $feature) {
            $feature = stripslashes_deep($feature);
            if (!$feature['id']) {
                if ($feature['deleted'] == 'true') {
                    continue;
                }
                $obj = Pwyw_Feature::create(
                    $film_id,
                    $feature['image'],
                    $feature['title'],
                    $feature['subtitle'],
                    $feature['runtime']
                );
            } else {
                if ($feature['deleted'] == 'true') {
                    Pwyw_Feature::delete($feature['id']);
                    continue;
                }
                $obj = new Pwyw_Feature($feature['id']);
                $obj->film_id  = $film_id;
                $obj->image    = $feature['image'];
                $obj->title    = $feature['title'];
                $obj->subtitle = $feature['subtitle'];
                $obj->runtime  = $feature['runtime'];
            }
            $obj->save();
        }
    }

    public static function saveReviews($film_id, $reviews)
    {
        foreach ($reviews as $review) {
            $review = stripslashes_deep($review);
            if (!$review['id']) {
                if ($review['deleted'] == 'true') {
                    continue;
                }
                $obj = Pwyw_Review::create(
                    $film_id,
                    $review['review'],
                    $review['author'],
                    $review['publication'],
                    $review['image'],
                    $review['link']
                );
            } else {
                if ($review['deleted'] == 'true') {
                    Pwyw_Review::delete($review['id']);
                    continue;
                }
                $obj = new Pwyw_Review($review['id']);
                $obj->film_id     = $film_id;
                $obj->review      = $review['review'];
                $obj->author      = $review['author'];
                $obj->publication = $review['publication'];
                $obj->image       = $review['image'];
                $obj->link        = $review['link'];
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
                ORDER BY sort ASC";

        return $wpdb->get_results($sql, OBJECT);
    }

    /**
     * Returns an object with all features for specified film.
     */
    public static function allFeatures($film_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FEATURES;
        $sql = "SELECT * FROM {$table}
                WHERE film_id = {$film_id}
                ORDER BY title ASC";

        return $wpdb->get_results($sql, OBJECT);
    }

    /**
     * Returns an object with all reviews for specified film.
     */
    public static function allReviews($film_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::REVIEWS;
        $sql = "SELECT * FROM {$table}
                WHERE film_id = {$film_id}
                ORDER BY id ASC";

        return $wpdb->get_results($sql, OBJECT);
    }


    /**
     * Deletes all films associated with the bundle.
     */
    public static function delete($bundle_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FILMS;

        // Build an array of all film id's we're going to delete.
        $sql = "SELECT id FROM {$table}
                 WHERE bundle_id = {$bundle_id}";

        $ids = $wpdb->get_results($sql, ARRAY_N);
        $filmIds = array();
        foreach ($ids as $id) {
            array_push($filmIds, $id[0]);
        }

        // Delete the reviews and special features
        foreach ($filmIds as $id) {
            Pwyw_Feature::deleteByFilm($id);
            Pwyw_Review::deleteByFilm($id);
        }

        // Delete the films
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
