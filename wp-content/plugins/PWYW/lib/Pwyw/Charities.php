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

    public static function save()
    {
        var_dump($_REQUEST['bundle']);
        var_dump($_POST);
        die('save edit bundle!');
    }

    public static function create()
    {
    }

    public static function delete()
    {
    }

    public static function all()
    {
    }
}
