<?php
/**
 * Title: Header Minimal
 * Slug: vitalisite-fse/header-minimal
 * Description: Header ultra-minimaliste inspiré d'Ollie. Logo, navigation et CTA sur une seule ligne.
 * Categories: vitalisite-header
 * Keywords: header, minimal, simple, clean
 * Viewport Width: 1400
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Header Minimal"},"align":"full","className":"vitalisite-header vitalisite-header--minimal","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-header vitalisite-header--minimal">
  <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap","orientation":"horizontal"}} -->
  <div class="wp-block-group alignwide">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
    <div class="wp-block-group">
      <!-- wp:site-logo {"width":44} /-->
      <!-- wp:site-title {"level":0} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:navigation {"openSubmenusOnClick":true,"icon":"menu","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} /-->

    <!-- wp:buttons {"className":"vitalisite-header__cta"} -->
    <div class="wp-block-buttons vitalisite-header__cta">
      <!-- wp:button {"backgroundColor":"primary","textColor":"base"} -->
      <div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button">Contact</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
