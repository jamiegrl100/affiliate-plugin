<?php
function affiliate_registration_form() {
    if (is_user_logged_in()) {
        return '<p>You are already logged in.</p>';
    }

    ob_start(); ?>

    <form id="affiliate-registration-form" action="" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </p>
        <p>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required>
        </p>
        <p>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required>
        </p>
        <p>
            <label for="paypal_email">PayPal Email</label>
            <input type="email" name="paypal_email" id="paypal_email">
        </p>
        <p>
            <input type="submit" name="affiliate_register" value="Register">
        </p>
    </form>

    <?php
    return ob_get_clean();
}
