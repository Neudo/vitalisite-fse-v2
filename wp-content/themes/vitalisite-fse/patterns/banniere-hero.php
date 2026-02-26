<?php
/**
 * Title: Bannière Hero (Image + Texte)
 * Slug: vitalisite-fse/banniere-hero
 * Description: Section hero avec image de fond, filtre sombre pour lisibilité, titre, sous-titre et texte.
 * Categories: banniere-vitalisite
 * Keywords: banniere, hero, image, fond, cover, overlay
 */
?>

<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-section full-section vitalisite-hero-cover-wrapper","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"20px","right":"20px"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section full-section vitalisite-hero-cover-wrapper" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:20px;padding-right:20px">

    <!-- wp:cover {"tagName":"div","dimRatio":35,"minHeight":60,"minHeightUnit":"vh","className":"vitalisite-hero-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"border":{"radius":"var:preset|custom|image-radius"}},"layout":{"type":"constrained"}} -->
    <div class="wp-block-cover vitalisite-hero-cover" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);min-height:60vh;border-radius:var(--wp--preset--custom--image-radius)">
        <span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="background-color:#000;opacity:0.35"></span>
        <div class="wp-block-cover__inner-container">

            <!-- wp:group {"className":"vitalisite-hero-cover__content","layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group vitalisite-hero-cover__content">

                <!-- wp:heading {"level":1,"style":{"typography":{"fontWeight":"700","lineHeight":"1.1"}}} -->
                <h1 class="wp-block-heading" style="font-weight:700;line-height:1.1">Titre principal de la section</h1>
                <!-- /wp:heading -->

                <!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"400","fontSize":"1.3rem"}}} -->
                <h2 class="wp-block-heading" style="font-weight:400;font-size:1.3rem">Sous-titre ou spécialité du praticien</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <p style="line-height:1.8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <!-- /wp:paragraph -->

            </div>
            <!-- /wp:group -->

        </div>
    </div>
    <!-- /wp:cover -->

</section>
<!-- /wp:group -->
