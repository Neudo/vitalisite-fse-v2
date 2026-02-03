<?php
/**
 * Title: Héro bannière sans image
 * Slug: vitalisite-fse/hero-banniere-v2
 * Categories: banniere-vitalisite
 * Keywords: hero, banniere, cta, accueil
 * Block Types: core/group
 * Description: Bannière sans image, fond coloré, titre, description et CTA.
 */
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"72px","bottom":"72px"}}},"backgroundColor":"primary"} -->
<section class="wp-block-group has-primary-background-color has-background" style="padding-top:72px;padding-bottom:72px">
  <!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"16px"}}} -->
  <div class="wp-block-group">
    <!-- wp:heading {"level":1,"textColor":"base","style":{"typography":{"fontSize":"clamp(2.25rem, 3vw + 1rem, 3.75rem)","lineHeight":"1.1"}}} -->
    <h1 class="has-base-color has-text-color" style="font-size:clamp(2.25rem, 3vw + 1rem, 3.75rem);line-height:1.1">Une présence qui inspire confiance</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"textColor":"base","style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"top":"8px"}}}} -->
    <p class="has-base-color has-text-color" style="margin-top:8px;font-size:1.125rem">Mettez en avant votre expertise avec un message clair et une proposition de valeur immédiate. Idéal pour une page d’accueil simple et efficace.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"24px"}}}} -->
    <div class="wp-block-buttons" style="margin-top:24px">
      <!-- wp:button {"backgroundColor":"base","textColor":"primary","style":{"border":{"radius":"999px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}}} -->
      <div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-base-background-color has-text-color has-background" style="border-radius:999px;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">Parler à un conseiller</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"textColor":"base","style":{"border":{"radius":"999px","width":"1px","style":"solid"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}},"borderColor":"base","className":"is-style-outline"} -->
      <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-base-color has-text-color" style="border-radius:999px;border-width:1px;border-style:solid;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">Découvrir les offres</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->
</section>
<!-- /wp:group -->
