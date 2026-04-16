<?php
/**
 * Title: Presentation praticien - Carte superposee
 * Slug: vitalisite-fse/doctor-presentation-skills
 * Description: Presentation du praticien avec grand visuel et carte superposee pour un rendu premium et tres editorial.
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
            <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"vitalisite-doctor-cover__photo reveal-y"} -->
            <figure class="wp-block-image size-large vitalisite-doctor-cover__photo reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-3.jpg' ) ); ?>" alt="Photo du praticien"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center","width":"50%","className":"vitalisite-doctor-cover__right reveal-y"} -->
        <div class="wp-block-column is-vertically-aligned-center vitalisite-doctor-cover__right reveal-y" style="flex-basis:50%">

            <!-- wp:group {"backgroundColor":"primary","className":"vitalisite-doctor-cover__card","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}}} -->
            <div class="wp-block-group vitalisite-doctor-cover__card has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60)">

                <!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700","lineHeight":"1.1"}}} -->
                <h2 class="wp-block-heading" style="font-weight:700;line-height:1.1">Dr. Prenom Nom</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"className":"vitalisite-doctor-cover__specialty"} -->
                <p class="vitalisite-doctor-cover__specialty">Specialite du cabinet</p>
                <!-- /wp:paragraph -->

                <!-- wp:separator {"className":"vitalisite-doctor-cover__divider"} -->
                <hr class="wp-block-separator vitalisite-doctor-cover__divider"/>
                <!-- /wp:separator -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <p style="line-height:1.8">Je peux utiliser cette variante pour valoriser ma specialite, ma posture de soin et une image de cabinet plus haut de gamme.</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <p style="line-height:1.8">J'y presente mon approche, mes valeurs, mon cadre de consultation et la qualite du suivi propose aux patients.</p>
                <!-- /wp:paragraph -->

                <!-- wp:buttons -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"className":"btn-on-primary"} -->
                    <div class="wp-block-button btn-on-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->

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
