<?php
function affiliate_thank_you_shortcode() {
    ob_start(); ?>
    <h2>Thank You for Registering!</h2>
    <p>Your registration was successful. You can now log in and start promoting our products as an affiliate.</p>
    <?php
    return ob_get_clean();
}
add_shortcode('affiliate_thank_you', 'affiliate_thank_you_shortcode');
