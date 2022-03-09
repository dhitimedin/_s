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

        /** 
         * 
         * This Function forms an html block that contains a 
         * list of tem members with their details.
         * It takes as arguments query object and post object and returns a string with the list of 
         * team members
         * 
         **/  
        function team_list( $post_count, $post, $modal_tag ) {

            $ttlorg             = explode( ",", $post->post_excerpt , 2 );
            $image_url          = wp_get_attachment_url( $post->ID ); 
            $text_section = $text_caption = $team_block = $modal_team = '';

            foreach ( $ttlorg as $ttl ) {
                $text_section .= "<p class='text-center h6 d-block'>$ttl</p>";
                $text_caption .= "<p class='text-center h6'>$ttl</p>";
            }
            
            $modal_team .= "<div class='modal fade text-primary' id='{$modal_tag}{$post_count}' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-body'>
            
                                <div class='container-fluid'>
                                    <div class='row position-relative'>
                                        <button type='button' class='btn-close position-absolute end-0' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>                                                        
                                    <div class='row g-5 m-auto d-flex justify-content-center align-items-center'>
            
                                        <div class='col-md-4 p-0'>
                                            <figure>
                                                <div class='d-flex justify-content-center'>
                                                    <picture>
                                                        <source srcset='$image_url' media='(min-width: 1400px)>
                                                        <source srcset='$image_url' media='(min-width: 769px)'>
                                                        <source srcset='$image_url' media='(min-width: 577px)'>
                                                        <img srcset='$image_url' alt='responsive image' class='img-fluid img-thumbnail rounded shadow border border-primary p-0 m-0'>
                                                    </picture>                                                      
                                                </div>
                                                <figcaption>
                                                    <h4 class='text-center pt-3' id='teamModalLabel'>$post->post_title</h4>
                                                    $text_section
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class='col-md-8'>$post->post_content</div>
                                    </div>   
                                </div>
                            </div> <!-- Close Modal Body -->
                        </div>
                    </div>
                </div>"; 
            
                //array_push( $modal_members, $modal_team );
            
                $team_block .= "<div class='spi-team-cards'>
                                <div class='spi-team-figure' data-bs-target='#{$modal_tag}{$post_count}' data-bs-toggle='modal' role='button'>
                                    <picture>
                                        <source srcset='$post->guid' media='(min-width: 1400px)'>
                                        <source srcset='$post->guid' media='(min-width: 769px)'>
                                        <source srcset='$post->guid' media='(min-width: 577px)'>
                                        <img srcset='$post->guid' alt='responsive image' class='spi-team-figure-img shadow'>
                                    </picture>                                                             
                                    <h4 class='text-center'>$post->post_title</h4>  
                                    $text_caption
                                </div>
                            $modal_team
                        </div>";            

            return $team_block;
        }

        /**
         * This function takes as argument a post object
         * and returns header for the block
         */

        function block_title( $post ) {

            $title = "<div class='d-flex justify-content-center'>
                    <div class='pill-button'><span>$post->post_title</span></div>
                </div>";

            return $title;
        }


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
            'post_parent'   => $current_page_id,
            'child_of'      => $current_page_id,
            'post_type'     => 'page',
            'orderby'       => 'menu_order',
            'depth'         => 1,
        );

        $query_child = new WP_Query( $args_w );

        while ( $query_child->have_posts() ) :
            $query_child->the_post();

            $page_id                = $post->ID; // get the ID of the childpage
            $page_img               = get_the_post_thumbnail( $page_id ); // returns the featured image <img> element
            $page_title             = get_the_title(); // returns the title of the child page
            $thumbnail_title        = get_post( get_post_thumbnail_id() )->post_title;
            $thmbnail_description   = get_post( get_post_thumbnail_id() )->post_content;
            $mission_banner         = '';
            $thumnail_url           = get_the_post_thumbnail_url();

            if ( class_exists( 'MultiPostThumbnails' ) ) {
                $thumbnailmob       =  MultiPostThumbnails::get_post_thumbnail_url( get_post_type(), 'secondary-image', $page_id );
            }                        
        ?>
            <div class="spi-card-container">
                <picture>
                    <source srcset="<?php echo $thumnail_url; ?>" media="(min-width: 1400px)">
                    <source srcset="<?php echo $thumnail_url; ?>" media="(min-width: 769px)">
                    <source srcset="<?php echo $thumbnailmob; ?>" media="(max-width: 768px)">                
                    <source srcset="<?php echo $thumbnailmob; ?>" media="(min-width: 577px)">
                    <img srcset="<?php echo $thumnail_url; ?>" alt="responsive image" class="card-img img-fluid">
                </picture>
                <div class="spi-card-img-overlay-left">
                    <h2 class="spi-card-title"><strong><?php echo $page_title; ?></strong></h2>
                    <p class="spi-card-text"><?php echo get_the_post_thumbnail_caption(); ?></p>
                    <h2 class="spi-card-title"><strong><?php echo $thumbnail_title; ?></strong></h2>
                    <p class="spi-card-text"><?php echo $thmbnail_description; ?></p>                   
                </div>
            </div>                     
        <?php                         
        endwhile;
        wp_reset_postdata();                  
       
         // <!-- Team Portfolio -->

        $query_board    = new WP_Query ( array( 
                            'post_type'         => 'team-portfolio',
                            'posts_per_page'    => -1
                        )
                    );

        //$section_title  = '<h2 class="text-center text-primary mb-4"><strong> The Team </strong></h2>';
        $content_title = array();

        $team_member_block = array();
        while ( $query_board->have_posts() ) {
            $query_board->the_post();

            if ( $post->post_name === 'board-members' ) {

                $content_title[ $post->post_title ] = block_title( $post ); 


                $args = array( 
                            'post_type'         => 'attachment',
                            'post_status'       => 'inherit',
                            'post_mime_type'    => 'image',
                            'posts_per_page'    => -1,
                            'order'             => 'ASC', 
                            'post_parent'       => $post->ID,
                        );
                $modal_tag = array(
                                "Board Members" => 'board-modal',
                                "Team Members"  => 'team-modal',
                            );
                $members[ $post->post_title ]           = new WP_Query( $args );
                $array_key                              = $post->post_title;
                $team_member_block[ $post->post_title ] = '';            
                while ( $members[ $array_key ]->have_posts() ) {
                    $members[ $array_key ]->the_post();

                    $post_count = intval( $members[ $array_key ]->current_post ) + 1;
                    $team_member_block[ $array_key ] .= team_list( $post_count, $post, $modal_tag[ $array_key ] );
                }
            }
                    
        }   //End of main loop   



        wp_reset_postdata();

        ?>
            <div class="container my-5">
                <div class="row">
                    <br/>
                    <h1 class="text-center text-primary mb-4"><strong> The Team </strong></h1>
                </div>
                <div class="row">
                    <?php echo $content_title['Board Members']; ?>
                </div>
                <div class="row">
                <div class="spi-team-grid-container">
                    <?php echo $team_member_block['Board Members']; ?>
                </div>
                </div>
                <div class="row mt-5">
                    <?php echo $content_title['Team Members']; ?>
                </div>
                <div class="row">
                <div class="spi-team-grid-container">
                    <?php echo $team_member_block['Team Members'] ?>
                </div> 
                </div>                  
            </div>             

	</main><!-- #main -->

<?php
get_footer();
