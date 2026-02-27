<?php
/**
 * Title: Footer simple
 * Slug: vitalisite-fse/footer-simple
 * Description: Pied de page simple avec colonnes et liens.
 * Categories: vitalisite-footer
 * Keywords: footer, liens
 * Viewport Width: 1400
 * Block Types: core/template-part/footer
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Footer"},"align":"full","className":"vitalisite-footer","backgroundColor":"main","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-footer has-base-color has-main-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
  <!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|60"}}} -->
  <div class="wp-block-columns alignwide">
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:site-title {"level":0,"isLink":false} /-->
      <!-- wp:paragraph {"fontSize":"small"} -->
      <p class="has-small-font-size">Un thème pensé pour inspirer confiance, avec des sections prêtes à l'emploi et faciles à personnaliser.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
      <p style="font-weight:600">Navigation</p>
      <!-- /wp:paragraph -->
      <!-- wp:navigation {"layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"fontSize":"small"} /-->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->

  <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group alignwide">
    <!-- wp:paragraph {"fontSize":"small"} -->
    <p class="has-small-font-size">© 2026 Vitalisite. Tous droits réservés.</p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
