<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function create_affiliate_commissions_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'affiliate_commissions';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        affiliate_id bigint(20) NOT NULL,
        order_id bigint(20) NOT NULL,
        commission float(10,2) NOT NULL,
        product_id bigint(20) NOT NULL,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        paid tinyint(1) DEFAULT 0 NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
?>
