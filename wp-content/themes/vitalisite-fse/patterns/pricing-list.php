<?php
/**
 * Title: Tarifs detailles
 * Slug: vitalisite-fse/pricing-list
 * Description: Section de tarifs detaillee pour decrire clairement les actes et consultations proposes.
 * Categories: vitalisite-pricing
 * Keywords: pricing, tarifs, prix, liste, praticien, detail
 */

?>
<!-- wp:group {"tagName":"section","className":"vitalisite-pricing-section vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-pricing-section vitalisite-section">

    <!-- wp:group {"className":"mb-60","layout":{"type":"constrained"}} -->
    <div class="wp-block-group mb-60">
        <!-- wp:heading {"textAlign":"center","level":2,"className":"reveal-y"} -->
        <h2 class="wp-block-heading has-text-align-center reveal-y">Honoraires et consultations</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","className":"reveal-y"} -->
        <p class="has-text-align-center reveal-y">Je detaille ici mes consultations pour permettre une lecture simple des modalites et des tarifs.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:vitalisite-fse/pricing-list -->
    <div class="wp-block-vitalisite-fse-pricing-list vitalisite-pricing-list reveal-stagger">
        <!-- wp:vitalisite-fse/pricing-item {"title":"Premiere consultation","description":"Ce premier rendez-vous permet de faire le point sur votre situation, d'identifier vos besoins et de definir une prise en charge claire. C'est le temps ideal pour presenter le contexte, poser vos questions et construire un accompagnement adapte.","price":"80€","buttonText":"Prendre rendez-vous","buttonUrl":""} /-->

        <!-- wp:vitalisite-fse/pricing-item {"title":"Consultation de suivi","description":"Destinee aux patients deja suivis, cette consultation permet d'ajuster l'accompagnement, de faire le point sur l'evolution des symptomes et de proposer des recommandations concretes entre deux rendez-vous.","price":"60€","buttonText":"Prendre rendez-vous","buttonUrl":""} /-->

        <!-- wp:vitalisite-fse/pricing-item {"title":"Bilan approfondi ou acte specifique","description":"Cette formule convient lorsque la situation demande davantage de temps d'analyse, un bilan plus complet ou un accompagnement cible. Elle permet de valoriser un acte plus technique tout en restant tres lisible pour le patient.","price":"95€","buttonText":"Me contacter","buttonUrl":""} /-->
    </div>
    <!-- /wp:vitalisite-fse/pricing-list -->

</section>
<!-- /wp:group -->
