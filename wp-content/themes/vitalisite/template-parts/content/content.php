<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('border-2 p-4 rounded-3xl reveal-y2 flex flex-col md:flex-row flew-wrap h-fit mb-6'); ?>>


	<?php vitalisite_post_thumbnail(); ?>

	<div class="card-body pt-6 md:pt-2 md:pl-6">
		<footer class="entry-footer flex flex-col border-b-2 pb-4 mb-4 gap-4 md:flex-row">
			<?php vitalisite_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	<header class="entry-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span">%s</span>', esc_html_x( 'Featured', 'post', 'vitalisite' ) );
		}
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="text-2xl font-bold"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>
	</header><!-- .entry-header -->

	<div <?php vitalisite_content_class( 'entry-content py-4' ); ?>>
		<?php
		echo get_the_excerpt();

		wp_link_pages(
			array(
				'before' => '<div>' . __( 'Pages:', 'vitalisite' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	</div>

</article><!-- #post-${ID} -->
