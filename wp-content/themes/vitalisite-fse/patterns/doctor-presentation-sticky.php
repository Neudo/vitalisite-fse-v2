<?php
/**
 * Title: Présentation docteur (Sticky scroll)
 * Slug: vitalisite-fse/doctor-presentation-sticky
 * Description: Section avec présentation fixée à gauche et galerie défilante à droite.
 * Categories: vitalisite-doctor
 * Keywords: docteur, presentation, sticky, moderne, scroll, défilement
 */
?>
<!-- wp:group {"tagName":"section","align":"full","backgroundColor":"primary","textColor":"on-primary","className":"vitalisite-section full-section vitalisite-doctor-sticky","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section full-section vitalisite-doctor-sticky has-on-primary-color has-primary-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
    <!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"className":"vitalisite-doctor-sticky__layout"} -->
    <div class="wp-block-columns alignwide vitalisite-doctor-sticky__layout">
        
        <!-- wp:column {"width":"45%","className":"vitalisite-doctor-sticky__content"} -->
        <div class="wp-block-column vitalisite-doctor-sticky__content" style="flex-basis:45%">
            <!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
            <div class="wp-block-group">
                <!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700","fontSize":"clamp(2rem, 5vw, 3rem)","lineHeight":"1.1"}}} -->
                <h2 class="wp-block-heading" style="font-size:clamp(2rem, 5vw, 3rem);font-weight:700;line-height:1.1">Dr. Prénom Nom</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"2px","fontWeight":"600"}}} -->
                <p style="font-weight:600;letter-spacing:2px;text-transform:uppercase;opacity:0.8">Spécialité — Diplôme</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.7","fontSize":"1.1rem"}}} -->
                <p style="font-size:1.1rem;line-height:1.7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                <!-- /wp:paragraph -->

                <!-- wp:list {"style":{"typography":{"lineHeight":"1.8"}}} -->
                <ul class="wp-block-list" style="line-height:1.8">
                    <li>Formation et parcours d'excellence</li>
                    <li>Approche personnalisée et à l'écoute</li>
                    <li>Membre de l'ordre des médecins</li>
                </ul>
                <!-- /wp:list -->

                <!-- wp:shortcode -->
                [vitalisite_social_links]
                <!-- /wp:shortcode -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"55%","className":"vitalisite-doctor-sticky__images"} -->
        <div class="wp-block-column vitalisite-doctor-sticky__images" style="flex-basis:55%">
            <!-- wp:image {"aspectRatio":"3/4","scale":"cover","className":"vitalisite-doctor-sticky__img"} -->
            <figure class="wp-block-image vitalisite-doctor-sticky__img"><img alt="Photo du cabinet" style="aspect-ratio:3/4;object-fit:cover"/></figure>
            <!-- /wp:image -->

            <!-- wp:image {"aspectRatio":"3/4","scale":"cover","className":"vitalisite-doctor-sticky__img"} -->
            <figure class="wp-block-image vitalisite-doctor-sticky__img"><img alt="Consultation" style="aspect-ratio:3/4;object-fit:cover"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->
        
    </div>
    <!-- /wp:columns -->
</section>
<!-- /wp:group -->
