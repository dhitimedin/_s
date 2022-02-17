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
                    the_title( '<h1 class="spi-impact-title">', '</h1>' );                    

                    $sldrs_types = new WP_Query(array('post_type' => 'slider', 'post_name__in' => array('impactstories') , 'posts_per_page' => -1));
                    
                    
                    while($sldrs_types->have_posts()){
                        $sldrs_types->the_post();
                        

                        $you_tube_arr = get_post_custom_values( 'youtube', $post->ID);
                        $title_arr = get_post_custom_values( 'title', $post->ID);
                        $description_arr = get_post_custom_values( 'description', $post->ID);
                  
                        echo '<div class="spi-impactstories-grid-container">'; 
                        $count = 0;
                        if($you_tube_arr){
                            forEach($you_tube_arr as $sldr_rsrcs){
                                
                                echo ''
                                    . '<div class="spi-impact-figure">'
                                        . '<div class="spi-impact-figure-video">'
                                        . '<iframe src="' . $sldr_rsrcs . '" frameborder="0" allowfullscreen="true" height="100%" width="100%"></iframe>'
                                        . '</div>'
                                        . '<p class="spi-impact-header">' . $title_arr[$count] . '</p>'
                                        . '<p class="spi-impact-decription">' . $description_arr[$count] . '</p>'
                                    . '</div>';
                                $count++;           
                            }
                        }    
                        
                        echo '</div>'; 
                        
                    }
                }
		else 
                {
			get_template_part( 'template-parts/content', 'none' );

                }
		?>

	</main><!-- #main -->

<?php
get_footer();
