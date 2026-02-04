/**
 * JavaScript pour la page de paramètres Vitalisite
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

(function($) {
	'use strict';

	const VitalisiSettingsJS = {
		
		/**
		 * Initialisation
		 */
		init: function() {
			this.tabs();
			this.photoUpload();
			this.resetWizard();
		},

		/**
		 * Gestion des tabs
		 */
		tabs: function() {
			$('.nav-tab').on('click', function(e) {
				e.preventDefault();
				
				const target = $(this).attr('href');
				
				// Activer le tab
				$('.nav-tab').removeClass('nav-tab-active');
				$(this).addClass('nav-tab-active');
				
				// Afficher le contenu
				$('.tab-content').removeClass('active');
				$(target).addClass('active');
			});
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
							<img src="${attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url}" alt="">
							<button type="button" class="button remove-photo">Supprimer</button>
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
		 * Réinitialiser le wizard
		 */
		resetWizard: function() {
			$('.reset-wizard-button').on('click', function(e) {
				e.preventDefault();
				
				if (!confirm('Êtes-vous sûr de vouloir réinitialiser le wizard ? Cela supprimera toutes les données actuelles.')) {
					return;
				}

				const button = $(this);
				const originalText = button.html();
				
				button.prop('disabled', true).html('<span class="dashicons dashicons-update spin"></span> Réinitialisation...');

				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'vitalisite_reset_wizard',
						nonce: '<?php echo wp_create_nonce( "vitalisite_reset_wizard" ); ?>'
					},
					success: function(response) {
						if (response.success) {
							window.location.href = response.data.redirect;
						} else {
							alert('Erreur lors de la réinitialisation.');
							button.prop('disabled', false).html(originalText);
						}
					},
					error: function() {
						alert('Erreur lors de la réinitialisation.');
						button.prop('disabled', false).html(originalText);
					}
				});
			});
		}
	};

	// Initialiser au chargement du DOM
	$(document).ready(function() {
		VitalisiSettingsJS.init();
	});

	// CSS pour l'animation spin
	const style = document.createElement('style');
	style.textContent = `
		@keyframes spin {
			from { transform: rotate(0deg); }
			to { transform: rotate(360deg); }
		}
		.spin {
			animation: spin 1s linear infinite;
			display: inline-block;
		}
	`;
	document.head.appendChild(style);

})(jQuery);
