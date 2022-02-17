<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */



              // if(in_category( 'Media Coverage' )) {     // Code to filter out video posts                
                if($count == 3) {
                    $count = 0;
                }
            /* Code Introduced for displaying blog post as card */
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

                
               if( ($isactive == 0) && ($count == 0)) {  ?>   
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                <?php ++$isactive;}
                elseif (($isactive == 1) && ($count == 0)) {              ?>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                <?php  ++$isactive;}
                elseif(($isactive == 2) && ($count == 0)) {  ?> 
                    <div class="carousel-item">                
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">                                         
                <?php ++$isactive;}  
                 elseif (($isactive == 2) && (($count == 1) || ($count == 2))) { ?>
                                <div class="col-lg-4 mb-4 mb-lg-0 d-none d-lg-block">   
                 <?php }
                else {                                        ?>
                               <div class="col-lg-4 d-none d-lg-block">  
                <?php }                                       ?>
                                   
                        <div class="card h-100">
                            <?php
                                if( in_category( 'Video' ) ) {
                                    // Add within the loop
                                    $content = get_the_content();
                                    //echo htmlentities(var_dump($content));
                                    $blocks = parse_blocks( $content );

                                    foreach ( $blocks as $block ) {
                                        // YouTube's block name
                                       echo $block['innerHTML']; 
                                    } 
                                }
                                else {
                           ?>
                            <img src=<?php echo $label; ?> class="card-img-top" alt="..."/>
                                <?php } ?>
                            <div class="card-body">
                                <?php
                                    the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' );
                                ?>                                
                                <p class="card-text my-0"><?php the_excerpt(); //if(has_video())?></span></p>
                            </div>
                            <div class="card-footer mt-0">
                                <small class="text-muted"><?php _s_posted_on(); _s_posted_by(); ?></small>
                            </div>
                        </div>

            <?php if($count == 2) { ?>
                   </div>
                </div>
            </div>
        </div>                
        <?php
                  }
                  else { ?>
                    </div>
        <?php     }
                  ++$count; 
                  
            // } //End of If in_category block <!-- #post-<?php the_ID(); ?> -->
<!-- Carousel wrapper --> 