<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
 */

get_header();
?>
	<main id="primary" class="site-main container">
              
        <div class="row g-4">
            <?php if ( ! ( in_category( 'newsletter' ) || in_category( 'events' ) ) ) : ?>
                <div class="col-md-8 text-start">
                    <div class="five-star-line "></div> 
            <?php else : ?>
                <div class="col-md-12 p-0 m-0">
            
            <?php endif; //end of else
                  
                while ( have_posts() ) :
                    the_post();
                                
                    if ( in_category( 'newsletter' ) || in_category( 'events' ) ) {
                        get_template_part( 'template-parts/content', 'newsletter' );
                    } 
                    else {
                    get_template_part( 'template-parts/content', get_post_type() );
                    }

                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', '_s' ) . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', '_s' ) . '</span> <span class="nav-title">%title</span>',
                        )
                    );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
		
                echo ( ! in_category( 'newsletter' ) || in_category( 'events' ) ) ? '<div class="five-star-line "></div>': '' ;

                ?>
            </div>

            
            <?php if ( ! ( in_category( 'newsletter' ) || in_category( 'events' ) ) ) : ?>

                <div class="col-md-4 mt-5">
                    <?php get_sidebar(); ?>
                </div> 

            <?php endif; ?>

        </div>
    </main><!-- #main -->           

<?php
get_footer();
