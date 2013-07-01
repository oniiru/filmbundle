<?php
/**
 * Class to hold charity entities.
 */
class Pwyw_Charity
{
    /** Holds the data for the charity instance */
    public $id = null;
    public $bundle_id = null;
    public $title;
    public $image;
    public $embed;
    public $description;

    public function __construct($id = 0)
    {
        if ($id > 0) {
            $this->id = $id;
            if (!$this->load()) {
                $this->id = null;
            }
        }
    }

    private function load()
    {
    }

    public function save()
    {
    }


    // -------------------------------------------------------------------------
    // Static methods
    // -------------------------------------------------------------------------

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
