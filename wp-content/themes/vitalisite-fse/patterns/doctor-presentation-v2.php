<?php
/**
 * Title: Presentation praticien - Portrait
 * Slug: vitalisite-fse/doctor-presentation-v2
 * Description: Portrait du praticien avec image a gauche et contenu a droite, pour une presentation immediate et elegante.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, doctor, praticien, equipe, moderne
 */

?>

<!-- wp:group {"tagName":"section","className":"vitalisite-doctor-section-v2 vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-doctor-section-v2 vitalisite-section">

    <!-- wp:columns {"verticalAlignment":"center","className":"vitalisite-doctor-card-v2"} -->
    <div class="wp-block-columns are-vertically-aligned-center vitalisite-doctor-card-v2">

        <!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
        <div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
            <!-- wp:image {"aspectRatio":"4/5","scale":"cover","className":"vitalisite-doctor-card-v2__avatar reveal-y"} -->
            <figure class="wp-block-image vitalisite-doctor-card-v2__avatar reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-4.jpg' ) ); ?>" alt="Photo du praticien" style="aspect-ratio:4/5;object-fit:cover"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
        <div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--60);flex-basis:55%">
            
            <!-- wp:group {"className":"vitalisite-doctor-card-v2__content reveal-y","layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group vitalisite-doctor-card-v2__content reveal-y">
                
                <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                <div class="wp-block-group">
                    <!-- wp:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"className":"vitalisite-doctor-card-v2__name"} -->
                    <h3 class="wp-block-heading vitalisite-doctor-card-v2__name" style="font-style:normal;font-weight:700">Dr. Prenom Nom</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"className":"vitalisite-doctor-card-v2__specialty"} -->
                    <p class="vitalisite-doctor-card-v2__specialty">Specialite du cabinet</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->

                <!-- wp:paragraph {"className":"vitalisite-doctor-card-v2__description"} -->
                <p class="vitalisite-doctor-card-v2__description">Je presente ici ma posture de soin, ma relation au patient et les grands axes de mon accompagnement avec un ton simple et professionnel.</p>
                <!-- /wp:paragraph -->

                <!-- wp:buttons {"className":"mt-20"} -->
                <div class="wp-block-buttons mt-20">
                    <!-- wp:button {"className":"btn-primary"} -->
                    <div class="wp-block-button btn-primary"><a class="wp-block-button__link wp-element-button">Prendre rendez-vous</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->

            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</section>
<!-- /wp:group -->
