<?php
/**
 * Private theme updater for Vitalisite FSE.
 *
 * Expected remote JSON payload at the Update URI:
 * {
 *   "version": "0.1.7",
 *   "details_url": "https://www.vitalisite.com/themes/vitalisite-fse",
 *   "download_url": "https://www.vitalisite.com/downloads/vitalisite-fse-0.1.7.zip",
 *   "tested": "6.7",
 *   "requires_php": "7.4",
 *   "autoupdate": false
 * }
 *
 * @package Vitalisite_FSE
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const THEME_UPDATE_CACHE_TTL = 15 * MINUTE_IN_SECONDS;

/**
 * Get the transient key used to cache remote update metadata.
 *
 * @param string $update_uri Theme update URI.
 * @return string
 */
function get_theme_update_cache_key( $update_uri ) {
	return 'vitalisite_theme_update_' . md5( $update_uri );
}

/**
 * Register the dynamic theme update hook based on the Update URI host.
 *
 * @return void
 */
function register_theme_update_hook() {
	$update_uri = wp_get_theme()->get( 'UpdateURI' );
	$hostname   = wp_parse_url( sanitize_url( $update_uri ), PHP_URL_HOST );

	if ( ! $hostname ) {
		return;
	}

	add_filter( "update_themes_{$hostname}", __NAMESPACE__ . '\filter_private_theme_update', 10, 4 );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\register_theme_update_hook', 20 );

/**
 * Fetch and cache remote theme update metadata.
 *
 * @param string $update_uri Update manifest URI.
 * @return array<string,mixed>|false
 */
function get_remote_theme_update_data( $update_uri ) {
	$cache_key = get_theme_update_cache_key( $update_uri );
	$cached    = get_site_transient( $cache_key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$response = wp_safe_remote_get(
		$update_uri,
		array(
			'timeout'    => 8,
			'headers'    => array(
				'Accept' => 'application/json',
			),
			'user-agent' => 'WordPress/' . wp_get_wp_version() . '; ' . home_url( '/' ),
		)
	);

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return false;
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! is_array( $data ) || empty( $data['version'] ) ) {
		return false;
	}

	$normalized = array(
		'version'      => sanitize_text_field( (string) $data['version'] ),
		'details_url'  => ! empty( $data['details_url'] ) ? esc_url_raw( (string) $data['details_url'] ) : esc_url_raw( $update_uri ),
		'download_url' => ! empty( $data['download_url'] ) ? esc_url_raw( (string) $data['download_url'] ) : '',
		'tested'       => ! empty( $data['tested'] ) ? sanitize_text_field( (string) $data['tested'] ) : '',
		'requires_php' => ! empty( $data['requires_php'] ) ? sanitize_text_field( (string) $data['requires_php'] ) : '',
		'autoupdate'   => ! empty( $data['autoupdate'] ),
		'translations' => ! empty( $data['translations'] ) && is_array( $data['translations'] ) ? $data['translations'] : array(),
	);

	set_site_transient( $cache_key, $normalized, THEME_UPDATE_CACHE_TTL );

	return $normalized;
}

/**
 * Return update metadata for the private Vitalisite theme updater.
 *
 * @param array|false $update           Existing update data.
 * @param array       $theme_data       Theme header data.
 * @param string      $theme_stylesheet Theme stylesheet slug.
 * @param string[]    $locales          Installed locales.
 * @return array<string,mixed>|false
 */
function filter_private_theme_update( $update, $theme_data, $theme_stylesheet, $locales ) {
	unset( $locales );

	if ( 'vitalisite-fse' !== $theme_stylesheet ) {
		return $update;
	}

	$update_uri = ! empty( $theme_data['UpdateURI'] ) ? sanitize_url( $theme_data['UpdateURI'] ) : '';

	if ( ! $update_uri ) {
		return false;
	}

	$remote = get_remote_theme_update_data( $update_uri );

	if ( ! $remote ) {
		return false;
	}

	return array(
		'theme'        => $theme_stylesheet,
		'version'      => $remote['version'],
		'url'          => $remote['details_url'],
		'package'      => $remote['download_url'],
		'tested'       => $remote['tested'],
		'requires_php' => $remote['requires_php'],
		'autoupdate'   => (bool) $remote['autoupdate'],
		'translations' => $remote['translations'],
	);
}

/**
 * Clear the cached update manifest after a successful theme update.
 *
 * @param \WP_Upgrader $upgrader_object Upgrader instance.
 * @param array        $options         Upgrader options.
 * @return void
 */
function clear_theme_update_cache_after_upgrade( $upgrader_object, $options ) {
	unset( $upgrader_object );

	if ( empty( $options['type'] ) || 'theme' !== $options['type'] ) {
		return;
	}

	$updated_themes = array();

	if ( ! empty( $options['themes'] ) && is_array( $options['themes'] ) ) {
		$updated_themes = $options['themes'];
	} elseif ( ! empty( $options['theme'] ) && is_string( $options['theme'] ) ) {
		$updated_themes = array( $options['theme'] );
	}

	if ( ! in_array( 'vitalisite-fse', $updated_themes, true ) ) {
		return;
	}

	$update_uri = wp_get_theme()->get( 'UpdateURI' );

	if ( ! $update_uri ) {
		return;
	}

	delete_site_transient( get_theme_update_cache_key( $update_uri ) );
}
add_action( 'upgrader_process_complete', __NAMESPACE__ . '\clear_theme_update_cache_after_upgrade', 10, 2 );
