<?php
/**
 * Template part for displaying page content of child pages of our work section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */


//Variable declaration for partner slider
$carousel_inner_content = $carousel_container = $partner_title = '';
$slider_dotl_container = $carSliders = $carCntrls = $carTitle = $carContainer = $carousel_block = '';
$requesting_slug        = basename( get_permalink() );

//Other variable declarations
$sldrs_types            = null; 
$postTitle = $postTitlePartner = '';

$required_custome_posts = array(
    'mini-grid-model'                                   => array( 
                                                            'post_name__in'         => array( 'mini-grid-slider','mini-grid-partners' ),
                                                            'carousel_contyainer'   => '<div class="spi-coverflow-container-mini-grid my-5">',
                                                        ),
    'innovation'                                        => array( 
                                                            'post_name__in'         => array( 'innovative-solutions','innovation-partners' ),
                                                            'carousel_contyainer'   => '<div class="spi-coverflow-container-innovation my-5">',
                                                        ),
    'energy-service-franchise-model'                    => array(
                                                            'post_name__in'         => array( 'esf' ),
                                                            'carousel_contyainer'   => '<div class="spi-coverflow-container-esf my-5">',
                                                        ),  
    'enhanced-rural-revenue-franchise-e-rrf-program'    => array(
                                                            'post_name__in'         => array( 'e-rrf' ),
                                                            'carousel_contyainer'   => '<div class="spi-coverflow-container-esf my-5">',
                                                        ),    
    'micro-enterprise-development'                      => array(
                                                            'post_name__in'         => array( 'microenterprise', 'micro-enterprise-partners' ),
                                                            'carousel_contyainer'   => '<div class="spi-slider-container-menterprise my-5">',
                                                        ),    
);

$sldrs_types    = new WP_Query( 
    array(
        'post_type'         => 'slider',
        'post_name__in'     => $required_custome_posts[ $requesting_slug ] [ 'post_name__in'  ],
        'posts_per_page'    => -1
    )
);
$carContainer   .= $required_custome_posts[ $requesting_slug ] [ 'carousel_contyainer'  ];

/*
switch ( $requesting_slug ) {
    case 'mini-grid-model':
        $sldrs_types = new WP_Query( 
                            array(
                                'post_type' => 'slider',
                                'post_name__in' => array('mini-grid-slider','mini-grid-partners'),
                                'posts_per_page' => -1
                            )
                        );
        $carContainer .= '<div class="spi-coverflow-container-mini-grid my-5">';
        break;
    case 'innovation':
        $sldrs_types = new WP_Query(
                            array(
                                'post_type' => 'slider',
                                'post_name__in' => array('innovative-solutions','innovation-partners'),
                                'posts_per_page' => -1
                            )
                        );
        $carContainer .= '<div class="spi-coverflow-container-innovation my-5">';
        break;    
    case 'energy-service-franchise-model':
        $sldrs_types = new WP_Query(
                            array(
                                'post_type' => 'slider',
                                'post_name__in' => array('esf'),
                                'posts_per_page' => -1
                            )
                        );
        $carContainer .= '<div class="spi-coverflow-container-esf my-5">';
        break;
    case 'enhanced-rural-revenue-franchise-e-rrf-program':
        $sldrs_types = new WP_Query(
                            array(
                                'post_type' => 'slider',
                                'post_name__in' => array('e-rrf') , 
                                'posts_per_page' => -1
                            )
                        );
        $carContainer .= '<div class="spi-coverflow-container-esf my-5">';
        break;
    case 'micro-enterprise-development':
        $sldrs_types = new WP_Query(
                            array(
                                'post_type' => 'slider',
                                'post_name__in' => array('microenterprise', 'micro-enterprise-partners'),
                                'posts_per_page' => -1
                            )
                        );
        $carContainer .= '<div class="spi-slider-container-menterprise my-5">';
        break;
    
}*/

