<?php

function custom_show_post_meta() {
    global $CUSTOMFIELD_CONFIG, $post;
    if ( empty ( $post ) || 'post' !== get_post_type( $GLOBALS['post'] ) ) {
        return;
    }

    foreach ($CUSTOMFIELD_CONFIG as $metaKey => $field) {
        if ( ! $content = get_post_meta( $post->ID, $metaKey, TRUE ) ) {
            $content = '';
        }

        $template = CUSTOMFIELD_STRING_INPUT_TEMPLATE;
        if ($field['type'] == 'text') {
            $template = CUSTOMFIELD_TEXT_INPUT_TEMPLATE;
        }

        printf(
            $template,
            $metaKey,
            $field['label'],
            esc_attr( $content )
        );
    }
}

function custom_save_post_meta( $post_id ) {
    global $CUSTOMFIELD_CONFIG;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    foreach ($CUSTOMFIELD_CONFIG as $metaKey => $field) {
        if ( isset ( $_POST[ $metaKey ] ) ) {
            delete_post_meta( $post_id, $metaKey );
            update_post_meta( $post_id, $metaKey, $_POST[ $metaKey ] );
        }
    }
}

function get_the_custom_meta($key) {
    global $post;
    if ( empty ( $post ) || 'post' !== get_post_type( $GLOBALS['post'] ) ) {
        return;
    }

    $content = get_post_meta($post->ID, $key, TRUE);
    return $content;
}

add_action('edit_form_after_editor', 'custom_show_post_meta');
add_action('save_post', 'custom_save_post_meta');
