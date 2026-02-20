<?php
/**
 * Title: Carrousel complet
 * Slug: vitalisite-fse/carrousel-complet
 * Description: Section complète avec titre, description, slider d'images et bouton d'action
 * Categories: vitalisite-carrousel
 * Keywords: slider, carrousel, images, galerie, cta
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-carrousel-section vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-carrousel-section vitalisite-section">
	
	<!-- wp:heading {"textAlign":"center","level":2,"className":"vitalisite-carrousel__title"} -->
	<h2 class="wp-block-heading has-text-align-center vitalisite-carrousel__title">Lorem ipsum dolor sit amet</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","className":"vitalisite-carrousel__description"} -->
	<p class="has-text-align-center vitalisite-carrousel__description">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
	<!-- /wp:paragraph -->

	<!-- wp:vitalisite-fse/slider {"showNavigation":true,"showPagination":true,"autoplayDelay":5000,"enableLoop":true} -->
	<div class="wp-block-vitalisite-fse-slider vitalisite-slider-wrapper">
		<div class="vitalisite-slider swiper" data-show-navigation="true" data-show-pagination="true" data-autoplay-delay="5000" data-enable-loop="true">
			<div class="swiper-wrapper">
			</div>
		</div>
	</div>
	<!-- /wp:vitalisite-fse/slider -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"vitalisite-carrousel__cta","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons vitalisite-carrousel__cta" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"className":"btn-primary"} -->
		<div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</section>
<!-- /wp:group -->
