<?php
/**
 * Template part for displaying thumbnail of a post and content associated with the thumbnail
 *
 * @package _s
 */
 
    
if ( has_post_thumbnail() ) :
    $title          = get_the_title(); 
    $thumbnailcap   = get_the_post_thumbnail_caption(); 
    $page_link      = get_permalink($post->ID);
    $thumnail_url   = get_the_post_thumbnail_url();
    
    // Get secondary thumbnail that replaces the primary thumbnail in small screens 
    if ( class_exists( 'MultiPostThumbnails' ) ) {

        $thumbnailmob =  MultiPostThumbnails::get_post_thumbnail_url( get_post_type(), 'secondary-image', get_the_ID() );
    }
?>         
    <div class="home-knowledge-container">
        <picture>
            <source srcset="<?php echo $thumnail_url ?>" media="(min-width: 1400px)">
            <source srcset="<?php echo $thumnail_url ?>" media="(min-width: 769px)">
            <source srcset="<?php echo $thumbnailmob ?>" media="(max-width: 768px)">
            <source srcset="<?php echo $thumbnailmob ?>" media="(max-width: 577px)">
            <img srcset='<?php echo $thumnail_url ?>' alt="responsive image" class="card-img img-fluid" loading="lazy">
        </picture>                                
        <div class="<?php echo ( in_array( $post->post_name, 
                array(
                    'mini-grid-model',
                    'energy-service-franchise-model',
                    'rural-electricity-access',
                    'internships-and-fellowship', 
                    'model-distribution-zone-mdz-program',
                    'enhanced-rural-revenue-franchise-e-rrf-program',
                    'innovation'
                ) ) 
                ? 'home-img-overlay-small-right' : 'home-img-overlay-small-left'
            ); ?>">
            <h2 class='home-card-header'>
                <strong><?php echo $post->post_title ?></strong>
            </h2>
            <p class="<?php echo ( in_array( 
                                    $post->post_name, 
                                    array( 
                                            'internships-and-fellowship',
                                            'current-vacancy'
                                        ) 
                                ) ? 
                                'spi-card-text' : 'home-card-text' ); 
                    ?> ">
                <?php echo get_the_post_thumbnail_caption(); ?>
            </p>
            <div class="spi-pill-container">
                <div class="pill-button">
                    <a href="<?php echo $page_link ?>">Learn More</a>
                </div>
            </div>
        </div>
    </div>
        
<?php endif; ?>

