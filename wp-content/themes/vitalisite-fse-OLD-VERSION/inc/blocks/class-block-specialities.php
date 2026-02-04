<?php
/**
 * Block: Specialities
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Block_Specialities {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'register_swiper' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_assets' ) );
	}

	/**
	 * Enregistre Swiper
	 */
	public function register_swiper() {
		wp_register_style(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			array(),
			'11.0.0'
		);
		
		wp_register_script(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			array(),
			'11.0.0',
			true
		);
	}

	/**
	 * Enqueue assets pour l'éditeur
	 */
	public function enqueue_editor_assets() {
		// Swiper CSS
		wp_enqueue_style(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
			array(),
			'11.0.0'
		);
		
		// Swiper JS
		wp_enqueue_script(
			'swiper',
			'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
			array(),
			'11.0.0',
			true
		);
	}

	/**
	 * Enregistre le bloc
	 */
	public function register_block() {
		register_block_type( 'vitalisite/specialities', array(
			'api_version'     => 3,
			'title'           => __( 'Spécialités Vitalisite', 'vitalisite-fse' ),
			'description'     => __( 'Affiche les spécialités médicales', 'vitalisite-fse' ),
			'category'        => 'vitalisite-fse-sections',
			'icon'            => 'portfolio',
			'keywords'        => array( 'specialities', 'spécialités', 'services', 'médical', 'slider' ),
			'supports'        => array(
				'html'   => false,
				'align'  => array( 'wide', 'full' ),
				'anchor' => true,
			),
			'attributes'      => array(
				'count' => array(
					'type'    => 'number',
					'default' => 6,
				),
				'columns' => array(
					'type'    => 'number',
					'default' => 3,
				),
				'showDescription' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'linkToSingle' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'layout' => array(
					'type'    => 'string',
					'default' => 'slider',
				),
				'showNavigation' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'autoplay' => array(
					'type'    => 'boolean',
					'default' => false,
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
		$count = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 6;
		$columns = isset( $attributes['columns'] ) ? absint( $attributes['columns'] ) : 3;
		$show_description = isset( $attributes['showDescription'] ) ? $attributes['showDescription'] : true;
		$link_to_single = isset( $attributes['linkToSingle'] ) ? $attributes['linkToSingle'] : true;
		$layout = isset( $attributes['layout'] ) ? $attributes['layout'] : 'slider';
		$show_navigation = isset( $attributes['showNavigation'] ) ? $attributes['showNavigation'] : true;
		$autoplay = isset( $attributes['autoplay'] ) ? $attributes['autoplay'] : false;

		$specialities = get_posts( array(
			'post_type'      => 'specialities',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		) );

		if ( empty( $specialities ) ) {
			return '<p class="vitalisite-no-content">' . esc_html__( 'Aucune spécialité à afficher.', 'vitalisite-fse' ) . '</p>';
		}

		// Enqueue Swiper si layout slider
		if ( $layout === 'slider' ) {
			wp_enqueue_style( 'swiper' );
			wp_enqueue_script( 'swiper' );
		}

		$wrapper_classes = array(
			'wp-block-vitalisite-specialities',
			'vitalisite-specialities',
			'vitalisite-specialities--' . $layout,
		);

		if ( $layout === 'grid' ) {
			$wrapper_classes[] = 'vitalisite-specialities--cols-' . $columns;
		}

		$unique_id = 'vitalisite-specialities-' . uniqid();

		ob_start();
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" id="<?php echo esc_attr( $unique_id ); ?>">
			<?php if ( $layout === 'slider' ) : ?>
				<div class="swiper vitalisite-specialities__swiper">
					<div class="swiper-wrapper">
						<?php foreach ( $specialities as $speciality ) : 
							$short_desc = get_post_meta( $speciality->ID, '_speciality_short_description', true );
							$permalink = get_permalink( $speciality->ID );
							$photo_id = get_post_meta( $speciality->ID, '_speciality_photo', true );
							$thumbnail = $photo_id ? wp_get_attachment_image_url( $photo_id, 'medium_large' ) : '';
						?>
							<div class="swiper-slide">
								<div class="vitalisite-speciality-card">
									<?php if ( $link_to_single ) : ?>
										<a href="<?php echo esc_url( $permalink ); ?>" class="vitalisite-speciality-card__link">
									<?php endif; ?>
									
									<?php if ( $thumbnail ) : ?>
										<div class="vitalisite-speciality-card__image">
											<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $speciality->post_title ); ?>" loading="lazy">
										</div>
									<?php endif; ?>
									
									<h3 class="vitalisite-speciality-card__title"><?php echo esc_html( $speciality->post_title ); ?></h3>
									
									<?php if ( $show_description && $short_desc ) : ?>
										<p class="vitalisite-speciality-card__description"><?php echo esc_html( $short_desc ); ?></p>
									<?php endif; ?>
									
									<?php if ( $link_to_single ) : ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					
					<?php if ( $show_navigation ) : ?>
						<div class="vitalisite-specialities__navigation">
							<button class="vitalisite-specialities__nav vitalisite-specialities__nav--prev" aria-label="<?php esc_attr_e( 'Précédent', 'vitalisite-fse' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
							</button>
							<button class="vitalisite-specialities__nav vitalisite-specialities__nav--next" aria-label="<?php esc_attr_e( 'Suivant', 'vitalisite-fse' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
							</button>
						</div>
					<?php endif; ?>
				</div>
				
				<script>
				document.addEventListener('DOMContentLoaded', function() {
					new Swiper('#<?php echo esc_js( $unique_id ); ?> .swiper', {
						slidesPerView: 1,
						spaceBetween: 20,
						<?php if ( $autoplay ) : ?>
						autoplay: {
							delay: 5000,
							disableOnInteraction: false,
						},
						<?php endif; ?>
						<?php if ( $show_navigation ) : ?>
						navigation: {
							nextEl: '#<?php echo esc_js( $unique_id ); ?> .vitalisite-specialities__nav--next',
							prevEl: '#<?php echo esc_js( $unique_id ); ?> .vitalisite-specialities__nav--prev',
						},
						<?php endif; ?>
						breakpoints: {
							640: {
								slidesPerView: 2,
								spaceBetween: 20,
							},
							1024: {
								slidesPerView: <?php echo esc_js( $columns ); ?>,
								spaceBetween: 30,
							},
						},
					});
				});
				</script>
			<?php else : ?>
				<div class="vitalisite-specialities__grid">
					<?php foreach ( $specialities as $speciality ) : 
						$short_desc = get_post_meta( $speciality->ID, '_speciality_short_description', true );
						$permalink = get_permalink( $speciality->ID );
						$photo_id = get_post_meta( $speciality->ID, '_speciality_photo', true );
						$thumbnail = $photo_id ? wp_get_attachment_image_url( $photo_id, 'medium_large' ) : '';
					?>
						<div class="vitalisite-speciality-card">
							<?php if ( $link_to_single ) : ?>
								<a href="<?php echo esc_url( $permalink ); ?>" class="vitalisite-speciality-card__link">
							<?php endif; ?>
							
							<?php if ( $thumbnail ) : ?>
								<div class="vitalisite-speciality-card__image">
									<img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php echo esc_attr( $speciality->post_title ); ?>" loading="lazy">
								</div>
							<?php endif; ?>
							
							<h3 class="vitalisite-speciality-card__title"><?php echo esc_html( $speciality->post_title ); ?></h3>
							
							<?php if ( $show_description && $short_desc ) : ?>
								<p class="vitalisite-speciality-card__description"><?php echo esc_html( $short_desc ); ?></p>
							<?php endif; ?>
							
							<?php if ( $link_to_single ) : ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}

// Initialiser
Vitalisite_Block_Specialities::get_instance();
