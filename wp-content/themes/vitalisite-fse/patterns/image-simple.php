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
		<h2 class="wp-block-heading has-text-align-center reveal-y">Titre de la section</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"align":"center","className":"reveal-y"} -->
		<p class="has-text-align-center reveal-y">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
		<!-- /wp:paragraph -->

		<!-- wp:image {"sizeSlug":"full","align":"wide","className":"reveal-y"} -->
		<figure class="wp-block-image size-full alignwide reveal-y"><img alt="" /></figure>
		<!-- /wp:image -->

	</div>
	<!-- /wp:group -->

</section>
<!-- /wp:group -->
