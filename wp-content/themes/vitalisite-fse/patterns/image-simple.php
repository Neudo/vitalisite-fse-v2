<?php
/**
 * Title: Image simple
 * Slug: vitalisite-fse/image-simple
 * Description: Une grande image mettant en valeur un équipement, une technologie ou votre cabinet, avec une légende optionnelle.
 * Categories: vitalisite-media
 * Keywords: image, photo, media, plein ecran, cabinet
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- wp:group {"metadata":{"name":"Image simple"},"align":"full","className":"vitalisite-section","style":{"spacing":{"padding":{"top":"var(--wp--preset--spacing--70)","bottom":"var(--wp--preset--spacing--70)"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var(--wp--preset--spacing--40)"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide">
		
		<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"is-style-rounded"} -->
		<figure class="wp-block-image size-large is-style-rounded">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder-image.webp' ); ?>" alt="Présentation médicale"/>
			<figcaption class="wp-element-caption">Légende de la photo (optionnelle) - Équipement de dernière génération</figcaption>
		</figure>
		<!-- /wp:image -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