while($sldrs_types->have_posts()){
    $sldrs_types->the_post();
    
    if( ! strpos(strtoupper($post->post_title), "PARTNERS")){
        $carTitle = $carTitle . '<h2 class="spi-ourwork-header"> <strong>' . $post->post_title . '</strong></h2>';
        
            


            $args = array( 
                'post_type'         => 'attachment', 
                'post_status'       => 'inherit', 
                'post_mime_type'    => 'image',
                'order'             => 'ASC',
                'posts_per_page'    => -1,  
                'post_parent'       => $post->ID 
            );

            $sldrs_rsrcs    = new WP_Query( $args );
            $you_tube_arr   = get_post_custom_values( 'youtube', $post->ID );
            
            
            
            if ( $requesting_slug == 'micro-enterprise-development' ) {
                $slds       = ((int)($sldrs_rsrcs->post_count)) + count($you_tube_arr);
                $carCntrls .= '<i class="bi bi-arrow-right-circle-fill icon-right-coverflow"></i>
                            <i class="bi bi-arrow-left-circle-fill icon-left-coverflow"></i>';                          
            }
            else {
                $carCntrls .= '<i class="bi bi-chevron-compact-right icon-right-coverflow"></i>
                            <i class="bi bi-chevron-compact-left icon-left-coverflow"></i>';                          
            }
            
            $slider_horizontal_container = $controls = '';
            $count = 0;

            if ( $you_tube_arr ) {
                if($requesting_slug != 'micro-enterprise-development'){
                    forEach($you_tube_arr as $sldr_rsrcs){
                        $carSliders = $carSliders 
                            . '<div class="coverflow-item-flat coverflow-helper-minigrid-' . (($count < 5) ? ($count + 1): 'other') . '">'
                                . '<div class="video-container"><iframe src="' . $sldr_rsrcs . '" frameborder="0" allowfullscreen class="responsive-iframe" loading="lazy"></iframe></div>'                                    
                            .'</div>';
                        ++$count;
                    }                             
                }
                else
                {

                    forEach($you_tube_arr as $slds_rsrcs) {
                        $slider_dotl_container = $slider_dotl_container . '<span class="dot ' . (($count == 0) ? 'hmecrslatve':'') . '"></span>';
                        if($count < 3){ 
                            $carSliders = $carSliders . '<div class="slideshow-item-enterprise active-' . ($count + 1).'">';
                        }
                        elseif ($count >= ($slds - 2)) {
                            $carSliders = $carSliders . '<div class="slideshow-item-enterprise active-' . (6 - ($slds - $count)) . '">';
                        }
                        else {
                            $carSliders = $carSliders . '<div class="slideshow-item-enterprise active-other">';
                        }                               

                        $carSliders = $carSliders
                            .'<figure class="figure-enterprise">'
                                . '<iframe src="' . $slds_rsrcs . '" title="YouTube video player" class="figure-img-enterprise" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="true"  loading="lazy"></iframe>'
                            . '</figure>'                                        
                        . '</div>';
                        ++$count;                           
                    }                            
                    
                }
            
            }
            
            while($sldrs_rsrcs->have_posts()){
                $sldrs_rsrcs->the_post();
                
                
                if($requesting_slug != 'micro-enterprise-development'){
                    
                    $carSliders = $carSliders . '<div class="coverflow-item-flat coverflow-helper-minigrid-' . (($count < 5) ? ($count + 1): 'other') . '">'
                            .'<figure class="figure-enterprise">'
                                . '<picture>'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                                    . '<img srcset="' . wp_get_attachment_url($post->ID) . '" class="figure-img-enterprise img-fluid rounded" alt="responsive image" loading="lazy">'
                                . '</picture>'                                     
                                . '<figcaption class="figure-caption-enterprise text-white">' . $post->post_excerpt . '</figcaption>'
                            . '</figure>'                            
                        .'</div>';
                    ++$count;                             
                    
                }
                else{
                    
                    $slider_dotl_container = $slider_dotl_container . '<span class="dot ' . (($count == 0) ? 'hmecrslatve':'') . '"></span>';

                    if($count < 3){ 
                        $carSliders = $carSliders . '<div class="slideshow-item-enterprise active-' . ($count + 1).'">';
                    }
                    elseif ($count >= ($slds - 2)) {
                        $carSliders = $carSliders . '<div class="slideshow-item-enterprise active-' . (6 - ($slds - $count)) . '">';
                    }
                    else {
                        $carSliders = $carSliders . '<div class="slideshow-item-enterprise active-other">';
                    }                               

                    $carSliders = $carSliders
                            .'<figure class="figure-enterprise">'
                                . '<picture>'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                                    . '<img srcset="' . wp_get_attachment_url($post->ID) . '" class="figure-img-enterprise img-fluid rounded" alt="responsive image" loading="lazy">'
                                . '</picture>'                                     
                                . '<figcaption class="figure-caption-enterprise text-white text-center">' . $post->post_title . '</figcaption>'
                            . '</figure>'                                                               
                        . '</div>';
                    ++$count;                            
                    
                }
                
            }

            if ( $requesting_slug != 'micro-enterprise-development' ) {
            $carousel_block = $carousel_block
                . $carContainer  
                    . $carTitle
                    . '<div class="spi-coverflow-wrapper">'
                        . $carSliders
                    . '</div>'
                    . $carCntrls
                . '</div>';                     
            }
            else{

            $carousel_block = $carousel_block 
                . $carContainer
                    . $carTitle
                    . '<div class="line-break"></div>'
                    . '<div class="spi-slideshow-wrapper-menterprise">'
                        . $carSliders
                    . '</div>'
                    . '<div class="line-break"></div>'
                    . '<div class="spi-dot-container-menterprise d-flex justify-content-evenly">'
                        . $slider_dotl_container
                    . '</div>'
                    . '<div class="spi-vertical-container-small">'
                        . $carCntrls
                    . '</div>'
                . '</div>';  
            
            //echo $carousel_block;
                
            }


        
    }
    else
    {

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
        $partner_title          = '<h2 class="text-center text-uppercase text-success mt-5"> <strong>' . $post->post_title . '</strong></h2>' ; 
        $post_count             = $partner_slider_content->found_posts;
        $count                  = ( $partner_slider_content->found_posts <=3 ) ? 1 : 0;
        
        while ( $partner_slider_content->have_posts() ) {
            $partner_slider_content->the_post();
            
                $img_block = ''
                            .'<a class="spi-link-decoration" href="' . $post->post_title . '" target="_blank">'
                                . '<picture>'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                                    . '<img srcset="' . wp_get_attachment_url($post->ID) . '" class="d-block mx-auto" alt="responsive image" loading="lazy">'
                                . '</picture>'
                            . '</a>'; 
                

                    $carousel_inner_content = $carousel_inner_content
                            . '<div class="coverflow-item-partner coverflow-helper-partner-' . (($count < 5) ? ($count + 1) : "other") . '">'
                                . $img_block
                            . '</div>';

            ++$count;  
        }
        

        $carousel_container = $carousel_container
            . '<div class="spi-coverflow-container-partner">'
                . (($post_count <=3)?
                '<i class="bi bi-chevron-left icon-left-coverflow-partner-3"></i>' :
                '<i class="bi bi-chevron-left icon-left-coverflow-partner"></i>')
                . '<div class="spi-coverflow-wrapper-partner" ' . (($post_count <=3) ? 'data-autoplay="false"' : 'data-autoplay="true"') . '>'
                    . $carousel_inner_content
                . '</div>'
                . (($post_count <=3)? 
                    '<i class="bi bi-chevron-right icon-right-coverflow-partner-3"></i>' :
                    '<i class="bi bi-chevron-right icon-right-coverflow-partner"></i>')  
            . '</div>' ;                  

    }
}    

//Assembling the partner sliders
wp_reset_postdata(); 
$contact_block = '<p class="text-center my-5">
                    Please 
                    <strong>
                        <a href="' . home_url() . '/contact' . '" class="text-decoration-none text-dark">
                            Contact Us
                        </a>
                    </strong> to know more about our ' . get_the_title( get_the_ID() ) 
                . '</p>'; 
if( !empty( $partner_title ) ) {
    
    echo "{ $carousel_block } { $partner_title } { $carousel_container } { $contact_block }" ;     
}
else {
    echo "{ $carousel_block } { $contact_block }";
}
  
    

?>

