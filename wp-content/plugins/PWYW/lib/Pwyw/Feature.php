<?php
/**
 * Class to hold special feature entities.
 */
class Pwyw_Feature
{
    /** Holds the data for the special feature instance */
    public $id = null;
    public $film_id = null;
    public $image;
    public $title;
    public $subtitle;

    /**
     * Save a special feature in the database.
     */
    public function save()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FEATURES;

        $data =  array(
            'film_id'  => $this->film_id,
            'image'    => $this->image,
            'title'    => $this->title,
            'subtitle' => $this->subtitle
        );

        if ($this->id == null) {
            // Insert new film
            $wpdb->insert($table, $data, null);
            $res = ($wpdb->insert_id == 0) ? false : true;
        } else {
            // Update existing film
            $res = $wpdb->update($table, $data, array('id' => $this->id), null);
        }
        return $res;
    }


    // -------------------------------------------------------------------------
    // Static methods
    // -------------------------------------------------------------------------

    /**
     * Create a new special feature
     */
    public static function create(
        $film_id,
        $image,
        $title,
        $subtitle
    ) {
        $feature = new Pwyw_Feature;
        $feature->film_id  = $film_id;
        $feature->image    = $image;
        $feature->title    = $title;
        $feature->subtitle = $subtitle;
        return $feature;
    }

    /**
     * Delete a special feature
     */
    public static function delete($id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FEATURES;

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
