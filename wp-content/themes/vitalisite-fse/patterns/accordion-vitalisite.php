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

    <!-- wp:heading {"textAlign":"center","level":2,"className":"mb-60 reveal-y"} -->
        <h2 class="wp-block-heading has-text-align-center reveal-y">Questions et reponses</h2>
    <!-- /wp:heading -->

    <!-- wp:vitalisite-fse/accordion {"variant":"legacy"} -->
    <div class="wp-block-vitalisite-fse-accordion vitalisite-accordion-container vitalisite-accordion-variant-legacy">
        
        <!-- wp:vitalisite-fse/accordion-item {"summary":"Pour quels besoins consulter ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item reveal-y">
            <summary>Pour quels besoins consulter ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Cette premiere question peut servir a presenter les motifs de consultation les plus frequents et les situations pour lesquelles votre cabinet est sollicite.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

        <!-- wp:vitalisite-fse/accordion-item {"summary":"Le cabinet prend-il en charge tous les profils de patients ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item reveal-y">
            <summary>Le cabinet prend-il en charge tous les profils de patients ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Utilisez cette reponse pour preciser votre public, vos specialites et les situations qui peuvent necessiter une orientation complementaire.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

    </div>
    <!-- /wp:vitalisite-fse/accordion -->

</section>
<!-- /wp:group -->
