<?php

function affiliate_detailed_reports_shortcode() {
    global $wpdb;
    $affiliate_id = get_current_user_id();

    // Get detailed commissions data
    $commissions = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}affiliate_commissions WHERE affiliate_id = %d ORDER BY date DESC",
        $affiliate_id
    ));

    // Get conversion rates and traffic sources
    $conversion_rate = calculate_conversion_rate($affiliate_id);
    $traffic_sources = get_traffic_sources($affiliate_id);

    ob_start();
    ?>
    <div class="affiliate-reports">
        <h2>Detailed Reports</h2>
        <h3>Commissions</h3>
        <table>
            <tr><th>Order ID</th><th>Product ID</th><th>Commission</th><th>Date</th></tr>
            <?php foreach ($commissions as $commission): ?>
                <tr>
                    <td><?php echo esc_html($commission->order_id); ?></td>
                    <td><?php echo esc_html($commission->product_id); ?></td>
                    <td><?php echo esc_html(number_format($commission->commission, 2)); ?></td>
                    <td><?php echo esc_html($commission->date); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Conversion Rate</h3>
        <p><?php echo esc_html($conversion_rate); ?>%</p>

        <h3>Traffic Sources</h3>
        <ul>
            <?php foreach ($traffic_sources as $source => $count): ?>
                <li><?php echo esc_html($source); ?>: <?php echo esc_html($count); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}

function calculate_conversion_rate($affiliate_id) {
    // Calculate conversion rate for the affiliate
    // This is just a placeholder function, replace with actual logic
    return rand(1, 100);
}

function get_traffic_sources($affiliate_id) {
    // Get traffic sources for the affiliate
    // This is just a placeholder function, replace with actual logic
    return [
        'Google' => rand(1, 100),
        'Facebook' => rand(1, 100),
        'Twitter' => rand(1, 100)
    ];
}

add_shortcode('affiliate_detailed_reports', 'affiliate_detailed_reports_shortcode');

?>
