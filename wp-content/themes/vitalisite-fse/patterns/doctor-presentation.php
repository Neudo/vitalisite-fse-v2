<?php
/**
 * Title: Présentation docteur (Carte Profil)
 * Slug: vitalisite-fse/doctor-presentation
 * Description: Présentation du praticien sous forme de carte profil centrée, avec photo, badges de stats, biographie et CTA.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, doctor, praticien, profil, carte, stats
 */
?>

<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

    <!-- wp:group {"align":"wide","className":"vitalisite-doctor-profile reveal-y"} -->
    <div class="wp-block-group alignwide vitalisite-doctor-profile reveal-y">

        <!-- wp:image {"aspectRatio":"1","scale":"cover","align":"center","className":"vitalisite-doctor-profile__avatar"} -->
        <figure class="wp-block-image aligncenter vitalisite-doctor-profile__avatar"><img alt="Portrait du praticien" style="aspect-ratio:1;object-fit:cover"/></figure>
        <!-- /wp:image -->

        <!-- wp:shortcode -->
        [vitalisite_social_links]
        <!-- /wp:shortcode -->

        <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"}}} -->
        <h2 class="wp-block-heading has-text-align-center" style="font-weight:700">Dr. Prénom Nom</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","textColor":"primary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"2px","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}}}} -->
        <p class="has-text-align-center has-primary-color has-text-color" style="font-weight:600;letter-spacing:2px;text-transform:uppercase;margin-top:var(--wp--preset--spacing--30);margin-bottom:0">Spécialité — Diplôme</p>
        <!-- /wp:paragraph -->

        <!-- wp:group {"className":"vitalisite-doctor-profile__stats","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
        <div class="wp-block-group vitalisite-doctor-profile__stats">

            <!-- wp:group {"className":"vitalisite-doctor-profile__badge","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group vitalisite-doctor-profile__badge">
                <!-- wp:heading {"textAlign":"center","level":3,"className":"vitalisite-doctor-profile__badge-number"} -->
                <h3 class="wp-block-heading has-text-align-center vitalisite-doctor-profile__badge-number">10+</h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-profile__badge-label"} -->
                <p class="has-text-align-center vitalisite-doctor-profile__badge-label">Années d'expérience</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"vitalisite-doctor-profile__badge","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group vitalisite-doctor-profile__badge">
                <!-- wp:heading {"textAlign":"center","level":3,"className":"vitalisite-doctor-profile__badge-number"} -->
                <h3 class="wp-block-heading has-text-align-center vitalisite-doctor-profile__badge-number">500+</h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-profile__badge-label"} -->
                <p class="has-text-align-center vitalisite-doctor-profile__badge-label">Patients accompagnés</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"vitalisite-doctor-profile__badge","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group vitalisite-doctor-profile__badge">
                <!-- wp:heading {"textAlign":"center","level":3,"className":"vitalisite-doctor-profile__badge-number"} -->
                <h3 class="wp-block-heading has-text-align-center vitalisite-doctor-profile__badge-number">3</h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-profile__badge-label"} -->
                <p class="has-text-align-center vitalisite-doctor-profile__badge-label">Diplômes spécialisés</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:group -->

        <!-- wp:paragraph {"align":"center","textColor":"muted","style":{"typography":{"lineHeight":"1.8"}}} -->
        <p class="has-text-align-center has-muted-color has-text-color" style="line-height:1.8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Passionné par son métier, il accompagne ses patients avec bienveillance et expertise depuis plus de 10 ans. Son approche combine rigueur scientifique et écoute attentive.</p>
        <!-- /wp:paragraph -->

    </div>
    <!-- /wp:group -->

</section>
<!-- /wp:group -->
