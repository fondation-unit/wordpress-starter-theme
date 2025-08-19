<?php

/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header();

$title = get_the_title();
$class = getClassFromTitle($title);
$container = get_theme_mod('understrap_container_type');

$logo = get_field('logo');
$illustration = get_field('illustration');

$size = wp_is_mobile() ? 'medium' : 'medium_large';
?>

    <div id="single-project">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <?php
                            get_template_part('loop-templates/content-single');
                            ?>

                        </div><!-- #content -->
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
