<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

get_header();
?>

<main id="primary" class="site-main container-fluid m-0 p-0">

    <?php
        $query_allposts = new WP_Query(array('post_type' => 'slider', 'post_name__in' => array('media-page-slider') , 'posts_per_page' => -1));
        
        while($query_allposts->have_posts()){
            $query_allposts->the_post();

            $args = array( 
                'post_type' => 'attachment', 
                'post_status' => 'inherit', 
                'post_mime_type' => 'image', 
                'posts_per_page' => -1, 
                'order'   => 'ASC', 
                'post_parent' => $post->ID 
            );
            
            $query_slds = new WP_Query( $args );
            $hrtCntner = $dtCntner = $capBlock= '';
            
            while($query_slds->have_posts()){
                $query_slds->the_post();

                if( ((int)($query_slds->current_post)) < 3){ 
                    $hrtCntner = $hrtCntner . '<div class="slideshow-item active-' . (((int)($query_slds->current_post)) + 1).'">';
                }
                elseif ( ((int)($query_slds->current_post)) >= ( ((int)($query_slds->post_count)) - 2)) {
                    $hrtCntner = $hrtCntner . '<div class="slideshow-item active-' . (6 - ( ((int)($query_slds->post_count)) - ((int)($query_slds->current_post)) )) . '">';
                }
                else {
                    $hrtCntner = $hrtCntner . '<div class="slideshow-item active-other">';
                }
                $hrtCntner = $hrtCntner
                       . '<picture>'
                            . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                            . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                            . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                            . '<img srcset="' . wp_get_attachment_url($post->ID) . '" alt="responsive image" class="d-block img-fluid" loading="lazy" style="width: 100% !important" />'
                        . '</picture>'                     
                . '</div>';

               $capBlock = $capBlock . (( ((int)($query_slds->current_post)) == 0) ? '<div class="caption-item caption-active">': '<div class="caption-item">');

               $capBlock = $capBlock . ((empty($post->post_content)) ? 
                   '<div class="spi-accordion-media">' . $post->post_excerpt . '</div><div class="spi-panel-media"> </div>':
                   '<div class="spi-accordion-media">' . $post->post_excerpt . '<span class="caption-dot">...</span></div>' 
                   . '<div class="spi-panel-media">' . $post->post_content .  '</div>');
               $capBlock = $capBlock . '</div>';

               $dtCntner = $dtCntner . '<span class="dot ' . (( ((int)($query_slds->current_post)) == 0) ? 'hmecrslatve':'') . '"></span>';
               
                
            }
            
        }
        
        echo ''
            . '<div class="spi-slider-container-caption">'
                . '<div class="spi-slideshow-wrapper">'
                    . $hrtCntner
                . '</div>'
                . '<div class="spi-caption-block">'
                    . $capBlock
                . '</div>'
                . '<div class="spi-dot-container">'
                    . $dtCntner
                . '</div>'
            . '</div>';
          
        wp_reset_postdata();



        // <!-- Section for Media Coverage and Videos Carouse Begins -->           

        $header_video =  '<section id="video-coverage" class="spi-card-header"><p id="video">Video</p></section>';

        // The Query for Video Section
        $query1 = new WP_Query( array( 'category_name' => 'video' ) );
        $last_count = floor(($query1->post_count)/3);
        
        $crslIndctrs = $crslCntrls = $crslInner = '';
        
        
        $crslCntrls = $crslCntrls
            . '<section class="icons-card">'
                . '<i class="bi bi-chevron-left icon-left-coverflow-card"></i>'
                . '<i class="bi bi-chevron-right icon-right-coverflow-card"></i>'
            . '</section>';              

        //Initialising the flags
        $count = 0; 

        // The Loop
        while ( $query1->have_posts() ) {
            $query1->the_post();
            
            $content = get_the_content();
            //echo htmlentities(var_dump($content));
            $blocks = parse_blocks( $content );
                        
            $crslInner = $crslInner
                . '<article class="coverflow-item-card coverflow-helper-card-' . (($count < 5) ? ($count + 1) : "other") . '" >'
                    . '<div class="spi-media-thumbnail">';
                        foreach ( $blocks as $block ) {
                           $output = simplexml_load_string( $block['innerHTML'] );
                        
                            // $crslInner = $crslInner . $block['innerHTML']; 
                            $crslInner = $crslInner 
                                . '<iframe src="' . $output->attributes()->{'src'} . '" class="spi-responsive-iframe-media" frameborder="0" allowfullscreen="true" loading="lazy"></iframe>';

                        }                         
                $crslInner = $crslInner         
                    . '</div>'
                    . '<div class="spi-card-content">'
                    . '</div>'
                    . '<footer class="spi-footer-card">'
                        . '<div class="post-meta">'
                            . '<h6><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none">' . get_the_title() . '</a></h6>'
                        . '</div>'
                    . '</footer>'
                . '</article>';

                ++$count;
        }
        
        echo ''
            . '<div class="spi-coverflow-container-card">'
                . $header_video
                . '<section class="spi-coverflow-wrapper-cards" data-autoplay="false">'
                    . $crslInner
                . '</section>'
                . $crslCntrls                
            . '</div>';

                
                                    

        /* Restore original Post Data 
         * NB: Because we are using new WP_Query we aren't stomping on the 
         * original $wp_query and it does not need to be reset with 
         * wp_reset_query(). We just need to set the post data back up with
         * wp_reset_postdata().
         */
        
        $last_count = 0;
        wp_reset_postdata();

        //<!--    /* Query for Media Coverage */  -->

        //<!-- Header for Media Coverage -->
        $header_media =  '<section id="media-coverage" class="spi-card-header"><p id="media">Media Coverage</p></section>';

   
        $query2 = new WP_Query( array( 'category_name' => 'news-events' ) );
        $last_count = floor(($query2->post_count)/3);
        
        $crslIndctrsM = $crslCntrlsM = $crslInnerM = '';
        

        $crslCntrlsM = $crslCntrlsM
            . '<section class="icons-card">'
                . '<i class="bi bi-chevron-left icon-left-coverflow-card"></i>'
                . '<i class="bi bi-chevron-right icon-right-coverflow-card"></i>'
            . '</section>'; 
        
        
        //Initialising the flags
        $count =0;

        // The Loop
        while ( $query2->have_posts() ) {
            $query2->the_post();
            $label_title = $label = '';
            if (has_post_thumbnail()){
                $thumb_id = get_post_thumbnail_id();
                $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                $label = $thumb_url_array[0];
                $label_title = get_post($thumb_id)->post_title;
            }
            elseif (function_exists('the_custom_logo')) {
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id);
                $label = $logo[0];
            }
            
            $crslInnerM = $crslInnerM
                . '<article class="coverflow-item-card coverflow-helper-card-' . (($count < 5) ? ($count + 1) : "other") . '" >'
                    . '<div class="spi-media-thumbnail">'
                        . '<picture>'
                            . '<source srcset="' . $label . '" media="(min-width: 1400px)">'
                            . '<source srcset="' . $label . '" media="(min-width: 769px)">'
                            . '<source srcset="' . $label . '" media="(min-width: 577px)">'
                            . '<img srcset="' . $label . '" alt="..." class="spi-card-img-top" loading="lazy">'
                        . '</picture>'
                        . '<p class="spi-category">' . $label_title . '</p>'                   
                    . '</div>'
                    . '<div class="spi-card-content">'
                    . '</div>'
                    . '<footer class="spi-footer-card">'
                        . '<div class="post-meta">'
                            . '<h6><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="text-decoration-none">' . get_the_title() . '</a></h6>'
                        . '</div>'
                    . '</footer>'
                . '</article>';                    

            ++$count;                                 

        } // End of While loop for Video Content
        
        
        echo ''
            . '<div class="spi-coverflow-container-card">'
                . $header_media
                . '<section class="spi-coverflow-wrapper-cards" data-autoplay="false">'
                    . $crslInnerM
                . '</section>'
                . $crslCntrlsM                
            . '</div>';        


        $last_count = 0;
        wp_reset_postdata();


?>
                        
<!-- Section for Media Coverage and Video Carouse  Ends -->  

</main><!-- #main -->

<?php
get_footer();
