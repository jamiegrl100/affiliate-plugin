<?php

if (!function_exists('display_affiliate_leaderboard')) {
    function display_affiliate_leaderboard() {
        global $wpdb;

        $results = $wpdb->get_results("
            SELECT affiliate_id, SUM(commission) as total_commission
            FROM {$wpdb->prefix}affiliate_commissions
            GROUP BY affiliate_id
            ORDER BY total_commission DESC
            LIMIT 10
        ");

        if ($results) {
            echo '<h2>Top Affiliates</h2>';
            echo '<ul>';
            foreach ($results as $result) {
                $affiliate = get_user_by('id', $result->affiliate_id);
                echo '<li>' . esc_html($affiliate->display_name) . ' - $' . number_format($result->total_commission, 2) . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No affiliates found.</p>';
        }
    }
    add_shortcode('affiliate_leaderboard', 'display_affiliate_leaderboard');
}

?>
