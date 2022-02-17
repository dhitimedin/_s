<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

get_header();
?>

	<main id="primary" class="site-main">
		<?php
		if ( have_posts() ) {
                    
                    echo '<header class="blog-title-header">';
                        
                        echo '<h1 class="spi-blog-header">' . single_cat_title('',false) . '</h1>';
                        the_archive_description( '<div class="spi-blog-subheader">', '</div>' );
                    echo '</header>';                
                    

                    /* Start the Loop */
                    echo '<div class="spi-impactstories-grid-container">';
                    while ( have_posts() ) {
                            the_post();

                            $output = simplexml_load_string($post->post_content); 

                       // <!-- introduced for cards -->
                                echo ''
                                    . '<div class="spi-impact-figure">'
                                        . '<div class="spi-impact-figure-video">'
                                        . '<iframe src="' . $output->attributes()->{'src'} . '" frameborder="0" allowfullscreen="true" height="100%" width="100%"></iframe>'
                                        . '</div>'
                                        . '<p class="spi-impact-header"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" style="text-decoration:none;">'
                                            . $post->post_title
                                        . '</a></p>'
                                        . '<p class="spi-impact-decription">' . $post->post_excerpt . '</p>' 
                                    . '</div>';                            
                        
                    }
                    echo '</div>';
                }
		else
                {

                    get_template_part( 'template-parts/content', 'none' );

                }
		?>
	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
