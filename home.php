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
        <!--    -->
		<?php
                $the_query = new WP_Query( array( 
                    'category_name' => 'Blogs', 
                    'posts_per_page' => 10 
                ) );

              
		if ( have_posts() ) {

                    echo '<header class="blog-title-header">';
                
                    if ( is_home() && ! is_front_page() ) {
                        $p_id = get_queried_object_id();
                        echo '<p class="spi-blog-header">' . get_the_title($p_id) . '</p>'
                           . '<p class="spi-blog-subheader">' . get_post_meta( $p_id , "blog-sub-title", true) . '</p>';
                    }
                    echo  '</header>';                   
                   
                    echo '<div class="spi-blogpost-grid-container">'
                        . '<div>';
                    
			/* Start the Loop */
                        
			while ( have_posts() ) {
                            the_post();
                            /* Code Introduced for displaying blog post as card */
                            //$categories = get_the_category();
                            
                            if (has_post_thumbnail()){
                                $thumb_id = get_post_thumbnail_id();
                                $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                                $label = $thumb_url_array[0];
                                //$label = the_post_thumbnail_url('thumbnail');
                            }
                            elseif (function_exists('the_custom_logo')) {
                                $custom_logo_id = get_theme_mod('custom_logo');
                                $logo = wp_get_attachment_image_src($custom_logo_id);
                                $label = $logo[0];
                            }
                            else { 
                                $label = "";
                            } 
                            
                            //Test Card
                            echo '<div class="spi-card-hover">'
                                    . '<img src="' . $label . '" alt="..." loading="lazy">'
                                    . '<div class="card-body">'
                                        . '<h5 class="card-title">'
                                            . '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none text-success">'
                                                . get_the_title()
                                            . '</a>'
                                        . '</h5>'
                                        . '<p class="card-text">' . get_the_excerpt() . '</p>'
                                        . '<p class="card-text"><small class="text-muted">' . ((_s_posted_on()) .  (_s_posted_by())) . '</small></p>'
                                    . '</div>'
                                . '</div>' ;                           
                            //Test Card ends
      
                        
                        }
                     
                     echo '<p>' . get_the_posts_navigation() . '</p>';    
                    //echo get_the_posts_navigation() . '<br />';
            
                    echo '</div>'; //<!-- End Inner Col -->
                    ?>
                    <div> <?php get_sidebar() ?> </div>
                    <?php

                    echo '</div>'; //<!-- outer row ends here -->                    
                }
		else{

			get_template_part( 'template-parts/content', 'none' );
                        get_sidebar();

                }
		?>

	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
