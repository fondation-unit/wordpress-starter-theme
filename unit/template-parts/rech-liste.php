<?php

include_once(get_stylesheet_directory() . '/inc/SolrRequest.php');
include_once(get_stylesheet_directory() . '/inc/GenerateFacets.php');

$solrReq = new SolrRequest();
$res = $solrReq->solrListeQuery($_GET, $paged);
$num = $res->response->numFound;
$breadcrumb = searchBreadcrumb($_GET, $num);
?>
<div class="container px-4">
    <div class="d-flex flex-row formulaire align-items-center justify-content-center">
        <form action="<?php echo get_permalink(get_the_ID()); ?>" id="search-text">
            <input type="text"
                   name="recherche"
                   id="recherche-out"
                   placeholder="Rechercher"
                   value="<?php echo ! empty($_GET['recherche']) ? $_GET['recherche'] : ''; ?>">
            <button role="submit" id="rech-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <a href="#" title="Accéder à la recherche avancée" class="btn-advanced ">
            <i class="icon-rouage"></i>
        </a>
    </div>
    <div class="d-flex flex-md-row flex-column liste-resultats mb-md-5 mb-4">
        <div class="d-flex flex-column col-md-10">
            <h2 class="<?php echo PRIMARY; ?>">Votre recherche</h2>

            <p class="resultats"><?php echo $breadcrumb; ?></p>
        </div>
        <div class="select col-md-2 d-flex justify-content-end mt-md-5">
            <form action="" id="search-tri">
                <select name="tri" id="tri-out">
                    <option value="date-" <?php echo isset($_GET['tri']) && (empty($_GET['tri'])
                        ||  $_GET['tri'] == 'date-')
                        ? 'selected="selected"' : ''; ?>>Par date descendante
                    </option>
                    <option value="date+" <?php echo isset($_GET['tri']) && $_GET['tri'] == 'date+'
                        ? 'selected="selected"' : ''; ?>>Par date ascendante
                    </option>
                </select>
            </form>
        </div>
    </div>
    <div class="d-flex flex-md-row flex-column search-cards">
        <?php get_template_part('template-parts/search-facets'); ?>
        <div class="col-md-8 search-liste">
            <div class="cards d-flex flex-md-row flex-wrap">
                <?php
                if (is_array($res['response']['docs']) && $res->response->numFound > 0) {
                    foreach ($res['response']['docs'] as $fiche) {
                        ?>

                        <div class="resultat <?php echo isset($fiche->vignette) ?  'vignette':''; ?>">
                            <a href="<?php echo $fiche->ressource_liens[0]; ?>" class="external" target="_blank">
                                <?php if (isset($fiche->vignette)): ?>
                                    <div class="image">
                                        <img src="<?php echo 'https://ressources.luniversitenumerique.fr/uploads/images/'.$fiche->vignette; ?>" alt="">
                                    </div>
                                <?php
                                endif;
                                ?>
                                <h3><?php
                                    echo $fiche->titre[0];
                                    ?>
                                </h3>
                            </a>
                            <div class="contenu"> <?php
                                $excerpt = $fiche->description_text;
                                echo '<p>' . ((mb_strlen($excerpt) > 200)
                                        ? mb_substr($excerpt,
                                            0, 200)
                                        . '...' : $excerpt) . '</p>'
                                ?>
                            </div>

                            <div class="date">
                                <i class="icon-calendrier"></i> <?php echo wp_date('d/m/Y',
                                    strtotime($fiche->date_modification)); ?>
                            </div>
                            <a href="<?php echo get_permalink() . '?fiche=' . $fiche->uuid; ?>"
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
                } else {
                    ?>
                    <p>Désolé, aucun résultat ne correspond à votre recherche.</p>
                    <?php
                }
                ?>
            </div>
            <div class="Ligne nav-actus pb-md-6 py-4 <?php echo PRIMARY; ?>">
                <div id="navPages" class="w-100 mt-4">
                    <?php
                    $pagination = new Pagination();
                    $pagination::render(get_query_var('paged'), ceil($res['response']['numFound'] / ROWS_PER_PAGE)); ?>
                </div>
            </div>
        </div>
    </div>

</div>