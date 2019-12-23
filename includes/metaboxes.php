<?php

function _themename_add_metabox() {
    add_meta_box( 
        '_themename_post_metabox',
        'Post Settings',
        '_themename_post_metabox_html',
        'post',
        'normal',
        'default'
    );

}

add_action( 'add_meta_boxes', '_themename_add_metabox' );

function _themename_post_metabox_html($post) {
    wp_nonce_field( '_themename_update_post_metabox', '_themename_update_post_nonce' );

    $subtitle = get_post_meta( $post->ID, '__themename_post_subtitle', true );
    $layout = get_post_meta( $post->ID, '__themename_post_layout', true );

    echo '<p><label for="_themename_post_subtitle_field">'.esc_html__( 'Subtitle: ', '_themename-_pluginname' ).'</label>'.
        '<input class="widefat" value="'.esc_attr($subtitle).'" type="text" name="_themename_post_subtitle_field" id="_themename_post_subtitle_field" /></p>';

    echo '<p><label for="_themename_post_layout_field">'.esc_html__( 'Layout: ', '_themename-_pluginname' ).'</label>'; ?>
    <select name="_themename_post_layout_field" id="_themename_post_layout_field" class="widefat">
        <option <?php selected( $layout, 'full' ); ?> value="full"><?php esc_html_e( 'Full width', '_themename-_pluginname' ); ?></option>
        <option <?php selected( $layout, 'sidebar' ); ?> value="sidebar"><?php esc_html_e( 'With sidebar', '_themename-_pluginname' ); ?></option>
    </select>
    <?php
}

function _themename_save_post_metabox($post_id, $post) {
    $edit_capability = get_post_type_object( $post->post_type )->cap->edit_post;

    if( !current_user_can( $edit_capability, $post_id )) {
        return;
    }

    if( !isset($_POST['_themename_update_post_nonce']) || !wp_verify_nonce( '_themename_update_post_nonce', '_themename_update_post_metabox' )) {
        return;
    }

    if(array_key_exists('_themename_post_subtitle_field', $_POST)) {
        $meta_value = sanatize_text_field($_POST['_themename_post_subtitle_field']);
        update_post_meta( $post_id, '__themename_post_subtitle', $meta_value );
    }

    if(array_key_exists('_themename_post_layout_field', $_POST)) {
        $meta_value = sanatize_text_field($_POST['_themename_post_layout_field']);
        update_post_meta( $post_id, '__themename_post_layout', $meta_value );
    }
}

add_action( 'save_post', '_themename_save_post_metabox', 10, 2 );

