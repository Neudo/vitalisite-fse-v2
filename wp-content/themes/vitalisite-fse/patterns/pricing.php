<?php
/**
 * Title: Tarifs en cartes
 * Slug: vitalisite-fse/pricing
 * Description: Section de tarifs compacte pour presenter les principaux actes d'un praticien.
 * Categories: vitalisite-pricing
 * Keywords: pricing, tarifs, prix, cards
 */

?>

<!-- wp:group {"tagName":"section","className":"vitalisite-pricing-section vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-pricing-section vitalisite-section">

    <!-- wp:group {"className":"mb-60","layout":{"type":"constrained"}} -->
    <div class="wp-block-group mb-60">
        <!-- wp:heading {"textAlign":"center","level":2} -->
        <h2 class="wp-block-heading has-text-align-center reveal-y">Mes tarifs</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","className":"reveal-y"} -->
        <p class="has-text-align-center reveal-y">Je presente ici mes principaux actes avec une lecture rapide, rassurante et facile a comprendre.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns {"className":"vitalisite-pricing-grid"} -->
    <div class="wp-block-columns vitalisite-pricing-grid reveal-stagger">

        <!-- wp:column {"className":"vitalisite-pricing-card"} -->
        <div class="wp-block-column vitalisite-pricing-card">
            <!-- wp:heading {"textAlign":"center","level":3} -->
            <h3 class="wp-block-heading has-text-align-center reveal-y">Premiere consultation</h3>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","className":"vitalisite-pricing-card__price"} -->
            <p class="has-text-align-center vitalisite-pricing-card__price">80€</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"align":"center","className":"vitalisite-pricing-card__desc"} -->
            <p class="has-text-align-center vitalisite-pricing-card__desc">Temps d'echange, evaluation initiale et proposition d'une prise en charge adaptee.</p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button {"className":"btn-primary"} -->
                <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"vitalisite-pricing-card"} -->
        <div class="wp-block-column vitalisite-pricing-card">
            <!-- wp:heading {"textAlign":"center","level":3} -->
            <h3 class="wp-block-heading has-text-align-center reveal-y">Séance de suivi</h3>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","className":"vitalisite-pricing-card__price"} -->
            <p class="has-text-align-center vitalisite-pricing-card__price">60€</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"align":"center","className":"vitalisite-pricing-card__desc"} -->
            <p class="has-text-align-center vitalisite-pricing-card__desc">Consultation de suivi pour accompagner l'evolution de votre situation.</p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button {"className":"btn-primary"} -->
                <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"className":"vitalisite-pricing-card"} -->
        <div class="wp-block-column vitalisite-pricing-card">
            <!-- wp:heading {"textAlign":"center","level":3} -->
            <h3 class="wp-block-heading has-text-align-center reveal-y">Bilan approfondi</h3>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","className":"vitalisite-pricing-card__price"} -->
            <p class="has-text-align-center vitalisite-pricing-card__price">95€</p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"align":"center","className":"vitalisite-pricing-card__desc"} -->
            <p class="has-text-align-center vitalisite-pricing-card__desc">Rendez-vous plus complet lorsque la situation demande un temps d'analyse supplementaire.</p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button {"className":"btn-primary"} -->
                <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"mt-40 reveal-y"} -->
    <div class="wp-block-buttons mt-40 reveal-y">
        <!-- wp:button {"className":"btn-secondary"} -->
        <div class="wp-block-button btn-secondary"><a class="wp-block-button__link">Voir les tarifs detailles</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

</section>
<!-- /wp:group -->
