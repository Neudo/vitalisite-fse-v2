<?php
/**
 * Title: Header avec Fond
 * Slug: vitalisite-fse/header-fond
 * Description: Header moderne avec fond coloré et bordures arrondies.
 * Categories: vitalisite-header
 * Keywords: header, background, rounded, card
 * Viewport Width: 1400
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Header avec Fond"},"align":"full","className":"vitalisite-header","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-header">
  <!-- wp:group {"align":"wide","className":"vitalisite-header__bg","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group alignwide vitalisite-header__bg">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
    <div class="wp-block-group">
      <!-- wp:site-logo {"width":48} /-->
      <!-- wp:site-title {"level":0} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:navigation {"openSubmenusOnClick":true,"icon":"menu","layout":{"type":"flex","justifyContent":"right"}} /-->

    <!-- wp:buttons {"className":"vitalisite-header__cta"} -->
    <div class="wp-block-buttons vitalisite-header__cta">
      <!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Parler à un conseiller</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->

