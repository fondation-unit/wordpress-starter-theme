<?php
/**
 * Widgets functions file.
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package wordpress-starter-theme
 */

function wordpress_starter_widgets_init() {
  register_sidebar(
    array(
      'name' => 'Footer widgets',
      'id' => 'footer_widgets',
      'before_widget' => '<div id="wordpress_starter-widget">',
      'after_widget' => '</div>',
      'before_title' => '<h2>',
      'after_title' => '</h2>',
    )
  );
}
add_action( 'widgets_init', 'wordpress_starter_widgets_init' );
