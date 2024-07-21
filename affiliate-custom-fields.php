<?php
// Add custom field to user profile
function affiliate_add_custom_user_profile_fields($user) {
    if (current_user_can('administrator')) {
        $commission_rate = get_user_meta($user->ID, 'affiliate_commission_rate', true);
        ?>
        <h3><?php _e('Affiliate Commission Rate', 'affiliate-plugin'); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="affiliate_commission_rate"><?php _e('Commission Rate (%)', 'affiliate-plugin'); ?></label></th>
                <td>
                    <input type="number" name="affiliate_commission_rate" id="affiliate_commission_rate" value="<?php echo esc_attr($commission_rate); ?>" class="regular-text" />
                    <p class="description"><?php _e('Enter the commission rate for this affiliate.', 'affiliate-plugin'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }
}
add_action('show_user_profile', 'affiliate_add_custom_user_profile_fields');
add_action('edit_user_profile', 'affiliate_add_custom_user_profile_fields');

// Save custom field value
function affiliate_save_custom_user_profile_fields($user_id) {
    if (current_user_can('administrator')) {
        update_user_meta($user_id, 'affiliate_commission_rate', sanitize_text_field($_POST['affiliate_commission_rate']));
    }
}
add_action('personal_options_update', 'affiliate_save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'affiliate_save_custom_user_profile_fields');
?>
