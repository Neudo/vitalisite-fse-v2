<?php
/**
 * Title: Banniere avec image en bas
 * Slug: vitalisite-fse/hero-image-bottom
 * Categories: hero-vitalisite
 * Keywords: hero, bottom, cta, accueil
 * Block Types: core/group
 * Description: Banniere editoriale avec visuel large, ideale pour une page d'accueil de demo.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero hero-image-bottom vitalisite-section"} -->
<section class="wp-block-group alignfull vitalisite-hero hero-image-bottom vitalisite-section">
  <!-- wp:group {"className":"vitalisite-hero__inner","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
  <div class="wp-block-group vitalisite-hero__inner">
    <!-- wp:heading {"level":1,"className":"reveal-y reveal-y--soft","style":{"typography":{"fontSize":"clamp(2.25rem, 3vw + 1rem, 3.75rem)","lineHeight":"1.1"}}} -->
    <h1 class="reveal-y reveal-y--soft" style="font-size:clamp(2.25rem, 3vw + 1rem, 3.75rem);line-height:1.1">Un accompagnement rassurant a chaque etape du parcours de soin</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"className":"reveal-y reveal-y--soft","style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} -->
    <p class="reveal-y reveal-y--soft" style="margin-top:var(--wp--preset--spacing--30);font-size:1.125rem">Je vous recois sur rendez-vous dans un cadre de prise en charge serein, avec une approche attentive et personnalisee.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"className":"reveal-y reveal-y--soft","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
    <div class="wp-block-buttons reveal-y reveal-y--soft" style="margin-top:var(--wp--preset--spacing--50)">
      <!-- wp:button {"className":"btn-primary"} -->
      <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"className":"btn-secondary"} -->
      <div class="wp-block-button btn-secondary"><a class="wp-block-button__link">Decouvrir les prises en charge</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->

  <!-- wp:image {"sizeSlug":"large","align":"center","className":"reveal-y"} -->
  <figure class="wp-block-image aligncenter size-large reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-2.jpg' ) ); ?>" alt="Espace de consultation lumineux et apaisant" /></figure>
  <!-- /wp:image -->
</section>
<!-- /wp:group -->
