<?php
/**
 * Title: Héro bannière avec image en bas
 * Slug: vitalisite-fse/hero-banniere-v3
 * Categories: banniere-vitalisite
 * Keywords: hero, banniere, cta, accueil
 * Block Types: core/group
 * Description: Bannière avec image en bas, titre, description et CTA.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero vitalisite-section"} -->
<section class="wp-block-group alignfull vitalisite-hero vitalisite-section">
  <!-- wp:group {"className":"vitalisite-hero__inner","style":{"spacing":{"blockGap":"16px"}}} -->
  <div class="wp-block-group vitalisite-hero__inner">
    <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"clamp(2.25rem, 3vw + 1rem, 3.75rem)","lineHeight":"1.1"}}} -->
    <h1 style="font-size:clamp(2.25rem, 3vw + 1rem, 3.75rem);line-height:1.1">Lorem ipsum dolor sit amet</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"top":"8px"}}}} -->
    <p style="margin-top:8px;font-size:1.125rem">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"24px"}}}} -->
    <div class="wp-block-buttons" style="margin-top:24px">
      <!-- wp:button {"className":"btn-primary"} -->
      <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"className":"btn-secondary"} -->
      <div class="wp-block-button btn-secondary"><a class="wp-block-button__link">En savoir plus</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->

  <!-- wp:spacer {"height":"32px"} -->
  <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
  <!-- /wp:spacer -->

  <!-- wp:image {"sizeSlug":"large"} -->
  <figure class="wp-block-image size-large"><img src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?w=1600" alt="Équipe médicale en discussion" /></figure>
  <!-- /wp:image -->
</section>
<!-- /wp:group -->
