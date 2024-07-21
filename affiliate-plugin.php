<?php
/**
 * Plugin Name: Affiliate Program Plugin
 * Description: A comprehensive affiliate program plugin for WordPress.
 * Version: 1.0
 * Author: Jamie Folsom and Code Copilot
 * Text Domain: affiliate-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Include necessary files
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-cpt.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-registration-handler.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-registration-form.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-dashboard.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-tracking.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-commissions.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-reports.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-shortcodes.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/admin-interface.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-links.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/email-notifications.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/fraud-detection.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-payouts.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/affiliate-commissions-table.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/email-templates.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/email-sender.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/admin-email-campaigns.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-leaderboard.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-analytics.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-reporting.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-email-notifications.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-mlm.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-payout-threshold.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-referral-bonuses.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-social-media.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-custom-fields.php';
include_once plugin_dir_path(__FILE__) . 'includes/affiliate-thank-you.php';

// Add a settings page to the admin menu
function affiliate_plugin_menu() {
    add_menu_page(
        'Affiliate Settings',
        'Affiliate Settings',
        'manage_options',
        'affiliate-settings',
        'affiliate_plugin_settings_page',
        'dashicons-admin-generic'
    );
    add_submenu_page(
        'affiliate-settings',
        'Affiliate Payouts',
        'Affiliate Payouts',
        'manage_options',
        'affiliate-payouts',
        'affiliate_payout_page'
    );
    add_submenu_page(
        'affiliate-settings',
        'Affiliate Reports',
        'Affiliate Reports',
        'manage_options',
        'affiliate-reports',
        'affiliate_reports_page'
    );
}
add_action('admin_menu', 'affiliate_plugin_menu');

// Display the settings page
function affiliate_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Affiliate Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('affiliate_plugin_settings');
            do_settings_sections('affiliate-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function affiliate_plugin_settings_init() {
    register_setting('affiliate_plugin_settings', 'affiliate_payout_threshold');

    add_settings_section(
        'affiliate_plugin_settings_section',
        'Payout Settings',
        null,
        'affiliate-settings'
    );

    add_settings_field(
        'affiliate_payout_threshold',
        'Payout Threshold',
        'affiliate_payout_threshold_render',
        'affiliate-settings',
        'affiliate_plugin_settings_section'
    );
}
add_action('admin_init', 'affiliate_plugin_settings_init');

// Render the payout threshold field
function affiliate_payout_threshold_render() {
    $value = get_option('affiliate_payout_threshold', 50);
    ?>
    <input type="number" name="affiliate_payout_threshold" value="<?php echo esc_attr($value); ?>" />
    <?php
}

function affiliate_plugin_activate() {
    // Create Affiliate role
    add_role('affiliate', 'Affiliate', array(
        'read' => true,
    ));

    // Create or update the database table
    global $wpdb;
    $table_name = $wpdb->prefix . 'affiliate_commissions';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        affiliate_id bigint(20) NOT NULL,
        amount decimal(10, 2) NOT NULL,
        type varchar(20) NOT NULL,
        date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // Trigger activation functions
    affiliate_register_post_type();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'affiliate_plugin_activate');

// Deactivation hook
function affiliate_plugin_deactivate() {
    // Trigger deactivation functions
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'affiliate_plugin_deactivate');
?>
