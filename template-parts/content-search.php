<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <?php 
   
    echo ''
        . '<div class="spi-card-hover">'
            . '<img src="' . get_the_post_thumbnail_url() . '" alt="...">'
            . '<div class="card-body">'
                . '<h5 class="card-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark" class="text-decoration-none text-success">'
                    . get_the_title()
                . '</a></h5>';
                    if ( 'post' === get_post_type() ){
                        echo '<p class="card-text"><small class="text-muted">' . (_s_posted_on()) . (_s_posted_by()) . '</small></p>' ;
                    }                
            echo    '<p class="card-text">' . get_the_excerpt() . '</p>'
                . '<p class="card-text"><small class="text-muted">' . (_s_entry_footer()) . '</small></p>'
            . '</div>'
        . '</div>' ;     
     
    ?>    
    
</article><!-- #post-<?php the_ID(); ?> -->
