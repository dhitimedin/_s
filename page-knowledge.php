<?php
/**
 *
 * This page displays the content of Knowledge Page. 
 * It also displays the content of custom posts Publication, Resources, and Knowledge Partners
 *
 * @package _s
 */

get_header();
?>

	<main id="primary" class="site-main">

        <!-- Main Loop to display content of knowledge page -->
		<?php                              
                
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
                 
                
        <!-- Lopp to display custom posts publication, resources, knowledge partners  -->   
        
        <?php
        
        
        $carousel_block   = '';
        $carousel_inner_content = $partner_carousel_container = $partner_title = '';   
        $sldrs_types =  new WP_Query(
                        array(
                            'post_type'         => 'slider',
                            'post_name__in'     => array('resources-slider', 'publications-slider', 'knowledge-partners'),
                            'posts_per_page'    => -1
                        )
                    );
        
        while ( $sldrs_types->have_posts() ) {
            $sldrs_types->the_post();
            
            $img_arr = array();
            $att_arr = array();
            
            if( ! strpos( strtoupper( $post->post_title ), "PARTNERS" ) ) {
                $title = $post->post_title;
                $args = array( 
                    'post_type'         => 'attachment', 
                    'post_status'       => 'inherit',
                    'order'             => 'ASC',
                    'posts_per_page'    => -1,  
                    'post_parent'       => $post->ID 
                );
                
                $sldrs_rsrcs = new WP_Query( $args );
                
                while ( $sldrs_rsrcs->have_posts() ) {
                    $sldrs_rsrcs->the_post();

                    $mime_ck = explode( "/", $post->post_mime_type );
                    if ( $mime_ck[ 0 ] == 'application' ) {
                        $att_arr[ $post->post_title ] = $post;
                    }
                    else {
                        $img_arr[ $post->post_title ] = $post;
                    }                              

                }
                //wp_reset_postdata();
                $slider = '';
                if ( in_array( $title, array( "RESOURCES", "PUBLICATIONS" ) ) ) {
                    $count = 0; 
                    foreach ( $img_arr as $key=>$dsp_obj ) {
                        
                        if( $count < 5 ) {
                            $slider .= "<a class='coverflow-item coverflow-helper-" . ( $count + 1 ) . "' href='" . $att_arr[$key]->guid . "' data-index='" . ( $count + 1 ) . "' download>
                                    <figure class='figure'>
                                        <img src='$dsp_obj->guid' class='figure-img img-fluid rounded' alt='...' loading='lazy'>
                                        <figcaption class='figure-caption'>$dsp_obj->post_excerpt</figcaption>
                                    </figure>                           
                                </a>";
                        }
                        else {
                            $slider .= "<a class='coverflow-item coverflow-helper-other' href='" . $att_arr[$key]->guid . "' data-index='" . ( $count + 1 ) . "' download>
                                    <figure class='figure'>
                                        <img src='$dsp_obj->guid' style='object-fit: contain; width:100%; height:fit-content' alt='...' loading='lazy'>
                                        <figcaption class='figure-caption'>$dsp_obj->post_excerpt</figcaption>
                                    </figure>                            
                                </a>";                                    
                        }
                        ++$count;
                    }                        
                        
                    $carousel_block .= "<div class='spi-coverflow-container'>  
                            <h2 id='$title' style='text-align: center; width:100%; font-size:2rem;'>
                                <strong>$title</strong>
                            </h2>
                            <div class='spi-coverflow-wrapper'>$slider</div>
                            <i class='bi bi-chevron-compact-right icon-right-coverflow-knowledge'></i>
                            <i class='bi bi-chevron-compact-left icon-left-coverflow-knowledge'></i>
                        </div>"; 
                    
                }                        
                
            }
            else {

                $carousel_inner_content = $partner_carousel_container = $partner_title = $img_block = '';
                $args = array( 
                        'post_type'         => 'attachment', 
                        'post_status'       => 'inherit', 
                        'post_mime_type'    => 'image',
                        'order'             => 'ASC',
                        'posts_per_page'    => -1,  
                        'post_parent'       => $post->ID 
                );

                $partner_slider_content = new WP_Query( $args );

                //Partner Section Starts 

                $partner_title = "<h2 class='text-center text-uppercase text-success mt-5'>
                                    <strong>$post->post_title</strong>
                                </h2>" ;

                $post_count = $partner_slider_content->found_posts;
                $count = ( $partner_slider_content->found_posts <=3 ) ? 1 : 0;
                
                while ( $partner_slider_content->have_posts() ) {
                    $partner_slider_content->the_post();
                    
                    $img_block .= "<a class='spi-link-decoration' href='$post->post_title' target='_blank'>
                                    <picture>
                                        <source srcset='" . wp_get_attachment_url( $post->ID ) . "' media='(min-width: 1400px)'>
                                        <source srcset='" . wp_get_attachment_url( $post->ID ) . "' media='(min-width: 769px)'>
                                        <source srcset='" . wp_get_attachment_url( $post->ID ) . "' media='(min-width: 577px)'>
                                        <img srcset='" . wp_get_attachment_url( $post->ID ) . "' class='d-block mx-auto' alt='responsive image' loading='lazy'>
                                    </picture>
                                </a>"; 
                

                    $carousel_inner_content .= "<div class='coverflow-item-partner coverflow-helper-partner-" . (($count < 5) ? ($count + 1) : 'other') . "'>
                                $img_block
                            </div>";
                    ++$count;  
                }

                $partner_carousel_container .= "<div class='spi-coverflow-container-partner'>"
                        . ( ( $post_count <=3 ) ?
                            '<i class="bi bi-chevron-left icon-left-coverflow-partner-3"></i>' :
                            '<i class="bi bi-chevron-left icon-left-coverflow-partner"></i>' )
                        . "<div class='spi-coverflow-wrapper-partner' " . ( ( $post_count <=3 ) ? 'data-autoplay="false"' : 'data-autoplay="true"' ) . ">
                            $carousel_inner_content
                        </div>"
                        . ( ( $post_count <=3 ) ? 
                            '<i class="bi bi-chevron-right icon-right-coverflow-partner-3"></i>' :
                            '<i class="bi bi-chevron-right icon-right-coverflow-partner"></i>' )                    
                    . "</div>" ;                         
            }

            
        }
        
        wp_reset_postdata();   
        echo "{$carousel_block}{$partner_title}{$partner_carousel_container}                   
            <p class='text-center my-5'>Please<strong><a href='" . home_url() . '/contact' 
            . "' class='text-decoration-none text-dark'> Contact Us</a></strong> to know more about our " 
            .  get_the_title( get_the_ID() ) . "</p>";                
        
        ?>
        
        <!-- Partner Section Ends -->

            
	</main><!-- #main -->

<?php
get_footer();
