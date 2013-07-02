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
    public $user_reviews;

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

        // We found the film, let's populate the object
        $this->bundle_id    = $film->bundle_id;
        $this->title        = $film->title;
        $this->image        = $film->image;
        $this->rating       = $film->rating;
        $this->embed        = $film->embed;
        $this->logline      = $film->logline;
        $this->genre        = $film->genre;
        $this->runtime      = $film->runtime;
        $this->director     = $film->director;
        $this->writers      = $film->writers;
        $this->stars        = $film->stars;
        $this->website      = $film->website;
        $this->note         = $film->note;
        $this->user_reviews = $film->user_reviews;
        return true;
    }

    /**
     * Save a film in the database.
     */
    public function save()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FILMS;

        $data =  array(
            'bundle_id'    => $this->bundle_id,
            'title'        => $this->title,
            'image'        => $this->image,
            'rating'       => $this->rating,
            'embed'        => $this->embed,
            'logline'      => $this->logline,
            'genre'        => $this->genre,
            'runtime'      => $this->runtime,
            'director'     => $this->director,
            'writers'      => $this->writers,
            'stars'        => $this->stars,
            'website'      => $this->website,
            'note'         => $this->note,
            'user_reviews' => $this->user_reviews,
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
     * Create a new film
     */
    public static function create(
        $bundle_id,
        $title,
        $image,
        $rating,
        $embed,
        $logline,
        $genre,
        $runtime,
        $director,
        $writers,
        $stars,
        $website,
        $note,
        $user_reviews
    ) {
        $film = new Pwyw_Film;
        $film->bundle_id    = $bundle_id;
        $film->title        = $title;
        $film->image        = $image;
        $film->rating       = $rating;
        $film->embed        = $embed;
        $film->logline      = $logline;
        $film->genre        = $genre;
        $film->runtime      = $runtime;
        $film->director     = $director;
        $film->writers      = $writers;
        $film->stars        = $stars;
        $film->website      = $website;
        $film->note         = $note;
        $film->user_reviews = $user_reviews;
        return $film;
    }

    /**
     * Delete a film
     */
    public static function delete($id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::FILMS;

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
