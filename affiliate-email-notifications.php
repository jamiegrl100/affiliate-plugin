<?php

// Function to send an email notification to an affiliate
if (!function_exists('send_affiliate_notification')) {
    function send_affiliate_notification($affiliate_id, $subject, $message) {
        $affiliate = get_user_by('id', $affiliate_id);
        $email = $affiliate->user_email;
        
        wp_mail($email, $subject, $message);
    }
}

// Notify affiliate about a new commission
if (!function_exists('notify_new_commission')) {
    function notify_new_commission($order_id) {
        $order = wc_get_order($order_id);
        $affiliate_id = sanitize_text_field(get_post_meta($order_id, 'affiliate_id', true));
        
        $subject = "New Commission Earned";
        $message = "Congratulations! You have earned a new commission on order #" . $order_id;
        
        send_affiliate_notification($affiliate_id, $subject, $message);
    }
    add_action('woocommerce_thankyou', 'notify_new_commission');
}

// Notify affiliate about MLM commission
if (!function_exists('notify_mlm_commission')) {
    function notify_mlm_commission($parent_affiliate_id, $order_id) {
        $subject = "New MLM Commission Earned";
        $message = "Congratulations! You have earned a new MLM commission on order #" . $order_id;
        
        send_affiliate_notification($parent_affiliate_id, $subject, $message);
    }
}

// Notify affiliate about payout processing
if (!function_exists('notify_payout_processed')) {
    function notify_payout_processed($affiliate_id) {
        $subject = "Payout Processed";
        $message = "Your payout has been processed.";
        
        send_affiliate_notification($affiliate_id, $subject, $message);
    }
}

// Notify affiliate about referral bonus
if (!function_exists('notify_referral_bonus')) {
    function notify_referral_bonus($referrer_id) {
        $subject = "Referral Bonus Awarded";
        $message = "Congratulations! You have earned a referral bonus.";
        
        send_affiliate_notification($referrer_id, $subject, $message);
    }
}

?>
