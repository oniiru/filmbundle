<?php
/**
 * Class to hold film entities.
 */
class Pwyw_Film
{
    /** Holds the data for the film instance */
    public $id = null;
    public $bundle_id = null;
    public $title;
    public $image;
    public $rating;
    public $embed;
    public $logline;
    public $genre;
    public $runtime;
    public $director;
    public $writers;
    public $stars;
    public $website;
    public $note;

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
     * Load a film
     */
    private function load()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FILMS;
        $sql = "SELECT * from {$table} WHERE id = {$this->id}";
        $film = $wpdb->get_row($sql, OBJECT);

        // No film with that id
        if (is_null($film)) {
            return false;
        }


    public $id = null;
    public $bundle_id = null;
    public $title;
    public $image;
    public $rating;
    public $embed;
    public $logline;
    public $genre;
    public $runtime;
    public $director;
    public $writers;
    public $stars;
    public $website;
    public $note;


        // We found the charity, let's populate the object
        $this->bundle_id = $charity->bundle_id;
        $this->title     = $charity->title;
        $this->image     = $charity->image;
        $this->rating    = $charity->rating;
        $this->embed     = $charity->embed;
        $this->logline   = $charity->logline;
        $this->genre     = $charity->genre;
        $this->runtime   = $charity->runtime;
        $this->director  = $charity->director;
        $this->writers   = $charity->writers;
        $this->stars     = $charity->stars;
        $this->website   = $charity->website;
        $this->note      = $charity->note;
        return true;
    }

    /**
     * Save a film in the database.
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
     * Create a new film
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

    /**
     * Delete a film
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
