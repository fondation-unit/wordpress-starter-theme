<?php

/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header();

$container = get_theme_mod('understrap_container_type');
?>
    <div id="single-competence">
        <div class="wrapper" id="page-wrapper">
            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">
                <div class="row">
                    <main class="site-main" id="main">
                        <section class="competence mb-md-6 mb-4">
                            <div class="container">
                                <?php the_title('<h1 class="' . PRIMARY
                                    . '">', '</h1>'); ?>
                                <div class="content">
                                    <?php the_content(); ?>
                                </div>
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

                                $projetsLies = new WP_Query($args);
                                $titre = (($projetsLies->post_count > 1) ? 'Projets dans lesquels ' : 'Projet dans lequel ').'nous mettons à profit notre compétence "'.get_the_title().'"';
                                if ($projetsLies->have_posts()):

                                    ?>
                            <div class="pattern-gauche">
                                <div class="container">
                                    <h2 class="my-md-5 my-4"><?php echo $titre; ?></h2>
                                    <div class="d-flex flex-md-row flex-column flex-wrap projets">

                                        <?php
                                        while ($projetsLies->have_posts()):
                                            $projetsLies->the_post();
                                            $photo = get_field('illustration');
                                            $desc = get_field('introduction');
                                            $competences = get_field('competences');

                                            ?>
                                            <div class="projet loop-card">
                                                <div class="image">
                                                    <?php
                                                    if ($photo):
                                                        ?>
                                                        <?php
                                                        $size = wp_is_mobile() ? 'medium' : 'project-size';
                                                        $imageArr = altTextForFormationImages($photo, $size);
                                                        echo wp_get_attachment_image($photo['ID'], $size, false,
                                                            ['alt' => '', 'class' => 'lozad']);
                                                        ?>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </div>
                                                <div class="content p-md-4 p-3">
                                                    <?php the_title('<h3>', '</h3>'); ?>
                                                    <p>
                                                        <?php echo limitTitle(strip_tags((string) $desc)); ?>
                                                    </p>
                                                </div>
                                                <a href="<?php echo get_permalink(); ?>" class="link">
                                                    <div class="link-content">
                                                        <span class="sr-only">Voir les détails du
                                                                              projet</span>
                                                        <span class="hidden">En savoir plus</span>
                                                        <i class="icon-fleche-actu-projet"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php

                                        endwhile;
                                        wp_reset_postdata();
                                        ?>
                                    </div>
                                </div>
                                <?php
                                endif;
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
