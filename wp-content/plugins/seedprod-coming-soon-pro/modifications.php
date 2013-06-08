<?php
// Custom modifications of the seedprod plugin

class SeedProdCustomization
{
    public function __construct()
    {
        add_action('user_register', array(&$this, 'registrationSubscribe'));
    }

    /**
     * Hooks into WP user registration, and automatically adds new user's to the
     * subscriber database.
     */
    public function registrationSubscribe($user_id)
    {
        // Collect user data from the db
        $userdata = get_userdata($user_id);
        $fname = $user_info->user_firstname;
        $lname = $user_info->user_lastname;
        $email = $userdata->user_email;

        // Add to DB
        global $seed_csp3;
        if ($email) {
            $seed_csp3->add_subscriber($email, $fname, $lname);
        }
    }
}

new SeedProdCustomization;
