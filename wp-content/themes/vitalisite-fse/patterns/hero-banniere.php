<?php
/**
 * Title: Héro bannière avec image
 * Slug: vitalisite-fse/hero-banniere
 * Categories: banniere-vitalisite
 * Keywords: hero, banniere, cta, accueil
 * Block Types: core/group, core/cover
 * Description: Bannière avec image, titre, description et deux CTA optionnels.
 */
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"64px","bottom":"64px"}}}} -->
<section class="wp-block-group" style="padding-top:64px;padding-bottom:64px">
  <!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":"48px"}}} -->
  <div class="wp-block-columns are-vertically-aligned-center">
    <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
      <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"clamp(2.25rem, 3vw + 1rem, 3.75rem)","lineHeight":"1.1"}}} -->
      <h1 style="font-size:clamp(2.25rem, 3vw + 1rem, 3.75rem);line-height:1.1">Des soins attentifs, un accompagnement humain</h1>
      <!-- /wp:heading -->

      <!-- wp:paragraph {"style":{"typography":{"fontSize":"1.125rem"},"spacing":{"margin":{"top":"16px"}}}} -->
      <p style="margin-top:16px;font-size:1.125rem">Présentez votre offre de santé ou de bien‑être avec une bannière claire, moderne et rassurante. Mettez en avant votre promesse de valeur en quelques lignes.</p>
      <!-- /wp:paragraph -->

      <!-- wp:buttons {"style":{"spacing":{"margin":{"top":"24px"}}}} -->
      <div class="wp-block-buttons" style="margin-top:24px">
        <!-- wp:button {"backgroundColor":"vital-blue","textColor":"vital-mist","style":{"border":{"radius":"999px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-vital-mist-color has-vital-blue-background-color has-text-color has-background" style="border-radius:999px;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">Prendre rendez‑vous</a></div>
        <!-- /wp:button -->

        <!-- wp:button {"textColor":"vital-ink","style":{"border":{"radius":"999px","width":"1px","style":"solid"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"24px","right":"24px"}}},"borderColor":"vital-ink","className":"is-style-outline"} -->
        <div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-vital-ink-color has-text-color" style="border-radius:999px;border-width:1px;border-style:solid;padding-top:12px;padding-bottom:12px;padding-left:24px;padding-right:24px">Découvrir nos services</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
    <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
      <!-- wp:image {"sizeSlug":"large"} -->
      <figure class="wp-block-image size-large"><img src="https://images.unsplash.com/photo-1526256262350-7da7584cf5eb?w=1200" alt="Équipe médicale souriante" /></figure>
      <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</section>
<!-- /wp:group -->
