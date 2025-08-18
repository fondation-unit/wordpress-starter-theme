<?php

/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header();

$title = get_the_title();
$class = getClassFromTitle($title);
$container = get_theme_mod('understrap_container_type');

$typeContact = get_field('type_de_contact');
$lien = $typeContact === 'Lien' ? get_field('url_contact') : 'mailto:' . get_field('mail_contact');

$partenaires = get_field('partenaires');
$site = get_field('site');
$titreMentions = get_field('titre_mentions_concernees');
$mentions = get_field('mentions_concernees');
$actions = get_field('principales_actions');
$logo = get_field('logo');
?>

    <div id="single-unt">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <?php
                            the_title(
                                '<header class="entry-header"><h1 class="entry-title ' . $class . '">',
                                '</h1></header><!-- .entry-header -->'
                            );
                            ?>
                            <div class="d-flex flex-md-row flex-column">
                                <section class="unt w-100">
                                    <div class="px-md-0 px-3">
                                        <div class="d-flex flex-column flex-wrap">
                                            <?php

                                            if($logo){
                                                echo '<div class="image">
                                                    <img src="'.$logo['sizes']['medium'].'" alt="'.$logo['alt'].'">
                                                    </div>';
                                            }
                                            the_field('specialite');

                                            if ($site) {
                                                ?>
                                                <a href="<?php echo $site; ?>" target="_blank">
                                                    Le site <?php echo $title; ?></a>
                                                <?php
                                            }
                                            if ($lien) {
                                                ?>
                                                <a href="<?php echo $lien; ?>" target="_blank">
                                                    Contactez <?php echo $title; ?></a>
                                                <?php
                                            }
                                            if ($partenaires) {
                                                ?>
                                                <a href="<?php echo $partenaires; ?>" target="_blank">
                                                    Les partenaires <?php echo $title; ?></a>
                                                <?php
                                            }
                                            if (have_rows('reseaux_sociaux')):

                                                // Loop through rows.
                                                while (have_rows('reseaux_sociaux')) : the_row();
                                                    // Load sub field value.
                                                    $rs = get_sub_field('reseau_social');
                                                    $lienRs = get_sub_field('lien_reseau');

                                                    if($rs && $lienRs){
                                                        echo '<a href="'.$lienRs.'" target="_blank">'.createRSIcon($rs).'</a>';
                                                    }

                                                endwhile;
                                            endif;
                                            if($titreMentions){
                                                echo '<h2 class="no-point">'.$titreMentions.'</h2>';
                                            }
                                            the_field('mentions_concernees');
                                            the_field('principales_actions');
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
