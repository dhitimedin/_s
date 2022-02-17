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

get_header();
?>

        <!-- Experimental Code is here -->

        <!-- Experimental Code Ends -->
	<main id="primary" class="site-main container-fluid m-0 p-0">          
            
            <?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
                        
                } // End of the loop.

                wp_reset_postdata();
                get_template_part( 'template-parts/content', 'partner' );

            ?>
                
                <!-- Partner Section Ends -->            
            
            
            

	</main><!-- #main -->

<?php
get_footer();
