<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function affiliate_admin_menu() {
    add_menu_page(
        'Affiliate Program',
        'Affiliates',
        'manage_options',
        'affiliate-program',
        'affiliate_admin_page',
        'dashicons-admin-users',
        6
    );
}

add_action( 'admin_menu', 'affiliate_admin_menu' );

function affiliate_admin_page() {
    global $wpdb;
    $affiliates = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'affiliate' AND post_status = 'publish'" );

    ?>
    <div class="wrap">
        <h1>Affiliate Program</h1>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col" class="manage-column column-title column-primary">Affiliate</th>
                    <th scope="col" class="manage-column">Email</th>
                    <th scope="col" class="manage-column">Website</th>
                    <th scope="col" class="manage-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $affiliates as $affiliate ) : ?>
                    <tr>
                        <td class="title column-title has-row-actions column-primary" data-colname="Affiliate">
                            <strong><a class="row-title" href="<?php echo get_edit_post_link( $affiliate->ID ); ?>"><?php echo esc_html( $affiliate->post_title ); ?></a></strong>
                        </td>
                        <td><?php echo esc_html( get_post_meta( $affiliate->ID, 'affiliate_email', true ) ); ?></td>
                        <td><?php echo esc_url( get_post_meta( $affiliate->ID, 'affiliate_website', true ) ); ?></td>
                        <td>
                            <a href="<?php echo get_edit_post_link( $affiliate->ID ); ?>">Edit</a> | 
                            <a href="<?php echo get_delete_post_link( $affiliate->ID ); ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>
