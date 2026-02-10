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

// Include block render callbacks (global namespace – referenced by string).
require_once __DIR__ . '/inc/block-testimonials.php';
require_once __DIR__ . '/inc/block-video.php';
require_once __DIR__ . '/inc/block-before-after.php';
require_once __DIR__ . '/inc/block-opening-hours.php';

// Patterns & blocks registration.
require_once __DIR__ . '/inc/patterns.php';

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
 * Enqueue global styles (theme stylesheet + utilities + layout CSS).
 */
function enqueue_global_styles() {
	$version = VITALISITE_FSE_VERSION;
	$uri     = get_template_directory_uri();

	wp_enqueue_style( 'vitalisite-fse', $uri . '/style.css', array(), $version );
	wp_enqueue_style( 'vitalisite-fse-utilities', $uri . '/assets/styles/utilities.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-header', $uri . '/assets/styles/header.css', array( 'vitalisite-fse' ), $version );
	wp_enqueue_style( 'vitalisite-fse-hero', $uri . '/assets/styles/hero.css', array( 'vitalisite-fse' ), $version );
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
