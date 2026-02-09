<?php
/**
 * Title: Cartes (Legacy Style)
 * Slug: vitalisite-fse/cards
 * Description: Grille de 3 cartes avec titre, texte et bouton (style bordé)
 * Categories: vitalisite-cards, vitalisite-blocks
 * Keywords: cards, grid, feature, services
 */
?>

<!-- wp:group {"tagName":"section","className":"vitalisite-cards-section vitalisite-section"} -->
<section class="wp-block-group vitalisite-cards-section vitalisite-section">

    <!-- wp:group {"className":"mb-60","layout":{"type":"constrained"}} -->
    <div class="wp-block-group mb-60">
        <!-- wp:heading {"textAlign":"center","level":2} -->
        <h2 class="wp-block-heading has-text-align-center">Nos Services ici</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:vitalisite-fse/cards-container -->
    <div class="wp-block-vitalisite-fse-cards-container vitalisite-cards-grid">

        <!-- wp:vitalisite-fse/card {"title":"Consultation","description":"Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.","ctaText":"En savoir plus","ctaUrl":"#"} -->
        <div class="wp-block-vitalisite-fse-card vitalisite-card">
            <h3 class="wp-block-heading" style="font-weight:300">Consultation</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            <div class="wp-block-buttons"><div class="wp-block-button is-style-outline"><a class="wp-block-button__link" href="#">En savoir plus</a></div></div>
        </div>
        <!-- /wp:vitalisite-fse/card -->

        <!-- wp:vitalisite-fse/card {"title":"Urgences","description":"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.","ctaText":"En savoir plus","ctaUrl":"#"} -->
        <div class="wp-block-vitalisite-fse-card vitalisite-card">
            <h3 class="wp-block-heading" style="font-weight:300">Urgences</h3>
            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
            <div class="wp-block-buttons"><div class="wp-block-button is-style-outline"><a class="wp-block-button__link" href="#">En savoir plus</a></div></div>
        </div>
        <!-- /wp:vitalisite-fse/card -->

    </div>
    <!-- /wp:vitalisite-fse/cards-container -->

</section>
<!-- /wp:group -->
