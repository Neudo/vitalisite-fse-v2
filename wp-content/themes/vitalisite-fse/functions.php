<?php
/**
 * Vitalisite FSE – Theme functions.
 *
 * @package Vitalisite_FSE
 */

namespace Vitalisite_FSE;

/**
 * Theme version constant.
 */
define( 'VITALISITE_FSE_VERSION', wp_get_theme()->get( 'Version' ) );

// Include CPT registrations (global namespace – class-based).
require_once __DIR__ . '/inc/cpt-testimonials.php';
require_once __DIR__ . '/inc/cpt-specialities.php';

// Include block render callbacks (global namespace – referenced by string).
require_once __DIR__ . '/inc/block-testimonials.php';
require_once __DIR__ . '/inc/block-video.php';
require_once __DIR__ . '/inc/block-before-after.php';
require_once __DIR__ . '/inc/block-opening-hours.php';

// Patterns & blocks registration.
require_once __DIR__ . '/inc/patterns.php';

// Admin settings page.
require_once __DIR__ . '/inc/admin-settings.php';

// Dynamic footer content injection.
require_once __DIR__ . '/inc/footer-dynamic.php';

// Features: announcement banner + sticky CTA + links page.
require_once __DIR__ . '/inc/feature-banner.php';
require_once __DIR__ . '/inc/feature-sticky-cta.php';
require_once __DIR__ . '/inc/feature-links-page.php';

// AJAX contact form handler.
require_once __DIR__ . '/inc/ajax-contact-form.php';

// Block render callback: contact form.
require_once __DIR__ . '/inc/block-contact-form.php';

// Google Reviews integration.
require_once __DIR__ . '/inc/google-reviews-functions.php';

// Debug visuel couleurs (WP_DEBUG uniquement).
// require_once __DIR__ . '/inc/debug-colors.php';

// License system & setup wizard.
require_once __DIR__ . '/inc/license.php';
require_once __DIR__ . '/inc/setup-wizard.php';

/**
 * Check if the site is running in development mode.
 */
function is_dev_mode() {
	if ( defined( 'VITALISITE_DEV_MODE' ) && VITALISITE_DEV_MODE ) {
		return true;
	}
	if ( function_exists( 'wp_get_environment_type' ) ) {
		return wp_get_environment_type() === 'local';
	}
	return false;
}

/**
 * Theme setup: editor styles, remove core patterns.
 */
