<?php

/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header();

$container = get_theme_mod('understrap_container_type');
$title = get_the_title();
$class = getClassFromTitle($title);

$size = wp_is_mobile() ? 'thumbnail' : 'medium_large';
?>
    <div id="single-unt" class="<?php echo $class; ?>">
        <div class="wrapper" id="page-wrapper">
            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">
                <div class="row">
                    <main class="site-main" id="main">
                        <section class="unt mb-md-6 mb-4">
                            <?php
                            get_template_part('template-parts/unt-header');
                            get_template_part('template-parts/unt-fiche');
                            ?>
                        </section>
                    </main>
                </div><!-- #content -->
            </div>
        </div>
    </div>
<?php
get_footer();
