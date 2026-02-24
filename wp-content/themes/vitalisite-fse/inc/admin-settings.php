<?php
/**
 * Vitalisite Admin Settings Page.
 *
 * Registers a top-level "Vitalisite" menu page with tabbed sections
 * using the WordPress Settings API. No external dependencies.
 *
 * Options are stored as:
 *   - vitalisite_cabinet   (array) — Cabinet info fields
 *   - vitalisite_hours     (array) — Opening hours per day + global closed + emergency
 *   - vitalisite_social    (array) — Social links
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

const OPTION_CABINET  = 'vitalisite_cabinet';
const OPTION_HOURS    = 'vitalisite_hours';
const OPTION_SOCIAL   = 'vitalisite_social';
const OPTION_FEATURES = 'vitalisite_features';
const OPTION_BLOG     = 'vitalisite_blog';

/* ------------------------------------------------------------------ */
/*  Helper: get a single option value with a default                  */
/* ------------------------------------------------------------------ */

/**
 * Retrieve a value from one of the Vitalisite option groups.
 *
 * @param string $group   One of OPTION_CABINET, OPTION_HOURS, OPTION_SOCIAL.
 * @param string $key     The field key inside the group.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function vitalisite_get_option( $group, $key, $default = '' ) {
	$options = get_option( $group, array() );
	return isset( $options[ $key ] ) && '' !== $options[ $key ] ? $options[ $key ] : $default;
}

/* ------------------------------------------------------------------ */
/*  1. Register menu page                                             */
/* ------------------------------------------------------------------ */

function admin_menu() {
	add_menu_page(
		__( 'Vitalisite', 'vitalisite-fse' ),
		__( 'Vitalisite', 'vitalisite-fse' ),
		'manage_options',
		'vitalisite-settings',
		__NAMESPACE__ . '\render_settings_page',
		'dashicons-heart',
		3
	);
}
add_action( 'admin_menu', __NAMESPACE__ . '\admin_menu' );

/* ------------------------------------------------------------------ */
/*  2. Register settings, sections & fields                           */
/* ------------------------------------------------------------------ */

