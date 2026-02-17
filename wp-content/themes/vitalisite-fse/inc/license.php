<?php
/**
 * Vitalisite License System.
 *
 * Handles license activation, deactivation, and status checks
 * via the vitalisite.com API.
 *
 * Options stored:
 *   - vitalisite_license_key    (string) — The license key
 *   - vitalisite_license_status (string) — 'activated' | 'deactivated' | ''
 *
 * @package Vitalisite_FSE
 * @since   1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------ */
/*  Constants                                                         */
/* ------------------------------------------------------------------ */

const LICENSE_API_BASE  = 'https://vitalisite.com/api/';
const OPTION_LICENSE_KEY    = 'vitalisite_license_key';
const OPTION_LICENSE_STATUS = 'vitalisite_license_status';

/* ------------------------------------------------------------------ */
/*  Helpers                                                           */
/* ------------------------------------------------------------------ */

/**
 * Check if the theme license is activated.
 *
 * @return bool
 */
function is_license_active() {
	return get_option( OPTION_LICENSE_STATUS ) === 'activated';
}

/**
 * Get the stored license key.
 *
 * @return string
 */
function get_license_key() {
	return get_option( OPTION_LICENSE_KEY, '' );
}

/* ------------------------------------------------------------------ */
/*  API calls                                                         */
/* ------------------------------------------------------------------ */

/**
 * Activate a license key via the API.
 *
 * @param string $key The license key to activate.
 * @return array { success: bool, message: string }
 */
function activate_license( $key ) {
	$response = wp_remote_post( LICENSE_API_BASE . 'check-license', array(
		'body'    => wp_json_encode( array( 'unique_key' => $key ) ),
		'headers' => array( 'Content-Type' => 'application/json' ),
		'timeout' => 15,
	) );

	if ( is_wp_error( $response ) ) {
		return array(
			'success' => false,
			'message' => __( 'Impossible de contacter le serveur de licence. Vérifiez votre connexion internet.', 'vitalisite-fse' ),
		);
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! empty( $body['success'] ) ) {
		update_option( OPTION_LICENSE_KEY, sanitize_text_field( $key ) );
		update_option( OPTION_LICENSE_STATUS, 'activated' );

		return array(
			'success' => true,
			'message' => __( 'Licence activée avec succès !', 'vitalisite-fse' ),
		);
	}

	$error_msg = ! empty( $body['message'] )
		? $body['message']
		: __( 'Clé de licence invalide.', 'vitalisite-fse' );

	return array(
		'success' => false,
		'message' => $error_msg,
	);
}

/**
 * Deactivate the current license key via the API.
 *
 * @return array { success: bool, message: string }
 */
function deactivate_license() {
	$key = get_license_key();

	if ( empty( $key ) ) {
		return array(
			'success' => false,
			'message' => __( 'Aucune clé de licence trouvée.', 'vitalisite-fse' ),
		);
	}

	$response = wp_remote_post( LICENSE_API_BASE . 'desactivate-license', array(
		'body'    => wp_json_encode( array( 'unique_key' => $key ) ),
		'headers' => array( 'Content-Type' => 'application/json' ),
		'timeout' => 15,
	) );

	if ( is_wp_error( $response ) ) {
		return array(
			'success' => false,
			'message' => __( 'Impossible de contacter le serveur de licence.', 'vitalisite-fse' ),
		);
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! empty( $body['success'] ) ) {
		update_option( OPTION_LICENSE_STATUS, 'deactivated' );
		update_option( OPTION_LICENSE_KEY, '' );

		return array(
			'success' => true,
			'message' => __( 'Licence désactivée avec succès.', 'vitalisite-fse' ),
		);
	}

	$error_msg = ! empty( $body['message'] )
		? $body['message']
		: __( 'Erreur lors de la désactivation.', 'vitalisite-fse' );

	return array(
		'success' => false,
		'message' => $error_msg,
	);
}

/* ------------------------------------------------------------------ */
/*  AJAX handlers                                                     */
/* ------------------------------------------------------------------ */

/**
 * AJAX: activate license.
 */
function ajax_activate_license() {
	check_ajax_referer( 'vitalisite_license_nonce', '_wpnonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'Permission refusée.', 'vitalisite-fse' ) ), 403 );
	}

	$key = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';

	if ( empty( $key ) ) {
		wp_send_json_error( array( 'message' => __( 'Veuillez saisir une clé de licence.', 'vitalisite-fse' ) ) );
	}

	$result = activate_license( $key );

	if ( $result['success'] ) {
		wp_send_json_success( $result );
	} else {
		wp_send_json_error( $result );
	}
}
add_action( 'wp_ajax_vitalisite_activate_license', __NAMESPACE__ . '\ajax_activate_license' );

/**
 * AJAX: deactivate license.
 */
function ajax_deactivate_license() {
	check_ajax_referer( 'vitalisite_license_nonce', '_wpnonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => __( 'Permission refusée.', 'vitalisite-fse' ) ), 403 );
	}

	$result = deactivate_license();

	if ( $result['success'] ) {
		wp_send_json_success( $result );
	} else {
		wp_send_json_error( $result );
	}
}
add_action( 'wp_ajax_vitalisite_deactivate_license', __NAMESPACE__ . '\ajax_deactivate_license' );
