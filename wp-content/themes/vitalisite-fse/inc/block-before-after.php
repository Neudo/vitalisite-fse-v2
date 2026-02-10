<?php
/**
 * Server-side rendering for the before/after block.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vitalisite_render_before_after_block( $attributes ) {
	$before_url     = ! empty( $attributes['beforeImageUrl'] ) ? $attributes['beforeImageUrl'] : '';
	$after_url      = ! empty( $attributes['afterImageUrl'] ) ? $attributes['afterImageUrl'] : '';
	$before_label   = ! empty( $attributes['beforeLabel'] ) ? $attributes['beforeLabel'] : __( 'Avant', 'vitalisite-fse' );
	$after_label    = ! empty( $attributes['afterLabel'] ) ? $attributes['afterLabel'] : __( 'Après', 'vitalisite-fse' );
	$show_labels    = isset( $attributes['showLabels'] ) ? $attributes['showLabels'] : true;
	$show_disclaimer = isset( $attributes['showDisclaimer'] ) ? $attributes['showDisclaimer'] : false;
	$disclaimer_text = ! empty( $attributes['disclaimerText'] ) ? $attributes['disclaimerText'] : '';

	if ( ! $before_url && ! $after_url ) {
		return '<div class="vitalisite-before-after-placeholder"><p>' . esc_html__( 'Sélectionnez les images avant et après.', 'vitalisite-fse' ) . '</p></div>';
	}

	ob_start();
	?>
	<div class="vitalisite-before-after">
		<div class="vitalisite-before-after__grid">
			<div class="vitalisite-before-after__image-wrapper">
				<?php if ( $before_url ) : ?>
					<img src="<?php echo esc_url( $before_url ); ?>" alt="<?php echo esc_attr( $before_label ); ?>" loading="lazy">
				<?php endif; ?>
				<?php if ( $show_labels ) : ?>
					<span class="vitalisite-before-after__label"><?php echo esc_html( $before_label ); ?></span>
				<?php endif; ?>
			</div>

			<div class="vitalisite-before-after__image-wrapper">
				<?php if ( $after_url ) : ?>
					<img src="<?php echo esc_url( $after_url ); ?>" alt="<?php echo esc_attr( $after_label ); ?>" loading="lazy">
				<?php endif; ?>
				<?php if ( $show_labels ) : ?>
					<span class="vitalisite-before-after__label"><?php echo esc_html( $after_label ); ?></span>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $show_disclaimer && $disclaimer_text ) : ?>
			<p class="vitalisite-before-after__disclaimer"><?php echo esc_html( $disclaimer_text ); ?></p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
