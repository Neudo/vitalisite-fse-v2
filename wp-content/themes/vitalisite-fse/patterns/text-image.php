<?php
/**
 * Title: Texte + Image
 * Slug: vitalisite-fse/text-image
 * Description: Section classique avec texte d'un côté et image de l'autre
 * Categories: vitalisite-text-image
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
            <h2 class="wp-block-heading">Titre de la section</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph -->
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons -->
            <div class="wp-block-buttons">
                <!-- wp:button {"className":"btn-primary"} -->
                <div class="wp-block-button btn-primary"><a class="wp-block-button__link">En savoir plus</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column {"width":"50%"} -->
        <div class="wp-block-column" style="flex-basis:50%">
            <!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"vitalisite-rounded-image"} -->
            <figure class="wp-block-image size-large vitalisite-rounded-image"><img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80" alt="Medical Team"/></figure>
            <!-- /wp:image -->
        </div>
        <!-- /wp:column -->

    </div>
    <!-- /wp:columns -->

</section>
<!-- /wp:vitalisite-fse/text-image -->
