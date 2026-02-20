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
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero vitalisite-hero--tall vitalisite-hero--tight vitalisite-section full-section"} -->
<section class="wp-block-group alignfull vitalisite-hero vitalisite-hero--tall vitalisite-hero--tight vitalisite-section full-section">
  <!-- wp:group {"className":"vitalisite-hero__inner vitalisite-hero__inner--filled","layout":{"type":"constrained"}} -->
  <div class="wp-block-group vitalisite-hero__inner vitalisite-hero__inner--filled">
    <!-- wp:heading {"textAlign":"center","level":1,"textColor":"base","className":"vitalisite-hero__title"} -->
    <h1 class="has-text-align-center has-base-color has-text-color vitalisite-hero__title">Lorem ipsum dolor sit amet</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","textColor":"base","className":"vitalisite-hero__lead"} -->
    <p class="has-text-align-center has-base-color has-text-color vitalisite-hero__lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"vitalisite-hero__actions"} -->
    <div class="wp-block-buttons vitalisite-hero__actions">
      <!-- wp:button {"className":"btn-primary-soft"} -->
      <div class="wp-block-button btn-primary-soft"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"className":"btn-secondary-soft"} -->
      <div class="wp-block-button btn-secondary-soft"><a class="wp-block-button__link">En savoir plus</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->
