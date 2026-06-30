<?php

include_once(get_stylesheet_directory() . '/inc/pagination.php');
/**
 * Template Name: Page Equipes
 * Author : Fondation UNIT
 */
get_header(); ?>

<?php
$args = [
    'post_type' => 'equipe',
    'meta_key' => 'ordre',
    'orderby' => 'meta_value',
    'order' => 'ASC'
];
$argsEquipes = new WP_Query($args);

$container = get_theme_mod('understrap_container_type');

?>

    <div id="equipes">
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
                                <section class="equipes w-100">
                                    <div class="px-md-0 px-3">
                                        <div class="d-flex flex-md-row flex-column flex-wrap">

                                            <?php
                                            if ($argsEquipes->have_posts()) :
                                                while ($argsEquipes->have_posts()) :
                                                    $argsEquipes->the_post();

                                                    $photo = get_field('photo');
                                                    $fonction = get_field('fonction');
                                                    $twitter = get_field('twitter');
                                                    $linkedin = get_field('linkedin');
                                                    $github = get_field('github');

                                                    ?>
                                                    <div class="equipe">
                                                        <div class="image">

                                                            <?php
                                                            if ($photo):
                                                                $size = wp_is_mobile() ? 'medium' : 'large';
                                                                $imgDatas = altTextForFormationImages($photo, $size);
                                                                echo wp_get_attachment_image($photo['ID'], $size, false,
                                                                    [
                                                                        'alt' => '',
                                                                        'class' => 'wp-post-image lozad',
                                                                    ]);
                                                            endif;
                                                            ?>

                                                        </div>
                                                        <div class="content p-3">
                                                            <?php the_title('<h2 class="no-point">', '</h2>'); ?>
                                                            <p><?php echo $fonction; ?></p>
                                                            <?php
                                                            if($twitter || $linkedin || $github){
                                                                ?>
                                                                <div class="d-flex flex-row">
                                                                    <?php
                                                                    if($linkedin):
                                                                        ?>
                                                                        <div class="col-md-4">
                                                                            <a href="https://www.linkedin.com/in/<?php echo $linkedin; ?>" target="_blank"><?php echo createRSIcon('Linkedin'); ?></a>
                                                                        </div>
                                                                    <?php
                                                                        endif;
                                                                        if($twitter):
                                                                        ?>
                                                                        <div class="col-md-4">
                                                                            <a href="<?php echo $twitter; ?>" target="_blank"><?php echo createRSIcon('Twitter (X)'); ?></a>
                                                                        </div>
                                                                    <?php
                                                                        endif;
                                                                        if($github):
                                                                        ?>
                                                                        <div class="col-md-4">
                                                                            <a href="<?php echo $github; ?>" target="_blank"><?php echo createRSIcon('Github'); ?></a>
                                                                        </div>
                                                                    <?php
                                                                        endif;
                                                                    ?>
                                                                </div>
                                                                <?php
                                                            }

                                                            ?>
                                                        </div>

                                                    </div>

                                                <?php
                                                endwhile;
                                            endif;
                                            wp_reset_query();
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
