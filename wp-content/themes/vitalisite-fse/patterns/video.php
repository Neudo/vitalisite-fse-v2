<?php
/**
 * Title: Vidéo
 * Slug: vitalisite-fse/video
 * Description: Section vidéo avec titre, description et bouton CTA.
 * Categories: vitalisite-media
 * Keywords: video, youtube, media
 */

?>

<!-- wp:group {"tagName":"section","className":"vitalisite-video-section vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-video-section vitalisite-section">

    <!-- wp:group {"className":"mb-60","layout":{"type":"constrained"}} -->
    <div class="wp-block-group mb-60">
        <!-- wp:heading {"textAlign":"center","level":2} -->
        <h2 class="wp-block-heading has-text-align-center">Découvrez notre cabinet en vidéo</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center">Une visite virtuelle de nos installations et de notre équipe.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:video -->
    <figure class="wp-block-video"></figure>
    <!-- /wp:video -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"mt-40"} -->
    <div class="wp-block-buttons mt-40">
        <!-- wp:button {"className":"btn-primary"} -->
        <div class="wp-block-button btn-primary"><a class="wp-block-button__link" href="#">Prendre rendez-vous</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

</section>
<!-- /wp:group -->
