<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function get_email_template( $template_name, $data = array() ) {
    ob_start();
    switch ( $template_name ) {
        case 'new_commission':
            ?>
            <p>Hi <?php echo esc_html( $data['affiliate_name'] ); ?>,</p>
            <p>Congratulations! You have earned a new commission of $<?php echo number_format( $data['commission'], 2 ); ?>.</p>
            <p>Thank you for your continued support.</p>
            <p>Best regards,<br>Imagine Books</p>
            <?php
            break;
        case 'newsletter':
            ?>
            <p>Hi <?php echo esc_html( $data['affiliate_name'] ); ?>,</p>
            <p><?php echo nl2br( esc_html( $data['message'] ) ); ?></p>
            <p>Best regards,<br>Imagine Books</p>
            <?php
            break;
        // Add more templates as needed
    }
    return ob_get_clean();
}
?>
