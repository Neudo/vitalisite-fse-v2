<?php
/**
 * Intégration avec le plugin Vitalisite Core
 * 
 * Gère la validation de licence avec l'API Vitalisite
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Plugin_Integration {

	/**
	 * Instance unique
	 */
	private static $instance = null;

	/**
	 * Singleton
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructeur
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialise les hooks
	 */
	private function init_hooks() {
		// Intégrer la validation de licence dans le wizard
		add_action( 'vitalisite_validate_license', array( $this, 'validate_license_with_api' ) );
	}

	/**
	 * Valide la licence avec l'API Vitalisite
	 */
	public function validate_license_with_api( $license_key ) {
		$api_url = 'https://vitalisite.com/api/check-license';

		$args = array(
			'body' => json_encode( array( 'unique_key' => $license_key ) ),
			'headers' => array(
				'Content-Type' => 'application/json',
			),
			'method' => 'POST',
			'timeout' => 15,
		);

		$response = wp_remote_post( $api_url, $args );

		if ( is_wp_error( $response ) ) {
			// Erreur de connexion
			add_settings_error(
				'vitalisite_license',
				'api_error',
				__( 'Erreur de connexion à l\'API. Veuillez réessayer.', 'vitalisite-fse' ),
				'error'
			);
			return false;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! empty( $body['success'] ) && $body['success'] === true ) {
			// Licence valide
			update_option( 'theme_license_key', $license_key );
			update_option( 'theme_license_status', 'activated' );
			
			return true;
		} else {
			// Licence invalide
			$message = ! empty( $body['message'] ) ? $body['message'] : __( 'Clé de licence invalide.', 'vitalisite-fse' );
			
			add_settings_error(
				'vitalisite_license',
				'invalid_license',
				$message,
				'error'
			);
			
			return false;
		}
	}

	/**
	 * Récupère les infos du médecin
	 * 
	 * @param string $key Clé spécifique (optionnel)
	 * @return mixed Toutes les infos ou une info spécifique
	 */
	public static function get_doctor_info( $key = '' ) {
		$doctor_info = get_option( 'vitalisite_doctor_info', array() );
		
		if ( empty( $key ) ) {
			return $doctor_info;
		}
		
		return isset( $doctor_info[ $key ] ) ? $doctor_info[ $key ] : '';
	}
}

// Initialiser l'intégration
Vitalisite_Plugin_Integration::get_instance();
