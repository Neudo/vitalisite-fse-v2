<?php
/**
 * Title: Formulaire de contact — Image + Formulaire
 * Slug: vitalisite-fse/contact-form-v3
 * Description: Formulaire de contact avec image à gauche et formulaire à droite en desktop.
 * Categories: vitalisite-contact
 * Keywords: contact, formulaire, form, email, image
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-contact-v3-section vitalisite-section full-section"} -->
<section class="wp-block-group vitalisite-contact-v3-section vitalisite-section full-section">

    <!-- wp:columns {"verticalAlignment":"center","className":"vitalisite-contact-v3__columns"} -->
    <div class="wp-block-columns are-vertically-aligned-center vitalisite-contact-v3__columns">

        <!-- wp:column {"width":"50%","className":"vitalisite-contact-v3__image"} -->
        <div class="wp-block-column vitalisite-contact-v3__image" style="flex-basis:50%">

            <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"vitalisite-contact-v3__img"} -->
            <figure class="wp-block-image size-large vitalisite-contact-v3__img">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&q=80" alt="Équipe médicale" />
            </figure>
            <!-- /wp:image -->

        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"50%","className":"vitalisite-contact-v3__content"} -->
        <div class="wp-block-column vitalisite-contact-v3__content" style="flex-basis:50%">

            <!-- wp:heading {"level":2} -->
            <h2 class="wp-block-heading">Nous contacter</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph -->
            <p>Une question ? N'hésitez pas à nous envoyer un message, nous vous répondrons dans les plus brefs délais.</p>
            <!-- /wp:paragraph -->

            <!-- wp:vitalisite-fse/contact-form /-->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</section>
<!-- /wp:group -->
