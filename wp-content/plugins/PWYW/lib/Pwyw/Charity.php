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

    /**
     * Save a charity in the database.
     */
    public function save()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::CHARITIES;

        $data =  array(
            'bundle_id' => $this->bundle_id,
            'title' => $this->title,
            'image' => $this->image,
            'embed' => $this->embed,
            'description' => $this->description
        );

        if ($this->id == null) {
            // Insert new provider
            $wpdb->insert($table, $data, null);
            $res = ($wpdb->insert_id == 0) ? false : true;
        } else {
            // Update existing provider
            $res = $wpdb->update($table, $data, array('id' => $this->id), null);
        }
        return $res;
    }


    // -------------------------------------------------------------------------
    // Static methods
    // -------------------------------------------------------------------------

    /**
     * Create a new Charity
     */
    public static function create(
        $bundle_id,
        $title,
        $image,
        $embed,
        $description
    ) {
        $charity = new Pwyw_Charity;
        $charity->bundle_id = $bundle_id;
        $charity->title = $title;
        $charity->image = $image;
        $charity->embed = $embed;
        $charity->description = $description;
        return $charity;
    }

    public static function delete()
    {
    }

    public static function all()
    {
    }
}
