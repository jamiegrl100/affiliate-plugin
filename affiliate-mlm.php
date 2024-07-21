<?php

if (!function_exists('record_mlm_commission')) {
    function record_mlm_commission($order_id) {
        global $wpdb;
        $order = wc_get_order($order_id);
        $affiliate_id = sanitize_text_field(get_post_meta($order_id, 'affiliate_id', true));
        $parent_affiliate_id = get_user_meta($affiliate_id, 'parent_affiliate_id', true);

        if ($parent_affiliate_id) {
            $items = $order->get_items();
            foreach ($items as $item) {
                $product_id = intval($item->get_product_id());
                $commission_rate = floatval(get_post_meta($product_id, 'commission_rate', true)) * 0.1; // 10% of the original commission
                $commission = floatval($item->get_total()) * ($commission_rate / 100);

                $wpdb->insert(
                    $wpdb->prefix . 'affiliate_commissions',
                    array(
                        'order_id'      => intval($order_id),
                        'affiliate_id'  => intval($parent_affiliate_id),
                        'product_id'    => $product_id,
                        'commission'    => $commission,
                        'date'          => current_time('mysql'),
                    )
                );

                // Notify parent affiliate
                notify_mlm_commission($parent_affiliate_id, $order_id);
            }
        }
    }
    add_action('woocommerce_thankyou', 'record_mlm_commission');
}

?>
