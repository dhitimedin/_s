<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
        

    </head>
  
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div id="page" class="site">
            <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', '_s'); ?></a>
           <?php

            $custom_logo_id = get_theme_mod( 'custom_logo' );
           // $image = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>       
            <nav class="navbar navbar-expand-lg spi-header-background py-0 my-0 sticky-top shadow">
                <div class="container-fluid m-0 p-0 pb-md-1">
                    <a class="navbar-brand m-0 p-0" href="<?php echo get_home_url(); ?>" style="max-width:60%;">
                        <picture>
                            <source srcset="<?php echo wp_get_attachment_url($custom_logo_id); ?>" media="(min-width: 1024px)">
                            <source srcset="<?php echo wp_get_attachment_url($custom_logo_id); ?>" media="(min-width: 300px)">
                            <source srcset="<?php echo wp_get_attachment_url($custom_logo_id); ?>" media="(min-width: 150px)">
                            <img srcset="<?php echo wp_get_attachment_url($custom_logo_id); ?>" class="bg-warning px-4" style="max-height:90px;" alt="Smart Power India" />
                        </picture>
                    </a>
                    <button class="navbar-toggler collapsed border-0 fs-1 fw-bolder" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span><i class="bi bi-list text-primary "></i></span>
                    </button>
            <?php
                        /**
                        * Introduced in version 1.1
                        */

                        wp_nav_menu( array(
                            'theme_location'  => 'menu-1',
                            'depth'           => 0, // 1 = no dropdowns, 2 = with dropdowns.
                            'container'       => 'div',
                            'container_class' => 'navbar-collapse collapse',
                            'container_id'    => 'navbarSupportedContent',
                            'menu_class'      => 'navbar-nav',
                            'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'          => new WP_Bootstrap_Navwalker(),
                        ) );

            ?>

                </div>
            </nav> 
