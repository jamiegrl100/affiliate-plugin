<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function affiliate_dashboard() {
    ob_start();
    ?>
    <div class="affiliate-dashboard">
        <h2>Affiliate Dashboard</h2>
        <p>Welcome to your dashboard. Here you can find your performance metrics and other useful information.</p>
        <!-- Add dashboard content here -->
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'affiliate_dashboard', 'affiliate_dashboard' );
?>