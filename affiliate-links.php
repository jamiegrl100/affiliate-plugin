<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function generate_affiliate_link( $affiliate_id ) {
    $affiliate = get_post( $affiliate_id );
    if ( $affiliate && 'affiliate' === $affiliate->post_type ) {
        return site_url( '?ref=' . $affiliate_id );
    }
    return '';
}

function display_affiliate_links() {
    if ( ! is_user_logged_in() ) {
        return '<p>You need to be logged in to view your affiliate links.</p>';
    }

    $current_user = wp_get_current_user();
    $affiliate = get_posts( array(
        'post_type' => 'affiliate',
        'meta_key'  => 'affiliate_email',
        'meta_value' => $current_user->user_email,
    ) );

    if ( ! $affiliate ) {
        return '<p>You are not an affiliate yet.</p>';
    }

    $affiliate_id = $affiliate[0]->ID;
    $affiliate_link = generate_affiliate_link( $affiliate_id );

    ob_start();
    ?>
    <div class="affiliate-links">
        <h2>Your Affiliate Links</h2>
        <p>Share this link to earn commissions: <a href="<?php echo esc_url( $affiliate_link ); ?>"><?php echo esc_url( $affiliate_link ); ?></a></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'affiliate_links', 'display_affiliate_links' );
?>
