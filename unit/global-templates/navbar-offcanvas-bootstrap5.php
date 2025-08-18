<?php
/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since   1.1.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
?>

<nav id="main-nav" class="navbar navbar-expand-xl navbar-dark bg-white fixed-top pt-2 py-4" aria-labelledby="main-nav-label">
    <div class="container">
        <h2 id="main-nav-label" class="screen-reader-text">
            <?php esc_html_e('Main Navigation', 'understrap'); ?>
        </h2>

        <div class="d-flex flex-md-row justify-content-between w-100"><!-- Your site branding in the menu -->
            <div class="left d-flex flex-xl-row justify-content-between align-items-xl-end">
                <?php get_template_part('global-templates/navbar-branding'); ?>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#navbarNavOffcanvas"
                    aria-controls="navbarNavOffcanvas"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e('Open menu', 'understrap'); ?>"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="offcanvas offcanvas-end bg-primary" tabindex="-1" id="navbarNavOffcanvas">

                    <div class="offcanvas-header justify-content-end">
                        <button
                            class="btn-close btn-close-white text-reset"
                            type="button"
                            data-bs-dismiss="offcanvas"
                            aria-label="<?php esc_attr_e('Close menu', 'understrap'); ?>"
                        ></button>
                    </div><!-- .offcancas-header -->

                          <!-- The WordPress Menu goes here -->
                    <?php
                    wp_nav_menu(
                        [
                            'theme_location' => 'primary',
                            'container_class' => 'offcanvas-body',
                            'container_id' => '',
                            'menu_class' => 'navbar-nav justify-content-end flex-grow-1 pe-3 pb-2',
                            'fallback_cb' => '',
                            'menu_id' => 'main-menu',
                            'depth' => 2,
                            'walker' => new Understrap_WP_Bootstrap_Navwalker(),
                        ]
                    );
                    ?>
                    <div class="d-xl-none right d-flex justify-content-end align-items-end pb-3">
                        <div>
                            <a href="#" class="search-toggle"><i class="fa-solid fa-magnifying-glass"></i></a>
                        </div>
                        <div>
                            <a href="#" class="btn btn-primary ms-3">
                                Accès Moodle
                            </a>
                        </div>
                    </div>
                </div><!-- .offcanvas -->
            </div>
            <div class="d-xl-flex d-none right justify-content-end align-items-end pb-3">
                <div>
                    <a href="#" class="search-toggle"><i class="fa-solid fa-magnifying-glass"></i></a>
                </div>
                <div>
                    <a href="#" class="btn btn-primary ms-3">
                        Accès Moodle
                    </a>
                </div>
            </div>
            <div class="search-form-div">
<!--                    <input type="text" name="s" id="search" placeholder="--><?php //echo __('Search &hellip;', 'understrap-child'); ?><!--">-->
<!--                    <button type="submit" class="btn btn-success">-->
<!--                        <i class="fa-solid fa-magnifying-glass"></i>-->
<!--                    </button>-->
                <?php get_search_form(); ?>
            </div>
        </div>

    </div><!-- .container -->

</nav><!-- #main-nav -->
