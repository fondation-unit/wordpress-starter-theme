<?php
/**
 * H5P related functions.
 *
 * @link https://h5p.org/node/2692
 *
 * @package wordpress-starter-theme
 */

/**
 * Function to alter H5P styles.
 *
 * @param array $styles The array of styles to be altered.
 * @param array $libraries An array of libraries.
 * @param string $embed_type The type of embed.
 * @return void
 */
function custom_h5p_alter_styles( &$styles, $libraries, $embed_type ) {
	$styles[] = (object) array(
		// Path must be relative to wp-content/uploads/h5p or absolute.
		'path' => get_stylesheet_directory_uri() . '/assets/css/custom-h5p.css',
		'version' => '?ver='.time() // Cache buster
	);
}
add_action('h5p_alter_library_styles', 'custom_h5p_alter_styles', 10, 3);
