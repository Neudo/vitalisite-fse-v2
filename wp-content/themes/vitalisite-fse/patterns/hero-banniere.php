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
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero hero-v1 vitalisite-section big-section"} -->
<section class="wp-block-group alignfull vitalisite-hero hero-v1 vitalisite-section big-section">
  <!-- wp:group {"className":"vitalisite-hero__inner"} -->
  <div class="wp-block-group vitalisite-hero__inner">
    <!-- wp:columns {"verticalAlignment":"center","className":"vitalisite-hero__columns"} -->
    <div class="wp-block-columns are-vertically-aligned-center vitalisite-hero__columns">
    <!-- wp:column {"verticalAlignment":"center","className":"vitalisite-hero__column"} -->
    <div class="wp-block-column is-vertically-aligned-center vitalisite-hero__column">
      <!-- wp:heading {"level":1,"className":"vitalisite-hero__title"} -->
      <h1 class="vitalisite-hero__title">Lorem ipsum dolor sit amet consectetur</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"className":"vitalisite-hero__lead"} -->
      <p class="vitalisite-hero__lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"className":"vitalisite-hero__actions"} -->
      <div class="wp-block-buttons vitalisite-hero__actions">
        <!-- wp:button {"className":"btn-primary"} -->
        <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez‑vous</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"className":"btn-secondary"} -->
        <div class="wp-block-button btn-secondary"><a class="wp-block-button__link">En savoir plus</a></div>
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
