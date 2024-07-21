<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function send_affiliate_notification( $affiliate_id, $subject, $message ) {
    $affiliate_email = get_post_meta( $affiliate_id, 'affiliate_email', true );
    if ( $affiliate_email ) {
        wp_mail( $affiliate_email, $subject, $message );
    }
}

function notify_new_commission( $order_id ) {
    if ( isset( $_COOKIE['affiliate_referral'] ) ) {
        $affiliate_referral = sanitize_text_field( $_COOKIE['affiliate_referral'] );
        $order = wc_get_order( $order_id );

        $subject = 'New Commission Earned!';
        $message = 'Congratulations! You have earned a new commission for order #' . $order_id . '.';

        send_affiliate_notification( $affiliate_referral, $subject, $message );
    }
}
add_action( 'woocommerce_order_status_completed', 'notify_new_commission' );
?>
