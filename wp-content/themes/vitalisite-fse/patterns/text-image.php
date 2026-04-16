<?php
/**
 * Title: Texte + Image
 * Slug: vitalisite-fse/text-image
 * Description: Section classique avec texte d'un côté et image de l'autre
 * Categories: vitalisite-text
 * Keywords: about, feature, text, image
 */
?>

<!-- wp:vitalisite-fse/text-image -->
<section class="wp-block-vitalisite-fse-text-image vitalisite-text-image vitalisite-section">

    <!-- wp:columns {"verticalAlignment":"center"} -->
    <div class="wp-block-columns are-vertically-aligned-center">
        
        <!-- wp:column {"width":"50%"} -->
        <div class="wp-block-column" style="flex-basis:50%">
            <!-- wp:heading {"level":2} -->
            <h2 class="wp-block-heading reveal-y">Titre de la section</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"reveal-y"} -->
            <p class="reveal-y">Ce bloc permet de présenter simplement une approche, une méthode de consultation ou une information importante, avec un texte clair et une image de cabinet rassurante.</p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"className":"reveal-y"} -->
            <div class="wp-block-buttons reveal-y">
                <!-- wp:button {"className":"btn-primary"} -->
                <div class="wp-block-button btn-primary"><a class="wp-block-button__link">En savoir plus</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"50%"} -->
        <div class="wp-block-column" style="flex-basis:50%">
            <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"vitalisite-rounded-image reveal-y"} -->
            <figure class="wp-block-image size-large vitalisite-rounded-image reveal-y"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-5.jpg' ) ); ?>" alt="Illustration du cabinet"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</section>
<!-- /wp:vitalisite-fse/text-image -->
