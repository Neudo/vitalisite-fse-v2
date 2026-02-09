<?php
/**
 * Title: Accordéon FAQ (Simple)
 * Slug: vitalisite-fse/accordion-faq
 * Description: Liste de questions fréquentes style minimaliste
 * Categories: vitalisite-accordion, vitalisite-blocks
 * Keywords: faq, accordion, details, questions
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-accordion-wrapper vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-accordion-wrapper vitalisite-section">

    <!-- wp:heading {"textAlign":"center","level":2,"className":"mb-60"} -->
    <h2 class="wp-block-heading has-text-align-center">Questions Fréquentes</h2>
    <!-- /wp:heading -->

    <!-- wp:group {"layout":{"type":"default"}} -->
    <div class="wp-block-group">
        
        <!-- wp:details {"className":"vitalisite-accordion-item","showContent":true} -->
        <details class="wp-block-details vitalisite-accordion-item" open>
            <summary>Lorem ipsum dolor sit amet ?</summary>
            <!-- wp:paragraph -->
            <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.</p>
            <!-- /wp:paragraph -->
        </details>
        <!-- /wp:details -->

        <!-- wp:details {"className":"vitalisite-accordion-item"} -->
        <details class="wp-block-details vitalisite-accordion-item">
            <summary>Duis aute irure dolor in reprehenderit ?</summary>
            <!-- wp:paragraph -->
            <p>Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.</p>
            <!-- /wp:paragraph -->
        </details>
        <!-- /wp:details -->

        <!-- wp:details {"className":"vitalisite-accordion-item"} -->
        <details class="wp-block-details vitalisite-accordion-item">
            <summary>Excepteur sint occaecat cupidatat non proident ?</summary>
            <!-- wp:paragraph -->
            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque.</p>
            <!-- /wp:paragraph -->
        </details>
        <!-- /wp:details -->

    </div>
    <!-- /wp:group -->

</section>
<!-- /wp:group -->
