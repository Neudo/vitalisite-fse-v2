<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package vitalisite
 */
$template_name = pathinfo(get_page_template(), PATHINFO_FILENAME);

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<?php
$cta_main_hover_color = get_theme_mod('primary_cta_hover_color', '#03486A');
$cta_main_color = get_theme_mod('primary_cta_color', '#007CBA');
$cta_main_text_color = get_theme_mod('primary_cta_text_color', '#FFFFFF');
$main_color = get_theme_mod('main_color', '#051b2e' );
$main_text_color = is_light_color($main_color) ? 'rgb(30 41 59)' : 'rgb(226 232 240)';
?>
<style>
	:root {
		--main-color: <?php echo esc_attr($main_color); ?>;
		--main-text-color: <?php echo esc_attr($main_text_color); ?>;
		--cta-color: <?php echo esc_attr($cta_main_color); ?>;
		--cta-text-color: <?php echo esc_attr($cta_main_text_color); ?>;
		--cta-hover-color: <?php echo esc_attr($cta_main_hover_color); ?>;
	}
</style>
<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page">
	<a href="#content" class="sr-only"><?php esc_html_e( 'Skip to content', 'vitalisite' ); ?></a>
	<?php if (!is_404() && $template_name !== 'template-links-list') :?>
		<?php get_template_part( 'template-parts/layout/header/header-content-1'); ?>
	<?php endif; ?>
	<?php if (get_option('enable_announcement') && is_front_page() ) : ?>
		<div class="announcement-bar z-20 bg-blue-500 text-center py-2 px-4" style="background-color:<?= get_option('announcement_bg_color') ?>; color:<?= get_option('announcement_text_color') ?>">
			<span><?= esc_html(get_option('announcement_text')); ?></span>
		</div>
	<?php endif; ?>
	<div id="content">
