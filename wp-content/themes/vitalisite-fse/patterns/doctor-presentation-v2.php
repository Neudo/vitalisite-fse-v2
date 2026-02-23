<?php
/**
 * Title: Présentation docteur (Moderne)
 * Slug: vitalisite-fse/doctor-presentation-v2
 * Description: Section de présentation du praticien avec un design moderne (image à gauche, texte à droite).
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
            <!-- wp:image {"aspectRatio":"4/5","scale":"cover","className":"vitalisite-doctor-card-v2__avatar"} -->
            <figure class="wp-block-image vitalisite-doctor-card-v2__avatar"><img alt="Photo du praticien" style="aspect-ratio:4/5;object-fit:cover"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
        <div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--60);flex-basis:55%">
            
            <!-- wp:group {"className":"vitalisite-doctor-card-v2__content","layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group vitalisite-doctor-card-v2__content">
                
                <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                <div class="wp-block-group">
                    <!-- wp:heading {"level":3,"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"className":"vitalisite-doctor-card-v2__name"} -->
                    <h3 class="wp-block-heading vitalisite-doctor-card-v2__name" style="font-style:normal;font-weight:700">Dr. Prénom Nom</h3>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"className":"vitalisite-doctor-card-v2__specialty"} -->
                    <p class="vitalisite-doctor-card-v2__specialty">Spécialité — Diplôme</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->

                <!-- wp:paragraph {"className":"vitalisite-doctor-card-v2__description"} -->
                <p class="vitalisite-doctor-card-v2__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Passionné par son métier, il accompagne ses patients avec bienveillance et expertise depuis plus de 10 ans.</p>
                <!-- /wp:paragraph -->

                <!-- wp:buttons {"className":"mt-20"} -->
                <div class="wp-block-buttons mt-20">
                    <!-- wp:button {"className":"btn-primary"} -->
                    <div class="wp-block-button btn-primary"><a class="wp-block-button__link wp-element-button" href="#">Prendre rendez-vous</a></div>
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
