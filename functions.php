<?php

/*
 * config
 */
add_theme_support('post-thumbnails');

// disable admin-bar
// add_filter( 'show_admin_bar', '__return_false' );


/*
 * @return site name and article title if necessary
 */
function get_title_element_text() {
    return wp_title(' | ', false, 'right') . get_bloginfo('name', false);
}


/*
 * @return article thumbnail url or null
 */
function get_thumbnail_url() {
    if (is_front_page()) {
        return NULL;
    }
    $image_id = get_post_thumbnail_id();
    $image_props = wp_get_attachment_image_src($image_id, true);
    if (count($image_props) > 0) {
        return $image_props[0];
    } else {
        return NULL;
    }
}
