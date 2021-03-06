<?php
/**
 * The file pulls data from custom posts Home Slider and Publications
 * and displays that data as a slider on the home page.
 * It also pulls in data from direct children of our work page.
 *
 * @package _s
 */

get_header();
?>

	<main id="primary" class="spi-main-page">
            
        <?php
        
        
        $horizontal_container = $dot_container = $controls = $image_overlay = $background_image = '';

        // Pulling data from custom posts
        $query_allposts = new WP_Query (
                            array(
                                'post_type'         => 'slider',
                                'post_name__in'     => array( 'home-page-slider','publications-slider', 'background' ) ,
                                'posts_per_page'    => -1
                            )
                        );

        while ( $query_allposts->have_posts() ) {
            $query_allposts->the_post();
            
            switch ( $post->post_title ) {
                case "Home Page Slider":
                    {
                        $slider_vertical_container = $slider_horizontal_container = $slider_dotl_container = 
                        $vertical_controls = $image_overlay_big_screen = $image_overlay_small = '';                            
                        
                        $args = array( 
                            'post_type'         => 'attachment', 
                            'post_status'       => 'inherit', 
                            'post_mime_type'    => 'image', 
                            'posts_per_page'    => -1, 
                            'order'             => 'DESC', 
                            'post_parent'       => $post->ID 
                        );
                        $query_image_hps = new WP_Query( $args );
                        
                        while ( $query_image_hps->have_posts() ) {
                            $query_image_hps->the_post();
                            

                            $slider_dotl_container .= '<span class="dot ' 
                                                    . ( ( intval( $query_image_hps->current_post ) == 0 ) ? 'hmecrslatve' : '' ) 
                                                    . '"></span>';

                            if ( intval ( $query_image_hps->current_post ) < 3 ) {
                                $css_class_identifier = intval ( $query_image_hps->current_post ) + 1; 
                                $slider_vertical_container      .= "<div class='animatebox animatebox-$css_class_identifier'>";
                                $slider_horizontal_container    .= "<div class='slideshow-item active-$css_class_identifier'>";
                            }
                            elseif ( ( intval( $query_image_hps->current_post ) ) >= ( intval ( $query_image_hps->post_count )  - 2) ) {
                                $css_class_identifier = 6 - 
                                    ( intval ( $query_image_hps->post_count ) - intval ( $query_image_hps->current_post ) );
                                $slider_vertical_container .= "<div class='animatebox animatebox-$css_class_identifier'>";
                                $slider_horizontal_container .= "<div class='slideshow-item active-$css_class_identifier'>";
                            }
                            else {
                                $slider_vertical_container .= '<div class="animatebox animate-other">';
                                $slider_horizontal_container .= '<div class="slideshow-item active-other">';
                            }

                            $slider_vertical_container .= "<span style='align-self: center; padding: 1vw;'>
                                                                $post->post_title
                                                            </span>
                                                        </div>";

                                
                            $slider_horizontal_container .=  ( empty ( $post->post_content ) ? '' : 
                                            '<a href="' . $post->post_content . '"  target="_blank" >')
                                . '<picture>'    
                                    . '<source srcset="' . wp_get_attachment_url( $post->ID ) . '" media="(min-width: 1400px)">'
                                    . '<source srcset="' . wp_get_attachment_url( $post->ID ) . '" media="(min-width: 769px)">'
                                    . '<source srcset="' . wp_get_attachment_url( $post->ID ) . '" media="(min-width: 577px)">'
                                    . '<img srcset="' . wp_get_attachment_url( $post->ID ) . '" alt="responsive image" class="d-block img-fluid" loading="lazy">'
                                . '</picture>'
                            . ( empty( $post->post_content ) ? '' : '</a>' )
                            . '</div>';

                        }
                        

                        $vertical_controls = '<i class="bi bi-chevron-compact-up icon-top"></i>
                            <i class="bi bi-chevron-compact-left icon-left"></i>
                            <i class="bi bi-chevron-compact-down icon-bottom"></i>
                            <i class="bi bi-chevron-compact-right icon-right"></i>'; 

                        $image_overlay_big_screen =  '<h1 class="home-card-header">Em<span style="color:#ffe500">POWERING</span> Rural
                                    <div class="home-imgovrly-txtcntnr">
                                        <span class="home-imgovrl-pill"></span>Communities
                                    </div> 
                                    & Transforming Lives
                                </h1>
                                <p class="home-card-text">Through access to reliable and quality electricity</p>';

                        $image_overlay_small .= '<h1 class="home-card-header"><strong>EmPOWERING Rural</strong><br/>
                                    <strong>Communities</strong><br/>
                                    <strong>& Transforming Lives</strong>
                                </h1>
                                <p class="home-card-text">Through access to reliable and quality electricity</p>';                        

                        echo "<div class='spi-slider-container'>
                                <div class='spi-slideshow-wrapper'>
                                    $slider_horizontal_container
                                </div>
                                <div class='spi-dot-container'>
                                    $slider_dotl_container
                                </div>
                                <div class='home-img-overlay spi-d-none spi-d-md-block'>
                                    $image_overlay_big_screen
                                </div>
                                <div class='home-img-overlay spi-d-md-none'>
                                    $image_overlay_small
                                </div>
                                <div class='spi-vertical-container'>
                                    $slider_vertical_container
                                    $vertical_controls
                                </div>                                                         
                            </div>"; 
                    };
                    
                    break;

                case "PUBLICATIONS":
                    {

                        $img_arr = array();
                        $att_arr = array();

                        $args = array( 
                            'post_type'         => 'attachment', 
                            'post_status'       => 'inherit',                                       
                            'posts_per_page'    => 16,
                            'order'             => 'DESC', 
                            'post_parent'       => $post->ID 
                        );
                        $query_image_p =  new WP_Query( $args );
                        
                        while ( $query_image_p->have_posts() ) {
                            $query_image_p->the_post();
                            
                            $mime_ck = explode( "/", $post->post_mime_type );
                            if ( $mime_ck[ 0 ] == 'application' ) {
                                $att_arr[ $post->post_title ] = $post;
                            }
                            else {
                                $img_arr[ $post->post_title ] = $post;
                            }
                        }
                        $count = 0;
                        $arr_length = count( $img_arr );
                        foreach ( $img_arr as $key=>$dsp_obj ) {

                            $dot_container .= '<span class="dot ' . ( ( $count == 0 ) ? 'hmecrslatve' : '' ) . '"></span>';

                                if( ( $count ) < 3 ) {
                                    $horizontal_container .= '<div class="slideshow-item-small active-' . ( $count + 1 ).'">';
                                }
                                elseif ( $count >= ( $arr_length  - 2 ) ) {
                                    $horizontal_container .= '<div class="slideshow-item-small active-' 
                                        . ( 6 - ( $arr_length - $count ) ) . '">';
                                }
                                else {
                                    $horizontal_container .= '<div class="slideshow-item-small active-other">';
                                }

                            $horizontal_container .= "<a href='" . ( $att_arr[$key]->guid ) . "' download>
                                        <picture>
                                            <source srcset='$dsp_obj->guid' media='(min-width: 1400px)'>
                                            <source srcset='$dsp_obj->guid' media='(min-width: 769px)'>
                                            <source srcset='$dsp_obj->guid' media='(min-width: 577px)'>
                                            <img srcset='$dsp_obj->guid' style='width:100%; height:auto; object-fit: contain;' loading='lazy'>
                                        </picture>
                                    </a>
                                </div>";

                            $count++;
                        }
                        $count = 0;
                        $controls .= '<i class="bi bi-chevron-compact-left icon-left"></i>
                                <i class="bi bi-chevron-compact-right icon-right"></i>';                                                             
                        
                    };

                    break;
                case "Background":
                    {

                        $args = array( 
                            'post_type'         => 'attachment', 
                            'post_status'       => 'inherit',                                       
                            'posts_per_page'    => -1,
                            'order'             => 'ASC', 
                            'post_parent'       => $post->ID 
                        );
                        $query_image_p =  new WP_Query( $args );
                        
                        while ( $query_image_p->have_posts() ) {
                            $query_image_p->the_post();
                            
                            
                            if ( $post->post_title == "Knowledge" ) {

                                $background_image .= "<picture class='spi-d-none spi-d-md-block'>
                                        <source srcset='$post->guid' media='(min-width: 1400px)'>
                                        <source srcset='$post->guid' media='(min-width: 769px)'>
                                        <source srcset='$post->guid' media='(min-width: 577px)'>
                                        <img srcset='$post->guid' alt='responsive image' class='card-img img-fluid' loading='lazy'>
                                    </picture>" ;

                                $image_overlay .= "<h2 class='home-card-header mb-2'><strong>$post->post_title</strong></h2>
                                        <p class='home-card-text mb-3'>$post->post_excerpt</p>
                                        <div class='spi-pill-container'>
                                            <div class='pill-button'>
                                                <a href='" . get_permalink( get_page_by_path( 'knowledge' ) ) . "' >
                                                    Learn More
                                                </a>
                                            </div>
                                        </div>";                                        
                            
                                
                            }

                        }
                        
                    }
                    break;
                                            
            }
        }

        wp_reset_postdata();
        
        // pulls child pages of 'our work' and displays the featured image attached to each of them
        $workpage = get_page_by_path('our-work');
        $args_w = array(
            'post_parent'   => $workpage->ID,
            'child_of'      => $workpage->ID,
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
        $query_child = new WP_Query( $args_w );
        while ( $query_child->have_posts() ) {
            $query_child->the_post();
            get_template_part( 'template-parts/content', 'sumup' );
        }
        wp_reset_postdata();      
        
        //Displays the knowledge block of home page.
        echo "<div class='home-knowledge-container'>
                $background_image
            <div class='spi-slider-container-small'>
                <div class='spi-slideshow-wrapper-small'>
                    $horizontal_container
                </div>
                <div class='spi-dot-container-small'>
                    $dot_container
                </div>
                <div class='spi-vertical-container-small'>
                    $controls
                </div>
            </div>
            <div class='home-img-overlay-small-left'>
                $image_overlay
            </div>
        </div>";
    
        wp_reset_postdata();
            
    ?>

                                                                       
	</main><!-- #main -->

<?php
get_footer();
