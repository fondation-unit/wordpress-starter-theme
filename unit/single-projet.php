<?php

/**
 * Template Name: Page Actualités
 * Author : Fondation UNIT
 */
get_header();

$title = get_the_title();
$class = getClassFromTitle($title);
$container = get_theme_mod('understrap_container_type');

$logo = get_field('logo');
$illustration = get_field('illustration');
$introduction = get_field('introduction');
$presentation = get_field('presentation');
$savoirs = get_field('savoirs');
$enChiffre = get_field('en_chiffres');
$outro = get_field('outro');
$unts = get_field('unts');

$size = getPhotoSize();
?>

    <div id="single-project" class="mb-md-6 mb-4">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">
                            <div class="logo d-flex justify-content-center mb-md-6 mb-4">
                                <?php the_title('<h1 class="' . PRIMARY
                                    . '">', '</h1>'); ?>
                            </div>
                            <div class="d-flex flex-column my-4 introduction">
                                <div class="d-flex flex-md-row flex-column">
                                    <div class="col-md-6 d-flex align-items-start pe-md-4 mb-4">
                                        <?php
                                        if ($logo):
                                            $imgDatas = altTextForFormationImages($logo, $size);
                                            echo wp_get_attachment_image($logo['ID'], $size, false,
                                                [
                                                    'alt' => $imgDatas['alt'],
                                                    'class' => 'wp-post-image lozad',
                                                ]);
                                        endif;
                                        ?>
                                    </div>
                                    <div class="col-md-6 ps-md-4 mb-4">
                                        <?php
                                        if ($introduction):
                                            ?>
                                            <h2 class="<?php echo PRIMARY; ?>">Introduction</h2>
                                            <?php
                                            echo $introduction;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    <?php
                                    echo get_field('presentation');
                                    ?>
                                </div>
                            </div>
                            <?php
                            if ($savoirs):
                                ?>
                                <div class="savoirs my-4 d-flex flex-column">
                                    <h3 class="<?php echo PRIMARY; ?>">Les savoirs mis en oeuvre</h3>
                                    <?php
                                    echo $savoirs;
                                    ?>
                                </div>
                            <?php
                            endif;

                            if ($enChiffre || have_rows('chiffres') || $outro):
                                ?>
                                <div class="chiffres my-4 d-flex flex-column">
                                    <?php
                                    echo $enChiffre;

                                    if (have_rows('chiffres')):
                                        ?>
                                        <div class="liste-chiffres d-flex flex-md-row flex-column my-4">

                                            <?php
                                            while (have_rows('chiffres')) : the_row();
                                                ?>
                                                <div class=" d-flex flex-column align-items-center justify-content-center col">
                                                    <div class="chiffre">
                                                        <?php
                                                        echo get_sub_field('chiffre')
                                                        ?>
                                                    </div>
                                                    <div class="texte">
                                                        <?php
                                                        echo get_sub_field('chiffre_texte')
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php

                                            endwhile;
                                            ?>
                                        </div>
                                    <?php
                                    endif;
                                    if ($outro):
                                        ?>
                                        <div class="outro my-4">
                                            <?php echo $outro; ?>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            <?php
                            endif;

                            if ($unts):
                                ?>
                                <div class="liste-unts d-flex flex-md-row flex-column my-4 align-items-center">
                                    <?php
                                    $i = 1;
                                    foreach ($unts as $unt):
                                        $logoU = get_field('logo', $unt->ID);
                                        $lien = get_permalink($unt->ID);
                                        ?>
                                        <div class="unt d-flex me-md-4 mb-md-0 <?php echo $i !== count($unts) ? ' mb-5'
                                            : ''; ?>">
                                            <a href="<?php echo $lien; ?>">
                                                <?php
                                                $imgDatas = altTextForFormationImages($logoU, $size);
                                                echo wp_get_attachment_image($logoU['ID'], $size, false,
                                                    [
                                                        'alt' => $imgDatas['alt'],
                                                        'class' => 'wp-post-image lozad',
                                                    ]);
                                                ?>
                                            </a>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();
