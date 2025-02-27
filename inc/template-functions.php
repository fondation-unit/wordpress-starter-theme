<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wordpress-starter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wordpress_starter_body_classes($classes)
{
    // Adds a class of hfeed to non-singular pages.
    if (! is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (! is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'wordpress_starter_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wordpress_starter_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'wordpress_starter_pingback_header');

//====================================================================
//
//    DEBUG
//
//====================================================================
function dd($data, $die = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($die) die();
}

//====================================================================
//
//    CUSTOM ADMIN
//
//====================================================================
function my_custom_login_logo()
{
    $upload_dir = wp_upload_dir();
    echo '<style type="text/css">
h1 a {background-image:url(' . get_stylesheet_directory_uri() . '/img/logo.png)!important;
-webkit-background-size:inherit!important;
background-size:inherit!important;
height: 170px !important;
width:inherit!important;}
</style>';
}

add_action('login_head', 'my_custom_login_logo');


function my_login_logo_url()
{
    return get_bloginfo('url');
}

add_filter('login_headerurl', 'my_login_logo_url');

function my_login_logo_url_title()
{
    return 'Connexion à ' . get_bloginfo('name');
}

add_filter('login_headertitle', 'my_login_logo_url_title');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    require_once get_template_directory() . '/classes/class-wp-bootstrap-navwalker.php';
}

add_action('after_setup_theme', 'register_navwalker');
