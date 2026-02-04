<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no `home.php` file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */

get_header();
?>

	<section id="primary">
		<main id="main" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
			<?php
			if ( have_posts() ) {

				if ( is_home() && ! is_front_page() ) :
					?>
					<header class="entry-header">
						<h1 class="entry-title"><?php single_post_title(); ?></h1>
					</header><!-- .entry-header -->
				<?php
				endif;
				set_query_var('is_archive_sidebar', true);
				get_template_part('template-parts/components/post-sidebar', 'archive-sidebar');
				echo '<div class="grid gap-4">';
				// Load posts loop.
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content/content' );
				}
				echo '</div>';
				// Previous/next page navigation.
				vitalisite_the_posts_navigation();

			} else {

				// If no content, include the "No posts found" template.
				get_template_part( 'template-parts/content/content', 'none' );

			}
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
