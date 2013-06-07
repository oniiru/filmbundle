<?php
// Custom modifications of the seedprod plugin

class SeedProdCustomization
{
    public function __construct()
    {
        add_action('user_register', array(&$this, 'registrationSubscribe'));
        add_action('wsl_hook_process_login_after_create_wp_user', array(&$this, 'registrationSubscribe'));
		
		
    }

    /**
     * Hooks into WP user registration, and automatically adds new user's to the
     * subscriber database.
     */
    public function registrationSubscribe($user_id)
    {
        global $seed_csp3;

        $fname = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $email = isset($_POST['user_email']) ? $_POST['user_email'] : null;

        // Add to DB
        if ($email) {
            $seed_csp3->add_subscriber($email, $fname, '');
        }
    }
}

new SeedProdCustomization;
