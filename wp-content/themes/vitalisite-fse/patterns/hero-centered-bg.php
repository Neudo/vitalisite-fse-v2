<?php
/**
 * Title: Héro centré avec fond coloré
 * Slug: vitalisite-fse/hero-centered-bg
 * Categories: hero-vitalisite
 * Keywords: hero, background, cta, accueil
 * Block Types: core/group
 * Description: Bannière sans image, fond coloré, titre, description et CTA.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero hero-centered-bg vitalisite-hero--tight vitalisite-section full-section"} -->
<section class="wp-block-group alignfull vitalisite-hero hero-centered-bg vitalisite-hero--tight vitalisite-section full-section">
  <!-- wp:group {"className":"vitalisite-hero__inner vitalisite-hero__inner--filled","layout":{"type":"constrained"}} -->
  <div class="wp-block-group vitalisite-hero__inner vitalisite-hero__inner--filled">
    <!-- wp:heading {"textAlign":"center","level":1,"className":"vitalisite-hero__title reveal-y reveal-y--soft"} -->
    <h1 class="has-text-align-center vitalisite-hero__title reveal-y reveal-y--soft">Lorem ipsum dolor sit amet</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","className":"vitalisite-hero__lead reveal-y reveal-y--soft"} -->
    <p class="has-text-align-center vitalisite-hero__lead reveal-y reveal-y--soft">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"vitalisite-hero__actions reveal-y reveal-y--soft"} -->
    <div class="wp-block-buttons vitalisite-hero__actions reveal-y reveal-y--soft">
      <!-- wp:button {"className":"btn-on-primary"} -->
      <div class="wp-block-button btn-on-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
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
