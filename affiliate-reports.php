<?php
function affiliate_reports_page() {
    global $wpdb;

    // Get total affiliates
    $total_affiliates = count(get_users(array('role' => 'affiliate')));

    // Get commissions paid
    $total_commissions_paid = $wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}affiliate_commissions WHERE type = 'payout'");
    $total_commissions_paid = $total_commissions_paid ? floatval($total_commissions_paid) : 0.0;

    // Get total earnings
    $total_earnings = $wpdb->get_var("SELECT SUM(amount) FROM {$wpdb->prefix}affiliate_commissions WHERE type = 'commission'");
    $total_earnings = $total_earnings ? floatval($total_earnings) : 0.0;

    // Calculate profit
    $profit = $total_earnings - $total_commissions_paid;

    // Get new affiliates per day, week, month
    $new_affiliates_day = count(get_users(array('role' => 'affiliate', 'date_query' => array('after' => '1 day ago'))));
    $new_affiliates_week = count(get_users(array('role' => 'affiliate', 'date_query' => array('after' => '1 week ago'))));
    $new_affiliates_month = count(get_users(array('role' => 'affiliate', 'date_query' => array('after' => '1 month ago'))));

    ?>
    <div class="wrap">
        <h1>Affiliate Reports</h1>
        <?php if ($total_affiliates > 0) : ?>
            <h2>Overall Statistics</h2>
            <table class="wp-list-table widefat fixed striped">
                <tbody>
                    <tr>
                        <th>Total Affiliates</th>
                        <td><?php echo esc_html($total_affiliates); ?></td>
                    </tr>
                    <tr>
                        <th>Total Commissions Paid</th>
                        <td>$<?php echo number_format($total_commissions_paid, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Total Earnings</th>
                        <td>$<?php echo number_format($total_earnings, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Profit</th>
                        <td>$<?php echo number_format($profit, 2); ?></td>
                    </tr>
                </tbody>
            </table>
            <h2>New Affiliates</h2>
            <table class="wp-list-table widefat fixed striped">
                <tbody>
                    <tr>
                        <th>Past Day</th>
                        <td><?php echo esc_html($new_affiliates_day); ?></td>
                    </tr>
                    <tr>
                        <th>Past Week</th>
                        <td><?php echo esc_html($new_affiliates_week); ?></td>
                    </tr>
                    <tr>
                        <th>Past Month</th>
                        <td><?php echo esc_html($new_affiliates_month); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else : ?>
            <p>No affiliates found.</p>
        <?php endif; ?>
    </div>
    <?php
}
?>
