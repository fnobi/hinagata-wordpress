<?php

/* ======================================== *
 * requires
 * ======================================== */
require_once('extends/post-customfield.php');


/* ======================================== *
 * config
 * ======================================== */

// activate post-thumbnail
add_theme_support('post-thumbnails');

// disable admin-bar
// add_filter( 'show_admin_bar', '__return_false' );

// post-customfield keys
define('CUSTOMFIELD_KEY_EXTERNAL_LINK', 'CUSTOMFIELD_POST_EXTERNAL_LINK');
define(
    'CUSTOMFIELD_STRING_INPUT_TEMPLATE',
    '<br />'
    . '<div class="postbox">'
    . '<h3 class="hndle"><span>%2$s</span></h3>'
    . '<div class="inside">'
    . '<input size="50" type="text" name="%1$s" id="%1$s_id" value="%3$s" />'
    . '</div>'
    . '</div>'
);

$CUSTOMFIELD_CONFIG = array(
    CUSTOMFIELD_KEY_EXTERNAL_LINK => array(
        'type' => 'string',
        'label' => "URL",
    )
);


/* ======================================== *
 * utils
 * ======================================== */

/*
 * @return site name and article title if necessary
 */
function get_title_element_text() {
    return wp_title(' | ', false, 'right') . get_bloginfo('name', false);
}


/*
 * @return article thumbnail url or null
 */
function get_the_thumbnail_url() {
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


/*
 * @return article external link url or null
 */
function get_the_external_link() {
    return get_the_custom_meta(CUSTOMFIELD_KEY_EXTERNAL_LINK);
}


/*
 * display category tree
 */
function category_tree ($root_id, $wrap = true) {
    $categories = get_categories(array(
        'child_of' => $root_id,
        'hide_empty' => false
    ));

    if (!$categories) {
        return;
    }

    if ($wrap) { echo '<ul>'; }
    foreach($categories as $child) {
        if ($child->parent != $root_id) {
            continue;
        }

        $name = $child->name;
        $link = get_category_link($child->cat_ID);
        
        echo "<li data-category-name=\"$name\">";
        echo "<a href=\"$link\">$name</a>";
        category_tree($child->cat_ID);
        echo '</li>';
    }
    if ($wrap) { echo '</ul>'; }
}
