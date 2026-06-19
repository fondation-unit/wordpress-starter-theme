<?php

/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header();

$container = get_theme_mod('understrap_container_type');
?>
    <div id="single-unt" class="<?php echo $class; ?>">
        <div class="wrapper" id="page-wrapper">
            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">
                <div class="row">
                    <main class="site-main" id="main">
                        <section class="unt mb-md-6 mb-4">
                            <div class="container">
                                <?php the_title('<h1 class="' . PRIMARY
                                    . '">', '</h1>'); ?>
                                <div class="content">
                                    <?php the_content(); ?>
                                </div>
                                <?php
                                $args = [
                                    'posts_per_page' => 4,
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'post_type' => 'projet',
                                    'meta_query' => [
                                        [
                                            'key' => 'competences',
                                            'value' => sprintf(':"%s";', get_the_ID()),
                                            'compare' => 'LIKE',
                                        ],
                                    ],
                                ];

                                $query = new WP_Query($args);
                                ?>
                            </div>
                        </section>
                    </main>
                </div><!-- #content -->
            </div>
        </div>
    </div>
<?php
get_footer();
