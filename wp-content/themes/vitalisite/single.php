<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package vitalisite
 */
get_header();
?>

	<section id="primary">
		<main id="main">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'single' );

				// If comments are open, or we have at least one comment, load
				// the comment template.
//				if ( comments_open() || get_comments_number() ) {
//					comments_template();
//				}

				// End the loop.
			endwhile;
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
