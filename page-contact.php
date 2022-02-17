<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */



// get the header
get_header();
?>

	<main id="primary" class="site-main container-fluid px-md-5 mt-0 pt-0">
         

            <section class="container-fluid g-4 text-white px-md-5 pt-3" style="background-color: #1d4578;">
                <!--Section heading-->
            <?php 
                if ( have_posts() ) { 
                    while ( have_posts() ) { 
                        the_post();
                        echo '<h2 class="spi-card-title text-uppercase text-left my-3"><strong>' . get_the_title() . '</strong></h2>';
                        //<!--Section description-->
                        $msg = "All fields marked with (*) are mandatory";
                        if ( !empty( $msg ) ){
                            echo '<p class="text-left spi-card-text mx-auto mb-4">' . $msg . '</p>';
                        }
                        
                        $content = get_the_content();
                        $content = apply_filters('the_content', $content);
                        
                        echo ''
                            . '<div class="row g-5">'
                                . '<div class="col-md-6 mb-5">'
                                    . $content
                                .'</div>'
                                . '<div class="col-md-6 pb-4">'
                                    . '<p><strong> Telephone : </strong> <a href="tel:+91-124-4692015" class="text-decoration-none text-white">+91-124-4692015 </a></p>'
                                    . '<div class="ratio ratio-16x9">'
                                       . '<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Smart+Power+India+Gurugram+India" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>'
                                    . '</div>'
                                . '</div>'

                            . '</div>';                           

                    } //End While
                }    //End If            
            ?>
            </section>
            <!--Section: Contact v.2-->            
            

	</main><!-- #main -->


<?php
get_footer();
