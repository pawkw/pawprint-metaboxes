<?php

function _themename__pluginname_admin_assets() {
    global $pagenow;

    if( $pagenow != 'post.php') return;

    wp_enqueue_style( '_themename-_pluginname-admin-stylesheet', plugins_url().'/_themename-metaboxes/dist/assets/css/admin.css' , array(), '1.0.0', 'all' );
    wp_enqueue_script( '_themename-_pluginname-admin-scripts', plugins_url().'/_themename-metaboxes/dist/assets/js/admin.js', array(), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', '_themename__pluginname_admin_assets' );