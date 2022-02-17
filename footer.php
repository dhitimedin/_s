<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
    <?php 

        /**
        * Introduced in version 1.1
        */

        // Get menu object
        $my_menu = wp_get_nav_menu_object( 'Secondary Menu' );

        // Echo count of items in menu
        $footer_nav_menu = $my_menu->count;
        $nav_list =  wp_nav_menu( array(
            'theme_location'  => 'menu-2',
            'depth'           => 1, // 1 = no dropdowns, 2 = with dropdowns.
            'container'       => false,
            'menu_class'      => 'footer-nav-bar',
            'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
            'walker'          => new WP_Bootstrap_Navwalker(),
            'echo'            => false,
        ) );

        echo '<footer id="colophon" class="site-footer">'
                . '<div class="footer-sun"></div>'
               // <!--Social buttons-->
                . '<nav class="spi-social mx-2">'
                    . '<div class="spi-social-list" style="margin-right:' . ( round( 100 / ( $footer_nav_menu  * 2 ) ) ) . 'vw ">'
                        . '<p class="spi-social-item h3"style="margin-left:0;">'
                            . "Follow Us" . '<i class="bi bi-chevron-compact-right h3"></i>'
                        . '</p>'
                        . '<p class="spi-social-item">'
                            . '<a href="https://www.facebook.com/smartpower.in/" title="Facebook" target="_blank">'
                                . '<i class="bi bi-facebook h3" style="color: #3b5998"></i>'
                            . '</a>'                          
                        . '</p>'
                        . '<p class="spi-social-item">'
                            . '<a href="https://www.linkedin.com/company/smart-powerindia/" title="Linkedin" target="_blank">'
                                . '<i class="bi bi-linkedin h3" style="color: #0e76a8"></i>'
                            . '</a>'                          
                        . '</p>'
                        . '<p class="spi-social-item">'
                            . '<a href="https://twitter.com/smartpowerorg" title="Twitter" target="_blank">'
                                . '<i class="bi bi-twitter h3" style="color: #00acee"></i>'
                            . '</a>'                          
                        . '</p>'
                        . '<p class="spi-social-item">'
                            . '<a href="https://www.youtube.com/c/SmartPowerIndia_SPI"  title="Youtube" target="_blank">'
                                . '<i class="bi bi-youtube h3" style="color: #FF0000"></i>'
                            . '</a>'                          
                        . '</p>'
                    . '</div>'
                . '</nav>'
               // <!--/.Social buttons-->           
                . '<hr class="bg-dark d-block d-md-none mx-2">'   
                // <!--Footer Links-->
                . '<div class="row mx-2" style="z-index: 2">'
                    . '<div class="row m-0 p-0">'
                        . '<button class="spi-accordion h3 d-md-none m-0 p-0">All Links</button>'
                                //Getting Nav Item list
                                //for median and smaller screen size
                            . '<nav class="spi-panel" aria-label="footer navigation small screen">'
                                . $nav_list
                            . '</nav>'                        

                            // For the expanded condition
                            . '<nav class="d-none d-md-inline mt-3 spi-footer-nav"  aria-label="footer navigation large screen" style="column-count:' . $footer_nav_menu . ';">'
                                . $nav_list
                            . '</nav>'                  
                    . '</div>' //<!--Footer Link End-->
                    . '<div class="footer-lower">'
                        . '<i class="bi bi-envelope-fill text-primary fs-5 me-2"></i>'
                        . '<a class="text-primary text-decoration-none" href="' . esc_url(__('mailto:contact@smartpowerindia.org', '_s')) . '">'
                            /* translators: %s: CMS name, i.e. WordPress. */
                            . esc_html__('contact@smartpowerindia.org', '_s')
                        . '</a>'
                    . '</div>'
                . '</div>'
                //<!--Copyright-->
                . '<div class="footer-copyright">'
                        /* translators: %s: CMS name, i.e. WordPress. */
                    . (esc_html__('Copyright Smart Power India ©', '_s') . date('Y') . ' | All rights reserved')
                . '</div>'
                //<!--/.Copyright-->
                
            . '</footer>'; //<!-- #colophon -->
?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
