<?php
// Shortcode for displaying the affiliate dashboard
function affiliate_dashboard_shortcode() {
    ob_start();
    affiliate_dashboard();
    return ob_get_clean();
}
add_shortcode('affiliate_dashboard', 'affiliate_dashboard_shortcode');

// Shortcode for displaying the affiliate registration form
function affiliate_registration_shortcode() {
    ob_start();
    affiliate_registration_form();
    return ob_get_clean();
}
add_shortcode('affiliate_registration', 'affiliate_registration_shortcode');

// Shortcode for displaying the affiliate reports
function affiliate_reports_shortcode() {
    ob_start();
    affiliate_reports_page();
    return ob_get_clean();
}
add_shortcode('affiliate_reports', 'affiliate_reports_shortcode');

// Shortcode for displaying the affiliate leaderboard
function affiliate_leaderboard_shortcode() {
    ob_start();
    display_affiliate_leaderboard();
    return ob_get_clean();
}
add_shortcode('affiliate_leaderboard', 'affiliate_leaderboard_shortcode');

// Shortcode for displaying affiliate analytics
function affiliate_analytics_shortcode() {
    ob_start();
    display_affiliate_analytics();
    return ob_get_clean();
}
add_shortcode('affiliate_analytics', 'affiliate_analytics_shortcode');
?>
