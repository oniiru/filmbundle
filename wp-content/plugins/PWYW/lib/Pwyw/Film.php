<?php
/**
 * Class to hold film entities.
 */
class Pwyw_Film
{
    /** Holds the data for the film instance */
    public $id = null;
    public $bundle_id = null;
    public $sort = 0;
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
    public $filmmaker_note;
    public $filmmaker_image;
    public $filmmaker_name;
    public $curator_note;
    public $curator_image;
    public $curator_name;
    public $user_reviews;
    public $linkedpage;
    public $meta;

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
        $this->bundle_id       = $film->bundle_id;
        $this->sort            = $film->sort;
        $this->title           = $film->title;
        $this->image           = $film->image;
        $this->altimage           = $film->altimage;
        $this->rating          = $film->rating;
        $this->linkedpage      = $film->linkedpage;
        $this->embed           = $film->embed;
        $this->logline         = $film->logline;
        $this->genre           = $film->genre;
        $this->runtime         = $film->runtime;
        $this->director        = $film->director;
        $this->writers         = $film->writers;
        $this->stars           = $film->stars;
        $this->website         = $film->website;
        $this->filmmaker_note  = $film->filmmaker_note;
        $this->filmmaker_image = $film->filmmaker_image;
        $this->filmmaker_name  = $film->filmmaker_name;
        $this->curator_note    = $film->curator_note;
        $this->curator_image   = $film->curator_image;
        $this->curator_name    = $film->curator_name;
        $this->user_reviews    = $film->user_reviews;
        $this->meta            = $film->meta;
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
            'bundle_id'       => $this->bundle_id,
            'sort'            => $this->sort,
            'title'           => $this->title,
            'image'           => $this->image,
            'altimage'           => $this->altimage,
			
            'rating'          => $this->rating,
			'linkedpage'      => $this->linkedpage,
            'embed'           => $this->embed,
            'logline'         => $this->logline,
            'genre'           => $this->genre,
            'runtime'         => $this->runtime,
            'director'        => $this->director,
            'writers'         => $this->writers,
            'stars'           => $this->stars,
            'website'         => $this->website,
            'filmmaker_note'  => $this->filmmaker_note,
            'filmmaker_image' => $this->filmmaker_image,
            'filmmaker_name'  => $this->filmmaker_name,
            'curator_note'    => $this->curator_note,
            'curator_image'   => $this->curator_image,
            'curator_name'    => $this->curator_name,
            'user_reviews'    => $this->user_reviews,
            'meta'            => $this->meta
        );

        if ($this->id == null) {
            // Insert new film
            $wpdb->insert($table, $data, null);
            $this->id = $wpdb->insert_id;
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
        $sort,
        $title,
        $image,
		$altimage,
        $rating,
        $linkedpage,
        $embed,
        $logline,
        $genre,
        $runtime,
        $director,
        $writers,
        $stars,
        $website,
        $filmmaker_note,
        $filmmaker_image,
        $filmmaker_name,
        $curator_note,
        $curator_image,
        $curator_name,
        $user_reviews,
        $meta
    ) {
        $film = new Pwyw_Film;
        $film->bundle_id       = $bundle_id;
        $film->sort            = $sort;
        $film->title           = $title;
        $film->image           = $image;
        $film->altimage           = $altimage;
		
        $film->rating          = $rating;
		$film->linkedpage      = $linkedpage;
        $film->embed           = $embed;
        $film->logline         = $logline;
        $film->genre           = $genre;
        $film->runtime         = $runtime;
        $film->director        = $director;
        $film->writers         = $writers;
        $film->stars           = $stars;
        $film->website         = $website;
        $film->filmmaker_note  = $filmmaker_note;
        $film->filmmaker_image = $filmmaker_image;
        $film->filmmaker_name  = $filmmaker_name;
        $film->user_reviews    = $user_reviews;
        $film->meta            = $meta;
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

        // Delete associated reviews and special features
        Pwyw_Feature::deleteByFilm($id);
        Pwyw_Review::deleteByFilm($id);

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
