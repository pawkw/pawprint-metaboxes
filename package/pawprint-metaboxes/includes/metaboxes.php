<?php

function pawprint_add_metabox() {
    add_meta_box( 
        'pawprint_post_metabox',
        'Post Settings',
        'pawprint_post_metabox_html',
        'post',
        'normal',
        'default'
    );

}

add_action( 'add_meta_boxes', 'pawprint_add_metabox' );

function pawprint_post_metabox_html($post) {
    wp_nonce_field( 'pawprint_update_post_metabox', 'pawprint_update_post_nonce' );

    $subtitle = get_post_meta( $post->ID, '_pawprint_post_subtitle', true );
    $layout = get_post_meta( $post->ID, '_pawprint_post_layout', true );

    echo '<p><label for="pawprint_post_subtitle_field">'.esc_html__( 'Subtitle: ', 'pawprint-metaboxes' ).'</label>'.
        '<input class="widefat" value="'.esc_attr($subtitle).'" type="text" name="pawprint_post_subtitle_field" id="pawprint_post_subtitle_field" /></p>';

    echo '<p><label for="pawprint_post_layout_field">'.esc_html__( 'Layout: ', 'pawprint-metaboxes' ).'</label>'; ?>
    <select name="pawprint_post_layout_field" id="pawprint_post_layout_field" class="widefat">
        <option <?php selected( $layout, 'full' ); ?> value="full"><?php esc_html_e( 'Full width', 'pawprint-metaboxes' ); ?></option>
        <option <?php selected( $layout, 'sidebar' ); ?> value="sidebar"><?php esc_html_e( 'With sidebar', 'pawprint-metaboxes' ); ?></option>
    </select>
    <?php
}

function pawprint_save_post_metabox($post_id, $post) {
    $edit_capability = get_post_type_object( $post->post_type )->cap->edit_post;

    if( !current_user_can( $edit_capability, $post_id )) {
        return;
    }

    if( !isset($_POST['pawprint_update_post_nonce']) || !wp_verify_nonce( 'pawprint_update_post_nonce', 'pawprint_update_post_metabox' )) {
        return;
    }

    if(array_key_exists('pawprint_post_subtitle_field', $_POST)) {
        $meta_value = sanatize_text_field($_POST['pawprint_post_subtitle_field']);
        update_post_meta( $post_id, '_pawprint_post_subtitle', $meta_value );
    }

    if(array_key_exists('pawprint_post_layout_field', $_POST)) {
        $meta_value = sanatize_text_field($_POST['pawprint_post_layout_field']);
        update_post_meta( $post_id, '_pawprint_post_layout', $meta_value );
    }
}

add_action( 'save_post', 'pawprint_save_post_metabox', 10, 2 );

