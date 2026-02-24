<?php
/**
 * Debug visuel des couleurs du thème — affiché uniquement si WP_DEBUG est actif
 *
 * @package Vitalisite_FSE
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
	return;
}

function vitalisite_debug_colors_panel() {
	$colors = [
		[ 'slug' => 'bg',                   'name' => 'Background' ],
		[ 'slug' => 'surface',              'name' => 'Surface' ],
		[ 'slug' => 'surface-2',            'name' => 'Surface 2' ],
		[ 'slug' => 'border',               'name' => 'Border' ],
		[ 'slug' => 'text',                 'name' => 'Text' ],
		[ 'slug' => 'muted',                'name' => 'Muted Text' ],
		[ 'slug' => 'primary',              'name' => 'Primaire' ],
		[ 'slug' => 'on-primary',           'name' => 'Texte sur Primaire' ],
		[ 'slug' => 'secondary',            'name' => 'Secondaire' ],
		[ 'slug' => 'on-secondary',         'name' => 'Texte sur Secondaire' ],
	];

	// Cherche aussi la couleur "accent" si elle existe dans les style variations
	$extra = [];
	$theme_json = wp_get_global_settings();
	if ( ! empty( $theme_json['color']['palette']['theme'] ) ) {
		$registered_slugs = array_column( $colors, 'slug' );
		foreach ( $theme_json['color']['palette']['theme'] as $color ) {
			if ( ! in_array( $color['slug'], $registered_slugs, true ) ) {
				$extra[] = [ 'slug' => $color['slug'], 'name' => $color['name'] ];
			}
		}
	}

	$all_colors = array_merge( $colors, $extra );
	?>
	<div id="vitalisite-debug-colors" style="
		position: fixed;
		bottom: 16px;
		right: 16px;
		z-index: 99999;
		background: #1e293b;
		color: #f8fafc;
		border-radius: 10px;
		padding: 14px 16px;
		font-family: ui-monospace, monospace;
		font-size: 11px;
		line-height: 1.5;
		box-shadow: 0 8px 24px rgba(0,0,0,0.4);
		min-width: 220px;
		max-height: 80vh;
		overflow-y: auto;
	">
		<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
			<strong style="font-size:12px;letter-spacing:.05em;color:#94a3b8;">🎨 Couleurs thème</strong>
			<button onclick="document.getElementById('vitalisite-debug-colors').remove()" style="
				background: none;
				border: none;
				color: #64748b;
				cursor: pointer;
				font-size: 14px;
				line-height: 1;
				padding: 0 2px;
			">✕</button>
		</div>
		<div style="display:flex;flex-direction:column;gap:6px;">
			<?php foreach ( $all_colors as $color ) :
				$var = '--wp--preset--color--' . $color['slug'];
				$hex = '';
				if ( ! empty( $theme_json['color']['palette']['theme'] ) ) {
					foreach ( $theme_json['color']['palette']['theme'] as $t_color ) {
						if ( $t_color['slug'] === $color['slug'] && ! empty( $t_color['color'] ) ) {
							$hex = $t_color['color'];
							break;
						}
					}
				}
			?>
			<div style="display:flex;align-items:center;gap:10px;" title="<?php echo esc_attr( $var ); ?>">
				<div style="
					width: 28px;
					height: 28px;
					border-radius: 6px;
					background: var(<?php echo esc_attr( $var ); ?>);
					border: 1px solid rgba(255,255,255,0.12);
					flex-shrink: 0;
				"></div>
				<div>
					<div style="color:#f1f5f9;font-weight:600;">
						<?php echo esc_html( $color['name'] ); ?>
						<?php if ( $hex ) : ?>
							<span style="color:#94a3b8;font-weight:normal;font-size:10px;margin-left:6px;"><?php echo esc_html( strtoupper( $hex ) ); ?></span>
						<?php endif; ?>
					</div>
					<div style="color:#64748b;"><?php echo esc_html( $var ); ?></div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'vitalisite_debug_colors_panel' );
