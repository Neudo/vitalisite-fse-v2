<?php
/**
 * AJAX Contact Form handler.
 *
 * Handles form submission, validation, spam protection, and email sending.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the AJAX actions for logged-in and non-logged-in users.
 */
add_action( 'wp_ajax_vitalisite_contact', __NAMESPACE__ . '\handle_contact_form' );
add_action( 'wp_ajax_nopriv_vitalisite_contact', __NAMESPACE__ . '\handle_contact_form' );

/**
 * Handle the contact form AJAX submission.
 */
function handle_contact_form() {
	// 1. Verify nonce.
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'vitalisite_contact_form' ) ) {
		wp_send_json_error( array( 'message' => __( 'Erreur de sécurité. Veuillez rafraîchir la page et réessayer.', 'vitalisite-fse' ) ), 403 );
	}

	// 2. Honeypot check — if filled, silently succeed (bot trap).
	if ( ! empty( $_POST['vitalisite_website'] ) ) {
		wp_send_json_success( array( 'message' => __( 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.', 'vitalisite-fse' ) ) );
	}

	// 3. Rate limiting via transient (1 submission per IP per 30 seconds).
	$ip_hash    = md5( $_SERVER['REMOTE_ADDR'] ?? 'unknown' );
	$transient  = 'vitalisite_contact_' . $ip_hash;
	if ( get_transient( $transient ) ) {
		wp_send_json_error( array( 'message' => __( 'Veuillez patienter quelques secondes avant de renvoyer un message.', 'vitalisite-fse' ) ), 429 );
	}

	// 4. Sanitize & validate fields.
	$name    = sanitize_text_field( $_POST['vitalisite_name'] ?? '' );
	$email   = sanitize_email( $_POST['vitalisite_email'] ?? '' );
	$phone   = sanitize_text_field( $_POST['vitalisite_phone'] ?? '' );
	$message = sanitize_textarea_field( $_POST['vitalisite_message'] ?? '' );
	$subject = sanitize_text_field( $_POST['vitalisite_subject'] ?? '' );

	$errors = array();

	if ( empty( $name ) ) {
		$errors['vitalisite_name'] = __( 'Le nom est requis.', 'vitalisite-fse' );
	}

	if ( empty( $email ) || ! is_email( $email ) ) {
		$errors['vitalisite_email'] = __( 'Une adresse email valide est requise.', 'vitalisite-fse' );
	}

	if ( empty( $message ) ) {
		$errors['vitalisite_message'] = __( 'Le message est requis.', 'vitalisite-fse' );
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error( array(
			'message' => __( 'Veuillez corriger les erreurs ci-dessous.', 'vitalisite-fse' ),
			'fields'  => $errors,
		), 422 );
	}

	// 5. Build and send email.
	$to = vitalisite_get_option( 'vitalisite_cabinet', 'email', get_option( 'admin_email' ) );

	$email_subject = ! empty( $subject )
		? sprintf( '[%s] %s', get_bloginfo( 'name' ), $subject )
		: sprintf( '[%s] Nouveau message de %s', get_bloginfo( 'name' ), $name );

	$body  = sprintf( "Nom : %s\n", $name );
	$body .= sprintf( "Email : %s\n", $email );
	if ( ! empty( $phone ) ) {
		$body .= sprintf( "Téléphone : %s\n", $phone );
	}
	if ( ! empty( $subject ) ) {
		$body .= sprintf( "Sujet : %s\n", $subject );
	}
	$body .= sprintf( "\nMessage :\n%s\n", $message );

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail( $to, $email_subject, $body, $headers );

	// Log email details in dev mode for local testing (no SMTP server needed).
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( sprintf(
			"[Vitalisite Contact] To: %s | Subject: %s | Sent: %s\n---\n%s\n---",
			$to,
			$email_subject,
			$sent ? 'YES' : 'NO',
			$body
		) );
	}

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.', 'vitalisite-fse' ) ), 500 );
	}

	// 6. Set rate limit transient (30 seconds).
	set_transient( $transient, true, 30 );

	wp_send_json_success( array( 'message' => __( 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.', 'vitalisite-fse' ) ) );
}
