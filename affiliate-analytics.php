<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function display_affiliate_analytics() {
    global $wpdb;
    $current_user = wp_get_current_user();
    $affiliate = get_posts( array(
        'post_type' => 'affiliate',
        'meta_key'  => 'affiliate_email',
        'meta_value' => $current_user->user_email,
    ) );

    if ( ! $affiliate ) {
        return '<p>You are not an affiliate yet.</p>';
    }

    $affiliate_id = $affiliate[0]->ID;
    $table_name = $wpdb->prefix . 'affiliate_commissions';

    $commissions = $wpdb->get_results( $wpdb->prepare(
        "SELECT SUM(commission) as total_commission, COUNT(order_id) as total_orders
        FROM $table_name
        WHERE affiliate_id = %d", $affiliate_id
    ) );

    $total_commission = $commissions[0]->total_commission ?? 0;
    $total_orders = $commissions[0]->total_orders ?? 0;

    ob_start();
    ?>
    <div class="affiliate-analytics">
        <h2>Your Performance Analytics</h2>
        <p>Total Commissions Earned: $<?php echo number_format( (float) $total_commission, 2 ); ?></p>
        <p>Total Orders Referred: <?php echo intval( $total_orders ); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'affiliate_analytics', 'display_affiliate_analytics' );
?>
