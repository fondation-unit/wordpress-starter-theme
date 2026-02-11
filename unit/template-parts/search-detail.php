<?php
if ($fiche['numFound'] !== 1) {
    wp_redirect(get_permalink(get_the_ID()));
}

$container = get_theme_mod('understrap_container_type');
get_header();
?>

    <div id="single-solr" class="mb-md-6 mb-4">
        <div class="wrapper" id="page-wrapper">

            <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

                <div class="row">

                    <main class="site-main" id="main">
                        <div class="container">

                            <div class="pe-md-4">
                                <h2><?php echo $fiche['contributeur']; ?>
                                    - <?php echo $fiche['date_publication']; ?></h2>
                                <p><?php echo $fiche['description']; ?></p>
                                <p><?php echo $fiche['droit']; ?></p>
                                <a href="<?php echo $fiche['lien']; ?>" class="btn btn-primary" target="_blank">
                                    Accéder à la ressource
                                </a>

                            </div>
                            <img src="<?php echo $fiche['vignette']; ?>" alt="">

                            <div class="d-flex flex-md-row flex-column conclusion">
                                <div class="col-md-7 px-4 me-md-4">
                                    <h2>Notice</h2>
                                    <h3>Université productrice</h3>
                                    <p><?php echo $fiche['porteur']; ?></p>
                                    <h3>Discipline</h3>
                                    <p><?php echo $fiche['disciplines']; ?></p>
                                    <h3>Mots clés</h3>
                                    <p><?php echo $fiche['keyWords']; ?></p>
                                </div>
                                <div class="col-md-4 px-4">
                                    <h2>Pédagogie</h2>
                                    <h3>Niveaux</h3>
                                    <p><?php echo $fiche['levels']; ?></p>
                                    <?php
                                    if (! empty($fiche['types_pedagogiques'])):
                                        ?>
                                        <h3>Types pédagogiques</h3>
                                        <p><?php echo $fiche['types_pedagogiques']; ?></p>
                                    <?php
                                    endif;
                                    ?>
                                    <h3>Langues</h3>
                                    <p><?php echo $fiche['langues']; ?></p>
                                </div>
                            </div>
                            <div class="d-flex mt-md-5 mt-3 justify-content-end">
                                <button onclick="history.go(-1);" class="btn btn-primary">Retour</button>
                            </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();