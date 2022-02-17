<?php
/**
 * The <?template for displaying all pages
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

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
		                
                        get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
                       // ++$itr;
		endwhile; // End of the loop.           
            
//<!-- Experimental Code Begins is here -->  
                
        $current_page_id = get_the_ID();

        $args_w = array(
            'post_parent' => $current_page_id,
            'child_of' => $current_page_id,
            'post_type' => 'page',
            'orderby' => 'menu_order',
            'depth' => 1,
        );
        $query_child = new WP_Query($args_w);
        while($query_child->have_posts()){
            $query_child->the_post();

            $page_id = $post->ID; // get the ID of the childpage
            $page_img = get_the_post_thumbnail($page_id); // returns the featured image <img> element
            $page_title = get_the_title(); // returns the title of the child page
            $thumbnail_title = get_post(get_post_thumbnail_id())->post_title;
            $thmbnail_description = get_post(get_post_thumbnail_id())->post_content;
            $mission_banner = ''; $thumnail_url = get_the_post_thumbnail_url();
            if(class_exists('MultiPostThumbnails')) {
                $thumbnailmob =  MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'secondary-image',$page_id);

            }                        

            $mission_banner = $mission_banner
                    
                .'<div class="spi-card-container">'
                    . '<picture>'
                        . '<source srcset="' . $thumnail_url . '" media="(min-width: 1400px)">'
                        . '<source srcset="' . $thumnail_url . '" media="(min-width: 769px)">'
                        . '<source srcset="' . $thumbnailmob . '" media="(max-width: 768px)">'                
                        . '<source srcset="' . $thumbnailmob . '" media="(min-width: 577px)">'
                        . '<img srcset="' . $thumnail_url . '" alt="responsive image" class="card-img img-fluid">'
                    . '</picture>'
                    . '<div class="spi-card-img-overlay-left">'
                        . '<h2 class="spi-card-title"><strong>' . $page_title . '</strong></h2>'
                        . '<p class="spi-card-text">' . get_the_post_thumbnail_caption() . '</p>'
                        . '<h2 class="spi-card-title"><strong>' . $thumbnail_title . '</strong></h2>'
                        . '<p class="spi-card-text">' . $thmbnail_description . '</p>'                    
                    . '</div>'
                . '</div>';                     
                                
        }
         wp_reset_postdata();                  
                        
                
            ?>
                
            <!-- Team Portfolio -->
            
            <?php
                //$query_board = new WP_Query (array('post_type' => 'team-portfolio', 'title' => 'Board Members', 'posts_per_page' => -1));
                $query_board = new WP_Query (array('post_type' => 'team-portfolio', 'posts_per_page' => -1));

                $section_title = '<h2 class="text-center text-primary mb-4"><strong> The Team </strong></h2>';
                
                while($query_board->have_posts()){
                    $query_board->the_post();
                    //Form the content title
                    switch($post->post_title){
                        case "Board Members":
                            {

                                $content_title_board =  '<div class="d-flex justify-content-center">'
                                        . '<div class="pill-button"><span>' . $post->post_title . '</span></div>'
                                    . '</div>';

                                $boardModal = $teamBlock = [];
                                $titleContainer = $teamContainer = $figBlock = '';                  

                                $args = array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image', 'posts_per_page' => -1,  'post_parent' => $post->ID );
                                $members = new WP_Query( $args );
                                while($members->have_posts()){
                                    $members->the_post();

                                    $ttlorg = explode(",", $post->post_excerpt ,2);
                                    $textSection = $textCaption = '';
                                    foreach($ttlorg as $ttl) {
                                        $textSection = $textSection . '<p class="text-center h6 d-block">' . $ttl . '</p>';
                                        $textCaption = $textCaption . '<figcaption class="text-center h6">' . $ttl . '</figcaption>';
                                    }
                                        $modal = ''
                                            . '<div class="modal fade text-primary" id="exampleModal' . ((int)($members->current_post) + 1) . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">'
                                                . '<div class="modal-dialog modal-lg modal-dialog-centered">'
                                                    . '<div class="modal-content">'
                                                        . '<div class="modal-body">'

                                                            . '<div class="container-fluid p-0 m-0">'
                                                                . '<div class="row position-relative">'
                                                                    . '<button type="button" class="btn-close position-absolute end-0" data-bs-dismiss="modal" aria-label="Close"></button>'
                                                                . '</div>'                                                         
                                                                . '<div class="row g-5 m-auto d-flex justify-content-center align-items-center">'

                                                                    . '<div class="col-md-4 p-0">'
                                                                        .'<figure>'
                                                                            . '<div class="d-flex justify-content-center">'
                                                                                . '<picture>'
                                                                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                                                                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                                                                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                                                                                    . '<img srcset="' . wp_get_attachment_url($post->ID) . '" alt="responsive image" class="img-fluid img-thumbnail rounded shadow border border-primary p-0 m-0">'
                                                                                . '</picture>'                                                       
                                                                            .'</div>'
                                                                            . '<figcaption>'
                                                                                . '<h4 class="text-center pt-3" id="teamModalLabel">' . $post->post_title . '</h4>'
                                                                                . $textSection
                                                                            .'</figcaption>'
                                                                        . '</figure>'                                                
                                                                    . '</div>'
                                                                    . '<div class="col-md-8">' . $post->post_content . '</div>'
                                                                . '</div>'    
                                                            . '</div>'
                                                        . '</div>' //<!-- Close Modal Body -->
                                                    . '</div>'
                                                . '</div>'
                                            . '</div>'; 

                                        array_push($boardModal, $modal);

                                        $figBlock = $figBlock
                                                . '<div class="col">'
                                                    . '<div class="text-center d-block text-decoration-none" data-bs-target="#exampleModal' . ((int)($members->current_post) + 1) . '" data-bs-toggle="modal" role="button">'
                                                        . '<figure class="figure text-primary">'
                                                            . '<img src="' . $post->guid . '" class="figure-img img-fluid rounded shadow" alt="..."/>'
                                                            . '<h4 class="text-center">' . $post->post_title . '</h4>'  
                                                            . $textCaption                                                
                                                    . '</div>'
                                                    . $modal
                                                . '</div>';

                                }
                            
                            };
                            break;
                        case "Team Members":
                            {

                                $content_title_team =  '<div class="d-flex justify-content-center">'
                                        . '<div class="pill-button"><span>' . $post->post_title . '</span></div>'
                                    . '</div>';

                                $teamModal = $teamBlock = [];
                                $titleContainer = $teamContainer = $figBlock_team = '';                  

                                $args = array( 
                                    'post_type' => 'attachment', 
                                    'post_status' => 'inherit', 
                                    'post_mime_type' => 'image',
                                    'order' => 'ASC',
                                    'posts_per_page' => -1,  
                                    'post_parent' => $post->ID 
                                );
                                $query_members = new WP_Query( $args );
                                while($query_members->have_posts()){
                                    $query_members->the_post();

                                    $ttlorg = explode(",", $post->post_excerpt ,2);
                                    $textSection = $textCaption = '';
                                    foreach($ttlorg as $ttl) {
                                        $textSection = $textSection . '<p class="text-center h6 d-block">' . $ttl . '</p>';
                                        $textCaption = $textCaption . '<p class="text-center h6">' . $ttl . '</p>';
                                    }
                                        $modal_team = ''
                                            . '<div class="modal fade text-primary" id="teamModal' . ((int)($query_members->current_post) + 1) . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">'
                                                . '<div class="modal-dialog modal-lg modal-dialog-centered">'
                                                    . '<div class="modal-content">'
                                                        . '<div class="modal-body">'

                                                            . '<div class="container-fluid">'
                                                                . '<div class="row position-relative">'
                                                                    . '<button type="button" class="btn-close position-absolute end-0" data-bs-dismiss="modal" aria-label="Close"></button>'
                                                                . '</div>'                                                         
                                                                . '<div class="row g-5 m-auto d-flex justify-content-center align-items-center">'

                                                                    . '<div class="col-md-4 p-0">'
                                                                        .'<figure>'
                                                                            . '<div class="d-flex justify-content-center">'
                                                                                . '<picture>'
                                                                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 1400px)">'
                                                                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 769px)">'
                                                                                    . '<source srcset="' . wp_get_attachment_url($post->ID) . '" media="(min-width: 577px)">'
                                                                                    . '<img srcset="' . wp_get_attachment_url($post->ID) . '" alt="responsive image" class="img-fluid img-thumbnail rounded shadow border border-primary p-0 m-0">'
                                                                                . '</picture>'                                                       
                                                                            .'</div>'
                                                                            . '<figcaption>'
                                                                                . '<h4 class="text-center pt-3" id="teamModalLabel">' . $post->post_title . '</h4>'
                                                                                . $textSection
                                                                            .'</figcaption>'
                                                                        . '</figure>'
                                                                    . '</div>'
                                                                    . '<div class="col-md-8">' . $post->post_content . '</div>'
                                                                . '</div>'    
                                                            . '</div>'
                                                        . '</div>' //<!-- Close Modal Body -->
                                                    . '</div>'
                                                . '</div>'
                                            . '</div>'; 

                                        array_push($teamModal, $modal_team);

                                        $figBlock_team = $figBlock_team
                                                . '<div class="spi-team-cards">'
                                                        . '<div class="spi-team-figure" data-bs-target="#teamModal' . ((int)($query_members->current_post) + 1) . '" data-bs-toggle="modal" role="button">'
                                                            . '<picture>'
                                                                . '<source srcset="' . $post->guid . '" media="(min-width: 1400px)">'
                                                                . '<source srcset="' . $post->guid . '" media="(min-width: 769px)">'
                                                                . '<source srcset="' . $post->guid . '" media="(min-width: 577px)">'
                                                                . '<img srcset="' . $post->guid . '" alt="responsive image" class="spi-team-figure-img shadow">'
                                                            . '</picture>'                                                             
                                                            . '<h4 class="text-center">' . $post->post_title . '</h4>'  
                                                            . $textCaption
                                                        . '</div>'
                                                    . $modal_team
                                                . '</div>';

                                }                            
                            
                            };
                            break;
                    }

                 

                }      

                wp_reset_postdata();                

                echo $mission_banner
                    . '<div class="container my-5">'
                        . '<div class="row">'
                            . '<br/>'
                            . '<h1 class="text-center text-primary mb-4"><strong> The Team </strong></h1>'
                        . '</div>'
                        . '<div class="row">'
                            . $content_title_board
                        . '</div>'
                        . '<div class="row mt-5">'
                            . $figBlock
                        . '</div>'
                        . '<div class="row mt-5">'
                            . $content_title_team
                        . '</div>'
                        . '<div class="spi-team-grid-container">'
                            . $figBlock_team
                        . '</div>'                      
                    . '</div>';  
                
    
                

                         

            ?>
<!-- Experimental Code Ends is here -->


	</main><!-- #main -->

<?php
get_footer();
