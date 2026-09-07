<?php

if ($fiche['numFound'] !== 1) {
    wp_redirect(get_permalink(get_the_ID()));
}
$container = get_theme_mod('understrap_container_type');
?>

<div id="single-solr" class="mb-md-6 mb-4">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <div class="row">

            <main class="site-main" id="main">
                <div class="container">

                    <div class="pe-md-4">
                        <?php
                        if (! empty($fiche['vignette'])):
                        ?>
                        <div class="d-flex flex-md-row-flex-column">
                            <div class="col-md-4 d-flex align-items-center">
                                <img src="<?php echo $fiche['vignette']; ?>" alt="">
                            </div>
                            <div class="col-md-8">

                                <?php
                                endif;
                                ?>
                                <h2><?php echo $fiche['contributeur']; ?></h2>
                                <?php echo $fiche['description']; ?>

                                <?php
                                if (! empty($fiche['vignette'])):
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                        <div class="d-flex flex-md-row justify-content-between mt-4">
                            <a href="<?php echo $fiche['lien']; ?>" class="btn btn-primary" target="_blank">
                                Accéder à la ressource
                            </a>
                            <a href="<?php echo $fiche['suplom']; ?>" class="btn btn-primary" target="_blank">
                                Fiche SUPLOMFR
                            </a>
                        </div>
                    </div>

                    <div class="d-flex flex-md-row flex-column conclusion">
                        <div class="col-md-6 px-4 me-md-4">
                            <h2>Description</h2>
                            <h3 class="no-point">Université productrice</h3>
                            <p><?php echo $fiche['porteur']; ?></p>
                            <h3 class="no-point">Discipline</h3>
                            <p><?php echo $fiche['disciplines']; ?></p>
                            <h3 class="no-point">Mots clés</h3>
                            <p><?php echo $fiche['keyWords']; ?></p>
                            <h3 class="no-point">Langues</h3>
                            <p><?php echo $fiche['langues']; ?></p>
                            <?php
                            if (! empty($fiche['droit'])):
                                ?>
                                <h3 class="no-point">Droits attachés à la ressource</h3>
                                <p><?php echo $fiche['droit']; ?></p>
                                <?php
                                if (! empty($fiche['logo_droit']['img'])):
                                    if (! empty($fiche['logo_droit']['lien'])):
                                        echo '<a href="' . $fiche['logo_droit']['lien'] . '" target="_blank">';
                                    endif;
                                    ?>
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/img/' . $fiche['logo_droit']['img']; ?>"
                                         alt="Logo <?php echo $fiche['logo_droit']['img']; ?>">
                                    <?php
                                    if (! empty($fiche['logo_droit']['lien'])):
                                        echo '</a>';
                                    endif;
                                endif;
                            endif;
                            ?>
                        </div>
                        <div class="col-md-6 px-4">
                            <h2>Indication pédagogique</h2>
                            <h3 class="no-point">Niveaux</h3>
                            <p><?php echo $fiche['levels']; ?></p>
                            <?php
                            if (! empty($fiche['proposition_utilisation'])):
                                ?>
                                <h3 class="no-point">Proposition d'utilisation</h3>
                                <p><?php echo $fiche['proposition_utilisation']; ?></p>
                            <?php
                            endif;
                            if (! empty($fiche['types_pedagogiques'])):
                                ?>
                                <h3 class="no-point">Type(s) pédagogique(s)</h3>
                                <p><?php echo $fiche['types_pedagogiques']; ?></p>
                            <?php
                            endif;
                            if (! empty($fiche['types_documentaires'])):
                                ?>
                                <h3 class="no-point">Type(s) documentaire(s)</h3>
                                <p><?php echo $fiche['types_documentaires']; ?></p>
                            <?php
                            endif;
                            if (! empty($fiche['dure_apprentissage'])):
                                ?>
                                <h3 class="no-point">Durée d'apprentissage</h3>
                                <p><?php echo $fiche['dure_apprentissage']; ?></p>
                            <?php
                            endif;

                            ?>

                        </div>
                    </div>
                    <?php
                    if (isset($fiche['associations_associate'][0])):

                        ?>
                        <div class="associates">
                            <h2>Ressources associées</h2>
                            <div class="d-flex flex-md-row flex-column flex-wrap cards">
                                <?php
                                foreach ($fiche['associations_associate'] as $ass) {
                                    $solrReq = new SolrRequest();
                                    $ficheAss = $solrReq->getFiche($ass->uuid);
                                    ?>
                                    <div class="col-md-4 resultat mb-4">
                                        <a href="<?php echo $ficheAss['lien']; ?>" class="external" target="_blank">
                                            <?php if (! empty($ficheAss['vignette'])): ?>
                                                <div class="image">
                                                    <img src="<?php echo 'https://ressources.luniversitenumerique.fr/uploads/images/'
                                                        . $ficheAss['vignette']; ?>" alt="">
                                                </div>
                                            <?php
                                            endif;
                                            ?>
                                            <h3><?php
                                                echo $ficheAss['titre'];
                                                ?>
                                            </h3>
                                        </a>
                                        <div class="contenu"> <?php
                                            $excerpt = $ficheAss['description'];
                                            echo((mb_strlen($excerpt) > 200)
                                                ? mb_substr($excerpt,
                                                    0, 200)
                                                . '...' : $excerpt);
                                            ?>
                                        </div>

                                        <a href="<?php echo get_permalink() . '?fiche=' . $ass->uuid; ?>"
                                           class="link">
                                            <div class="link-content">
                                                <span class="sr-only">Voir les détails de la ressource</span>
                                                <span class="hidden">Fiche détaillée</span>
                                                <i class="icon-fleche-actu-projet" aria-hidden="true"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    endif;
                    ?>
                    <div class="d-flex mt-md-5 mt-3 justify-content-end">
                        <button onclick="history.go(-1);" class="btn btn-primary">Retour</button>
                    </div>
            </main>
        </div>
    </div>
</div>