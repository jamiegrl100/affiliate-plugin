<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! function_exists( 'affiliate_email_campaigns_page' ) ) {
    function affiliate_email_campaigns_page() {
        ?>
        <div class="wrap">
            <h1>Affiliate Email Campaigns</h1>
            <form method="post" action="admin-post.php?action=send_newsletter">
                <?php wp_nonce_field( 'send_newsletter_action', 'send_newsletter_nonce' ); ?>
                <h2>Send Newsletter</h2>
                <label for="newsletter_subject">Subject</label>
                <input type="text" id="newsletter_subject" name="newsletter_subject" required>
                <label for="newsletter_message">Message</label>
                <textarea id="newsletter_message" name="newsletter_message" rows="10" required></textarea>
                <input type="submit" name="send_newsletter" value="Send Newsletter" class="button button-primary">
            </form>
        </div>
        <?php
    }
}

if ( ! function_exists( 'handle_send_newsletter' ) ) {
    function handle_send_newsletter() {
        if ( isset( $_POST['send_newsletter'] ) && check_admin_referer( 'send_newsletter_action', 'send_newsletter_nonce' ) ) {
            $subject = sanitize_text_field( $_POST['newsletter_subject'] );
            $message = sanitize_textarea_field( $_POST['newsletter_message'] );

            $affiliates = get_posts( array(
                'post_type' => 'affiliate',
                'post_status' => 'publish',
                'numberposts' => -1
            ) );

            foreach ( $affiliates as $affiliate ) {
                send_email_to_affiliate( $affiliate->ID, $subject, 'newsletter', array('message' => $message) );
            }

            wp_redirect( admin_url( 'admin.php?page=affiliate-email-campaigns&message=success' ) );
            exit;
        }
    }
}
add_action( 'admin_post_send_newsletter', 'handle_send_newsletter' );

if ( ! function_exists( 'add_email_campaigns_menu' ) ) {
    function add_email_campaigns_menu() {
        add_submenu_page(
            'affiliate-program',
            'Email Campaigns',
            'Email Campaigns',
            'manage_options',
            'affiliate-email-campaigns',
            'affiliate_email_campaigns_page'
        );
    }
}

add_action( 'admin_menu', 'add_email_campaigns_menu' );
?>
