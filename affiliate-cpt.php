<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function affiliate_register_post_type() {
    $labels = array(
        'name' => 'Affiliates',
        'singular_name' => 'Affiliate',
        'menu_name' => 'Affiliates',
        'name_admin_bar' => 'Affiliate',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Affiliate',
        'new_item' => 'New Affiliate',
        'edit_item' => 'Edit Affiliate',
        'view_item' => 'View Affiliate',
        'all_items' => 'All Affiliates',
        'search_items' => 'Search Affiliates',
        'parent_item_colon' => 'Parent Affiliates:',
        'not_found' => 'No affiliates found.',
        'not_found_in_trash' => 'No affiliates found in Trash.',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'affiliate' ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'affiliate', $args );
}
add_action( 'init', 'affiliate_register_post_type' );
?>
