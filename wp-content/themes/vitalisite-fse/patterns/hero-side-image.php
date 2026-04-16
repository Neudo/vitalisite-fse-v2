<?php
/**
 * Title: Banniere avec image laterale
 * Slug: vitalisite-fse/hero-side-image
 * Categories: hero-vitalisite
 * Keywords: hero, split, cta, accueil
 * Block Types: core/group, core/cover
 * Description: Banniere equilibree avec contenu et image, ideale pour presenter un cabinet ou une specialite.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-hero hero-side-image vitalisite-section big-section"} -->
<section class="wp-block-group alignfull vitalisite-hero hero-side-image vitalisite-section big-section">
  <!-- wp:group {"className":"vitalisite-hero__inner"} -->
  <div class="wp-block-group vitalisite-hero__inner">
    <!-- wp:columns {"verticalAlignment":"center","className":"vitalisite-hero__columns"} -->
    <div class="wp-block-columns are-vertically-aligned-center vitalisite-hero__columns">
    <!-- wp:column {"verticalAlignment":"center","className":"vitalisite-hero__column"} -->
    <div class="wp-block-column is-vertically-aligned-center vitalisite-hero__column">
      <!-- wp:heading {"level":1,"className":"vitalisite-hero__title reveal-y reveal-y--soft"} -->
      <h1 class="vitalisite-hero__title reveal-y reveal-y--soft">Des consultations personnalisees dans un cadre professionnel et rassurant</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"className":"vitalisite-hero__lead reveal-y reveal-y--soft"} -->
      <p class="vitalisite-hero__lead reveal-y reveal-y--soft">J'accompagne mes patients avec une approche claire, accessible et personnalisee, adaptee aux besoins du quotidien.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"className":"vitalisite-hero__actions reveal-y reveal-y--soft"} -->
      <div class="wp-block-buttons vitalisite-hero__actions reveal-y reveal-y--soft">
        <!-- wp:button {"className":"btn-primary"} -->
        <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez‑vous</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"className":"btn-secondary"} -->
        <div class="wp-block-button btn-secondary"><a class="wp-block-button__link">Decouvrir le cabinet</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"center","className":"vitalisite-hero__column"} -->
    <div class="wp-block-column is-vertically-aligned-center vitalisite-hero__column">
      <!-- wp:image {"sizeSlug":"large","className":"reveal-y"} -->
      <figure class="wp-block-image size-large reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-3.jpg' ) ); ?>" alt="Portrait d'un praticien dans son cabinet" /></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->
