<?php
/**
 * Search results partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<article class="loop-card-<?php echo PRIMARY; ?>" id="post-<?php echo get_the_ID(); ?>">
    <header class="entry-header">
        <?php
        the_title(
            sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())),
            '</a></h2>'
        );
        ?>
    </header><!-- .entry-header -->

    <div class="entry-summary">
        <?php
        if($post->post_type === 'post'){
            the_excerpt();
        }elseif($post->post_type === 'projet'){
            $desc = get_field('presentation', $post->ID);
            echo mb_strlen($desc) > 300 ? mb_substr($desc, 0, 300) . '...' : $desc;
        }

         ?>
    </div><!-- .entry-summary -->
    <div class="link">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="link-content">
            <span class="sr-only">Voir les détails de
                                  l'actualité</span>
            <span class="hidden">En savoir plus</span>
            <i class="icon-fleche-actu-projet"></i>
        </a>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
