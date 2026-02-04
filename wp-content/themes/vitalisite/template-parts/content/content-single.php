<?php
/**
 * Template part for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vitalisite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 lg:mt-16'); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="text-4xl lg:text-5xl font-bold mb-8 lg:mb-12 text-slate-950 text-center">', '</h1>' ); ?>
		<?php if ( ! is_page() ) : ?>
			<div class="entry-meta flex-wrap flex flex-col gap-2">
				<?php vitalisite_entry_meta(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div <?php vitalisite_content_class( 'content-page' ); ?>>
		<?php
		$post_type = get_post_type() ?: 'post';
		get_template_part('template-parts/content/content-' . $post_type);
		?>
		<?php if($post_type === 'post') :?>
		<div class="flex flex-col md:flex-row relative">
			<div class="md:w-2/3 wysiwyg">
				<?php the_content(
					sprintf(
						wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers. */
							__( 'Lire la suite<span class="sr-only"> "%s"</span>', 'vitalisite' ),
							array(
								'span' => array(
									'class' => array(''),
								),
							)
						),
						get_the_title()
					)
				); ?>
			</div>
			<?php get_template_part( 'template-parts/components/post-sidebar'); ?>
		</div>
		<?php else: ?>
			<?php the_content(
				sprintf(
					wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
						__( 'Lire la suite<span class="sr-only"> "%s"</span>', 'vitalisite' ),
						array(
							'span' => array(
								'class' => array(''),
							),
						)
					),
					get_the_title()
				)
			); ?>
		<?php endif; ?>
</article><!-- #post-${ID} -->
