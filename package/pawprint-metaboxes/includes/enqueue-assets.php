<?php

function pawprint_metaboxes_admin_assets() {
    global $pagenow;

    if( $pagenow != 'post.php') return;

    wp_enqueue_style( 'pawprint-metaboxes-admin-stylesheet', plugins_url().'/pawprint-metaboxes/dist/assets/css/admin.css' , array(), '1.0.0', 'all' );
    wp_enqueue_script( 'pawprint-metaboxes-admin-scripts', plugins_url().'/pawprint-metaboxes/dist/assets/js/admin.js', array(), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'pawprint_metaboxes_admin_assets' );