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
		while ( have_posts() ) :
			the_post();

			if ( in_array ( basename( get_permalink() ), array( 'our-work', 'careers' ) ) ) {
				get_template_part( 'template-parts/content', 'summary' );
			}
			else {
				get_template_part( 'template-parts/content', 'page' );
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		$page_list = array(
			'enhanced-rural-revenue-franchise-e-rrf-program',
			'energy-service-franchise-model',
			'micro-enterprise-development',
			'mini-grid-model',
			'innovation'
		);
		if ( in_array ( basename( get_permalink() ), $page_list ) ) {
			wp_reset_postdata();
			get_template_part( 'template-parts/content', 'partner' );
		}
		?>

	</main><!-- #main -->

<?php
get_footer();
