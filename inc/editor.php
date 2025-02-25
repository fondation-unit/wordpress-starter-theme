<?php

/**
 * Add color presets.
 */
add_theme_support(
    'editor-color-palette',
    array(
        array(
            'name'  => __('Rouge', 'wordpress-starter-theme'),
            'slug'  => 'rouge',
            'color' => '#df4050',
        ),
        array(
            'name'  => __('Blanc', 'wordpress-starter-theme'),
            'slug'  => 'blanc',
            'color' => '#FFFFFF',
        ),
    )
);


/**
 * Remove the gradient color support.
 */
add_theme_support('editor-gradient-presets', []);
add_theme_support('disable-custom-gradients', true);
