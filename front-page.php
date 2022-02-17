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

	<main id="primary" class="spi-main-page">
            
            <?php
            
                $hrtCntnerS = $dtCntnerS = $controlS = $imgOvrlS = $imgBck = '';
            
                $query_allposts = new WP_Query(array('post_type' => 'slider', 'post_name__in' => array('home-page-slider','publications-slider', 'background') , 'posts_per_page' => -1));
                while ( $query_allposts->have_posts() ) {
                    $query_allposts->the_post();
                    
                    switch ($post->post_title){
                        case "Home Page Slider":
                            {
                                $vrtCntner = $hrtCntner = $dtCntner = $vrtControls = 
                                    $imgOvrlLG = $imgOvrlSM = '';                            
                                
                                $args = array( 
                                    'post_type' => 'attachment', 
                                    'post_status' => 'inherit', 
                                    'post_mime_type' => 'image', 
                                    'posts_per_page' => -1, 
                                    'order'   => 'DESC', 
                                    'post_parent' => $post->ID 
                                );
                                $query_image_hps = new WP_Query($args);
                                //echo '<h1>' . $query_image_hps->post_count . '</h1>';
                                while ( $query_image_hps->have_posts() ) {
                                    $query_image_hps->the_post();
                                    

                                    $dtCntner = $dtCntner . '<span class="dot ' . (((int)($query_image_hps->current_post) == 0) ? 'hmecrslatve':'') . '"></span>';

                                    if( ((int)($query_image_hps->current_post)) < 3){ 
                                        $vrtCntner = $vrtCntner . '<div class="animatebox animatebox-' . ((int)($query_image_hps->current_post) + 1).'">';
                                        $hrtCntner = $hrtCntner . '<div class="slideshow-item active-' . ((int)($query_image_hps->current_post) + 1).'">';
                                    }
                                    elseif ( ((int)($query_image_hps->current_post)) >= ( ((int)($query_image_hps->post_count)) - 2)) {
                                        $vrtCntner = $vrtCntner . '<div class="animatebox animatebox-' . (6 - (((int)($query_image_hps->post_count)) - ((int)($query_image_hps->current_post)) )) . '">';
                                        $hrtCntner = $hrtCntner . '<div class="slideshow-item active-' . (6 - (((int)($query_image_hps->post_count)) -  ((int)($query_image_hps->current_post)) )) . '">';
                                    }
                                    else {
                                        $vrtCntner = $vrtCntner . '<div class="animatebox animate-other">';
                                        $hrtCntner = $hrtCntner . '<div class="slideshow-item active-other">';
                                    }    
                                        $vrtCntner = $vrtCntner . '<span style="align-self: center; padding: 1vw;">' . $post->post_title . '</span>'
                                                . '</div>';

                                        
                                    $hrtCntner =  (empty($post->post_content)? $hrtCntner: $hrtCntner . '<a href="' . $post->post_content . '"  target="_blank" >')
                                        . '<picture>'    
                                            . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                                            . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                                            . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                                            . '<img srcset="' . wp_get_attachment_url($post->ID) . '" alt="responsive image" class="d-block img-fluid" loading="lazy">'
                                        . '</picture>'
                                        . (empty($post->post_content) ? '':'</a>')
                                    . '</div>';

                                }
                                

                                $vrtControls = '<i class="bi bi-chevron-compact-up icon-top"></i>'
                                    . '<i class="bi bi-chevron-compact-left icon-left"></i>'
                                    . '<i class="bi bi-chevron-compact-down icon-bottom"></i>'
                                    . '<i class="bi bi-chevron-compact-right icon-right"></i>' ; 

                                $imgOvrlLG =  '<h1 class="home-card-header">Em<span style="color:#ffe500">POWERING</span> Rural'
                                        . '<div class="home-imgovrly-txtcntnr"><span class="home-imgovrl-pill"></span>Communities</div>' 
                                        . '& Transforming Lives</h1>'
                                    . '<p class="home-card-text">Through access to reliable and quality electricity</p>';

                                $imgOvrlSM = ''
                                        . '<h1 class="home-card-header"><strong>EmPOWERING Rural</strong><br/>'
                                        . '<strong>Communities</strong><br/>'
                                        . '<strong>& Transforming Lives</strong></h1>'
                                    . '<p class="home-card-text">Through access to reliable and quality electricity</p>';                        

                                echo ''
                                    . ' <div class="spi-slider-container">'
                                        . '<div class="spi-vertical-container">'
                                            . $vrtCntner
                                            . $vrtControls
                                        . '</div>'
                                        . '<div class="spi-slideshow-wrapper">'
                                            . $hrtCntner
                                        . '</div>'
                                        . '<div class="spi-dot-container">'
                                            . $dtCntner
                                        . '</div>'
                                        . '<div class="home-img-overlay d-none d-md-block">'
                                            . $imgOvrlLG
                                        . '</div>'
                                        . '<div class="home-img-overlay d-md-none">'
                                            . $imgOvrlSM
                                        . '</div>'
                                    . '</div>'; 

                                //}
                            };
                            break;
                        case "PUBLICATIONS":
                            {

                                $img_arr = array();
                                $att_arr = array();

                                $args = array( 
                                    'post_type' => 'attachment', 
                                    'post_status' => 'inherit',                                       
                                    'posts_per_page' => 16,
                                    'order'   => 'DESC', 
                                    'post_parent' => $post->ID 
                                );
                                $query_image_p =  new WP_Query($args);
                                
                                while($query_image_p->have_posts()){
                                    $query_image_p->the_post();
                                    
                                    $mime_ck = explode("/",$post->post_mime_type);
                                    if($mime_ck[0] == 'application')
                                    {
                                       $att_arr[$post->post_title] = $post;
                                    }
                                    else
                                    {
                                       $img_arr[$post->post_title] = $post;
                                    }
                                }
                                $count = 0;
                                $arr_length = count( $img_arr );
                                foreach( $img_arr as $key=>$dsp_obj ) {

                                    $dtCntnerS = $dtCntnerS . '<span class="dot ' . ( ( $count == 0 ) ? 'hmecrslatve':'') . '"></span>';

                                     if( ( $count ) < 3){
                                         $hrtCntnerS = $hrtCntnerS . '<div class="slideshow-item-small active-' . ( $count + 1 ).'">';
                                     }
                                     elseif ( $count >= ( $arr_length  - 2 ) ) {
                                         $hrtCntnerS = $hrtCntnerS . '<div class="slideshow-item-small active-' . ( 6 - ( $arr_length - $count ) ) . '">';
                                     }
                                     else {
                                         $hrtCntnerS = $hrtCntnerS . '<div class="slideshow-item-small active-other">';
                                     }

                                    $hrtCntnerS = $hrtCntnerS
                                         . '<a href="' . ($att_arr[$key]->guid) . '" download>'
                                            . '<picture>'
                                                 . '<source srcset="' . $dsp_obj->guid . '" media="(min-width: 1400px)">'
                                                 . '<source srcset="' . $dsp_obj->guid . '" media="(min-width: 769px)">'
                                                 . '<source srcset="' . $dsp_obj->guid . '" media="(min-width: 577px)">'
                                                 . '<img srcset="' . $dsp_obj->guid . '" loading="lazy">'
                                             . '</picture>'
                                         . '</a>'
                                   . '</div>';

                                   $count++;
                                }
                                $count = 0;
                                $controlS = $controlS . '<i class="bi bi-chevron-compact-left icon-left"></i>'
                                       .'<i class="bi bi-chevron-compact-right icon-right"></i>';                                                             
                                
                            };

                            break;
                        case "Background":
                            {

                                $args = array( 
                                    'post_type' => 'attachment', 
                                    'post_status' => 'inherit',                                       
                                    'posts_per_page' => -1,
                                    'order'   => 'ASC', 
                                    'post_parent' => $post->ID 
                                );
                                $query_image_p =  new WP_Query($args);
                                
                                while($query_image_p->have_posts()){
                                    $query_image_p->the_post();
                                    
                                    
                                    if($post->post_title == "Knowledge"){
                                        $imgBck = $imgBck
                                            . '<picture class="d-none d-md-block">'
                                                . '<source srcset="' . $post->guid . '" media="(min-width: 1400px)">'
                                                . '<source srcset="' . $post->guid . '" media="(min-width: 769px)">'
                                                . '<source srcset="' . $post->guid . '" media="(min-width: 577px)">'
                                                . '<img srcset="' . $post->guid . '" alt="responsive image" class="card-img img-fluid" loading="lazy">'
                                            . '</picture>' ;                                             
                                        $imgOvrlS = $imgOvrlS
                                                . '<h2 class="home-card-header mb-2"><strong>' . $post->post_title . '</strong></h2>'
                                                . '<p class="home-card-text mb-3">' . $post->post_excerpt . '</p>'
                                                . '<div class="d-md-inline d-flex justify-content-center m-0 p-0"><div class="pill-button"><a href="' . get_permalink( get_page_by_path( 'knowledge' ) ) . '" >Learn More</a></div></div>';                                        
                                    
                                        
                                    }
                                }
                                
                            }
                            break;
                                                    
                    }
                }
  
                wp_reset_postdata();
                
                $workpage = get_page_by_path('our-work');
                $args_w = array(
                    'post_parent' => $workpage->ID,
                    'child_of' => $workpage->ID,
                    'post_type' => 'page',
                    'orderby' => 'post_name__in',
                    'post_name__in' => array('rural-electricity-access', 'micro-enterprise-development', 'innovation', 'internships-and-fellowship', 'current-vacancy'),
                    'depth' => 1,
                );
                $query_child = new WP_Query($args_w);
                while($query_child->have_posts()){
                    $query_child->the_post();
                    get_template_part( 'template-parts/content', 'sumup' );
                }
                 wp_reset_postdata();       
                
            echo ''
                . '<div class="home-knowledge-container">'
                    . $imgBck
                    . '<div class="spi-slider-container-small">'
                        . '<div class="spi-slideshow-wrapper-small">'
                            . $hrtCntnerS
                        . '</div>'
                        . '<div class="spi-dot-container-small">'
                            . $dtCntnerS
                        . '</div>'
                        . '<div class="spi-vertical-container-small">'
                            . $controlS
                        . '</div>'
                    . '</div>'
                    . '<div class="home-img-overlay-small-left">'
                        . $imgOvrlS
                    . '</div>'
                . '</div>';
            
                wp_reset_postdata();
                
		?>

                                                                       
	</main><!-- #main -->

<?php
get_footer();