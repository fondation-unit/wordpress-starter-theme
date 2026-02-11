<?php
//====================================================================
//
//    DEBUG
//
//====================================================================
if (site_url() === 'http://unit.test') {
    define('ACTUALITES', 41);
    define('UNT_UN', 14230);
} else {
    define('ACTUALITES', 41);
    define('UNT_UN', 226);
}

define('PRIMARY', 'unit');

function dd($data, $die = false)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($die)
        die();
}

function register_my_session()
{
    if (! session_id()) {
        session_start();
    }
}

add_action('init', 'register_my_session');

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
-webkit-background-size:contain!important;
background-size:contain!important;
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

add_filter('login_head', 'my_login_logo_url_title');

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

add_filter('the_content', 'baseplate_lazyload_content_images');
add_filter('acf_the_content', 'baseplate_lazyload_content_images');
function baseplate_lazyload_content_images($content)
{
    if (mb_strpos($content, '.svg') === 0) {
        $content = preg_replace("/<img(.*?)(src=|srcset=)(.*?)>/i", '<img$1data-$2$3>', $content);
        //-- Add .lozad class to each image that already has a class.
        $content = preg_replace('/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2 lozad"$3>', $content);
        //-- Add .lozad class to each image that doesn't have a class.
        $content = preg_replace('/<img(.*?)(?!\bclass\b)(.*?)/i', '<img$1 class="lozad"$2', $content);
        $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '$1$2$3', $content);
    }

    //-- Change src/srcset to data attributes.

    return $content;
}

/**
 * @param $array
 * @param $size
 *
 * @return array
 *  Génère l'attribut alt suivant les données entrées dans le média
 */
function altTextForFormationImages($array, $size = 'thumbnail'): array
{
    $src = '';
    $alt = '';
    if ($array) {
        $src = $array['sizes'][$size];
        if (! empty($array['alt'])) {
            $alt = $array['alt'];
        } else {
            $alt = ! empty($array['description']) ? $array['description']
                : 'Image d\'illustration ' . get_the_title();
        }
    }

    return compact('src', 'alt');
}

add_filter('embed_oembed_html', 'filter_youtube_embed', 10, 2);
/**
 * crée lien vers admin-ajax.php pour le front pour ajax select modules
 */
add_action('wp_head', 'ajaxurl');

function ajaxurl()
{
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

function footer_sidebars()
{
    register_sidebar([
        'id' => 'left-footer',
        'name' => 'Footer gauche',
        'before_widget' => '',
        'after_widget' => '',
    ]);
    register_sidebar([
        'id' => 'center-footer',
        'name' => 'Footer center',
        'before_widget' => '',
        'after_widget' => '',
    ]);
    register_sidebar([
        'id' => 'right-footer',
        'name' => 'Footer droite',
        'before_widget' => '',
        'after_widget' => '',
    ]);
}

add_action('widgets_init', 'footer_sidebars');

function cleanUrl($url)
{
    return preg_replace('/https?:\/\/|www.|\/$/', '', $url);
}

function getClassFromTitle($title)
{
    return $title == 'IUTenligne' ? 'iut' : strtolower($title);
}

function createRSIcon($type)
{
    $typeIcon = [
        'Facebook' => 'facebook-f',
        'Linkedin' => 'linkedin-in',
        'Twitter (X)' => 'x-twitter',
        'Bluesky' => 'bluesky',
        'Youtube' => 'youtube',
    ];

    return '<i class="fa-brands fa-' . $typeIcon[$type] . '"></i>';
}

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext' => $filetype['ext'],
        'type' => $filetype['type'],
        'proper_filename' => $data['proper_filename'],
    ];
}, 10, 4);

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function wpdocs_add_svg($wp_get_mime_types)
{
    if (! array_key_exists('svg', $wp_get_mime_types)) {
        $wp_get_mime_types['svg'] = 'image/svg+xml';
    }

    return $wp_get_mime_types;
}

add_filter('mime_types', 'wpdocs_add_svg', 99);

function fix_svg()
{
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}

add_action('admin_head', 'fix_svg');

function getPhotoSize()
{
    return wp_is_mobile() ? 'medium' : 'medium_large';
}

function max_posts_search()
{
    global $wp_query;

    return $wp_query->max_num_pages;
}

function alter_att_attributes_wpse_102079($attr)
{
    $attr['data-src'] = $attr['src'];
    unset($attr['src']);

    return $attr;
}

add_filter('wp_get_attachment_image_attributes', 'alter_att_attributes_wpse_102079');

function register_custom_image_sizes()
{
    if (! current_theme_supports('post-thumbnails')) {
        add_theme_support('post-thumbnails');
    }
    add_image_size('project-size', 415, 245, true);
}

add_action('after_setup_theme', 'register_custom_image_sizes');

//====================================================================
//
//    ACCES FLAMINGO EDITEURS
//
//====================================================================
add_filter('flamingo_map_meta_cap', 'custom_flamingo_map_meta_cap');

function custom_flamingo_map_meta_cap($meta_caps)
{
    $meta_caps = array_merge($meta_caps, [
        'flamingo_edit_inbound_message' => 'edit_pages',
        'flamingo_edit_inbound_messages' => 'edit_pages',
        'flamingo_delete_inbound_message' => 'edit_pages',
        'flamingo_delete_inbound_messages' => 'edit_pages',
        'flamingo_spam_inbound_message' => 'edit_pages',
        'flamingo_unspam_inbound_message' => 'edit_pages',
        'flamingo_edit_contacts' => 'edit_pages',
    ]);

    return $meta_caps;
}

function searchBreadcrumb($get, $num)
{
    $breadcrumb = '';

    if (isset($get['recherche']) && ! empty($get['recherche'])) {
        $breadcrumb .= '"' . $get['recherche'] . '"' . (($num > 0) ? ' - ' : '');
    }

    if ($num > 0) {
        $breadcrumb .= $num . ' résultat' . (($num > 1) ? 's' : '');
    }

    return $breadcrumb;
}
