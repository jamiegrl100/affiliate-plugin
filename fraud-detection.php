<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function detect_fraudulent_activity( $order_id ) {
    if ( isset( $_COOKIE['affiliate_referral'] ) ) {
        $affiliate_referral = sanitize_text_field( $_COOKIE['affiliate_referral'] );
        $order = wc_get_order( $order_id );

        $order_ip = $order->get_meta( '_customer_ip_address', true );
        $affiliate_email = get_post_meta( $affiliate_referral, 'affiliate_email', true );

        if ( $order_ip === $_SERVER['REMOTE_ADDR'] ) {
            // Log fraudulent activity
            $message = 'Possible fraudulent activity detected for affiliate ' . $affiliate_referral . ' with order ' . $order_id;
            error_log( $message );
        }
    }
}
add_action( 'woocommerce_order_status_processing', 'detect_fraudulent_activity' );
?>
