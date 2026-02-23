<?php
/**
 * Title: Présentation docteur
 * Slug: vitalisite-fse/doctor-presentation
 * Description: Section de présentation du praticien avec photo, nom, description et CTA.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, doctor, praticien, equipe
 */

?>

<!-- wp:group {"tagName":"section","className":"vitalisite-doctor-section vitalisite-section"} -->
<section class="wp-block-group vitalisite-doctor-section vitalisite-section">

    <!-- wp:group {"className":"vitalisite-doctor-card","layout":{"contentSize":"700px"}} -->
    <div class="wp-block-group vitalisite-doctor-card">

        <!-- wp:image {"align":"center","width":"180px","height":"180px","scale":"cover","className":"vitalisite-doctor-card__avatar"} -->
        <figure class="wp-block-image aligncenter is-resized vitalisite-doctor-card__avatar"><img alt="Photo du praticien" style="object-fit:cover;width:180px;height:180px"/></figure>
        <!-- /wp:image -->

        <!-- wp:heading {"textAlign":"center","level":3} -->
        <h3 class="wp-block-heading has-text-align-center">Dr. Prénom Nom</h3>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-card__specialty"} -->
        <p class="has-text-align-center vitalisite-doctor-card__specialty">Spécialité — Diplôme</p>
        <!-- /wp:paragraph -->

        <!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Passionné par son métier, il accompagne ses patients avec bienveillance et expertise depuis plus de 10 ans.</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"mt-40"} -->
        <div class="wp-block-buttons mt-40">
            <!-- wp:button {"className":"btn-primary"} -->
            <div class="wp-block-button btn-primary"><a class="wp-block-button__link" href="#">Prendre rendez-vous</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

    </div>
    <!-- /wp:group -->

</section>
<!-- /wp:group -->
