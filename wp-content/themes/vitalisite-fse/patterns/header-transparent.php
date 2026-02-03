<?php
/**
 * Title: Header Transparent
 * Slug: vitalisite-fse/header-transparent
 * Description: Header transparent avec effet glassmorphism, parfait pour superposer sur un hero.
 * Categories: vitalisite-header
 * Keywords: header, transparent, glassmorphism, overlay, hero
 * Viewport Width: 1400
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Header Transparent"},"align":"full","className":"vitalisite-header vitalisite-header--transparent","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-header vitalisite-header--transparent">
  <!-- wp:group {"align":"wide","className":"vitalisite-header__wrapper","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group alignwide vitalisite-header__wrapper">
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
      <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Démarrer</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
