<?php
/**
 * Title: Accordéon Vitalisite (Boxed)
 * Slug: vitalisite-fse/accordion-vitalisite
 * Description: Variante style "Boxed" avec entêtes colorés
 * Categories: vitalisite-accordion
 * Keywords: faq, accordion, details, box, vitalisite
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-accordion-wrapper accordion-bg vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-accordion-wrapper accordion-bg vitalisite-section">

    <!-- wp:heading {"textAlign":"center","level":2,"className":"mb-60"} -->
    <h2 class="wp-block-heading has-text-align-center">Questions & Réponses</h2>
    <!-- /wp:heading -->

    <!-- wp:vitalisite-fse/accordion {"variant":"legacy"} -->
    <div class="wp-block-vitalisite-fse-accordion vitalisite-accordion-container vitalisite-accordion-variant-legacy">
        
        <!-- wp:vitalisite-fse/accordion-item {"summary":"Lorem ipsum dolor sit amet ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item">
            <summary>Lorem ipsum dolor sit amet ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

        <!-- wp:vitalisite-fse/accordion-item {"summary":"Ut enim ad minim veniam ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item">
            <summary>Ut enim ad minim veniam ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

    </div>
    <!-- /wp:vitalisite-fse/accordion -->

</section>
<!-- /wp:group -->
