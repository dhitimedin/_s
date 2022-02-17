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
            echo '<div class="spi-blogpost-grid-container">'
                . '<div>';
            
            while ( have_posts() ) {
                the_post();
                
                
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

                // <!-- introduced for cards -->
                echo '<div class="spi-card-hover">';
                        if ( strpos($post->post_content, "</iframe>" ) && strpos($post->post_content, "www.youtube.com") ) { 
                            $content = simplexml_load_string( get_the_content() );
                            echo '<div class="spi-res-video-container"><iframe src="' . $content->attributes()->{'src'} . '" frameborder="0" allowfullscreen class="responsive-iframe" loading="lazy"></iframe></div>'; 
                        }
                        else { 
                            echo '<img src="' . $label . '" alt="...">';
                        }
                        echo '<div class="card-body px-0 mx-0">'
                            . '<h5 class="card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none text-success">'
                                . get_the_title()
                            . '</a></h5>'
                            . '<p class="card-text">' . get_the_excerpt() . '</p>'
                            . '<p class="card-text"><small class="text-muted">' . ((_s_posted_on()) .  (_s_posted_by())) . '</small></p>'
                        . '</div>'
                    . '</div>' ;                                   
                
            }
                echo '<p>' . get_the_posts_navigation() . '</p>'; 
                
                echo '</div>'; //<!-- End Inner Col -->
                ?>
                <div> <?php get_sidebar() ?> </div>
                <?php

                echo '</div>'; //<!-- outer row ends here -->  
            }
		else
                {

                    get_template_part( 'template-parts/content', 'none' );
                    get_sidebar();

                }
		?>
             
	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
