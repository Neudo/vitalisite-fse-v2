<?php
/**
 * Title: Accordéon FAQ (Simple)
 * Slug: vitalisite-fse/accordion-faq
 * Description: Liste de questions fréquentes style minimaliste
 * Categories: vitalisite-accordion
 * Keywords: faq, accordion, details, questions
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-accordion-wrapper vitalisite-accordion-variant-simple vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-accordion-wrapper vitalisite-accordion-variant-simple vitalisite-section">

    <!-- wp:heading {"textAlign":"center","level":2,"className":"mb-60 reveal-y"} -->
        <h2 class="wp-block-heading has-text-align-center reveal-y">Questions frequentes</h2>
    <!-- /wp:heading -->

    <!-- wp:vitalisite-fse/accordion {"variant":"simple"} -->
    <div class="wp-block-vitalisite-fse-accordion vitalisite-accordion-container">
        
        <!-- wp:vitalisite-fse/accordion-item {"summary":"Quand puis-je prendre rendez-vous ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item reveal-y">
            <summary>Quand puis-je prendre rendez-vous ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Utilisez cette reponse pour expliquer simplement vos modalites de prise de rendez-vous, vos delais moyens et vos canaux de contact.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

        <!-- wp:vitalisite-fse/accordion-item {"summary":"Faut-il preparer quelque chose avant la consultation ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item reveal-y">
            <summary>Faut-il preparer quelque chose avant la consultation ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Cette question est ideale pour indiquer les documents utiles, les informations a apporter ou les recommandations avant un premier rendez-vous.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

        <!-- wp:vitalisite-fse/accordion-item {"summary":"Comment se deroule le suivi ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item reveal-y">
            <summary>Comment se deroule le suivi ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Vous pouvez preciser ici le rythme des consultations, les conseils donnes entre deux rendez-vous et la logique globale de votre accompagnement.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

    </div>
    <!-- /wp:vitalisite-fse/accordion -->

</section>
<!-- /wp:group -->
