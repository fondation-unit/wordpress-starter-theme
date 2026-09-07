<?php

include_once(get_stylesheet_directory() . '/inc/pagination.php');
/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header(); ?>

<?php
$limit = 8;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset = (($paged == 1) ? 1 : $paged * $limit);
$args = [
    'post_type' => 'post',
    'order_by' => "date",
    'order' => 'DESC',
    'posts_per_page' => $limit,
    'offet' => $offset,
    'paged' => $paged,
];
if(get_the_ID() === REPLAY){
    $args['cat'] = REPLAY_CAT;
}
$argsActus = new WP_Query($args);

$container = get_theme_mod('understrap_container_type');
?>

    <div id="actualites">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <?php
                            the_title(
                                '<header class="entry-header"><h1 class="entry-title ' . PRIMARY
                                . '">',
                                '</h1></header><!-- .entry-header -->'
                            );
                            ?>
                            <div class="d-flex flex-md-row flex-column">
                                <section class="actualites w-100">
                                    <div class="px-md-0 px-3">
                                        <div class="d-flex flex-column flex-wrap">

                                            <?php
                                            if ($argsActus->have_posts()) :
                                                while ($argsActus->have_posts()) :
                                                    $argsActus->the_post();
                                                    ?>
                                                    <div
                                                       class="actualite d-flex flex-md-row flex-column flex-md-wrap loop-card-<?php echo PRIMARY; ?> pb-md-0 pb-3">
                                                        <div class="image col-md-4">

                                                            <?php
                                                            $size = wp_is_mobile() ? 'medium' : 'medium_large';

                                                            if (has_post_thumbnail()) {
                                                                the_post_thumbnail($size, ['class' => 'lozad', 'alt' => '']);
                                                            }
                                                            ?>

                                                        </div>
                                                        <div class="content p-4 col-md-8">
                                                            <h2 class="no-point">
                                                                <?php
                                                                echo get_the_title();
                                                                ?>
                                                            </h2>
                                                            <?php
                                                            $excerpt = get_the_excerpt();
                                                            echo '<p>' . ((mb_strlen($excerpt) > 200)
                                                                    ? mb_substr($excerpt,
                                                                        0, 200)
                                                                    . '...' : $excerpt) . '</p>'
                                                            ?>
                                                        </div>
                                                        <div class="link">
                                                            <a href="<?php echo get_permalink(); ?>" class="link-content">
                                                                <span class="sr-only">Voir les détails du
                                                                                      projet</span>
                                                                <span class="hidden">En savoir plus</span>
                                                                <i class="icon-fleche-actu-projet" aria-hidden="true"></i>
                                                            </a>
                                                        </div>

                                                    </div>

                                                <?php
                                                endwhile;
                                            endif;
                                            wp_reset_query();
                                            ?>
                                        </div>
                                    </div>
                                    <div class="Ligne nav-actus pb-md-6 py-4 <?php echo PRIMARY; ?>">
                                        <div id="navPages" class="w-100 mt-4">
                                            <?php
                                            $pagination = new Pagination();
                                            $pagination::render(get_query_var('paged'), $argsActus->max_num_pages); ?>
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
