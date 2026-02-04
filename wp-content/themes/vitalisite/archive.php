<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */

get_header();
?>

	<section id="primary">
		<main id="main" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

			<header class="page-header w-full">
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header><!-- .page-header -->

			<?php
			set_query_var( 'is_archive_sidebar', true );
			get_template_part('template-parts/components/post-sidebar', 'archive-sidebar');
			if ( have_posts() ) :?>
			
			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'archive' );
				// End the loop.
			endwhile;

			// Previous/next page navigation.
			vitalisite_the_posts_navigation();

		else :

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
