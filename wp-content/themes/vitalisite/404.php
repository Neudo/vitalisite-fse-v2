<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package vitalisite
 */

get_header();
?>
	<section id="primary">
		<main id="main">
			<div class="mt-6 md:mt-12 flex flex-col md:flex-row max-w-6xl mx-auto justify-center p-4">
			<div class="p-8 md:w-1/2 rounded-3xl md:rounded-tl-3xl md:rounded-bl-3xl md:rounded-tr-none md:rounded-br-none bg-slate-200 flex flex-col justify-center">
				<header class="page-header">
					<h1 class="page-title reveal-y text-4xl md:text-6xl"><?= esc_html( get_theme_mod('title_404') );?></h1>
					<hr class="my-12 h-0.5 border-t-0 bg-neutral-100 dark:bg-black/10" />
				</header><!-- .page-header -->
			
				<div <?php vitalisite_content_class( 'page-content' ); ?>>
					<p class="reveal-y text-xl text-slate-500"><?= esc_html(get_theme_mod('description_404')); ?></p>
					
					<?php $cta_data = array(
						'cta_text' => "Retour à l'accueil",
						'cta_link' => home_url(),
						'cta_classes' => 'mt-4'
					);
					include get_template_directory() . '/template-parts/components/cta.php';
					?>
				</div><!-- .page-content -->
			</div>
			<div class="hidden md:block w-1/2 overflow-hidden rounded-tr-3xl rounded-br-3xl">
					<img src="<?= get_theme_mod('image_404') ?? get_template_directory_uri() . '/assets/img/404.jpg'; ?>" alt="404" class="w-full h-full object-cover">
				</div>
			</div>


		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
