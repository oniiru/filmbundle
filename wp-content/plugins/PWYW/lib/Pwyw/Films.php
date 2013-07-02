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
    }

    public function addFilm()
    {
        $array_id = $_POST['array_id'];

        // Create a default, empty film object
        $film = new stdClass;
        $film->bundle_id = '';
        $film->title     = '';
        $film->image     = '';
        $film->rating    = '';
        $film->embed     = '';
        $film->logline   = '';
        $film->genre     = '';
        $film->runtime   = '';
        $film->director  = '';
        $film->writers   = '';
        $film->stars     = '';
        $film->website   = '';
        $film->note      = '';

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
        $charities = isset($_POST['charities']) ? $_POST['charities'] : array();

        foreach ($charities as $charity) {
            $charity = stripslashes_deep($charity);
            // var_dump($charity);

            if (!$charity['id']) {
                if ($charity['deleted'] == 'true') {
                    continue;
                }
                $ch = Pwyw_Charity::create(
                    $bundle_id,
                    $charity['title'],
                    $charity['image'],
                    $charity['embed'],
                    $charity['description']
                );
            } else {
                if ($charity['deleted'] == 'true') {
                    Pwyw_Charity::delete($charity['id']);
                    continue;
                }
                $ch = new Pwyw_Charity($charity['id']);
                $ch->bundle_id = $bundle_id;
                $ch->title = $charity['title'];
                $ch->image = $charity['image'];
                $ch->embed = $charity['embed'];
                $ch->description = $charity['description'];
            }
            $ch->save();
        }
    }

    /**
     * Returns an object with all charities for specified bundle.
     */
    public static function all($bundle_id)
    {
        return array();
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::CHARITIES;
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
        $table = $prefix.Pwyw_Database::CHARITIES;

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
