<?php

get_header();

$container = get_theme_mod('understrap_container_type');

?>

    <div id="single-post" class="mb-4">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.',
                                    'understrap'); ?></h1>

                            </header><!-- .page-header -->

                            <div class="page-content">

                                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?',
                                        'understrap'); ?></p>

                                <?php get_search_form(); ?>

                            </div><!-- #content -->
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
