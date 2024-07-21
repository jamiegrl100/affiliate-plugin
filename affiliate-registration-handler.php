<?php
function handle_affiliate_registration() {
    if (isset($_POST['affiliate_register'])) {
        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $paypal_email = sanitize_email($_POST['paypal_email']);

        $errors = new WP_Error();

        if (username_exists($username) || email_exists($email)) {
            $errors->add('username_email_exists', 'Username or Email already exists.');
        }

        if (empty($errors->errors)) {
            $user_id = wp_create_user($username, $password, $email);

            if (!is_wp_error($user_id)) {
                wp_update_user(array(
                    'ID' => $user_id,
                    'role' => 'affiliate'
                ));
                update_user_meta($user_id, 'first_name', $first_name);
                update_user_meta($user_id, 'last_name', $last_name);
                update_user_meta($user_id, 'paypal_email', $paypal_email);

                // Log the user in
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);

                // Redirect to the thank you page
                wp_redirect(home_url('/thank-you'));
                exit;
            } else {
                $errors->add('registration_failed', 'Registration failed.');
            }
        }

        foreach ($errors->get_error_messages() as $error) {
            echo '<div class="error"><p>' . $error . '</p></div>';
        }
    }
}
add_action('template_redirect', 'handle_affiliate_registration');
