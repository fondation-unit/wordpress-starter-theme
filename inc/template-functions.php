<?php
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

add_filter('rest_endpoints', function ($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }

    return $endpoints;
});
