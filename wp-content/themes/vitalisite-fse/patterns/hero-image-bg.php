<?php
/**
 * Title: Héro avec image de fond (Cover)
 * Slug: vitalisite-fse/hero-image-bg
 * Description: Section hero avec image de fond, titre, sous-titre et texte.
 * Categories: hero-vitalisite
 * Keywords: banniere, hero, image, fond, cover, overlay
 */
?>

<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-section full-section hero-image-bg","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section full-section hero-image-bg" style="padding-top:0;padding-bottom:0">

    <!-- wp:group {"className":"vitalisite-hero-custom-cover","layout":{"type":"default"}} -->
    <div class="wp-block-group vitalisite-hero-custom-cover">

        <!-- wp:image {"sizeSlug":"large","className":"vitalisite-hero-custom-bg"} -->
        <figure class="wp-block-image size-large vitalisite-hero-custom-bg"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-slider-1.jpg' ) ); ?>" alt="Background Hero" /></figure>
        <!-- /wp:image -->

        <!-- wp:group {"className":"hero-image-bg__content reveal-parallax","layout":{"type":"default"}} -->
        <div class="wp-block-group hero-image-bg__content reveal-parallax">

            <!-- wp:heading {"level":1,"className":"reveal-y reveal-y--soft","style":{"typography":{"fontWeight":"700","lineHeight":"1.1"}}} -->
            <h1 class="wp-block-heading reveal-y reveal-y--soft" style="font-weight:700;line-height:1.1">Titre principal de la section</h1>
            <!-- /wp:heading -->

            <!-- wp:heading {"level":2,"className":"reveal-y reveal-y--soft","style":{"typography":{"fontWeight":"400","fontSize":"1.3rem"}}} -->
            <h2 class="wp-block-heading reveal-y reveal-y--soft" style="font-weight:400;font-size:1.3rem">Sous-titre ou spécialité du praticien</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"reveal-y reveal-y--soft","style":{"typography":{"lineHeight":"1.8"}}} -->
            <p class="reveal-y reveal-y--soft" style="line-height:1.8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <!-- /wp:paragraph -->

        </div>
        <!-- /wp:group -->

    </div>
    <!-- /wp:group -->

</section>
<!-- /wp:group -->
