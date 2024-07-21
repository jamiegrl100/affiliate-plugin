<?php

if (!function_exists('award_referral_bonus')) {
    function award_referral_bonus($referrer_id, $referred_id) {
        global $wpdb;
        $bonus_amount = 10; // Bonus amount

        $wpdb->insert(
            $wpdb->prefix . 'affiliate_commissions',
            array(
                'order_id'      => 0,
                'affiliate_id'  => intval($referrer_id),
                'product_id'    => 0,
                'commission'    => $bonus_amount,
                'date'          => current_time('mysql'),
            )
        );

        // Notify referrer
        notify_referral_bonus($referrer_id);
    }
}

if (!function_exists('check_new_affiliate_referrals')) {
    function check_new_affiliate_referrals($affiliate_id) {
        // This function checks if a new affiliate has been referred
        // Placeholder logic, replace with actual referral tracking logic
        $referrer_id = get_user_meta($affiliate_id, 'referrer_id', true);
        if ($referrer_id) {
            award_referral_bonus($referrer_id, $affiliate_id);
        }
    }

    // Hook this function to the user registration action
    add_action('user_register', 'check_new_affiliate_referrals');
}

?>
