<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');
$upload_dir = wp_upload_dir();

?>

<?php if (is_front_page() && is_home()) : ?>
    <?php get_template_part('global-templates/hero'); ?>
<?php endif; ?>

    <div class="wrapper" id="index-wrapper">
        <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">
            <main class="site-main" id="main">
                <?php
                the_content();
                ?>
            </main>
        </div><!-- #content -->
    </div><!-- #index-wrapper -->
<?php
get_footer();
