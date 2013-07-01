<?php
/**
 * Class to handle charities.
 */
class Pwyw_Charities
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
        add_action('wp_ajax_pwyw_add_charity', array(&$this, 'addCharity'));
    }

    public function addCharity()
    {
        $array_id = $_POST['array_id'];
        $data = array('array_id' => $array_id, 'id' => '');
        $charity = Pwyw_View::make('charity', $data);
        echo $charity;
        die();
    }

    // -------------------------------------------------------------------------
    // Static methods
    // -------------------------------------------------------------------------

    public static function save($bundle_id)
    {
        $charities = isset($_POST['charities']) ? $_POST['charities'] : array();

        foreach ($charities as $charity) {
            if (!$charity['id']) {
                $ch = Pwyw_Charity::create(
                    $bundle_id,
                    $charity['title'],
                    $charity['image'],
                    $charity['embed'],
                    $charity['description']
                );
            } else {
                $ch = new Pwyw_Charity($charity['id']);
                $ch->bundle_id = $bundle_id;
                $ch->title = $charity['title'];
                $ch->image = $charity['image'];
                $ch->embed = $charity['embed'];
                $ch->description = $charity['description'];
            }
            var_dump($ch);
            // $ch->save();
        }
        die('save edit bundle!');
    }

    /**
     * Returns an object with all charities for specified bundle.
     */
    public static function all($bundle_id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::CHARITIES;
        $sql = "SELECT * FROM {$table}
                WHERE bundle_id = {$bundle_id}
                ORDER BY title ASC";

        return $wpdb->get_results($sql, OBJECT);
    }
}
