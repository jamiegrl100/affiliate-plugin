<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function track_affiliate_referral() {
    if ( isset( $_GET['ref'] ) && isset( $_GET['product_id'] ) ) {
        $referral = sanitize_text_field( $_GET['ref'] );
        $product_id = intval( $_GET['product_id'] );
        setcookie( 'affiliate_referral', $referral, time() + (86400 * 30), '/' ); // 30-day cookie
        setcookie( 'affiliate_product', $product_id, time() + (86400 * 30), '/' ); // 30-day cookie
    }
}
add_action( 'init', 'track_affiliate_referral' );
?>
