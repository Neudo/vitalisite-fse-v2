<?php
/**
 * Block: Testimonials
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vitalisite_Block_Testimonials {

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
		register_block_type( 'vitalisite/testimonials', array(
			'api_version'     => 3,
			'title'           => __( 'Témoignages Vitalisite', 'vitalisite-fse' ),
			'description'     => __( 'Affiche les témoignages patients', 'vitalisite-fse' ),
			'category'        => 'vitalisite-fse-sections',
			'icon'            => 'testimonial',
			'keywords'        => array( 'testimonials', 'témoignages', 'avis', 'patients' ),
			'supports'        => array(
				'html'   => false,
				'align'  => array( 'wide', 'full' ),
				'anchor' => true,
			),
			'attributes'      => array(
				'count' => array(
					'type'    => 'number',
					'default' => 3,
				),
				'columns' => array(
					'type'    => 'number',
					'default' => 3,
				),
				'showRating' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showDate' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'layout' => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'backgroundColor' => array(
					'type'    => 'string',
					'default' => '',
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
		$count = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 3;
		$columns = isset( $attributes['columns'] ) ? absint( $attributes['columns'] ) : 3;
		$show_rating = isset( $attributes['showRating'] ) ? $attributes['showRating'] : true;
		$show_date = isset( $attributes['showDate'] ) ? $attributes['showDate'] : false;
		$layout = isset( $attributes['layout'] ) ? $attributes['layout'] : 'grid';
		$bg_color = isset( $attributes['backgroundColor'] ) ? $attributes['backgroundColor'] : '';

		$testimonials = get_posts( array(
			'post_type'      => 'testimonials',
			'posts_per_page' => $count,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );

		if ( empty( $testimonials ) ) {
			return '<p class="vitalisite-no-content">' . esc_html__( 'Aucun témoignage à afficher.', 'vitalisite-fse' ) . '</p>';
		}

		$wrapper_classes = array(
			'wp-block-vitalisite-testimonials',
			'vitalisite-testimonials',
			'vitalisite-testimonials--' . $layout,
			'vitalisite-testimonials--cols-' . $columns,
		);

		$wrapper_style = $bg_color ? 'background-color: ' . esc_attr( $bg_color ) . ';' : '';

		ob_start();
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" style="<?php echo esc_attr( $wrapper_style ); ?>">
			<div class="vitalisite-testimonials__grid">
				<?php foreach ( $testimonials as $testimonial ) : 
					$comment = get_post_meta( $testimonial->ID, '_testimonial_comment', true );
					$rating = get_post_meta( $testimonial->ID, '_testimonial_rating', true );
					$author_role = get_post_meta( $testimonial->ID, '_testimonial_author_role', true );
					$date = get_post_meta( $testimonial->ID, '_testimonial_date', true );
				?>
					<div class="vitalisite-testimonial-card">
						<?php if ( $show_rating && $rating ) : ?>
							<div class="vitalisite-testimonial-card__rating">
								<?php echo $this->render_stars( $rating ); ?>
							</div>
						<?php endif; ?>
						
						<blockquote class="vitalisite-testimonial-card__content">
							<?php echo esc_html( $comment ); ?>
						</blockquote>
						
						<div class="vitalisite-testimonial-card__author">
							<span class="vitalisite-testimonial-card__name"><?php echo esc_html( $testimonial->post_title ); ?></span>
							<?php if ( $author_role ) : ?>
								<span class="vitalisite-testimonial-card__role"><?php echo esc_html( $author_role ); ?></span>
							<?php endif; ?>
							<?php if ( $show_date && $date ) : ?>
								<span class="vitalisite-testimonial-card__date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Génère les étoiles
	 */
	private function render_stars( $rating ) {
		$output = '<div class="vitalisite-stars" aria-label="' . sprintf( esc_attr__( 'Note: %d sur 5', 'vitalisite-fse' ), $rating ) . '">';
		
		for ( $i = 1; $i <= 5; $i++ ) {
			$class = $i <= $rating ? 'filled' : 'empty';
			$output .= '<span class="vitalisite-star vitalisite-star--' . $class . '">★</span>';
		}
		
		$output .= '</div>';
		return $output;
	}
}

// Initialiser
Vitalisite_Block_Testimonials::get_instance();
