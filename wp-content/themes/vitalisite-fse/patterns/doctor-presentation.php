<?php
/**
 * Title: Presentation praticien - Carte profil
 * Slug: vitalisite-fse/doctor-presentation
 * Description: Carte profil centree pour presenter un praticien de facon sobre, claire et rassurante.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, doctor, praticien, profil, carte, stats
 */
?>

<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

    <!-- wp:group {"align":"wide","className":"vitalisite-doctor-profile reveal-y"} -->
    <div class="wp-block-group alignwide vitalisite-doctor-profile reveal-y">

        <!-- wp:image {"aspectRatio":"1","scale":"cover","align":"center","className":"vitalisite-doctor-profile__avatar"} -->
        <figure class="wp-block-image aligncenter vitalisite-doctor-profile__avatar"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-slider-4.jpg' ) ); ?>" alt="Portrait du praticien" style="aspect-ratio:1;object-fit:cover"/></figure>
        <!-- /wp:image -->

        <!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontWeight":"700"}}} -->
        <h2 class="wp-block-heading has-text-align-center" style="font-weight:700">Dr. Prenom Nom</h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","textColor":"primary","style":{"typography":{"textTransform":"uppercase","letterSpacing":"2px","fontWeight":"600"},"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}}}} -->
        <p class="has-text-align-center has-primary-color has-text-color" style="font-weight:600;letter-spacing:2px;text-transform:uppercase;margin-top:var(--wp--preset--spacing--30);margin-bottom:0">Specialite du cabinet</p>
        <!-- /wp:paragraph -->

        <!-- wp:group {"className":"vitalisite-doctor-profile__stats","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
        <div class="wp-block-group vitalisite-doctor-profile__stats">

            <!-- wp:group {"className":"vitalisite-doctor-profile__badge","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group vitalisite-doctor-profile__badge">
                <!-- wp:heading {"textAlign":"center","level":3,"className":"vitalisite-doctor-profile__badge-number"} -->
                <h3 class="wp-block-heading has-text-align-center vitalisite-doctor-profile__badge-number">Ecoute</h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-profile__badge-label"} -->
                <p class="has-text-align-center vitalisite-doctor-profile__badge-label">Temps d'echange et prise en charge personnalisee</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"vitalisite-doctor-profile__badge","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group vitalisite-doctor-profile__badge">
                <!-- wp:heading {"textAlign":"center","level":3,"className":"vitalisite-doctor-profile__badge-number"} -->
                <h3 class="wp-block-heading has-text-align-center vitalisite-doctor-profile__badge-number">Rigueur</h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-profile__badge-label"} -->
                <p class="has-text-align-center vitalisite-doctor-profile__badge-label">Evaluation attentive et informations claires</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

            <!-- wp:group {"className":"vitalisite-doctor-profile__badge","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group vitalisite-doctor-profile__badge">
                <!-- wp:heading {"textAlign":"center","level":3,"className":"vitalisite-doctor-profile__badge-number"} -->
                <h3 class="wp-block-heading has-text-align-center vitalisite-doctor-profile__badge-number">Suivi</h3>
                <!-- /wp:heading -->
                <!-- wp:paragraph {"align":"center","className":"vitalisite-doctor-profile__badge-label"} -->
                <p class="has-text-align-center vitalisite-doctor-profile__badge-label">Accompagnement adapte a chaque situation</p>
                <!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->

        </div>
        <!-- /wp:group -->

        <!-- wp:paragraph {"align":"center","className":"reveal-y","textColor":"muted","style":{"typography":{"lineHeight":"1.8"}}} -->
        <p class="has-text-align-center has-muted-color has-text-color reveal-y" style="line-height:1.8">Je presente ici mon parcours, mon approche et ce qui peut rassurer mes patients au premier contact. Cette version reste volontairement sobre pour convenir a de nombreuses specialites de sante.</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"reveal-y"} -->
        <div class="wp-block-buttons reveal-y">
            <!-- wp:button {"className":"btn-primary"} -->
            <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

        <!-- wp:shortcode -->
        [vitalisite_social_links]
        <!-- /wp:shortcode -->

    </div>
    <!-- /wp:group -->

</section>
<!-- /wp:group -->
