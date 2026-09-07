<?php
/**
 * The template for displaying search results pages
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');

?>

    <div class="wrapper" id="search-wrapper">

        <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

            <div class="row">

                <main class="site-main" id="main">
                    <div class="container">
                        <?php if (have_posts()) : ?>

                            <header class="page-header">

                                <h1 class="page-title">
                                    <?php
                                    printf(
                                    /* translators: %s: query term */
                                        esc_html__('Search Results for: %s', 'understrap'),
                                        '<span>' . get_search_query() . '</span>'
                                    );
                                    ?>
                                </h1>

                            </header><!-- .page-header -->

                            <?php /* Start the Loop */ ?>
                            <?php
                            while (have_posts()) :
                                the_post();

                                /*
                                 * Run the loop for the search to output the results.
                                 * If you want to overload this in a child theme then include a file
                                 * called content-search.php and that will be used instead.
                                 */
                                get_template_part('loop-templates/content', 'search');
                            endwhile;
                            ?>

                        <?php else : ?>

                            <?php get_template_part('loop-templates/content', 'none'); ?>

                        <?php endif; ?>
                        <div class="Ligne nav-actus pb-md-6 py-4 <?php echo PRIMARY; ?>">
                            <div id="navPages" class="w-100 mt-4">
                                <?php
                                $pagination = new Pagination();
                                $pagination::render(get_query_var('paged'), max_posts_search()); ?>
                            </div>
                        </div>
                    </div>

                </main>

            </div><!-- .row -->

        </div><!-- #content -->

    </div><!-- #search-wrapper -->

<?php
get_footer();
