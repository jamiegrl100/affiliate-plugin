<?php

if (!function_exists('check_payout_threshold')) {
    function check_payout_threshold($affiliate_id) {
        global $wpdb;
        $threshold = get_option('affiliate_payout_threshold', 50); // Default to $50 if not set
        $total_commissions = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(commission) FROM {$wpdb->prefix}affiliate_commissions WHERE affiliate_id = %d",
            $affiliate_id
        ));

        return $total_commissions >= $threshold;
    }
}

if (!function_exists('process_affiliate_payout')) {
    function process_affiliate_payout($affiliate_id) {
        if (check_payout_threshold($affiliate_id)) {
            // Process payout
            // This is just a placeholder function, replace with actual logic
            notify_payout_processed($affiliate_id);
        }
    }

    // Hook this function to a cron job or admin action to process payouts regularly
    add_action('process_affiliate_payouts', 'process_affiliate_payout');
}

?>
