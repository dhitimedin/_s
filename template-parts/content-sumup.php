<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */
 
    
    if(has_post_thumbnail()){
        $title = get_the_title(); $thumbnailcap = get_the_post_thumbnail_caption(); $post_banner = '';
        $page_link = get_permalink($post->ID);
        $thumnail_url = get_the_post_thumbnail_url();        
        if(class_exists('MultiPostThumbnails')) {
            $thumbnailmob =  MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'secondary-image',get_the_ID());

        }         
        $post_banner = $post_banner
                . '<div class="home-knowledge-container">'
                    . '<picture>'
                        . '<source srcset="' . $thumnail_url . '" media="(min-width: 1400px)">'
                        . '<source srcset="' . $thumnail_url . '" media="(min-width: 769px)">'
                        . '<source srcset="' . $thumbnailmob . '" media="(max-width: 768px)">'
                        . '<source srcset="' . $thumbnailmob . '" media="(max-width: 577px)">'
                        . '<img srcset="' . $thumnail_url . '" alt="responsive image" class="card-img img-fluid" loading="lazy">'
                    . '</picture>'                                
                    . '<div class="' . ((in_array($post->post_name, 
                            ["mini-grid-model", "energy-service-franchise-model", "rural-electricity-access", "internships-and-fellowship", 
                                "model-distribution-zone-mdz-program", "enhanced-rural-revenue-franchise-e-rrf-program", "innovation"])) 
                            ? 'home-img-overlay-small-right': 'home-img-overlay-small-left') . '">'
                        . '<h2 class="home-card-header"><strong>' . $post->post_title . '</strong></h2>'
                        . '<p class="' . ((in_array($post->post_name, ["internships-and-fellowship", "current-vacancy"])) ? 'spi-card-text': 'home-card-text')  . '">'
                            . get_the_post_thumbnail_caption() 
                        . '</p>'
                        . '<div class="d-md-inline d-flex justify-content-center m-0 p-0"><div class="pill-button"><a href="' . $page_link . '" >Learn More</a></div></div>'
                    . '</div>'
                . '</div>';
        
        echo $post_banner;
        
    }
    
?>
