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
<!-- wp:group {"metadata":{"name":"Footer"},"align":"full","className":"vitalisite-footer","backgroundColor":"main","textColor":"base","style":{"spacing":{"padding":{"top":"48px","bottom":"48px"}}},"layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-footer has-base-color has-main-background-color has-text-color has-background" style="padding-top:48px;padding-bottom:48px">
  <!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"32px"}}} -->
  <div class="wp-block-columns alignwide">
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:site-title {"level":0,"isLink":false} /-->
      <!-- wp:paragraph {"fontSize":"small"} -->
      <p class="has-small-font-size">Un thème pensé pour inspirer confiance, avec des sections prêtes à l’emploi et faciles à personnaliser.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
      <p style="font-weight:600">Entreprise</p>
      <!-- /wp:paragraph -->
      <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"fontSize":"small","layout":{"type":"constrained"}} -->
      <div class="wp-block-group has-small-font-size">
        <!-- wp:paragraph --><p>À propos</p><!-- /wp:paragraph -->
        <!-- wp:paragraph --><p>Carrières</p><!-- /wp:paragraph -->
        <!-- wp:paragraph --><p>Contact</p><!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}}} -->
      <p style="font-weight:600">Ressources</p>
      <!-- /wp:paragraph -->
      <!-- wp:group {"style":{"spacing":{"blockGap":"8px"}},"fontSize":"small","layout":{"type":"constrained"}} -->
      <div class="wp-block-group has-small-font-size">
        <!-- wp:paragraph --><p>Blog</p><!-- /wp:paragraph -->
        <!-- wp:paragraph --><p>Guides</p><!-- /wp:paragraph -->
        <!-- wp:paragraph --><p>Support</p><!-- /wp:paragraph -->
      </div>
      <!-- /wp:group -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->

  <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group alignwide">
    <!-- wp:paragraph {"fontSize":"small"} -->
    <p class="has-small-font-size">© 2026 Vitalisite. Tous droits réservés.</p>
    <!-- /wp:paragraph -->
    <!-- wp:social-links {"iconColor":"primary","iconBackgroundColor":"base-soft","className":"is-style-default"} -->
    <ul class="wp-block-social-links has-icon-color has-icon-background-color is-style-default">
      <!-- wp:social-link {"url":"#","service":"linkedin"} /-->
      <!-- wp:social-link {"url":"#","service":"instagram"} /-->
      <!-- wp:social-link {"url":"#","service":"facebook"} /-->
    </ul>
    <!-- /wp:social-links -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
