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

function filter_youtube_embed($cached_html, $url = null)
{

    // Search for youtu to return true for both youtube.com and youtu.be URLs
    if (strpos($url, 'youtu')) {
        $cached_html = preg_replace('/youtube\.com\/(v|embed)\//s', 'youtube-nocookie.com/$1/', $cached_html);
    }

    return $cached_html;
}

add_filter('embed_oembed_html', 'filter_youtube_embed', 10, 2);
