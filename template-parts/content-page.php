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
        $main_banner    = '';
        $thumnail_url   = get_the_post_thumbnail_url();
        if ( class_exists( 'MultiPostThumbnails' ) ) {
            $thumbnailmob =  MultiPostThumbnails::get_post_thumbnail_url( get_post_type(), 'secondary-image', get_the_ID() );

        }
        ?>
                <div class="spi-card-container">
                    <picture>
                        <source srcset="<?php echo $thumnail_url; ?>" media="(min-width: 1400px)">
                        <source srcset="<?php echo $thumnail_url; ?>" media="(min-width: 769px)">
                        <source srcset="<?php echo $thumbnailmob; ?>" media="(max-width: 768px)">                
                        <source srcset="<?php echo $thumbnailmob; ?>" media="(min-width: 577px)">
                        <img srcset="<?php echo $thumnail_url; ?>" alt="responsive image" class="card-img img-fluid">
                    </picture>        
                    <div class="<?php echo ( ( in_array( $post->post_name,
                            array( 
                                'mini-grid-model', 
                                'energy-service-franchise-model', 
                                'rural-electricity-access', 
                                'internships-and-fellowship',
                                'model-distribution-zone-mdz-program', 
                                'enhanced-rural-revenue-franchise-e-rrf-program', 
                                'innovation',
                                'rooftop-solar' ) ) )
                            ? 'spi-card-img-overlay-right' : 'spi-card-img-overlay-left' ); ?>">
                        <h1 class="spi-card-title"><strong><?php echo get_the_title(); ?></strong></h1>
                        <p class="spi-card-text"><?php echo get_the_post_thumbnail_caption(); ?></p>
                    </div>
                </div>                
         
    <?php 
    endif;
    
    switch($post->post_name) {
        case 'innovation':
    ?>
            <div class="spi-caption-innovation text-center py-3">
                <div class="caption-item-innovation bg-primary py-3 px-3">
                    <span class="spi-card-text text-white py-2">
                        <?php  echo get_post(get_post_thumbnail_id())->post_content; ?>
                    </span>
                </div>
            </div>
    <?php   
            break;
        case 'micro-enterprise-development':
    ?>
            <div class="spi-caption-enterprise text-center py-3">
                <div class="caption-item-enterprise bg-success py-3 px-3">
                    <span class="spi-card-text text-white py-2">
                        <?php echo get_post(get_post_thumbnail_id())->post_content; ?>
                    </span>
                </div>
            </div>
    <?php
            break;
    }
    
    if ( $post->post_name != 'about-us' ) :
    ?>
        <div class="entry-content">
            <div class="container<?php 
                    echo ( in_array( $post->post_name, array( 
                            "internships-and-fellowship", 
                            "current-vacancy" ) 
                    ) ? "text-start": "" ); ?>">
                <?php the_content(); ?>
            </div>
            <?php
            
            wp_link_pages(
                    array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
                            'after'  => '</div>',
                    )
            );
            $current_page_id = get_the_ID();
            $child_pages = get_pages(array(
                'child_of' => $current_page_id,
                'sort_column' => 'menu_order',
                'parent' => $current_page_id,
                ));
            if ($child_pages) {
                echo '<div class="d-flex justify-content-center">';
                foreach ($child_pages as $child_page) {

                    $page_id = $child_page->ID; // get the ID of the childpage
                    echo '<div class="pill-button"><a href="' . get_permalink($page_id) . '" >' . $child_page->post_title . '</a></div>';                        
                }//END foreach ($child_pages as $child_page)
                echo '</div>';
            }
        ?>
        </div> <!-- .entry-content -->

<?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer">
            <div class="d-flex justify-content-center">
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
            </div>
        </footer> <!-- .entry-footer --> 
<?php   endif;
    endif;
?>

</article><!-- #post-<?php the_ID(); ?> -->
