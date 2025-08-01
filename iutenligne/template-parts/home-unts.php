<?php
$listeUnts = new WP_Query([
    'post_type' => 'unt',
    'orderby' => 'rand',
    'post__not_in' => [UNT_UN],
]);
?>
<div class="py-md-6 py-4">
    <div class="container unts">
        <div class="d-flex flex-lg-row flex-column">
            <div class="col-lg-3 d-flex flex-column justify-content-center pe-md-5">
                <h2 class="violet">L'université numérique</h2>
                <?php
                the_field('presentation_un');

                ?>
            </div>
            <?php
            if ($listeUnts->have_posts()):

                ?>
                <div class="col-lg-9 d-flex flex-md-row flex-wrap ps-md-4">
                    <?php
                    while ($listeUnts->have_posts()):
                        $listeUnts->the_post();
                        $title = get_the_title();
                        $class = getClassFromTitle($title);
                        $url = get_field('site');
                        ?>
                        <a href="<?php echo get_the_permalink(); ?>"
                           class="unt d-flex flex-column align-items-center <?php echo $class; ?>">
                            <div class="icone ">
                                <i class="icon-<?php echo $class; ?>"></i>
                            </div>
                            <?php the_title('<h3>', '</h3>'); ?>
                            <div class="link-unt">
                                <?php echo cleanUrl($url); ?>
                            </div>
                        </a>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>