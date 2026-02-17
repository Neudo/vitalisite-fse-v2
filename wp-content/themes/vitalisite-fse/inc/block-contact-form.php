<?php
/**
 * Server-side rendering for the contact form block.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vitalisite_render_contact_form_block( $attributes ) {
	ob_start();
	?>
	<form class="vitalisite-contact-form" novalidate>
		<?php wp_nonce_field( 'vitalisite_contact_form' ); ?>

		<div class="vitalisite-contact-form__row">
			<div class="vitalisite-contact-form__field">
				<label for="vitalisite_name"><?php esc_html_e( 'Nom', 'vitalisite-fse' ); ?> <span class="required" aria-hidden="true">*</span></label>
				<input type="text" id="vitalisite_name" name="vitalisite_name" required placeholder="<?php esc_attr_e( 'Votre nom', 'vitalisite-fse' ); ?>" autocomplete="name">
				<span class="vitalisite-contact-form__error" hidden aria-live="polite"></span>
			</div>

			<div class="vitalisite-contact-form__field">
				<label for="vitalisite_email"><?php esc_html_e( 'Email', 'vitalisite-fse' ); ?> <span class="required" aria-hidden="true">*</span></label>
				<input type="email" id="vitalisite_email" name="vitalisite_email" required placeholder="<?php esc_attr_e( 'votre@email.fr', 'vitalisite-fse' ); ?>" autocomplete="email">
				<span class="vitalisite-contact-form__error" hidden aria-live="polite"></span>
			</div>
		</div>

		<div class="vitalisite-contact-form__row">
			<div class="vitalisite-contact-form__field">
				<label for="vitalisite_phone"><?php esc_html_e( 'Téléphone', 'vitalisite-fse' ); ?></label>
				<input type="tel" id="vitalisite_phone" name="vitalisite_phone" placeholder="<?php esc_attr_e( '01 42 42 42 42', 'vitalisite-fse' ); ?>" autocomplete="tel">
				<span class="vitalisite-contact-form__error" hidden aria-live="polite"></span>
			</div>

			<div class="vitalisite-contact-form__field">
				<label for="vitalisite_subject"><?php esc_html_e( 'Sujet', 'vitalisite-fse' ); ?></label>
				<input type="text" id="vitalisite_subject" name="vitalisite_subject" placeholder="<?php esc_attr_e( 'Objet de votre message', 'vitalisite-fse' ); ?>">
				<span class="vitalisite-contact-form__error" hidden aria-live="polite"></span>
			</div>
		</div>

		<div class="vitalisite-contact-form__field">
			<label for="vitalisite_message"><?php esc_html_e( 'Message', 'vitalisite-fse' ); ?> <span class="required" aria-hidden="true">*</span></label>
			<textarea id="vitalisite_message" name="vitalisite_message" required placeholder="<?php esc_attr_e( 'Votre message…', 'vitalisite-fse' ); ?>"></textarea>
			<span class="vitalisite-contact-form__error" hidden aria-live="polite"></span>
		</div>

		<!-- Honeypot -->
		<div class="vitalisite-contact-form__hp" aria-hidden="true">
			<label for="vitalisite_website"><?php esc_html_e( 'Ne pas remplir', 'vitalisite-fse' ); ?></label>
			<input type="text" id="vitalisite_website" name="vitalisite_website" tabindex="-1" autocomplete="off">
		</div>

		<div class="vitalisite-contact-form__submit">
			<button type="submit"><?php esc_html_e( 'Envoyer le message', 'vitalisite-fse' ); ?></button>
		</div>

		<div class="vitalisite-contact-form__feedback" hidden></div>
	</form>
	<?php
	return ob_get_clean();
}
