<?php
/**
 * Title: Accordéon FAQ (Simple)
 * Slug: vitalisite-fse/accordion-faq
 * Description: Liste de questions fréquentes style minimaliste
 * Categories: vitalisite-accordion
 * Keywords: faq, accordion, details, questions
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-accordion-wrapper vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-accordion-wrapper vitalisite-section">

    <!-- wp:heading {"textAlign":"center","level":2,"className":"mb-60"} -->
    <h2 class="wp-block-heading has-text-align-center">Questions Fréquentes</h2>
    <!-- /wp:heading -->

    <!-- wp:vitalisite-fse/accordion {"variant":"simple"} -->
    <div class="wp-block-vitalisite-fse-accordion vitalisite-accordion-container">
        
        <!-- wp:vitalisite-fse/accordion-item {"summary":"Lorem ipsum dolor sit amet ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item">
            <summary>Lorem ipsum dolor sit amet ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

        <!-- wp:vitalisite-fse/accordion-item {"summary":"Duis aute irure dolor in reprehenderit ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item">
            <summary>Duis aute irure dolor in reprehenderit ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

        <!-- wp:vitalisite-fse/accordion-item {"summary":"Excepteur sint occaecat cupidatat non proident ?"} -->
        <details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item">
            <summary>Excepteur sint occaecat cupidatat non proident ?</summary>
            <div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
                <!-- wp:paragraph -->
                <p>Sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque.</p>
                <!-- /wp:paragraph -->
            </div>
        </details>
        <!-- /wp:vitalisite-fse/accordion-item -->

    </div>
    <!-- /wp:vitalisite-fse/accordion -->

</section>
<!-- /wp:group -->
