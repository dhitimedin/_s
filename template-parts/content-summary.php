<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php
    if ( has_post_thumbnail() ) :
        $title          = get_the_title(); 
        $thumbnailcap   = get_the_post_thumbnail_caption(); 
        $thumnail_url   = get_the_post_thumbnail_url();

        // Pulling secondary thumnail which would replace primary thumbnail when page is viewed from a small screens 
        if ( class_exists( 'MultiPostThumbnails' ) ) {

            $thumbnailmob =  MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'secondary-image',get_the_ID());
        }
    ?>
                <div class="spi-card-container">
                    <picture>
                        <source srcset="<?php echo $thumnail_url; ?>" media="(min-width: 1400px)">
                        <source srcset="<?php echo $thumnail_url; ?>" media="(min-width: 769px)">
                        <source srcset="<?php echo $thumbnailmob; ?>" media="(max-width: 768px)">
                        <source srcset="<?php echo $thumbnailmob; ?>" media="(min-width: 577px)">
                        <img srcset="<?php echo $thumnail_url; ?>" alt="responsive image" class="card-img img-fluid" loading="lazy">
                    </picture>         
                    <div class="<?php echo ( in_array( $post->post_name, 
                            array(
                                "mini-grid-model",
                                "energy-service-franchise-model",
                                "rural-electricity-access",
                                "internships-and-fellowship", 
                                "model-distribution-zone-mdz-program",
                                "enhanced-rural-revenue-franchise-e-rrf-program",
                                "innovation"
                            ) ) 
                            ? 'spi-card-img-overlay-right' : 'spi-card-img-overlay-left'
                        ); ?>">
                        <h2 class="home-card-header"><strong><?php echo get_the_title(); ?></strong></h2>
                        <p class="<?php echo ( in_array( ( $wp_query->get_queried_object() )->post_name, array( "careers" ) ) ? 
                                                'spi-card-text': 'home-card-text' ); ?>">
                                                <?php echo get_the_post_thumbnail_caption(); ?>
                        </p>
                    </div>
                </div>                     
    <?php 
    endif;

    // get the ID of the current (parent) page
    $current_page_id = get_the_ID();


    $args_w = array(
        'post_parent'   => $current_page_id,
        'child_of'      => $current_page_id,
        'post_type'     => 'page',
        'orderby'       => 'post_name__in',
        'post_name__in' => array(
                                'rural-electricity-access', 
                                'micro-enterprise-development',
                                'innovation',
                                'internships-and-fellowship',
                                'current-vacancy'
                            ),
        'depth'         => 1,
    );
    $query_child        = new WP_Query( $args_w );
    while ( $query_child->have_posts() ) {
        $query_child->the_post();
        get_template_part( 'template-parts/content', 'sumup' );
    }
    wp_reset_postdata();  

    if ( get_edit_post_link() ) : 
?>
    <footer class="entry-footer">
        <?php
        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <div class="pill-button">%s</div>', '_s' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="pill-button">',
            '</span>'
        );
        ?>
    </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
