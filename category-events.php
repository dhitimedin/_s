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
		<?php if( have_posts() ) : ?>
                    
            <header class="blog-title-header">
                        
                <h1 class="spi-blog-header"><?php echo single_cat_title('',false) ?></h1>
                <?php echo the_archive_description( '<div class="spi-blog-subheader">', '</div>' ); ?>
            </header> 

            <div class="spi-newsletter-grid-container">             
        
            <?php

                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();
                    /* Code Introduced for displaying blog post as card */
                    if ( has_post_thumbnail() ) {
                        $thumb_id           = get_post_thumbnail_id();
                        $thumb_url_array    = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', true );
                        $label              = $thumb_url_array[ 0 ];
                        //$label = the_post_thumbnail_url('thumbnail');
                    }
                    elseif ( function_exists('the_custom_logo') ) {
                        $custom_logo_id     = get_theme_mod( 'custom_logo' );
                        $logo               = wp_get_attachment_image_src( $custom_logo_id );
                        $label              = $logo[ 0 ];
                    }
                    else { 
                        $label              = "";
                    }
            ?>

                    <!-- introduced for cards -->
                    <div class="spi-event-card">
                        <img src="<?php echo $label; ?>" class="" alt="..." />
                        <div class="spi-event-title">
                            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" style="text-decoration:none;">
                                <?php echo get_the_title(); ?>
                            </a>
                        </div>
                    </div><!-- col -->


                <?php endwhile; ?>
                    
            </div><!-- End Inner Row> -->
            <?php the_posts_navigation(); ?>
            <br />
		<?php else :
			get_template_part( 'template-parts/content', 'none' );

        endif;
		?>
	</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
