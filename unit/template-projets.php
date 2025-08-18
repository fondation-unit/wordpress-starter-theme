<?php

include_once(get_stylesheet_directory() . '/inc/pagination.php');
/**
 * Template Name: Page Projets
 * Author : Fondation UNIT
 */
get_header(); ?>

<?php
$limit = 9;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset = (($paged == 1) ? 1 : $paged * $limit);
$args = [
    'post_type' => 'projet',
    'order_by' => "date",
    'order' => 'DESC',
    'posts_per_page' => $limit,
    'offet' => $offset,
    'paged' => $paged,
];
$argsProjets = new WP_Query($args);



?>

    <div id="projets">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <?php
                            the_title(
                                '<header class="entry-header"><h1 class="entry-title uoh">',
                                '</h1></header><!-- .entry-header -->'
                            );
                            ?>
                            <div class="d-flex flex-md-row flex-column">
                                <section class="projets w-100">
                                    <div class="px-md-0 px-3">
                                        <div class="d-flex flex-md-row flex-column flex-wrap">

                                            <?php
                                            if ($argsProjets->have_posts()) :
                                                while ($argsProjets->have_posts()) :
                                                    $argsProjets->the_post();

                                                    $photo = get_field('illustration');
                                                    $desc = get_field('presentation');

                                                    ?>
                                                    <a href="<?php echo get_permalink(); ?>"
                                                       class="projet loop-card-uoh">
                                                        <div class="image">

                                                            <?php
                                                            if($photo):
                                                            $size = wp_is_mobile() ? 'medium' : 'medium_large';
                                                            $imgDatas = altTextForFormationImages($photo, $size);
                                                                 echo '<img class="attachment-medium_large size-medium_large wp-post-image lozad" src="'
                                                                    . $imgDatas['src'] . '" alt="' . $imgDatas['alt'] . '">';
                                                            endif;
                                                            ?>

                                                        </div>
                                                        <div class="content p-md-4 p-3">
                                                            <?php the_title('<h3 class="no-point">', '</h3>'); ?>
                                                            <p>
                                                                <?php echo limitTitle($desc); ?>
                                                            </p>
                                                        </div>
                                                        <div class="link">
                                                            <div class="link-content">
                                                                <span class="sr-only">Voir les détails du
                                                                                      projet</span>
                                                                <span class="hidden">En savoir plus</span>
                                                                <i class="icon-fleche-actu-projet"></i>
                                                            </div>
                                                        </div>

                                                    </a>

                                                <?php
                                                endwhile;
                                            endif;
                                            wp_reset_query();
                                            ?>
                                        </div>
                                    </div>
                                    <div class="Ligne nav-actus pb-md-6 py-4 uoh">
                                        <div id="navPages" class="w-100 mt-4">
                                            <?php
                                            $pagination = new Pagination();
                                            $pagination::render(get_query_var('paged'), $argsProjets->max_num_pages); ?>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div><!-- #content -->
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
