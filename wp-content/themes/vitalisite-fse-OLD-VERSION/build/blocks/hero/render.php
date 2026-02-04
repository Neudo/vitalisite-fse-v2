<?php
/**
 * Rendu front-end du bloc Hero
 *
 * @param array    $attributes Les attributs du bloc.
 * @param string   $content    Le contenu du bloc.
 * @param WP_Block $block      L'instance du bloc.
 */

$image_url      = $attributes['imageUrl'] ?? '';
$overlay_color  = $attributes['overlayColor'] ?? '#111111';
$overlay_opacity = ( $attributes['overlayOpacity'] ?? 30 ) / 100;
$min_height     = $attributes['minHeight'] ?? 50;
$min_height_unit = $attributes['minHeightUnit'] ?? 'vh';
$title          = $attributes['title'] ?? '';
$subtitle       = $attributes['subtitle'] ?? '';
$description    = $attributes['description'] ?? '';
$button_text    = $attributes['buttonText'] ?? '';
$button_url     = $attributes['buttonUrl'] ?? '#';
$content_position = $attributes['contentPosition'] ?? 'center left';

// Classes de position
$position_parts = explode( ' ', $content_position );
$vertical       = $position_parts[0] ?? 'center';
$horizontal     = $position_parts[1] ?? 'left';

$content_classes = 'wp-block-vitalisite-hero__content';
$content_classes .= ' align-' . $horizontal;
$content_classes .= ' valign-' . $vertical;

$wrapper_attributes = get_block_wrapper_attributes( [
	'class' => 'has-theme-border-radius alignfull',
	'style' => sprintf( 'min-height: %d%s;', $min_height, $min_height_unit ),
] );
?>

<div <?php echo $wrapper_attributes; ?>>
	<?php if ( $image_url ) : ?>
		<img 
			class="wp-block-vitalisite-hero__image" 
			src="<?php echo esc_url( $image_url ); ?>" 
			alt=""
		/>
	<?php endif; ?>
	
	<span 
		class="wp-block-vitalisite-hero__overlay" 
		style="background-color: <?php echo esc_attr( $overlay_color ); ?>; opacity: <?php echo esc_attr( $overlay_opacity ); ?>;"
		aria-hidden="true"
	></span>
	
	<div class="<?php echo esc_attr( $content_classes ); ?>">
		<div class="wp-block-vitalisite-hero__inner">
			<?php if ( $title ) : ?>
				<h1 class="wp-block-vitalisite-hero__title"><?php echo wp_kses_post( $title ); ?></h1>
			<?php endif; ?>
			
			<?php if ( $subtitle ) : ?>
				<p class="wp-block-vitalisite-hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
			
			<?php if ( $description ) : ?>
				<p class="wp-block-vitalisite-hero__description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
			
			<?php if ( $button_text ) : ?>
				<div class="wp-block-vitalisite-hero__button-wrapper">
					<a href="<?php echo esc_url( $button_url ); ?>" class="wp-block-vitalisite-hero__button wp-element-button">
						<?php echo esc_html( $button_text ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
