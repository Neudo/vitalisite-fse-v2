<?php
/**
 * Title: Header Simple
 * Slug: vitalisite-fse/header-simple
 * Description: Header simple et épuré avec logo, navigation et bouton d'action.
 * Categories: vitalisite-header
 * Keywords: header, navigation, cta, simple
 * Viewport Width: 1400
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Header Simple"},"align":"full","className":"vitalisite-header","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-header">
  <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap","orientation":"horizontal"}} -->
  <div class="wp-block-group alignwide">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left","orientation":"horizontal"}} -->
    <div class="wp-block-group">
      <!-- wp:site-logo {"width":48} /-->
      <!-- wp:site-title {"level":0} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:navigation {"openSubmenusOnClick":true,"icon":"menu","layout":{"type":"flex","justifyContent":"right"}} /-->

    <!-- wp:buttons {"className":"vitalisite-header__cta"} -->
    <div class="wp-block-buttons vitalisite-header__cta">
      <!-- wp:button -->
      <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Prendre rendez-vous</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->

