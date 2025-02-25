<?php

/**
 * Menus hook functions.
 *
 * @package wordpress-starter-theme
 */


/**
 * Add Bootstrap classes to the nav, depending on the current page.
 * 
 * @param array $classes
 * @param object $item
 * @param array $args
 * @return array The classes
 */
function add_custom_menu_classes($classes, $item, $args) {
    $classes[] = 'nav-item';

    return $classes;
}
add_filter('nav_menu_css_class', 'add_custom_menu_classes', 10, 3);


/**
 * Add Bootstrap classes to the nav, depending on the current page.
 * 
 * @param array $atts
 * @param object $item
 * @param array $args
 * @return array The attributes
 */
function add_custom_menu_link_attributes($atts, $item, $args) {
    // Get the current page URL
    $current_url = home_url(add_query_arg(array(), $GLOBALS['wp']->request));
    // Get the URL of the menu item
    $menu_item_url = $item->url;

    $atts['class'] = 'nav-link';
    if (str_contains($current_url, $menu_item_url)) {
        $atts['class'] = 'nav-link active';
    }

    // Check if the parent item has children
    if (in_array('menu-item-has-children', $item->classes)) {
        $parent_category = get_term($item->object_id, 'category');
        // Check if any sub-menu category is active
        if (has_submenu_categories($parent_category, get_queried_object_id())) {
            $atts['class'] .= ' active';
        }

        $atts['class'] .= ' dropdown-toggle';
        $atts['data-bs-toggle'] = 'dropdown';
        $atts['aria-expanded'] = 'false';
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_custom_menu_link_attributes', 10, 3);


/**
 * Add Bootstrap dropdown class when needed.
 * 
 * @return void
 */
function custom_nav_menu_css_class($classes, $item) {
    if (in_array('menu-item-has-children', $item->classes)) {
        $classes[] = 'dropdown';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'custom_nav_menu_css_class', 10, 2);


/**
 * Add Bootstrap dropdown-menu class when needed.
 * 
 * @return void
 */
function custom_nav_menu_submenu_css_class($classes) {
    $classes[] = 'dropdown-menu';
    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'custom_nav_menu_submenu_css_class');


/**
 * Check whether a menu item has a submenu category or belongs to the category as a single post.
 * 
 * @param object $parent_category
 * @param int $queried_object_id
 * @return bool True if any category of the the post is a child of the parent category, false otherwise
 */
function has_submenu_categories($parent_category, $queried_object_id) {
    // Check if the queried object is a category
    if (is_category()) {
        // Check if the queried category is a child of the parent category
        if (cat_is_ancestor_of($parent_category->term_id, $queried_object_id)) {
            return true;
        }
    } elseif (is_single()) {
        // Get the categories of the current post
        $post_categories = get_the_category($queried_object_id);
        // Check if any category of the post is a child of the parent category
        foreach ($post_categories as $category) {
            if (cat_is_ancestor_of($parent_category->term_id, $category->term_id)) {
                return true;
            }
        }
    }

    return false;
}
