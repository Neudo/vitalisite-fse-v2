<?php
/**
 * Title: Héro bannière sans image
 * Slug: vitalisite-fse/hero-banniere-v2
 * Categories: banniere-vitalisite
 * Keywords: hero, banniere, cta, accueil
 * Block Types: core/group
 * Description: Bannière sans image, fond coloré, titre, description et CTA.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero vitalisite-hero--tall vitalisite-hero--tight","layout":{"type":"constrained"},"backgroundColor":"primary"} -->
<section class="wp-block-group alignfull vitalisite-hero vitalisite-hero--tall vitalisite-hero--tight has-primary-background-color has-background">
  <!-- wp:group {"className":"vitalisite-hero__inner","layout":{"type":"constrained"}} -->
  <div class="wp-block-group vitalisite-hero__inner">
    <!-- wp:heading {"level":1,"textColor":"base","className":"vitalisite-hero__title"} -->
    <h1 class="has-base-color has-text-color vitalisite-hero__title">Une présence qui inspire confiance</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"textColor":"base","className":"vitalisite-hero__lead"} -->
    <p class="has-base-color has-text-color vitalisite-hero__lead">Mettez en avant votre expertise avec un message clair et une proposition de valeur immédiate. Idéal pour une page d’accueil simple et efficace.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"className":"vitalisite-hero__actions"} -->
    <div class="wp-block-buttons vitalisite-hero__actions">
      <!-- wp:button {"backgroundColor":"base","textColor":"primary"} -->
      <div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background">Parler à un conseiller</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"textColor":"base","borderColor":"base","className":"is-style-outline"} -->
      <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-base-color has-text-color">Découvrir les offres</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->
