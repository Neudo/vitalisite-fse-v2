<?php
/**
 * Title: Formulaire de contact — Style Vitalisite
 * Slug: vitalisite-fse/contact-form-v2
 * Description: Formulaire de contact avec fond coloré, infos pratiques à gauche et formulaire à droite.
 * Categories: vitalisite-contact
 * Keywords: contact, formulaire, form, email, style
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-contact-v2-section vitalisite-section full-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-contact-v2-section vitalisite-section full-section">

    <!-- wp:columns {"verticalAlignment":"stretch","className":"vitalisite-contact-v2__columns"} -->
    <div class="wp-block-columns are-vertically-aligned-stretch vitalisite-contact-v2__columns">

        <!-- wp:column {"width":"40%","className":"vitalisite-contact-v2__info"} -->
        <div class="wp-block-column vitalisite-contact-v2__info" style="flex-basis:40%">

            <!-- wp:heading {"level":2} -->
            <h2 class="wp-block-heading">Nous contacter</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"vitalisite-contact-v2__lead"} -->
            <p class="vitalisite-contact-v2__lead">Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner.</p>
            <!-- /wp:paragraph -->

            <!-- wp:group {"className":"vitalisite-contact-v2__details","layout":{"type":"flex","flexWrap":"nowrap","orientation":"vertical"}} -->
            <div class="wp-block-group vitalisite-contact-v2__details">

                <!-- wp:group {"className":"vitalisite-contact-v2__detail-item icon-map-pin","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group vitalisite-contact-v2__detail-item icon-map-pin">
                    <!-- wp:paragraph -->
                    <p>12 rue de la Santé, 75014 Paris</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->

                <!-- wp:group {"className":"vitalisite-contact-v2__detail-item icon-phone","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group vitalisite-contact-v2__detail-item icon-phone">
                    <!-- wp:paragraph -->
                    <p>01 42 42 42 42</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->

                <!-- wp:group {"className":"vitalisite-contact-v2__detail-item icon-clock","layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group vitalisite-contact-v2__detail-item icon-clock">
                    <!-- wp:paragraph -->
                    <p>Lun – Ven : 9h – 19h<br>Sam : 9h – 13h</p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:group -->

            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"60%","className":"vitalisite-contact-v2__form"} -->
        <div class="wp-block-column vitalisite-contact-v2__form" style="flex-basis:60%">

            <!-- wp:vitalisite-fse/contact-form /-->

        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</section>
<!-- /wp:group -->
