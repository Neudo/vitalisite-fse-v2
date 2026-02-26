<?php
/**
 * Title: Présentation docteur (Cover + Carte)
 * Slug: vitalisite-fse/doctor-presentation-skills
 * Description: Présentation du praticien avec grande photo à gauche et carte de présentation venant se superposer sur l'image, avec réseaux sociaux en bas.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, cover, carte, réseaux sociaux, moderne
 */
?>

<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-section vitalisite-doctor-cover","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section vitalisite-doctor-cover" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

    <!-- wp:columns {"align":"wide","verticalAlignment":"center","className":"vitalisite-doctor-cover__layout","style":{"spacing":{"blockGap":{"left":"0"}}}} -->
    <div class="wp-block-columns alignwide are-vertically-aligned-center vitalisite-doctor-cover__layout">

        <!-- wp:column {"verticalAlignment":"center","width":"55%","className":"vitalisite-doctor-cover__photo-col"} -->
        <div class="wp-block-column is-vertically-aligned-center vitalisite-doctor-cover__photo-col" style="flex-basis:55%">
            <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"vitalisite-doctor-cover__photo"} -->
            <figure class="wp-block-image size-large vitalisite-doctor-cover__photo"><img alt="Photo du praticien"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center","width":"50%","className":"vitalisite-doctor-cover__right"} -->
        <div class="wp-block-column is-vertically-aligned-center vitalisite-doctor-cover__right" style="flex-basis:50%">

            <!-- wp:group {"backgroundColor":"primary","className":"vitalisite-doctor-cover__card","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}}} -->
            <div class="wp-block-group vitalisite-doctor-cover__card has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60)">

                <!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700","lineHeight":"1.1"}}} -->
                <h2 class="wp-block-heading" style="font-weight:700;line-height:1.1">Dr. Prénom Nom</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"vitalisite-doctor-cover__specialty"} -->
                <p class="vitalisite-doctor-cover__specialty">Spécialité — Diplôme</p>
                <!-- /wp:paragraph -->

                <!-- wp:separator {"className":"vitalisite-doctor-cover__divider"} -->
                <hr class="wp-block-separator vitalisite-doctor-cover__divider"/>
                <!-- /wp:separator -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <p style="line-height:1.8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Passionné par son métier, il accompagne ses patients avec bienveillance et expertise depuis plus de 10 ans.</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <p style="line-height:1.8">Son approche combine rigueur scientifique et écoute attentive pour un suivi personnalisé et de qualité.</p>
                <!-- /wp:paragraph -->

            </div>
            <!-- /wp:group -->

            <!-- wp:shortcode -->
            [vitalisite_social_links]
            <!-- /wp:shortcode -->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</section>
<!-- /wp:group -->
