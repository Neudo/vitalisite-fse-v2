<?php
/**
 * Server-side rendering for the pricing blocks.
 *
 * @package Vitalisite_FSE
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render pricing item.
 */
function vitalisite_render_pricing_item_block( $attributes ) {
	$title       = ! empty( $attributes['title'] ) ? $attributes['title'] : '';
	$description = ! empty( $attributes['description'] ) ? $attributes['description'] : '';
	$price       = ! empty( $attributes['price'] ) ? $attributes['price'] : '';
	$button_text = ! empty( $attributes['buttonText'] ) ? $attributes['buttonText'] : '';
	$button_url  = ! empty( $attributes['buttonUrl'] ) ? $attributes['buttonUrl'] : '#';

	ob_start();
	?>
	<div class="wp-block-vitalisite-fse-pricing-item vitalisite-pricing-list-card reveal-y">
		<div class="vitalisite-pricing-list-card__content">
			<?php if ( $title ) : ?>
				<h3><?php echo wp_kses_post( $title ); ?></h3>
			<?php endif; ?>
			
			<?php if ( $description ) : ?>
				<p class="vitalisite-pricing-list-card__description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		</div>
		
		<div class="vitalisite-pricing-list-card__action">
			<?php if ( $price ) : ?>
				<p class="vitalisite-pricing-list-card__price"><?php echo wp_kses_post( $price ); ?></p>
			<?php endif; ?>
			
			<div class="wp-block-button btn-primary">
				<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $button_url ); ?>">
					<?php echo esc_html( $button_text ); ?>
				</a>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
