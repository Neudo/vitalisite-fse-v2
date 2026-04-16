<?php
/**
 * Title: Banniere avec image de fond
 * Slug: vitalisite-fse/hero-image-bg
 * Description: Banniere immersive avec image de fond pour valoriser une pratique ou une specialite.
 * Categories: hero-vitalisite
 * Keywords: banniere, hero, image, fond, cover, overlay
 */
?>

<!-- wp:group {"tagName":"section","align":"full","className":"vitalisite-section full-section hero-image-bg","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull vitalisite-section full-section hero-image-bg" style="padding-top:0;padding-bottom:0">

    <!-- wp:group {"className":"vitalisite-hero-custom-cover","layout":{"type":"default"}} -->
    <div class="wp-block-group vitalisite-hero-custom-cover">

        <!-- wp:image {"sizeSlug":"large","className":"vitalisite-hero-custom-bg"} -->
        <figure class="wp-block-image size-large vitalisite-hero-custom-bg"><img src="<?php echo esc_url( \Vitalisite_FSE\theme_asset_uri( 'assets/images/placeholder-slider-2.jpg' ) ); ?>" alt="Ambiance lumineuse d'un cabinet de sante" /></figure>
        <!-- /wp:image -->

        <!-- wp:group {"className":"hero-image-bg__content reveal-parallax","layout":{"type":"default"}} -->
        <div class="wp-block-group hero-image-bg__content reveal-parallax">

            <!-- wp:heading {"level":1,"className":"reveal-y reveal-y--soft","style":{"typography":{"fontWeight":"700","lineHeight":"1.1"}}} -->
            <h1 class="wp-block-heading reveal-y reveal-y--soft" style="font-weight:700;line-height:1.1">Votre sante merite une attention durable</h1>
            <!-- /wp:heading -->

            <!-- wp:heading {"level":2,"className":"reveal-y reveal-y--soft","style":{"typography":{"fontWeight":"400","fontSize":"1.3rem"}}} -->
            <h2 class="wp-block-heading reveal-y reveal-y--soft" style="font-weight:400;font-size:1.3rem">Consultations en cabinet, suivi personnalise et approche humaine</h2>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"className":"reveal-y reveal-y--soft","style":{"typography":{"lineHeight":"1.8"}}} -->
            <p class="reveal-y reveal-y--soft" style="line-height:1.8">Je presente ici ma specialite, mes valeurs et l'experience de consultation que je souhaite offrir des le premier regard.</p>

            <!-- wp:buttons {"className":"reveal-y reveal-y--soft","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
            <div class="wp-block-buttons reveal-y reveal-y--soft" style="margin-top:var(--wp--preset--spacing--40)">
                <!-- wp:button {"className":"btn-primary"} -->
                <div class="wp-block-button btn-primary"><a class="wp-block-button__link">Prendre rendez-vous</a></div>
                <!-- /wp:button -->

                <!-- wp:button {"className":"btn-secondary"} -->
                <div class="wp-block-button btn-secondary"><a class="wp-block-button__link">Decouvrir la specialite</a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
            <!-- /wp:paragraph -->

        </div>
        <!-- /wp:group -->

    </div>
    <!-- /wp:group -->

</section>
<!-- /wp:group -->
