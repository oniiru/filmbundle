<?php
/**
 * Class to hold review entities.
 */
class Pwyw_Review
{
    /** Holds the data for the review instance */
    public $id = null;
    public $film_id = null;
    public $review;
    public $author;
    public $publication;
    public $image;
    public $link;

    /**
     * Save a review in the database.
     */
    public function save()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::REVIEWS;

        $data =  array(
            'film_id'     => $this->film_id,
            'review'      => $this->review,
            'author'      => $this->author,
            'publication' => $this->publication,
            'image'       => $this->image,
            'link'        => $this->link,
        );

        if ($this->id == null) {
            // Insert new review
            $wpdb->insert($table, $data, null);
            $res = ($wpdb->insert_id == 0) ? false : true;
        } else {
            // Update existing review
            $res = $wpdb->update($table, $data, array('id' => $this->id), null);
        }
        return $res;
    }


    // -------------------------------------------------------------------------
    // Static methods
    // -------------------------------------------------------------------------

    /**
     * Create a new review
     */
    public static function create(
        $film_id,
        $review,
        $author,
        $publication,
        $image,
        $link
    ) {
        $review = new Pwyw_Review;
        $review->film_id     = $film_id;
        $review->review      = $review;
        $review->author      = $author;
        $review->publication = $publication;
        $review->image       = $image;
        $review->link        = $link;
        return $review;
    }

    /**
     * Delete a review
     */
    public static function delete($id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::REVIEWS;

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
