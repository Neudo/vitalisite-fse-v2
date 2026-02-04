<?php
/**
 * Block: Team (Doctors)
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Block_Team {

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
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Enregistre le bloc
	 */
	public function register_block() {
		register_block_type( 'vitalisite/team', array(
			'api_version'     => 3,
			'title'           => __( 'Équipe Vitalisite', 'vitalisite-fse' ),
			'description'     => __( 'Affiche l\'équipe médicale', 'vitalisite-fse' ),
			'category'        => 'vitalisite-fse-sections',
			'icon'            => 'groups',
			'keywords'        => array( 'team', 'équipe', 'doctors', 'médecins', 'personnel' ),
			'supports'        => array(
				'html'   => false,
				'align'  => array( 'wide', 'full' ),
				'anchor' => true,
			),
			'attributes'      => array(
				'count' => array(
					'type'    => 'number',
					'default' => 4,
				),
				'columns' => array(
					'type'    => 'number',
					'default' => 4,
				),
				'showSpeciality' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showPhone' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'showBookingButton' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showOnlineStatus' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'layout' => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'filterBySpeciality' => array(
					'type'    => 'number',
					'default' => 0,
				),
			),
			'render_callback' => array( $this, 'render_block' ),
			'editor_script'   => 'vitalisite-blocks-editor',
			'editor_style'    => 'vitalisite-blocks-editor-style',
			'style'           => 'vitalisite-blocks-style',
		) );
	}

	/**
	 * Rendu du bloc
	 */
	public function render_block( $attributes, $content ) {
		$count = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 4;
		$columns = isset( $attributes['columns'] ) ? absint( $attributes['columns'] ) : 4;
		$show_speciality = isset( $attributes['showSpeciality'] ) ? $attributes['showSpeciality'] : true;
		$show_phone = isset( $attributes['showPhone'] ) ? $attributes['showPhone'] : false;
		$show_booking = isset( $attributes['showBookingButton'] ) ? $attributes['showBookingButton'] : true;
		$show_online = isset( $attributes['showOnlineStatus'] ) ? $attributes['showOnlineStatus'] : true;
		$layout = isset( $attributes['layout'] ) ? $attributes['layout'] : 'grid';
		$filter_speciality = isset( $attributes['filterBySpeciality'] ) ? absint( $attributes['filterBySpeciality'] ) : 0;

		$query_args = array(
			'post_type'      => 'doctors',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);

		// Filtre par spécialité
		if ( $filter_speciality > 0 ) {
			$query_args['meta_query'] = array(
				array(
					'key'   => '_doctor_speciality',
					'value' => $filter_speciality,
				),
			);
		}

		$doctors = get_posts( $query_args );

		if ( empty( $doctors ) ) {
			return '<p class="vitalisite-no-content">' . esc_html__( 'Aucun membre de l\'équipe à afficher.', 'vitalisite-fse' ) . '</p>';
		}

		$wrapper_classes = array(
			'wp-block-vitalisite-team',
			'vitalisite-team',
			'vitalisite-team--' . $layout,
			'vitalisite-team--cols-' . $columns,
		);

		ob_start();
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>">
			<div class="vitalisite-team__grid">
				<?php foreach ( $doctors as $doctor ) : 
					$first_name = get_post_meta( $doctor->ID, '_doctor_first_name', true );
					$last_name = get_post_meta( $doctor->ID, '_doctor_last_name', true );
					$speciality_id = get_post_meta( $doctor->ID, '_doctor_speciality', true );
					$phone = get_post_meta( $doctor->ID, '_doctor_phone', true );
					$booking_url = get_post_meta( $doctor->ID, '_doctor_booking_url', true );
					$available_online = get_post_meta( $doctor->ID, '_doctor_available_online', true );
					$thumbnail = get_the_post_thumbnail_url( $doctor->ID, 'medium' );
					$full_name = trim( $first_name . ' ' . $last_name );
					if ( empty( $full_name ) ) {
						$full_name = $doctor->post_title;
					}
					
					$speciality_name = '';
					if ( $speciality_id ) {
						$speciality_post = get_post( $speciality_id );
						if ( $speciality_post ) {
							$speciality_name = $speciality_post->post_title;
						}
					}
				?>
					<div class="vitalisite-team-card">
						<div class="vitalisite-team-card__image">
							<?php if ( $thumbnail ) : ?>
								<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $full_name ); ?>">
							<?php else : ?>
								<div class="vitalisite-team-card__placeholder">
									<span class="dashicons dashicons-admin-users"></span>
								</div>
							<?php endif; ?>
							
							<?php if ( $show_online && $available_online === '1' ) : ?>
								<span class="vitalisite-team-card__online-badge" title="<?php esc_attr_e( 'Disponible en ligne', 'vitalisite-fse' ); ?>">
									<span class="dashicons dashicons-video-alt2"></span>
								</span>
							<?php endif; ?>
						</div>
						
						<div class="vitalisite-team-card__content">
							<h3 class="vitalisite-team-card__name">
								<a href="<?php echo esc_url( get_permalink( $doctor->ID ) ); ?>">
									<?php echo esc_html( $full_name ); ?>
								</a>
							</h3>
							
							<?php if ( $show_speciality && $speciality_name ) : ?>
								<p class="vitalisite-team-card__speciality"><?php echo esc_html( $speciality_name ); ?></p>
							<?php endif; ?>
							
							<?php if ( $show_phone && $phone ) : ?>
								<p class="vitalisite-team-card__phone">
									<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">
										<span class="dashicons dashicons-phone"></span>
										<?php echo esc_html( $phone ); ?>
									</a>
								</p>
							<?php endif; ?>
							
							<?php if ( $show_booking && $booking_url ) : ?>
								<a href="<?php echo esc_url( $booking_url ); ?>" class="vitalisite-team-card__booking wp-block-button__link" target="_blank" rel="noopener">
									<?php esc_html_e( 'Prendre RDV', 'vitalisite-fse' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

// Initialiser
Vitalisite_Block_Team::get_instance();
