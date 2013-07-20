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
    public $url;
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


    // -------------------------------------------------------------------------
    // I/O
    // -------------------------------------------------------------------------

    /**
     * Load a charity
     */
    private function load()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::CHARITIES;
        $sql = "SELECT * from {$table} WHERE id = {$this->id}";
        $charity = $wpdb->get_row($sql, OBJECT);

        // No charity with that id
        if (is_null($charity)) {
            return false;
        }

        // We found the charity, let's populate the object
        $this->bundle_id = $charity->bundle_id;
        $this->title = $charity->title;
        $this->image = $charity->image;
        $this->image = $charity->url;
        $this->embed = $charity->embed;
        $this->description = $charity->description;
        return true;
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
            'url'   => $this->url,
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
        $url,
        $embed,
        $description
    ) {
        $charity = new Pwyw_Charity;
        $charity->bundle_id = $bundle_id;
        $charity->title = $title;
        $charity->image = $image;
        $charity->url   = $url;
        $charity->embed = $embed;
        $charity->description = $description;
        return $charity;
    }

    /**
     * Delete a charity
     */
    public static function delete($id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::CHARITIES;

        return $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$table}
                 WHERE id = %d
                ",
                $id
            )
        );
    }
}
