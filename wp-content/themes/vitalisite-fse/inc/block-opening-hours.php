<?php
/**
 * Server-side rendering for the opening hours block.
 *
 * Reads opening hours from the vitalisite_hours option (Settings API).
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vitalisite_render_opening_hours_block( $attributes ) {
	$show_status    = isset( $attributes['showStatus'] ) ? $attributes['showStatus'] : true;
	$show_emergency = isset( $attributes['showEmergency'] ) ? $attributes['showEmergency'] : false;
	$emergency_text = ! empty( $attributes['emergencyText'] ) ? $attributes['emergencyText'] : '';

	// Read from Settings API option.
	$options         = get_option( 'vitalisite_hours', array() );
	$globally_closed = ! empty( $options['globally_closed'] );

	// Fallback emergency text from options if not set in block attributes.
	if ( empty( $emergency_text ) && ! empty( $options['emergency_text'] ) ) {
		$emergency_text = $options['emergency_text'];
	}

	$days = array(
		'monday'    => __( 'Lundi', 'vitalisite-fse' ),
		'tuesday'   => __( 'Mardi', 'vitalisite-fse' ),
		'wednesday' => __( 'Mercredi', 'vitalisite-fse' ),
		'thursday'  => __( 'Jeudi', 'vitalisite-fse' ),
		'friday'    => __( 'Vendredi', 'vitalisite-fse' ),
		'saturday'  => __( 'Samedi', 'vitalisite-fse' ),
		'sunday'    => __( 'Dimanche', 'vitalisite-fse' ),
	);

	// Build hours array from option.
	$hours = array();
	foreach ( array_keys( $days ) as $day ) {
		$day_data = isset( $options[ $day ] ) ? $options[ $day ] : array();
		$hours[ $day ] = array(
			'closed' => $globally_closed || ! empty( $day_data['closed'] ),
			'open'   => isset( $day_data['open'] ) ? $day_data['open'] : '09:00',
			'close'  => isset( $day_data['close'] ) ? $day_data['close'] : '18:00',
		);
	}

	// Determine current day and open status.
	$timezone        = new DateTimeZone( wp_timezone_string() );
	$now             = new DateTime( 'now', $timezone );
	$current_day_key = strtolower( $now->format( 'l' ) );
	$current_time    = $now->format( 'H:i' );

	$is_open = false;
	if ( ! $globally_closed && isset( $hours[ $current_day_key ] ) && ! $hours[ $current_day_key ]['closed'] ) {
		$open  = $hours[ $current_day_key ]['open'];
		$close = $hours[ $current_day_key ]['close'];
		if ( $current_time >= $open && $current_time <= $close ) {
			$is_open = true;
		}
	}

	ob_start();
	?>
	<div class="vitalisite-opening-hours">
		<?php if ( $show_status ) : ?>
			<div class="vitalisite-opening-hours__status vitalisite-opening-hours__status--<?php echo $is_open ? 'open' : 'closed'; ?>">
				<span class="vitalisite-opening-hours__status-dot"></span>
				<?php echo $is_open ? esc_html__( 'Actuellement ouvert', 'vitalisite-fse' ) : esc_html__( 'Actuellement fermé', 'vitalisite-fse' ); ?>
			</div>
		<?php endif; ?>

		<?php foreach ( $days as $key => $label ) :
			$day_data   = $hours[ $key ];
			$is_today   = ( $key === $current_day_key );
			$row_class  = 'vitalisite-opening-hours__row';
			if ( $is_today ) {
				$row_class .= ' vitalisite-opening-hours__row--today';
			}
		?>
			<div class="<?php echo esc_attr( $row_class ); ?>">
				<span class="vitalisite-opening-hours__day">
					<?php echo esc_html( $label ); ?>
					<?php if ( $is_today ) : ?>
						<small>(<?php esc_html_e( "aujourd'hui", 'vitalisite-fse' ); ?>)</small>
					<?php endif; ?>
				</span>
				<?php if ( $day_data['closed'] ) : ?>
					<span class="vitalisite-opening-hours__closed"><?php esc_html_e( 'Fermé', 'vitalisite-fse' ); ?></span>
				<?php else : ?>
					<span class="vitalisite-opening-hours__time">
						<?php echo esc_html( $day_data['open'] ); ?> – <?php echo esc_html( $day_data['close'] ); ?>
					</span>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<?php if ( $show_emergency && $emergency_text ) : ?>
			<div class="vitalisite-opening-hours__emergency">
				<?php echo esc_html( $emergency_text ); ?>
			</div>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
