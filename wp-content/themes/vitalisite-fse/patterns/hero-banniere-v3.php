<?php
/**
 * Title: Héro bannière avec image en bas
 * Slug: vitalisite-fse/hero-banniere-v3
 * Categories: banniere-vitalisite
 * Keywords: hero, banniere, cta, accueil
 * Block Types: core/group
 * Description: Bannière avec image en bas, titre, description et CTA.
 */
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"64px","bottom":"64px"}}}} -->
<section class="wp-block-group" style="padding-top:64px;padding-bottom:64px">
  <!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"16px"}}} -->
  <div class="wp-block-group">
    <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"clamp(2.25rem, 3vw + 1rem, 3.75rem)","lineHeight":"1.1"}}} -->
    <h1 style="font-size:clamp(2.25rem, 3vw + 1rem, 3.75rem);line-height:1.1">Un accueil soigné dès le premier regard</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"top":"8px"}}}} -->
    <p style="margin-top:8px;font-size:1.125rem">Créez une section héro élégante avec un message rassurant, puis illustrez vos services avec une image pleine largeur placée sous le contenu.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"24px"}}}} -->
    <div class="wp-block-buttons" style="margin-top:24px">
      <!-- wp:button {"backgroundColor":"primary","textColor":"base","style":{"border":{"radius":"999px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}}} -->
      <div class="wp-block-button"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background" style="border-radius:999px;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">Demander un devis</a></div>
      <!-- /wp:button -->

      <!-- wp:button {"textColor":"ink","style":{"border":{"radius":"999px","width":"1px","style":"solid"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}},"borderColor":"ink","className":"is-style-outline"} -->
      <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ink-color has-text-color" style="border-radius:999px;border-width:1px;border-style:solid;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">Voir les prestations</a></div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
  </div>
  <!-- /wp:group -->

  <!-- wp:spacer {"height":"32px"} -->
  <div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
  <!-- /wp:spacer -->

  <!-- wp:image {"sizeSlug":"large"} -->
  <figure class="wp-block-image size-large"><img src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?w=1600" alt="Équipe médicale en discussion" /></figure>
  <!-- /wp:image -->
</section>
<!-- /wp:group -->
