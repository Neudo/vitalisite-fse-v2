<?php
/**
 * Title: En-tête Minimal
 * Slug: vitalisite-fse/header-minimal
 * Description: En-tête épuré avec logo, navigation et bouton d'action
 * Categories: vitalisite-header
 * Keywords: header, minimal, simple, clean
 * Viewport Width: 1400
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"tagName":"header","metadata":{"name":"Header Minimal"},"align":"full","className":"vitalisite-header vitalisite-header--minimal","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<header class="wp-block-group alignfull vitalisite-header vitalisite-header--minimal" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--50)">
  <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group alignwide">
    <!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
    <div class="wp-block-group">
      <!-- wp:site-logo {"width":44} /-->
      <!-- wp:site-title {"level":0} /-->
    </div>
    <!-- /wp:group -->

    <!-- wp:navigation {"openSubmenusOnClick":true,"icon":"menu","layout":{"type":"flex","justifyContent":"center"}} /-->

    <!-- wp:buttons {"className":"vitalisite-header__cta"} -->
    <div class="wp-block-buttons vitalisite-header__cta">
      <!-- wp:button {"backgroundColor":"primary","textColor":"base"} -->
      <div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button">Prendre rendez-vous</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</header>
<!-- /wp:group -->
