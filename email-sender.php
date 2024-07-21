<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function send_email_to_affiliate( $affiliate_id, $subject, $template_name, $data ) {
    $affiliate_email = get_post_meta( $affiliate_id, 'affiliate_email', true );
    $affiliate_name = get_the_title( $affiliate_id );
    $data['affiliate_name'] = $affiliate_name;
    
    $message = get_email_template( $template_name, $data );
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    wp_mail( $affiliate_email, $subject, $message, $headers );
}
?>