function register_settings() {

	/* ---- Tab 1: Cabinet ---- */

	register_setting( 'vitalisite_tab_cabinet', OPTION_CABINET, array(
		'type'              => 'array',
		'sanitize_callback' => __NAMESPACE__ . '\sanitize_cabinet',
	) );

	add_settings_section(
		'vitalisite_cabinet_section',
		__( 'Informations du cabinet', 'vitalisite-fse' ),
		__NAMESPACE__ . '\section_cabinet_description',
		'vitalisite_tab_cabinet'
	);

	$cabinet_fields = get_cabinet_fields();
	foreach ( $cabinet_fields as $id => $field ) {
		add_settings_field(
			$id,
			$field['label'],
			__NAMESPACE__ . '\render_field',
			'vitalisite_tab_cabinet',
			'vitalisite_cabinet_section',
			array_merge( $field, array(
				'id'    => $id,
				'group' => OPTION_CABINET,
			) )
		);
	}

	/* ---- Tab 2: Hours ---- */

	register_setting( 'vitalisite_tab_hours', OPTION_HOURS, array(
		'type'              => 'array',
		'sanitize_callback' => __NAMESPACE__ . '\sanitize_hours',
	) );

	add_settings_section(
		'vitalisite_hours_section',
		__( 'Horaires d\'ouverture', 'vitalisite-fse' ),
		__NAMESPACE__ . '\section_hours_description',
		'vitalisite_tab_hours'
	);

	// "Cabinet fermé" global toggle is rendered inside the section callback.

	/* ---- Tab 3: Social ---- */

	register_setting( 'vitalisite_tab_social', OPTION_SOCIAL, array(
		'type'              => 'array',
		'sanitize_callback' => __NAMESPACE__ . '\sanitize_social',
	) );

	add_settings_section(
		'vitalisite_social_section',
		__( 'Réseaux sociaux & liens', 'vitalisite-fse' ),
		__NAMESPACE__ . '\section_social_description',
		'vitalisite_tab_social'
	);

	$social_fields = get_social_fields();
	foreach ( $social_fields as $id => $field ) {
		add_settings_field(
			$id,
			$field['label'],
			__NAMESPACE__ . '\render_field',
			'vitalisite_tab_social',
			'vitalisite_social_section',
			array_merge( $field, array(
				'id'    => $id,
				'group' => OPTION_SOCIAL,
			) )
		);
	}

	/* ---- Tab 4: Features (Banner, Sticky CTA) ---- */

	register_setting( 'vitalisite_tab_features', OPTION_FEATURES, array(
		'type'              => 'array',
		'sanitize_callback' => __NAMESPACE__ . '\sanitize_features',
	) );

	add_settings_section(
		'vitalisite_banner_section',
		__( 'Bannière d\'annonce', 'vitalisite-fse' ),
		__NAMESPACE__ . '\section_banner_description',
		'vitalisite_tab_features'
	);

	$banner_fields = get_banner_fields();
	foreach ( $banner_fields as $id => $field ) {
		add_settings_field(
			$id,
			$field['label'],
			__NAMESPACE__ . '\render_field',
			'vitalisite_tab_features',
			'vitalisite_banner_section',
			array_merge( $field, array(
				'id'    => $id,
				'group' => OPTION_FEATURES,
			) )
		);
	}

	add_settings_section(
		'vitalisite_cta_section',
		__( 'CTA sticky mobile', 'vitalisite-fse' ),
		__NAMESPACE__ . '\section_cta_description',
		'vitalisite_tab_features'
	);

	$cta_fields = get_cta_fields();
	foreach ( $cta_fields as $id => $field ) {
		add_settings_field(
			$id,
			$field['label'],
			__NAMESPACE__ . '\render_field',
			'vitalisite_tab_features',
			'vitalisite_cta_section',
			array_merge( $field, array(
				'id'    => $id,
				'group' => OPTION_FEATURES,
			) )
		);
	}

	/* ---- Tab 5: Blog ---- */

	register_setting( 'vitalisite_tab_blog', OPTION_BLOG, array(
		'type'              => 'array',
		'sanitize_callback' => __NAMESPACE__ . '\sanitize_blog',
	) );

	add_settings_section(
		'vitalisite_blog_section',
		__( 'Blog & Actualités', 'vitalisite-fse' ),
		__NAMESPACE__ . '\section_blog_description',
		'vitalisite_tab_blog'
	);

	$blog_fields = get_blog_fields();
	foreach ( $blog_fields as $id => $field ) {
		add_settings_field(
			$id,
			$field['label'],
			__NAMESPACE__ . '\render_field',
			'vitalisite_tab_blog',
			'vitalisite_blog_section',
			array_merge( $field, array(
				'id'    => $id,
				'group' => OPTION_BLOG,
			) )
		);
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\register_settings' );

/* ------------------------------------------------------------------ */
/*  3. Field definitions                                              */
/* ------------------------------------------------------------------ */

function get_cabinet_fields() {
	return array(
		'doctor_name' => array(
			'label'       => __( 'Nom du praticien', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => 'Dr. Jean Dupont',
		),
		'doctor_specialty' => array(
			'label'       => __( 'Spécialité', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => 'Ostéopathe D.O.',
		),
		'doctor_photo' => array(
			'label' => __( 'Photo du praticien', 'vitalisite-fse' ),
			'type'  => 'image',
		),
		'phone' => array(
			'label'       => __( 'Téléphone', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => '01 42 42 42 42',
		),
		'email' => array(
			'label'       => __( 'Email de contact', 'vitalisite-fse' ),
			'type'        => 'email',
			'placeholder' => 'contact@cabinet.fr',
		),
		'address' => array(
			'label'       => __( 'Adresse du cabinet', 'vitalisite-fse' ),
			'type'        => 'textarea',
			'placeholder' => '1 rue de la Liberté, 75013 Paris',
		),
		'appointment_url' => array(
			'label'       => __( 'Lien de prise de RDV', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://www.doctolib.fr/…',
		),
		'google_business_id' => array(
			'label'       => __( 'ID Google Business', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => 'ChIJ…',
			'description' => __( 'Identifiant Google Business pour afficher les avis Google.', 'vitalisite-fse' ),
		),
		'show_phone_footer' => array(
			'label'       => __( 'Afficher le téléphone dans le footer', 'vitalisite-fse' ),
			'type'        => 'checkbox',
		),
		'show_email_footer' => array(
			'label'       => __( 'Afficher l\'email dans le footer', 'vitalisite-fse' ),
			'type'        => 'checkbox',
		),
		'show_address_footer' => array(
			'label'       => __( 'Afficher l\'adresse dans le footer', 'vitalisite-fse' ),
			'type'        => 'checkbox',
		),
	);
}

function get_banner_fields() {
	return array(
		'banner_enabled' => array(
			'label' => __( 'Activer la bannière', 'vitalisite-fse' ),
			'type'  => 'checkbox',
		),
		'banner_text' => array(
			'label'       => __( 'Texte de la bannière', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => __( 'Cabinet fermé du 24 au 31 décembre.', 'vitalisite-fse' ),
		),
		'banner_link_text' => array(
			'label'       => __( 'Texte du lien (optionnel)', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => __( 'En savoir plus', 'vitalisite-fse' ),
		),
		'banner_link_url' => array(
			'label'       => __( 'URL du lien (optionnel)', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://…',
		),
		'banner_style' => array(
			'label'       => __( 'Style de la bannière', 'vitalisite-fse' ),
			'type'        => 'select',
			'options'     => array(
				'info'    => __( 'Information (bleu)', 'vitalisite-fse' ),
				'warning' => __( 'Avertissement (orange)', 'vitalisite-fse' ),
				'success' => __( 'Succès (vert)', 'vitalisite-fse' ),
				'urgent'  => __( 'Urgent (rouge)', 'vitalisite-fse' ),
			),
		),
		'banner_dismissible' => array(
			'label' => __( 'Permettre de fermer la bannière', 'vitalisite-fse' ),
			'type'  => 'checkbox',
		),
	);
}

function get_cta_fields() {
	return array(
		'cta_enabled' => array(
			'label' => __( 'Activer le CTA sticky mobile', 'vitalisite-fse' ),
			'type'  => 'checkbox',
		),
		'cta_text' => array(
			'label'       => __( 'Texte du bouton', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => __( 'Prendre rendez-vous', 'vitalisite-fse' ),
		),
		'cta_url' => array(
			'label'       => __( 'URL du bouton', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://www.doctolib.fr/…',
			'description' => __( 'Si vide, le lien de prise de RDV des infos du cabinet sera utilisé.', 'vitalisite-fse' ),
		),
		'cta_phone' => array(
			'label' => __( 'Afficher aussi un bouton téléphone', 'vitalisite-fse' ),
			'type'  => 'checkbox',
		),
	);
}

function get_social_fields() {
	return array(
		'facebook' => array(
			'label'       => __( 'Facebook', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://facebook.com/…',
		),
		'instagram' => array(
			'label'       => __( 'Instagram', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://instagram.com/…',
		),
		'linkedin' => array(
			'label'       => __( 'LinkedIn', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://linkedin.com/in/…',
		),
		'doctolib' => array(
			'label'       => __( 'Doctolib', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://www.doctolib.fr/…',
		),
		'google_maps' => array(
			'label'       => __( 'Google Maps', 'vitalisite-fse' ),
			'type'        => 'url',
			'placeholder' => 'https://maps.google.com/…',
			'description' => __( 'Lien Google Maps vers votre cabinet.', 'vitalisite-fse' ),
		),
	);
}

function get_blog_fields() {
	return array(
		'back_text' => array(
			'label'       => __( 'Texte du lien Retour', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => 'Retour aux actualités',
		),
		'read_more_text' => array(
			'label'       => __( 'Texte "Lire l\'article"', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => 'Lire l\'article',
		),
		'excerpt_length' => array(
			'label'       => __( 'Longueur de l\'extrait (en mots)', 'vitalisite-fse' ),
			'type'        => 'number',
			'placeholder' => '20',
		),
		'all_categories_text' => array(
			'label'       => __( 'Texte de réinitialisation des filtres ("Tous")', 'vitalisite-fse' ),
			'type'        => 'text',
			'placeholder' => 'Tous',
		),
	);
}

/* ------------------------------------------------------------------ */
/*  4. Section descriptions                                           */
/* ------------------------------------------------------------------ */

function section_cabinet_description() {
	echo '<p>' . esc_html__( 'Ces informations sont utilisées dans les blocs du site (en-tête, pied de page, formulaire de contact, etc.).', 'vitalisite-fse' ) . '</p>';
}

function section_hours_description() {
	// Render the global "cabinet fermé" checkbox + hours table here.
	$options = get_option( OPTION_HOURS, array() );
	render_hours_table( $options );
}

function section_social_description() {
	echo '<p>' . esc_html__( 'Ajoutez vos liens de réseaux sociaux. Ils seront affichés dans le pied de page et les blocs sociaux.', 'vitalisite-fse' ) . '</p>';
}

function section_banner_description() {
	echo '<p>' . esc_html__( 'Affichez une bannière d\'annonce en haut du site (fermeture exceptionnelle, promotion, info importante…).', 'vitalisite-fse' ) . '</p>';
}

function section_cta_description() {
	echo '<p>' . esc_html__( 'Barre fixe en bas de l\'écran sur mobile avec un bouton d\'action (prise de RDV, appel…). Apparaît après un léger scroll.', 'vitalisite-fse' ) . '</p>';
}

function section_blog_description() {
	echo '<p>' . esc_html__( 'Personnalisez les textes de la section actualités/blog du site.', 'vitalisite-fse' ) . '</p>';
}

/* ------------------------------------------------------------------ */
/*  5. Generic field renderer                                         */
/* ------------------------------------------------------------------ */

function render_field( $args ) {
	$group       = $args['group'];
	$id          = $args['id'];
	$type        = isset( $args['type'] ) ? $args['type'] : 'text';
	$placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';
	$description = isset( $args['description'] ) ? $args['description'] : '';
	$value       = vitalisite_get_option( $group, $id );
	$name        = esc_attr( $group ) . '[' . esc_attr( $id ) . ']';

	switch ( $type ) {
		case 'textarea':
			printf(
				'<textarea name="%s" id="%s" class="large-text" rows="3" placeholder="%s">%s</textarea>',
				$name,
				esc_attr( $id ),
				esc_attr( $placeholder ),
				esc_textarea( $value )
			);
			break;

		case 'image':
			$image_url = $value ? wp_get_attachment_image_url( $value, 'thumbnail' ) : '';
			?>
			<div class="vitalisite-image-field">
				<input type="hidden" name="<?php echo $name; ?>" id="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_attr( $value ); ?>">
				<div class="vitalisite-image-preview" id="<?php echo esc_attr( $id ); ?>-preview">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="" style="max-width:150px;height:auto;border-radius:50%;">
					<?php endif; ?>
				</div>
				<button type="button" class="button vitalisite-upload-btn" data-target="<?php echo esc_attr( $id ); ?>">
					<?php esc_html_e( 'Choisir une image', 'vitalisite-fse' ); ?>
				</button>
				<?php if ( $value ) : ?>
					<button type="button" class="button vitalisite-remove-btn" data-target="<?php echo esc_attr( $id ); ?>">
						<?php esc_html_e( 'Supprimer', 'vitalisite-fse' ); ?>
					</button>
				<?php endif; ?>
			</div>
			<?php
			break;

		case 'checkbox':
			printf(
				'<label><input type="checkbox" name="%s" id="%s" value="1" %s> %s</label>',
				$name,
				esc_attr( $id ),
				checked( $value, '1', false ),
				esc_html( $description )
			);
			$description = ''; // Already rendered inline.
			break;

		case 'select':
			$options = isset( $args['options'] ) ? $args['options'] : array();
			printf( '<select name="%s" id="%s">', $name, esc_attr( $id ) );
			foreach ( $options as $opt_value => $opt_label ) {
				printf(
					'<option value="%s" %s>%s</option>',
					esc_attr( $opt_value ),
					selected( $value, $opt_value, false ),
					esc_html( $opt_label )
				);
			}
			echo '</select>';
			break;

		default: // text, email, url, number
			printf(
				'<input type="%s" name="%s" id="%s" class="regular-text" value="%s" placeholder="%s">',
				esc_attr( $type ),
				$name,
				esc_attr( $id ),
				esc_attr( $value ),
				esc_attr( $placeholder )
			);
			break;
	}

	if ( $description ) {
		printf( '<p class="description">%s</p>', esc_html( $description ) );
	}
}

/* ------------------------------------------------------------------ */
/*  6. Hours table renderer                                           */
/* ------------------------------------------------------------------ */

function render_hours_table( $options ) {
	$globally_closed = ! empty( $options['globally_closed'] );
	$emergency_text  = isset( $options['emergency_text'] ) ? $options['emergency_text'] : '';

	$days = array(
		'monday'    => __( 'Lundi', 'vitalisite-fse' ),
		'tuesday'   => __( 'Mardi', 'vitalisite-fse' ),
		'wednesday' => __( 'Mercredi', 'vitalisite-fse' ),
		'thursday'  => __( 'Jeudi', 'vitalisite-fse' ),
		'friday'    => __( 'Vendredi', 'vitalisite-fse' ),
		'saturday'  => __( 'Samedi', 'vitalisite-fse' ),
		'sunday'    => __( 'Dimanche', 'vitalisite-fse' ),
	);
	?>

	<div class="vitalisite-hours-settings">
		<label class="vitalisite-global-closed">
			<input type="checkbox"
				name="<?php echo OPTION_HOURS; ?>[globally_closed]"
				value="1"
				<?php checked( $globally_closed ); ?>>
			<strong><?php esc_html_e( 'Cabinet fermé (vacances / absence)', 'vitalisite-fse' ); ?></strong>
			<p class="description"><?php esc_html_e( 'Cochez cette case lorsque le cabinet est temporairement fermé. Le site affichera automatiquement un message "Actuellement fermé" partout.', 'vitalisite-fse' ); ?></p>
		</label>

		<table class="widefat vitalisite-hours-table" id="vitalisite-hours-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Jour', 'vitalisite-fse' ); ?></th>
					<th><?php esc_html_e( 'Fermé', 'vitalisite-fse' ); ?></th>
					<th><?php esc_html_e( 'Ouverture', 'vitalisite-fse' ); ?></th>
					<th><?php esc_html_e( 'Fermeture', 'vitalisite-fse' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $days as $key => $label ) :
					$day_data   = isset( $options[ $key ] ) ? $options[ $key ] : array();
					$is_closed  = ! empty( $day_data['closed'] );
					$open_time  = isset( $day_data['open'] ) ? $day_data['open'] : '09:00';
					$close_time = isset( $day_data['close'] ) ? $day_data['close'] : '18:00';
					$name_base  = OPTION_HOURS . '[' . $key . ']';
				?>
				<tr>
					<td><strong><?php echo esc_html( $label ); ?></strong></td>
					<td>
						<input type="checkbox"
							name="<?php echo $name_base; ?>[closed]"
							value="1"
							class="vitalisite-day-closed"
							<?php checked( $is_closed ); ?>>
					</td>
					<td>
						<input type="time"
							name="<?php echo $name_base; ?>[open]"
							value="<?php echo esc_attr( $open_time ); ?>"
							<?php echo $is_closed ? 'disabled' : ''; ?>>
					</td>
					<td>
						<input type="time"
							name="<?php echo $name_base; ?>[close]"
							value="<?php echo esc_attr( $close_time ); ?>"
							<?php echo $is_closed ? 'disabled' : ''; ?>>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h3 style="margin-top:1.5em;"><?php esc_html_e( 'Message d\'urgence', 'vitalisite-fse' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Affiché lorsque le cabinet est fermé (hors horaires ou vacances).', 'vitalisite-fse' ); ?></p>
		<textarea name="<?php echo OPTION_HOURS; ?>[emergency_text]" class="large-text" rows="2" placeholder="<?php esc_attr_e( 'En cas d\'urgence, appelez le 15.', 'vitalisite-fse' ); ?>"><?php echo esc_textarea( $emergency_text ); ?></textarea>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  7. Sanitization callbacks                                         */
/* ------------------------------------------------------------------ */

function sanitize_cabinet( $input ) {
	$clean = array();
	$fields = get_cabinet_fields();

	foreach ( $fields as $id => $field ) {
		$type = isset( $field['type'] ) ? $field['type'] : 'text';
		if ( 'checkbox' === $type ) {
			$clean[ $id ] = ! empty( $input[ $id ] ) ? '1' : '';
			continue;
		}
		if ( ! isset( $input[ $id ] ) ) {
			$clean[ $id ] = '';
			continue;
		}
		switch ( $type ) {
			case 'email':
				$clean[ $id ] = sanitize_email( $input[ $id ] );
				break;
			case 'url':
				$clean[ $id ] = esc_url_raw( $input[ $id ] );
				break;
			case 'textarea':
				$clean[ $id ] = sanitize_textarea_field( $input[ $id ] );
				break;
			case 'image':
				$clean[ $id ] = absint( $input[ $id ] );
				break;
			default:
				$clean[ $id ] = sanitize_text_field( $input[ $id ] );
				break;
		}
	}
	return $clean;
}

function sanitize_hours( $input ) {
	$clean = array();
	$days  = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );

	$clean['globally_closed'] = ! empty( $input['globally_closed'] ) ? 1 : 0;
	$clean['emergency_text']  = isset( $input['emergency_text'] ) ? sanitize_textarea_field( $input['emergency_text'] ) : '';

	foreach ( $days as $day ) {
		$day_data = isset( $input[ $day ] ) ? $input[ $day ] : array();
		$clean[ $day ] = array(
			'closed' => ! empty( $day_data['closed'] ) ? 1 : 0,
			'open'   => isset( $day_data['open'] ) ? sanitize_text_field( $day_data['open'] ) : '09:00',
			'close'  => isset( $day_data['close'] ) ? sanitize_text_field( $day_data['close'] ) : '18:00',
		);
	}
	return $clean;
}

function sanitize_features( $input ) {
	$clean  = array();
	$fields = array_merge( get_banner_fields(), get_cta_fields() );

	foreach ( $fields as $id => $field ) {
		$type = isset( $field['type'] ) ? $field['type'] : 'text';
		if ( 'checkbox' === $type ) {
			$clean[ $id ] = ! empty( $input[ $id ] ) ? '1' : '';
			continue;
		}
		if ( ! isset( $input[ $id ] ) ) {
			$clean[ $id ] = '';
			continue;
		}
		switch ( $type ) {
			case 'url':
				$clean[ $id ] = esc_url_raw( $input[ $id ] );
				break;
			case 'select':
				$valid = isset( $field['options'] ) ? array_keys( $field['options'] ) : array();
				$clean[ $id ] = in_array( $input[ $id ], $valid, true ) ? $input[ $id ] : ( $valid[0] ?? '' );
				break;
			default:
				$clean[ $id ] = sanitize_text_field( $input[ $id ] );
				break;
		}
	}
	return $clean;
}

function sanitize_social( $input ) {
	$clean  = array();
	$fields = get_social_fields();

	foreach ( $fields as $id => $field ) {
		$clean[ $id ] = isset( $input[ $id ] ) ? esc_url_raw( $input[ $id ] ) : '';
	}
	return $clean;
}

function sanitize_blog( $input ) {
	$clean = array();
	$fields = get_blog_fields();

	foreach ( $fields as $id => $field ) {
		$type = isset( $field['type'] ) ? $field['type'] : 'text';
		if ( 'number' === $type ) {
			$clean[ $id ] = absint( $input[ $id ] );
		} else {
			$clean[ $id ] = sanitize_text_field( $input[ $id ] );
		}
	}
	return $clean;
}

/* ------------------------------------------------------------------ */
/*  8. Render the settings page                                       */
/* ------------------------------------------------------------------ */

function render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$tabs = array(
		'cabinet'  => __( 'Infos du cabinet', 'vitalisite-fse' ),
		'hours'    => __( 'Horaires', 'vitalisite-fse' ),
		'social'   => __( 'Réseaux sociaux', 'vitalisite-fse' ),
		'features' => __( 'Fonctionnalités', 'vitalisite-fse' ),
		'blog'     => __( 'Blog', 'vitalisite-fse' ),
	);

	$current_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'cabinet';
	if ( ! array_key_exists( $current_tab, $tabs ) ) {
		$current_tab = 'cabinet';
	}
	?>
	<div class="wrap vitalisite-settings-wrap">
		<h1><?php esc_html_e( 'Réglages Vitalisite', 'vitalisite-fse' ); ?></h1>

		<nav class="nav-tab-wrapper vitalisite-tabs">
			<?php foreach ( $tabs as $slug => $label ) : ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vitalisite-settings&tab=' . $slug ) ); ?>"
				   class="nav-tab <?php echo $current_tab === $slug ? 'nav-tab-active' : ''; ?>">
					<?php echo esc_html( $label ); ?>
				</a>
			<?php endforeach; ?>
		</nav>

		<form method="post" action="options.php" class="vitalisite-settings-form">
			<?php
			settings_fields( 'vitalisite_tab_' . $current_tab );
			do_settings_sections( 'vitalisite_tab_' . $current_tab );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/* ------------------------------------------------------------------ */
/*  9. Admin assets (CSS + JS for media uploader & hours toggle)      */
/* ------------------------------------------------------------------ */

function admin_enqueue_assets( $hook ) {
	if ( 'toplevel_page_vitalisite-settings' !== $hook ) {
		return;
	}

	wp_enqueue_media();

	$version = VITALISITE_FSE_VERSION;

	wp_enqueue_style(
		'vitalisite-admin-settings',
		get_template_directory_uri() . '/assets/styles/admin-settings.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'vitalisite-admin-settings',
		get_template_directory_uri() . '/assets/js/admin-settings.js',
		array( 'jquery' ),
		$version,
		true
	);
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_assets' );
