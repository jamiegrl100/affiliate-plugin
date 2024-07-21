<?php
function affiliate_process_payout($affiliate_id) {
    $paypal_email = get_user_meta($affiliate_id, 'paypal_email', true);
    $total_commission = get_user_meta($affiliate_id, 'total_commission', true);

    if ($total_commission >= get_option('affiliate_payout_threshold', 50)) {
        if (!class_exists('Stripe\Stripe')) {
            require_once plugin_dir_path(__FILE__) . '../stripe-php/init.php';
        }

        \Stripe\Stripe::setApiKey('your_secret_key_here');

        try {
            $transfer = \Stripe\Transfer::create([
                'amount' => $total_commission * 100, // Stripe works with cents
                'currency' => 'usd',
                'destination' => $paypal_email,
                'transfer_group' => 'AFFILIATE_PAYOUT'
            ]);

            update_user_meta($affiliate_id, 'total_commission', 0);

            global $wpdb;
            $table_name = $wpdb->prefix . 'affiliate_commissions';
            $wpdb->insert($table_name, [
                'affiliate_id' => $affiliate_id,
                'amount' => $total_commission,
                'date' => current_time('mysql'),
                'type' => 'payout'
            ]);

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    return 'Payout threshold not reached or invalid PayPal email.';
}

function affiliate_payout_page() {
    global $wpdb;
    $affiliates = get_users(array('role' => 'affiliate'));
    $threshold = get_option('affiliate_payout_threshold', 50);
    ?>
    <div class="wrap">
        <h1>Affiliate Payouts</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Affiliate ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($affiliates as $affiliate) : 
                    $affiliate_id = $affiliate->ID;
                    $total_commission = get_user_meta($affiliate_id, 'total_commission', true);
                    $total_commission = floatval($total_commission); // Ensure it's a float
                    ?>
                    <tr>
                        <td><?php echo esc_html($affiliate_id); ?></td>
                        <td><?php echo esc_html($affiliate->display_name); ?></td>
                        <td><?php echo esc_html($affiliate->user_email); ?></td>
                        <td>$<?php echo number_format($total_commission, 2); ?></td>
                        <td>
                            <?php if ($total_commission >= $threshold) : ?>
                                <form method="post" action="">
                                    <input type="hidden" name="affiliate_id" value="<?php echo esc_attr($affiliate_id); ?>">
                                    <input type="hidden" name="affiliate_payout_nonce" value="<?php echo wp_create_nonce('affiliate_payout_nonce'); ?>">
                                    <input type="submit" name="process_payout" value="Pay Now" class="button button-primary">
                                </form>
                            <?php else : ?>
                                <span>Below threshold</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        if (isset($_POST['process_payout']) && isset($_POST['affiliate_id']) && wp_verify_nonce($_POST['affiliate_payout_nonce'], 'affiliate_payout_nonce')) {
            $affiliate_id = intval($_POST['affiliate_id']);
            $result = affiliate_process_payout($affiliate_id);
            echo '<p>' . esc_html($result) . '</p>';
        }
        ?>
    </div>
    <?php
}
?>
