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
<header class="wp-block-group alignfull vitalisite-header vitalisite-header--minimal" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap","orientation":"horizontal"}} -->
<div class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60)"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":165} /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"never","openSubmenusOnClick":true,"layout":{"type":"flex","justifyContent":"center"}} /-->

<!-- wp:buttons {"className":"vitalisite-header__cta"} -->
<div class="wp-block-buttons vitalisite-header__cta"><!-- wp:button {"className":"btn-primary"} -->
<div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></header>
<!-- /wp:group -->
