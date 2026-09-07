<?php

$title = get_the_title();
$class = getClassFromTitle($title);
$newTitle = $title === 'IUTenligne' ? 'IUT en ligne' : $title;

$typeContact = get_field('type_de_contact');
$lien = $typeContact === 'Lien' ? get_field('url_contact') : 'mailto:' . get_field('mail_contact');

$partenaires = get_field('partenaires');
$site = get_field('site');
$logo = get_field('logo_blanc');
$specialite = get_field('specialite');

$size = wp_is_mobile() ? 'medium' : 'medium_large';
?>
<div class="bg-<?php echo $class; ?> mb-md-5 mb-4 py-md-6 py-4  ">
    <div class="container">
        <div class="d-flex flex-column">
            <?php
            if ($logo):
                ?>
                <div class="image">
                    <?php
                    $imageArr = altTextForFormationImages($logo, $size);
                    echo wp_get_attachment_image($logo['ID'], $size, false,
                        ['alt' => $imageArr['alt'], 'class' => 'lozad']);
                    ?>
                </div>
            <?php
            endif;
            if ($specialite):
                ?>
                <h2 class="my-4 mb-md-5 specialite"><?php echo $specialite; ?></h2>
            <?php
            endif;
            ?>
            <div class="unt-fiche d-flex flex-row flex-wrap">
                <?php
                if ($site) {
                    ?>

                    <a href="<?php echo $site; ?>" target="_blank" title="Lien vers le site de <?php echo $newTitle; ?> - Nouvelle fenêtre">Le
                                                                   site <?php echo $newTitle; ?></a>
                    <?php
                }
                if ($lien) {
                    ?>

                    <a href="<?php echo $lien; ?>" target="_blank" title="Lien vers le formulaire de contact de <?php echo $newTitle; ?> - Nouvelle fenêtre">
                        Contactez <?php echo $newTitle; ?></a>
                    <?php
                }
                if ($partenaires) {
                    ?>

                    <a href="<?php echo $partenaires; ?>" target="_blank" title="Lien vers la page partenaires de <?php echo $newTitle; ?> - Nouvelle fenêtre">Les
                                                                          partenaires <?php echo $newTitle; ?></a>
                    <?php
                }
                if (have_rows('reseaux_sociaux')):

                    // Loop through rows.
                    while (have_rows('reseaux_sociaux')) : the_row();
                        // Load sub field value.
                        $rs = get_sub_field('reseau_social');
                        $lienRs = get_sub_field('lien_reseau');

                        if ($rs && $lienRs) {
                            echo '<a href="' . $lienRs
                                . '" target="_blank" class="rs" title="Lien vers le compte '.$rs.' de '.$newTitle.' - Nouvelle fenêtre">'
                                . createRSIcon($rs) . '</a>';
                        }

                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
