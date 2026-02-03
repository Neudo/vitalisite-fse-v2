<?php
/**
 * Title: Header avec Bannière
 * Slug: vitalisite-fse/header-banniere
 * Description: Header complet avec barre de message supérieure et boutons d'action.
 * Categories: vitalisite-header
 * Keywords: header, banner, cta, announcement
 * Viewport Width: 1400
 * Block Types: core/template-part/header
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {"metadata":{"name":"Header avec Bannière"},"align":"full","className":"vitalisite-header","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull vitalisite-header">
  <!-- wp:group {"align":"full","className":"vitalisite-header__bar"} -->
  <div class="wp-block-group alignfull vitalisite-header__bar">
    <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
    <div class="wp-block-group alignwide">
      <!-- wp:paragraph {"className":"vitalisite-header__bar-text"} -->
      <p class="vitalisite-header__bar-text">Besoin d'un avis rapide ? Nos équipes répondent en moins de 24h.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"className":"vitalisite-header__bar-cta"} -->
      <div class="wp-block-buttons vitalisite-header__bar-cta">
        <!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Être rappelé</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->

  <!-- wp:group {"layout":{"inherit":true,"type":"constrained"}} -->
  <div class="wp-block-group">
    <!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
    <div class="wp-block-group alignwide">
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
        <div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Prendre rendez-vous</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->

