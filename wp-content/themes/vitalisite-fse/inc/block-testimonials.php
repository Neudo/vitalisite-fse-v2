<?php
/**
 * Server-side rendering for the testimonials block.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vitalisite_render_testimonials_block( $attributes ) {
	$count       = isset( $attributes['count'] ) ? intval( $attributes['count'] ) : -1;
	$show_rating = isset( $attributes['showRating'] ) ? $attributes['showRating'] : true;

	$testimonials = Vitalisite_CPT_Testimonials::get_testimonials( array(
		'posts_per_page' => $count,
	) );

	if ( empty( $testimonials ) ) {
		return '<p class="vitalisite-no-content">' . esc_html__( 'Aucun témoignage à afficher.', 'vitalisite-fse' ) . '</p>';
	}

	ob_start();
	?>
	<div class="swiper vitalisite-testimonials-carousel vitalisite-testimonials-swiper">
		<div class="swiper-wrapper">
			<?php foreach ( $testimonials as $testimonial ) :
				$comment     = get_post_meta( $testimonial->ID, '_testimonial_comment', true );
				$rating      = get_post_meta( $testimonial->ID, '_testimonial_rating', true );
				$author_role = get_post_meta( $testimonial->ID, '_testimonial_author_role', true );
			?>
				<div class="swiper-slide vitalisite-testimonial-card">
					<?php if ( $show_rating && $rating ) : ?>
						<?php echo Vitalisite_CPT_Testimonials::render_stars( $rating ); ?>
					<?php endif; ?>

					<blockquote class="vitalisite-testimonial-card__content">
						<?php echo esc_html( $comment ); ?>
					</blockquote>

					<div class="vitalisite-testimonial-card__author">
						<span class="vitalisite-testimonial-card__name"><?php echo esc_html( $testimonial->post_title ); ?></span>
						<?php if ( $author_role ) : ?>
							<span class="vitalisite-testimonial-card__role"><?php echo esc_html( $author_role ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
	<?php
	return ob_get_clean();
}
