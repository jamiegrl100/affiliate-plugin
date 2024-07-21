<?php

// Function to record affiliate commissions
function record_affiliate_commission($order_id) {
    $order = wc_get_order($order_id);
    $items = $order->get_items();
    $affiliate_id = sanitize_text_field(get_post_meta($order_id, 'affiliate_id', true));

    // Get custom commission rate from ACF
    $commission_rate = floatval(get_field('affiliate_commission_rate', 'user_' . $affiliate_id));

    foreach ($items as $item) {
        $product_id = intval($item->get_product_id());
        $product_commission_rate = floatval(get_post_meta($product_id, 'commission_rate', true));
        $final_commission_rate = $commission_rate ?: $product_commission_rate; // Use custom rate or fallback to product rate
        $commission = floatval($item->get_total()) * ($final_commission_rate / 100);

        global $wpdb;
        $wpdb->insert(
            $wpdb->prefix . 'affiliate_commissions',
            array(
                'order_id'      => intval($order_id),
                'affiliate_id'  => intval($affiliate_id),
                'product_id'    => $product_id,
                'commission'    => $commission,
                'date'          => current_time('mysql'),
            )
        );
    }
}
add_action('woocommerce_thankyou', 'record_affiliate_commission');
add_action('woocommerce_thankyou', 'record_affiliate_commission');


// Additional functions for managing commissions

// Get all commissions for a specific affiliate
function get_affiliate_commissions($affiliate_id) {
    global $wpdb;
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}affiliate_commissions WHERE affiliate_id = %d ORDER BY date DESC",
        intval($affiliate_id)
    ));

    return $results;
}

// Get total commissions for a specific affiliate
function get_total_affiliate_commissions($affiliate_id) {
    global $wpdb;
    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT SUM(commission) as total_commission FROM {$wpdb->prefix}affiliate_commissions WHERE affiliate_id = %d",
        intval($affiliate_id)
    ));

    return $result ? $result->total_commission : 0;
}

// Shortcode to display affiliate commissions
function affiliate_commissions_shortcode($atts) {
    $atts = shortcode_atts(array(
        'affiliate_id' => get_current_user_id(),
    ), $atts, 'affiliate_commissions');

    $commissions = get_affiliate_commissions($atts['affiliate_id']);

    if ($commissions) {
        ob_start();
        echo '<table>';
        echo '<tr><th>Order ID</th><th>Product ID</th><th>Commission</th><th>Date</th></tr>';
        foreach ($commissions as $commission) {
            echo '<tr>';
            echo '<td>' . esc_html($commission->order_id) . '</td>';
            echo '<td>' . esc_html($commission->product_id) . '</td>';
            echo '<td>' . esc_html(number_format($commission->commission ?? 0, 2)) . '</td>';
            echo '<td>' . esc_html($commission->date) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        return ob_get_clean();
    } else {
        return '<p>No commissions found.</p>';
    }
}
add_shortcode('affiliate_commissions', 'affiliate_commissions_shortcode');

// Shortcode to display total affiliate commissions
function total_affiliate_commissions_shortcode($atts) {
    $atts = shortcode_atts(array(
        'affiliate_id' => get_current_user_id(),
    ), $atts, 'total_affiliate_commissions');

    $total_commissions = get_total_affiliate_commissions($atts['affiliate_id']);

    return '<p>Total Commissions Earned: $' . esc_html(number_format($total_commissions ?? 0, 2)) . '</p>';
}
add_shortcode('total_affiliate_commissions', 'total_affiliate_commissions_shortcode');

?>
