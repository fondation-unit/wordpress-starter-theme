<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<footer class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="bg-dark-blue">
            <div class="container pt-md-6 py-4">
                <div class="d-flex flex-md-row flex-column">
                    <div class="col-md-3 d-flex flex-column left-footer mb-md-0 mb-4">
                        <?php dynamic_sidebar('left-footer'); ?>
                    </div>
                    <div class="col-md-6 d-flex flex-md-row center-footer">
                        <?php dynamic_sidebar('center-footer'); ?>
                    </div>
                    <div class="col-md-3 d-flex flex-column right-footer">
                        <?php dynamic_sidebar('right-footer'); ?>
                    </div>
                </div>

                <div class="footer-last d-flex border-top py-2">&copy; 2025 L'Université Numérique
                </div>
            </div>
		</div><!-- .row -->

	</div><!-- .container(-fluid) -->

</footer><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php
wp_footer();
if(is_front_page())
    echo '<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>';

?>

</body>

</html>

