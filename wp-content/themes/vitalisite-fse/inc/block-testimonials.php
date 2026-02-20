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
	$source             = isset( $attributes['testimonials_source'] ) ? $attributes['testimonials_source'] : 'local';
	$show_google_header = isset( $attributes['show_google_header'] ) ? $attributes['show_google_header'] : true;
	$google_place_id    = isset( $attributes['googlePlaceId'] ) ? trim( $attributes['googlePlaceId'] ) : '';

	// Google Reviews source
	if ( $source === 'google' ) {
		if ( empty( $google_place_id ) ) {
			return '<p class="vitalisite-no-content">' . esc_html__( 'Veuillez renseigner un Google Place ID dans les réglages du bloc.', 'vitalisite-fse' ) . '</p>';
		}

		$google_data = vitalisite_get_google_reviews( $google_place_id );
		$reviews = isset( $google_data['reviews'] ) ? $google_data['reviews'] : array();

		$place_info = array(
			'name'               => isset( $google_data['name'] ) ? $google_data['name'] : '',
			'rating'             => isset( $google_data['rating'] ) ? $google_data['rating'] : 0,
			'user_ratings_total' => isset( $google_data['user_ratings_total'] ) ? $google_data['user_ratings_total'] : 0,
			'place_id'           => $google_place_id,
		);

		if ( empty( $reviews ) ) {
			return '<p class="vitalisite-no-content">' . esc_html__( 'Aucun avis Google disponible. Vérifiez votre Place ID.', 'vitalisite-fse' ) . '</p>';
		}
	} else {
		// Local testimonials
		$testimonials = Vitalisite_CPT_Testimonials::get_testimonials( array(
			'posts_per_page' => $count,
		) );

		if ( empty( $testimonials ) ) {
			return '<p class="vitalisite-no-content">' . esc_html__( 'Aucun témoignage à afficher.', 'vitalisite-fse' ) . '</p>';
		}
	}

	ob_start();
	?>
	<div class="vitalisite-testimonials-wrapper">
		<?php if ( $source === 'google' && $show_google_header && ! empty( $place_info ) ) : ?>
			<!-- Google Reviews Header -->
			<div class="vitalisite-google-reviews-header">
				<div class="vitalisite-google-reviews-header__content">
					<div class="vitalisite-google-reviews-header__logo">
						<img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="Google" />
					</div>
					<div class="vitalisite-google-reviews-header__rating">
						<div class="vitalisite-google-reviews-header__score">
							<span class="vitalisite-google-reviews-header__number"><?php echo number_format( $place_info['rating'], 1 ); ?></span>
							<div class="vitalisite-google-reviews-header__stars">
								<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
									<svg class="vitalisite-star <?php echo $i <= $place_info['rating'] ? 'vitalisite-star--filled' : 'vitalisite-star--empty'; ?>" fill="currentColor" viewBox="0 0 20 20">
										<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
									</svg>
								<?php endfor; ?>
							</div>
						</div>
						<div class="vitalisite-google-reviews-header__meta">
							<span><?php echo esc_html( $place_info['user_ratings_total'] ); ?> avis</span>
							<span>•</span>
							<span><?php echo esc_html( $place_info['name'] ); ?></span>
						</div>
					</div>
					<?php if ( ! empty( $place_info['place_id'] ) ) : ?>
						<div class="vitalisite-google-reviews-header__cta">
							<a href="https://search.google.com/local/reviews?placeid=<?php echo esc_attr( $place_info['place_id'] ); ?>" 
							   target="_blank" 
							   class="vitalisite-google-cta vitalisite-google-cta--primary">
								<svg class="vitalisite-google-cta__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
								</svg>
								<span>Voir tous les avis</span>
							</a>
							<a href="https://search.google.com/local/writereview?placeid=<?php echo esc_attr( $place_info['place_id'] ); ?>" 
							   target="_blank" 
							   class="vitalisite-google-cta vitalisite-google-cta--outline">
								<svg class="vitalisite-google-cta__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
								</svg>
								<span>Laisser un avis</span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="swiper vitalisite-testimonials-carousel vitalisite-testimonials-swiper">
			<div class="swiper-wrapper">
				<?php if ( $source === 'google' ) : ?>
					<?php foreach ( $reviews as $review ) : ?>
						<div class="swiper-slide vitalisite-testimonial-card vitalisite-testimonial-card--google">
							<div class="vitalisite-testimonial-card__header">
								<?php if ( ! empty( $review['profile_photo_url'] ) ) : ?>
									<img src="<?php echo esc_url( $review['profile_photo_url'] ); ?>" 
										 alt="<?php echo esc_attr( $review['author_name'] ); ?>" 
										 class="vitalisite-testimonial-card__avatar" />
								<?php endif; ?>
								<div class="vitalisite-testimonial-card__author-info">
									<span class="vitalisite-testimonial-card__name"><?php echo esc_html( $review['author_name'] ); ?></span>
									<?php if ( $show_rating ) : ?>
										<div class="vitalisite-testimonial-card__rating">
											<?php echo vitalisite_format_rating( $review['rating'] ); ?>											
										</div>
										<span class="vitalisite-testimonial-card__time"><?php echo esc_html( $review['relative_time_description'] ); ?></span>
									<?php endif; ?>
								</div>
							</div>
							<blockquote class="vitalisite-testimonial-card__content">
								<svg class="vitalisite-testimonial-card__quote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
									<path d="M11.192 15.757c0-.88-.23-1.618-.69-2.217-.326-.412-.768-.683-1.327-.812-.55-.128-1.07-.137-1.54-.028-.16-.95.1-1.956.76-3.022.66-1.065 1.515-1.867 2.558-2.403L9.373 5c-.8.396-1.56.898-2.26 1.505-.71.607-1.34 1.305-1.9 2.094s-.98 1.68-1.25 2.69-.346 2.04-.217 3.1c.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003zm9.124 0c0-.88-.23-1.618-.69-2.217-.326-.42-.77-.692-1.327-.817-.56-.124-1.074-.13-1.54-.022-.16-.94.09-1.95.75-3.02.66-1.06 1.514-1.86 2.557-2.4L18.49 5c-.8.396-1.555.898-2.26 1.505-.708.607-1.34 1.305-1.894 2.094-.556.79-.97 1.68-1.24 2.69-.273 1-.345 2.04-.217 3.1.168 1.4.62 2.52 1.356 3.35.735.84 1.652 1.26 2.748 1.26.965 0 1.766-.29 2.4-.878.628-.576.94-1.365.94-2.368l.002.003z"/>
								</svg>
								<em><?php echo ! empty( $review['text'] ) ? esc_html( $review['text'] ) : esc_html__( 'Cet utilisateur a uniquement laissé une évaluation.', 'vitalisite-fse' ); ?></em>
							</blockquote>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
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
				<?php endif; ?>
				<div class="swiper-slide vitalisite-testimonials-ghost-slide" aria-hidden="true"></div>
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
