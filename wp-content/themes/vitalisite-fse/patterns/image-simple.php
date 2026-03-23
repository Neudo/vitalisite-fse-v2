<?php
/**
 * Title: Image simple
 * Slug: vitalisite-fse/image-simple
 * Description: Une grande image mettant en valeur un équipement, une technologie ou votre cabinet, avec titre et description optionnels.
 * Categories: vitalisite-media
 * Keywords: image, photo, media, plein ecran, cabinet
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- wp:group {"metadata":{"name":"Image simple"},"tagName":"section","align":"full","className":"vitalisite-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">

	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">

		<!-- wp:heading {"textAlign":"center","level":2,"className":"reveal-y"} -->
		<h2 class="wp-block-heading has-text-align-center reveal-y">Le cabinet en image</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"reveal-y"} -->
		<p class="has-text-align-center reveal-y">Une section tres simple pour valoriser un espace de consultation, un equipement ou une ambiance de cabinet.</p>
		<!-- /wp:paragraph -->

		<!-- wp:image {"sizeSlug":"full","align":"wide","className":"reveal-y"} -->
		<figure class="wp-block-image size-full alignwide reveal-y"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-slider-1.jpg' ) ); ?>" alt="Vue generale du cabinet" /></figure>
		<!-- /wp:image -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
