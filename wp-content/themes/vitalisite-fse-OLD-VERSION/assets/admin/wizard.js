/**
 * JavaScript pour le Setup Wizard de Vitalisite FSE
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

(function($) {
	'use strict';

	const VitalisiWizardJS = {
		
		/**
		 * Initialisation
		 */
		init: function() {
			this.photoUpload();
			this.colorPreview();
			this.formValidation();
		},

		/**
		 * Gestion de l'upload de photo
		 */
		photoUpload: function() {
			let mediaUploader;

			// Ouvrir le media uploader
			$(document).on('click', '.upload-photo-button', function(e) {
				e.preventDefault();

				// Si le media uploader existe déjà, l'ouvrir
				if (mediaUploader) {
					mediaUploader.open();
					return;
				}

				// Créer le media uploader
				mediaUploader = wp.media({
					title: 'Choisir une photo',
					button: {
						text: 'Utiliser cette photo'
					},
					multiple: false,
					library: {
						type: 'image'
					}
				});

				// Quand une image est sélectionnée
				mediaUploader.on('select', function() {
					const attachment = mediaUploader.state().get('selection').first().toJSON();
					
					// Mettre à jour l'ID de la photo
					$('#doctor_photo_id').val(attachment.id);

					// Afficher la preview
					const previewHtml = `
						<div class="photo-preview">
							<img src="${attachment.sizes.thumbnail.url}" alt="">
							<button type="button" class="remove-photo" data-photo-id="${attachment.id}">
								<span class="dashicons dashicons-no"></span>
							</button>
						</div>
					`;

					// Supprimer l'ancienne preview si elle existe
					$('.photo-preview').remove();

					// Ajouter la nouvelle preview
					$('.upload-photo-button').before(previewHtml);
				});

				// Ouvrir le media uploader
				mediaUploader.open();
			});

			// Supprimer la photo
			$(document).on('click', '.remove-photo', function(e) {
				e.preventDefault();
				
				// Supprimer la preview
				$(this).closest('.photo-preview').remove();
				
				// Réinitialiser l'input
				$('#doctor_photo_id').val('');
			});
		},

		/**
		 * Preview des couleurs en temps réel
		 */
		colorPreview: function() {
			// Mettre à jour la preview quand les couleurs changent
			$('#primary_color').on('input', function() {
				$('.preview-heading').css('color', $(this).val());
			});

			$('#accent_color').on('input', function() {
				$('.preview-button').css('background-color', $(this).val());
			});

			// Mettre à jour les fonts en temps réel
			$('#heading_font, #body_font').on('change', function() {
				const headingFont = $('#heading_font').val();
				const bodyFont = $('#body_font').val();

				// Appliquer les fonts à la preview
				$('.preview-heading').css('font-family', VitalisiWizardJS.getFontFamily(headingFont));
				$('.preview-text, .preview-button').css('font-family', VitalisiWizardJS.getFontFamily(bodyFont));
			});
		},

		/**
		 * Récupère la font-family CSS à partir du slug
		 */
		getFontFamily: function(slug) {
			const fonts = {
				'montserrat': 'Montserrat, sans-serif',
				'roboto': 'Roboto, sans-serif',
				'system-font': '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif'
			};

			return fonts[slug] || fonts['montserrat'];
		},

		/**
		 * Validation du formulaire
		 */
		formValidation: function() {
			$('.vitalisite-wizard-form').on('submit', function(e) {
				const form = $(this);
				let isValid = true;

				// Supprimer les anciens messages d'erreur
				$('.field-error').remove();

				// Valider les champs requis
				form.find('[required]').each(function() {
					const field = $(this);
					const value = field.val().trim();

					if (value === '') {
						isValid = false;
						field.addClass('error');
						field.after('<span class="field-error" style="color: #d63638; font-size: 13px; display: block; margin-top: 5px;">Ce champ est requis</span>');
					} else {
						field.removeClass('error');
					}
				});

				// Valider l'email
				const emailField = form.find('input[type="email"]');
				if (emailField.length && emailField.val().trim() !== '') {
					const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
					if (!emailRegex.test(emailField.val())) {
						isValid = false;
						emailField.addClass('error');
						emailField.after('<span class="field-error" style="color: #d63638; font-size: 13px; display: block; margin-top: 5px;">Adresse email invalide</span>');
					}
				}

				// Valider l'URL
				const urlField = form.find('input[type="url"]');
				if (urlField.length && urlField.val().trim() !== '') {
					const urlRegex = /^https?:\/\/.+/;
					if (!urlRegex.test(urlField.val())) {
						isValid = false;
						urlField.addClass('error');
						urlField.after('<span class="field-error" style="color: #d63638; font-size: 13px; display: block; margin-top: 5px;">URL invalide (doit commencer par http:// ou https://)</span>');
					}
				}

				// Empêcher la soumission si invalide
				if (!isValid) {
					e.preventDefault();
					
					// Scroll vers le premier champ en erreur
					$('html, body').animate({
						scrollTop: $('.error').first().offset().top - 100
					}, 300);

					return false;
				}

				// Ajouter un état de chargement
				form.addClass('loading');
			});

			// Supprimer l'erreur quand l'utilisateur corrige
			$(document).on('input change', '.error', function() {
				$(this).removeClass('error');
				$(this).next('.field-error').remove();
			});
		},

		/**
		 * Afficher un message de succès ou d'erreur
		 */
		showMessage: function(message, type) {
			const icon = type === 'success' ? 'yes-alt' : 'warning';
			const messageHtml = `
				<div class="vitalisite-wizard-message ${type}">
					<span class="dashicons dashicons-${icon}"></span>
					<span>${message}</span>
				</div>
			`;

			// Supprimer les anciens messages
			$('.vitalisite-wizard-message').remove();

			// Ajouter le nouveau message
			$('.vitalisite-wizard-content').prepend(messageHtml);

			// Scroll vers le message
			$('html, body').animate({
				scrollTop: $('.vitalisite-wizard-message').offset().top - 100
			}, 300);

			// Supprimer le message après 5 secondes
			setTimeout(function() {
				$('.vitalisite-wizard-message').fadeOut(300, function() {
					$(this).remove();
				});
			}, 5000);
		}
	};

	// Initialiser au chargement du DOM
	$(document).ready(function() {
		VitalisiWizardJS.init();
	});

	// Exposer l'objet globalement pour permettre l'utilisation externe
	window.VitalisiWizardJS = VitalisiWizardJS;

})(jQuery);
