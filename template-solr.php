<?php

/**
 * Template Name: Page Solr
 * Author : Fondation UNIT
 */

include_once(get_stylesheet_directory() . '/inc/SolrRequest.php');
$container = get_theme_mod('understrap_container_type');
$imageHeader = get_field('image_header');
$size = getPhotoSize();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


if (isset($_GET['fiche'])) {
    $solrReq = new SolrRequest();
    $uuid = sanitize_post($_GET['fiche']);
    $fiche = $solrReq->getFiche($uuid);
}

get_header(); ?>

    <div id="recherche" class="solr">
        <div class="wrapper one-bg <?php echo PRIMARY; ?>" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="bg-primary py-md-6 py-4 mb-md-0 mb-4">
                            <div class="container">
                                <?php
                                if(isset($_GET['fiche']) && $fiche['numFound'] === 1){
                                    echo '<header class="entry-header"><h1 class="entry-title no-point text-white">'.$fiche['titre'].'</h1></header>';
                                }else {
                                    the_title(
                                        '<header class="entry-header"><h1 class="entry-title no-point text-white">',
                                        '</h1></header><!-- .entry-header -->'
                                    );
                                }
                                ?>

                            </div>
                        </div>
                        <?php
                        if (! isset($_GET['fiche'])) {
                            set_query_var('paged', $paged);
                            get_template_part('template-parts/rech-liste');
                        } else {
                            set_query_var('fiche', $fiche);
                            get_template_part('template-parts/search-detail');
                        }
                        ?>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
