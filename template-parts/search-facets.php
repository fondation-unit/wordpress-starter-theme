<?php

include_once(get_stylesheet_directory() . '/inc/SolrRequest.php');
include_once(get_stylesheet_directory() . '/inc/GenerateFacets.php');

$solrReq = new SolrRequest();
$res = $solrReq->solrFacetsQuery();
$generateFacets = new GenerateFacets();
$facetsArray = $generateFacets->createFacetsArray($res->response->docs);
?>
<div class="col-md-4 search-aside pe-md-4 d-flex align-items-start mb-md-0 mb-4">
    <form method="get" class="search-facets" action="<?php echo get_permalink(get_the_ID()); ?>">
        <input type="hidden"
               name="recherche"
               id="recherche"
               value="<?php echo ! empty($_GET['recherche']) ? $_GET['recherche'] : ''; ?>">
        <input type="hidden" name="tri" id="tri" value="<?php echo ! empty($_GET['tri']) ? $_GET['tri'] : ''; ?>">
        <div class="accordion" id="accordionFacets">
            <?php
            $i = 1;
            $j = 1;
            foreach ($facetsArray as $key => $value):
                $arrayName = mb_strtolower(str_replace(' ', '_', $generateFacets->remove_accents($key)));
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse<?php echo $i; ?>"
                                aria-expanded="false"
                                aria-controls="collapse<?php echo $i; ?>">
                            <?php echo ucfirst($key); ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $i; ?>"
                         class="accordion-collapse collapse"
                         data-bs-parent="#accordionFacets">
                        <div class="accordion-body">
                            <div class="d-flex flex-column">
                                <?php
                                if (is_array($value)) {
                                    ksort($value);
                                    foreach ($value as $k => $v) {
                                        if ($k !== 'count'):
                                            if (count($v) > 1):
                                                ?>
                                                <button class="accordion-button collapsed sub pe-3"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse-sub-<?php echo $j; ?>"
                                                aria-expanded="false"
                                                aria-controls="collapse-sub-<?php echo $j; ?>">
                                            <?php
                                            endif;
                                            ?>
                                            <div class="d-flex flex-row field first-level">
                                                <input type="checkbox"
                                                       name="<?php echo $arrayName; ?>[]"
                                                       id="<?php echo $generateFacets->remove_accents($k); ?>"
                                                       value="<?php echo base64_encode($k); ?>"
                                                    <?php echo is_array($_GET[$arrayName])
                                                    && in_array(base64_encode($k), $_GET[$arrayName])
                                                        ? 'checked="checked"' : ''; ?>
                                                       data-bs-toggle="collapse" data-bs-target>
                                                <label for="<?php echo $k; ?>"  data-bs-toggle="collapse" data-bs-target><span class="titre"><?php echo $k; ?></span></label>
                                            </div>
                                            <?php
                                            if (count($v) > 1):
                                                ?>
                                                </button>
                                                <div id="collapse-sub-<?php echo $j; ?>"
                                                     class="accordion-collapse collapse second-level"
                                                     data-bs-parent="#collapse-sub-<?php echo $j; ?>">
                                                    <div class="accordion-body">
                                                        <div class="d-flex flex-column">
                                                            <?php
                                                            ksort($v);
                                                            foreach ($v as $sub => $valSub) {
                                                                if ($sub !== 'count') {
                                                                    ?>
                                                                    <div class="d-flex flex-row field">
                                                                        <input type="checkbox"
                                                                               name="<?php echo $arrayName; ?>[]"
                                                                               id="<?php echo $generateFacets->remove_accents($sub); ?>"
                                                                               value="<?php echo base64_encode($sub); ?>"
                                                                            <?php echo is_array($_GET[$arrayName])
                                                                            && in_array(base64_encode($sub),
                                                                                $_GET[$arrayName]) ? 'checked="checked"'
                                                                                : ''; ?>
                                                                        >
                                                                        <label for="<?php echo $sub; ?>"><span class="titre"><?php echo $sub; ?></span></label>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }

                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;
                                            ?>

                                        <?php
                                        endif;
                                        $j++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            endforeach;
            ?>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <input class="btn btn-primary" type="submit" value="rechercher">
        </div>
    </form>
</div>