function setup() {
	// Auto-detect all CSS files in assets/styles/ for the editor.
	$files       = glob( get_template_directory() . '/assets/styles/*.css' );
	$editor_css  = array();
	foreach ( $files as $file ) {
		$editor_css[] = 'assets/styles/' . basename( $file );
	}
	add_editor_style( $editor_css );

	// Hide core block patterns to keep the inserter focused on theme patterns.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );

// Disable remote patterns from the WordPress.org pattern directory.
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Change the post-content block wrapper from <div> to <main>.
 */
function post_content_use_main_tag( $block_content, $block ) {
	if ( 'core/post-content' !== $block['blockName'] ) {
		return $block_content;
	}
	return preg_replace(
		array( '/^<div\b/', '/<\/div>\s*$/' ),
		array( '<main', '</main>' ),
		$block_content
	);
}
add_filter( 'render_block', __NAMESPACE__ . '\post_content_use_main_tag', 10, 2 );

/**
 * Add a body class matching the active style variation slug.
 *
 * Compares the active primary color against each variation file to detect
 * which one is selected. Outputs: vitalisite-style--{slug} (e.g. vitalisite-style--mineral).
 * Falls back to vitalisite-style--default when no variation matches.
 */
function add_style_variation_body_class( $classes ) {
	$active_primary = wp_get_global_settings( array( 'color', 'palette', 'theme' ) );
	$current_primary = '';

	if ( is_array( $active_primary ) ) {
		foreach ( $active_primary as $color ) {
			if ( isset( $color['slug'] ) && 'primary' === $color['slug'] ) {
				$current_primary = strtolower( trim( $color['color'] ) );
				break;
			}
		}
	}

	$variation_slug = 'default';

	if ( $current_primary ) {
		$styles_dir = get_template_directory() . '/styles';
		foreach ( glob( $styles_dir . '/*.json' ) as $file ) {
			$data = json_decode( file_get_contents( $file ), true );
			if ( ! isset( $data['settings']['color']['palette'] ) ) {
				continue;
			}
			foreach ( $data['settings']['color']['palette'] as $color ) {
				if ( isset( $color['slug'] ) && 'primary' === $color['slug'] ) {
					if ( strtolower( trim( $color['color'] ) ) === $current_primary ) {
						$variation_slug = basename( $file, '.json' );
					}
					break;
				}
			}
		}
	}

	$classes[] = 'vitalisite-style--' . sanitize_html_class( $variation_slug );
	return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\add_style_variation_body_class' );

/**
 * Enqueue global styles (theme stylesheet + utilities + layout CSS).
 */
function enqueue_global_styles() {
	$version = VITALISITE_FSE_VERSION;
	$uri     = get_template_directory_uri();

	wp_enqueue_style( 'vitalisite-fse', $uri . '/style.css', array(), $version );
	wp_enqueue_style( 'vitalisite-fse-utilities', $uri . '/assets/styles/utilities.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-header', $uri . '/assets/styles/header.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-hero', $uri . '/assets/styles/hero.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-bento', $uri . '/assets/styles/bento.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-footer', $uri . '/assets/styles/footer.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-features', $uri . '/assets/styles/features.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-pricing', $uri . '/assets/styles/pricing.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-doctor', $uri . '/assets/styles/doctor.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-contact-form', $uri . '/assets/styles/contact-form.css', array( 'vitalisite-fse' ), $version );

	if ( is_page() && 'template-links' === get_page_template_slug() ) {
		wp_enqueue_style( 'vitalisite-fse-links-page', $uri . '/assets/styles/links-page.css', array( 'vitalisite-fse' ), $version );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_global_styles' );

/**
 * Enqueue block-specific styles only when the block is used.
 */
function enqueue_block_styles() {
	$version = VITALISITE_FSE_VERSION;

	$block_styles = array(
		'vitalisite-fse/accordion'       => 'accordion.css',
		'vitalisite-fse/accordion-item'  => 'accordion.css',
		'vitalisite-fse/cards-container' => 'cards.css',
		'vitalisite-fse/card'            => 'cards.css',
		'vitalisite-fse/text-image'      => 'text-image.css',
		'vitalisite-fse/testimonials'    => 'testimonials.css',
		'vitalisite-fse/video'           => 'video.css',
		'vitalisite-fse/before-after'    => 'before-after.css',
		'vitalisite-fse/slider'          => 'slider.css',
		'vitalisite-fse/opening-hours'   => 'opening-hours.css',
	);

	foreach ( $block_styles as $block_name => $css_file ) {
		$handle = 'vitalisite-fse-' . basename( $css_file, '.css' );
		wp_enqueue_block_style(
			$block_name,
			array(
				'handle' => $handle,
				'src'    => get_theme_file_uri( "assets/styles/{$css_file}" ),
				'path'   => get_theme_file_path( "assets/styles/{$css_file}" ),
				'ver'    => $version,
			)
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\enqueue_block_styles' );

/**
 * Enqueue responsive nav script — render-blocking in <head> to prevent flash.
 * Must run BEFORE first paint so the header is revealed only after the
 * desktop/mobile mode has been determined.
 */
function enqueue_responsive_nav() {
	$version = VITALISITE_FSE_VERSION;
	$uri     = get_template_directory_uri();

	// false = load in <head> (not in footer)
	wp_enqueue_script(
		'vitalisite-fse-responsive-nav',
		$uri . '/assets/js/responsive-nav.js',
		array(),
		$version,
		false
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_responsive_nav' );

/**
 * Remove defer/async from the responsive-nav script so it is truly
 * render-blocking. WordPress 6.3+ adds defer by default.
 */
function responsive_nav_remove_defer( $tag, $handle ) {
	if ( 'vitalisite-fse-responsive-nav' === $handle ) {
		$tag = str_replace( array( ' defer', ' async' ), '', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', __NAMESPACE__ . '\responsive_nav_remove_defer', 10, 2 );

/**
 * Enqueue vendor scripts (Swiper) and block-specific JS.
 */
function enqueue_scripts() {
	$version = VITALISITE_FSE_VERSION;
	$uri     = get_template_directory_uri();

	// Swiper.js (bundled, version 12.1.0)
	wp_enqueue_style( 'vitalisite-swiper-css', $uri . '/assets/styles/swiper.min.css', array(), $version );
	wp_enqueue_script( 'vitalisite-swiper', $uri . '/assets/js/vendor/swiper.min.js', array(), $version, true );

	// Slider JS
	wp_enqueue_script( 'vitalisite-fse-slider-js', $uri . '/assets/js/slider.js', array( 'vitalisite-swiper' ), $version, true );

	// Testimonials JS
	wp_enqueue_script( 'vitalisite-fse-testimonials-js', $uri . '/assets/js/testimonials.js', array( 'vitalisite-swiper' ), $version, true );

	// Contact Form JS
	wp_enqueue_script( 'vitalisite-fse-contact-form-js', $uri . '/assets/js/contact-form.js', array(), $version, true );
	wp_localize_script( 'vitalisite-fse-contact-form-js', 'vitalisiteContact', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
	) );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_scripts' );

/**
 * Clear caches in dev mode.
 */
function dev_cache_busting() {
	if ( ! is_dev_mode() ) {
		return;
	}
	if ( function_exists( 'wp_clean_themes_cache' ) ) {
		wp_clean_themes_cache( false );
	}
	if ( class_exists( 'WP_Theme_JSON_Resolver' ) ) {
		\WP_Theme_JSON_Resolver::clean_cached_data();
	}
}
add_action( 'init', __NAMESPACE__ . '\dev_cache_busting' );
