<?php

include_once(get_stylesheet_directory() . '/inc/pagination.php');
/**
 * Template Name: Page Organigrammes
 * Author : Fondation UNIT
 */
get_header(); ?>

<?php
$organigrammes = getOrganigrammeList();

$container = get_theme_mod('understrap_container_type');

?>

    <div id="organigrammes">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <?php
                            the_title(
                                '<header class="entry-header"><h1 class="entry-title unit">',
                                '</h1></header><!-- .entry-header -->'
                            );
                            the_content();
                            ?>
                            <div class="d-flex flex-md-row flex-column">
                                <section class="organigrammes w-100">
                                    <div class="px-md-0 px-3">
                                        <div class="d-flex flex-md-row flex-column flex-wrap">
                                            <?php
                                            foreach ($organigrammes as $organisme):
                                                echo '<h2>' . $organisme['name'] . '</h2>';
                                                ?>
                                                <div class="d-flex flex-row flex-wrap">
                                                    <?php
                                                    foreach ($organisme as $key => $value):
                                                        if (is_numeric($key)) {
                                                            $fonction = get_field('fonction', $value->ID);
                                                            $etablissement = get_field('etablissement', $value->ID);
                                                            ?>
                                                            <div class="col-md-4 w-100 mb-3 text-center">
                                                               <h3><?php echo $value->post_title; ?></h3>
                                                                <p><?php echo $fonction; ?></p>
                                                                <p><?php echo $etablissement; ?></p>
                                                            </div>
                                                            <?php
                                                        }
                                                    endforeach;
                                                    ?>
                                                </div>
                                            <?php
                                            endforeach;
                                            ?>
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
