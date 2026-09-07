<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

        <?php
        the_title(
            '<header class="entry-header"><h1 class="entry-title">',
            '</h1></header><!-- .entry-header -->'
        );
        ?>
        <div class="entry-meta my-4">

            <?php understrap_posted_on(); ?>

        </div><!-- .entry-meta -->

    </header><!-- .entry-header -->

    <div class="entry-content">

        <?php
        the_content();
        understrap_link_pages();
        ?>

    </div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
