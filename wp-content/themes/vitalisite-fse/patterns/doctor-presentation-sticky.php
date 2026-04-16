<?php
/**
 * Title: Presentation praticien - Galerie
 * Slug: vitalisite-fse/doctor-presentation-sticky
 * Description: Presentation immersive avec texte a gauche et galerie a droite pour valoriser le cadre de consultation.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, sticky, moderne, scroll, défilement
 */
?>
<!-- wp:group {"tagName":"section","align":"full","backgroundColor":"primary","textColor":"on-primary","className":"vitalisite-section full-section vitalisite-doctor-sticky","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section full-section vitalisite-doctor-sticky has-on-primary-color has-primary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
    <!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"className":"vitalisite-doctor-sticky__layout"} -->
    <div class="wp-block-columns alignwide vitalisite-doctor-sticky__layout">
        
        <!-- wp:column {"width":"45%","className":"vitalisite-doctor-sticky__content reveal-y"} -->
        <div class="wp-block-column vitalisite-doctor-sticky__content reveal-y" style="flex-basis:45%">
            <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group">
                <!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700","fontSize":"clamp(2rem, 5vw, 3rem)","lineHeight":"1.1"}}} -->
                <h2 class="wp-block-heading" style="font-size:clamp(2rem, 5vw, 3rem);font-weight:700;line-height:1.1">Dr. Prenom Nom</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"2px","fontWeight":"600"},"color":{"text":"var(--wp--preset--color--on-primary)"},"css":"opacity:0.8"}} -->
                <p style="font-weight:600;letter-spacing:2px;text-transform:uppercase;opacity:0.8">Specialite du cabinet</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.7","fontSize":"1.1rem"}}} -->
                <p style="font-size:1.1rem;line-height:1.7">Je peux mettre en avant ici l'experience de consultation, l'environnement du cabinet et la qualite de l'accompagnement propose dans la duree.</p>
                <!-- /wp:paragraph -->

                <!-- wp:list {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <ul class="wp-block-list" style="line-height:1.8">
                    <li>Accueil attentif et informations claires a chaque rendez-vous</li>
                    <li>Prise en charge adaptee au rythme et aux besoins du patient</li>
                    <li>Cadre professionnel, apaisant et facile a comprendre</li>
                </ul>
                <!-- /wp:list -->

                <!-- wp:buttons -->
                <div class="wp-block-buttons">
                    <!-- wp:button {"className":"btn-on-primary"} -->
                    <div class="wp-block-button btn-on-primary"><a class="wp-block-button__link">Me contacter</a></div>
                    <!-- /wp:button -->
                </div>
                <!-- /wp:buttons -->

                <!-- wp:shortcode -->
                [vitalisite_social_links]
                <!-- /wp:shortcode -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"55%","className":"vitalisite-doctor-sticky__images"} -->
        <div class="wp-block-column vitalisite-doctor-sticky__images" style="flex-basis:55%">
            <!-- wp:image {"aspectRatio":"3/4","scale":"cover","className":"vitalisite-doctor-sticky__img reveal-y"} -->
            <figure class="wp-block-image vitalisite-doctor-sticky__img reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-3.jpg' ) ); ?>" alt="Salle de consultation du cabinet" style="aspect-ratio:3/4;object-fit:cover"/></figure>
            <!-- /wp:image -->

            <!-- wp:image {"aspectRatio":"3/4","scale":"cover","className":"vitalisite-doctor-sticky__img reveal-y"} -->
            <figure class="wp-block-image vitalisite-doctor-sticky__img reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-4.jpg' ) ); ?>" alt="Materiel et espace d'accueil du cabinet" style="aspect-ratio:3/4;object-fit:cover"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->
        
    </div>
    <!-- /wp:columns -->
</section>
<!-- /wp:group -->
