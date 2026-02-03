<?php
/**
 * Title: Héro bannière avec image
 * Slug: vitalisite-fse/hero-banniere
 * Categories: banniere-vitalisite
 * Keywords: hero, banniere, cta, accueil
 * Block Types: core/group, core/cover
 * Description: Bannière avec image, titre, description et deux CTA optionnels.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-hero">
  <!-- wp:group {"className":"vitalisite-hero__inner","layout":{"type":"constrained"}} -->
  <div class="wp-block-group vitalisite-hero__inner">
    <!-- wp:columns {"verticalAlignment":"center","className":"vitalisite-hero__columns"} -->
    <div class="wp-block-columns are-vertically-aligned-center vitalisite-hero__columns">
    <!-- wp:column {"verticalAlignment":"center","className":"vitalisite-hero__column"} -->
    <div class="wp-block-column is-vertically-aligned-center vitalisite-hero__column">
      <!-- wp:heading {"level":1,"className":"vitalisite-hero__title"} -->
      <h1 class="vitalisite-hero__title">Des soins attentifs, un accompagnement humain</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"className":"vitalisite-hero__lead"} -->
      <p class="vitalisite-hero__lead">Présentez votre offre de santé ou de bien‑être avec une bannière claire, moderne et rassurante. Mettez en avant votre promesse de valeur en quelques lignes.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"className":"vitalisite-hero__actions"} -->
      <div class="wp-block-buttons vitalisite-hero__actions">
        <!-- wp:button {"backgroundColor":"vital-blue","textColor":"vital-mist"} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-vital-mist-color has-vital-blue-background-color has-text-color has-background">Prendre rendez‑vous</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"textColor":"vital-ink","borderColor":"vital-ink","className":"is-style-outline"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-vital-ink-color has-text-color">Découvrir nos services</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"center","className":"vitalisite-hero__column"} -->
    <div class="wp-block-column is-vertically-aligned-center vitalisite-hero__column">
      <!-- wp:image {"sizeSlug":"large"} -->
      <figure class="wp-block-image size-large"><img src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?w=1200" alt="Équipe médicale souriante" /></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->
