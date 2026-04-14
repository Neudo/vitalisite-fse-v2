<?php
/**
 * Plugin Name: Vitalisite Demo Theme Playground
 * Description: Adds a public demo modal to preview block theme style variations per browser.
 * Version: 0.1.0
 * Author: Vitalisite
 * Text Domain: vitalisite-theme-playground
 *
 * @package Vitalisite_Theme_Playground
 */

namespace Vitalisite\Theme_Playground;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const VERSION             = '0.1.0';
const TEXT_DOMAIN         = 'vitalisite-theme-playground';
const COOKIE_SELECTION    = 'vitalisite_theme_playground_selection';
const STORAGE_KEY         = 'vitalisiteThemePlaygroundSelection';
const PURCHASE_URL        = 'https://www.vitalisite.com/le-theme';

/**
 * Frontend style playground for block themes.
 */
final class Plugin {
	/**
	 * Cached style definitions.
	 *
	 * @var array<string,array<string,mixed>>|null
	 */
	private static $styles = null;

	/**
	 * Register plugin hooks.
	 */
	public static function bootstrap() {
		add_filter( 'wp_theme_json_data_user', array( __CLASS__, 'filter_user_theme_json' ) );
		add_action( 'send_headers', array( __CLASS__, 'send_cache_headers' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
		add_action( 'wp_footer', array( __CLASS__, 'render_mount' ) );
	}

	/**
	 * Tell caches that the page may vary by the visitor selection cookie.
	 */
	public static function send_cache_headers() {
		if ( is_admin() ) {
			return;
		}

		if ( ! headers_sent() ) {
			header( 'Vary: Cookie', false );
		}

		if ( null !== self::get_cookie_selection() ) {
			nocache_headers();
		}
	}

	/**
	 * Enqueue frontend modal assets.
	 */
	public static function enqueue_assets() {
		if ( ! self::can_use_playground() ) {
			return;
		}

		$asset_dir = plugin_dir_path( __FILE__ ) . 'assets/';
		$asset_url = plugin_dir_url( __FILE__ ) . 'assets/';

		wp_enqueue_style(
			'vitalisite-theme-playground',
			$asset_url . 'theme-playground.css',
			array(),
			file_exists( $asset_dir . 'theme-playground.css' ) ? (string) filemtime( $asset_dir . 'theme-playground.css' ) : VERSION
		);

		wp_enqueue_script(
			'vitalisite-theme-playground',
			$asset_url . 'theme-playground.js',
			array(),
			file_exists( $asset_dir . 'theme-playground.js' ) ? (string) filemtime( $asset_dir . 'theme-playground.js' ) : VERSION,
			true
		);

		wp_localize_script(
			'vitalisite-theme-playground',
			'vitalisiteThemePlayground',
			array(
				'cookieName'  => COOKIE_SELECTION,
				'storageKey'  => STORAGE_KEY,
				'cookieDays'  => 30,
				'purchaseUrl' => esc_url_raw( (string) apply_filters( 'vitalisite_theme_playground_purchase_url', PURCHASE_URL ) ),
				'selection'   => self::get_current_selection(),
				'styles'      => array_values( self::get_public_styles() ),
				'labels'      => array(
					'button'          => __( 'Personnaliser la demo', TEXT_DOMAIN ),
					'purchase'        => __( 'Obtenir le thème', TEXT_DOMAIN ),
					'title'           => __( 'Theme playground', TEXT_DOMAIN ),
					'intro'           => __( 'Choisissez un style. Le choix reste uniquement dans ce navigateur.', TEXT_DOMAIN ),
					'close'           => __( 'Fermer', TEXT_DOMAIN ),
					'apply'           => __( 'Appliquer', TEXT_DOMAIN ),
					'active'          => __( 'Actif', TEXT_DOMAIN ),
					'applying'        => __( 'Application du style...', TEXT_DOMAIN ),
					'reloading'       => __( 'Style applique. Rechargement...', TEXT_DOMAIN ),
					'empty'           => __( 'Aucun style disponible.', TEXT_DOMAIN ),
					'source'          => __( 'Source', TEXT_DOMAIN ),
					'activeStyleText' => __( 'Selection', TEXT_DOMAIN ),
				),
			)
		);
	}

	/**
	 * Render the JS mount point.
	 */
	public static function render_mount() {
		if ( ! self::can_use_playground() ) {
			return;
		}

		printf(
			'<div id="vitalisite-theme-playground-root" data-selection="%s"></div>',
			esc_attr( wp_json_encode( self::get_current_selection() ) )
		);
	}

	/**
	 * Apply the browser-selected variation to the generated theme JSON.
	 *
	 * @param mixed $theme_json WordPress theme JSON data object.
	 * @return mixed
	 */
	public static function filter_user_theme_json( $theme_json ) {
		if ( is_admin() || ! method_exists( $theme_json, 'update_with' ) ) {
			return $theme_json;
		}

		$selection = self::get_cookie_selection();
		if ( null === $selection ) {
			return $theme_json;
		}

		$data = self::get_theme_json_data_for_selection( $selection );
		if ( empty( $data ) ) {
			return $theme_json;
		}

		$theme_json->update_with( $data );

		return $theme_json;
	}

	/**
	 * Whether the current user and request may use the playground.
	 *
	 * @return bool
	 */
	private static function can_use_playground() {
		return ! is_admin()
			&& function_exists( 'wp_is_block_theme' )
			&& wp_is_block_theme();
	}

	/**
	 * Get public style data sent to the modal.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	private static function get_public_styles() {
		$selection = self::get_current_selection();
		$styles    = array();

		foreach ( self::get_styles() as $slug => $style ) {
			$kind = self::get_style_kind( $style );

			$styles[ $slug ] = array(
				'slug'     => $slug,
				'title'    => $style['title'],
				'group'    => $style['group'],
				'kind'     => $kind,
				'source'   => $style['source'],
				'swatches' => $style['swatches'],
				'active'   => self::selection_contains_style( $selection, $slug, $kind ),
			);
		}

		return $styles;
	}

	/**
	 * Discover theme.json and all style variation JSON files.
	 *
	 * @return array<string,array<string,mixed>>
	 */
	private static function get_styles() {
		if ( null !== self::$styles ) {
			return self::$styles;
		}

		$styles = array();

		$theme_json_path = get_theme_file_path( 'theme.json' );
		if ( is_readable( $theme_json_path ) ) {
			$data = self::read_json_file( $theme_json_path );
			if ( ! empty( $data ) ) {
				$styles['default'] = array(
					'slug'     => 'default',
					'title'    => __( 'Style par defaut', TEXT_DOMAIN ),
					'group'    => __( 'Base', TEXT_DOMAIN ),
					'source'   => 'theme.json',
					'path'     => $theme_json_path,
					'data'     => $data,
					'swatches' => self::extract_swatches( $data ),
				);
			}
		}

		$styles_dir = get_stylesheet_directory() . '/styles';
		if ( is_dir( $styles_dir ) ) {
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator( $styles_dir, \FilesystemIterator::SKIP_DOTS )
			);

			foreach ( $iterator as $file ) {
				if ( ! $file instanceof \SplFileInfo || 'json' !== strtolower( $file->getExtension() ) ) {
					continue;
				}

				$path     = $file->getPathname();
				$relative = str_replace( '\\', '/', ltrim( substr( $path, strlen( $styles_dir ) ), '/\\' ) );
				$slug     = preg_replace( '/\.json$/', '', $relative );
				$slug     = self::sanitize_style_key( $slug );

				if ( '' === $slug || isset( $styles[ $slug ] ) || ! is_readable( $path ) ) {
					continue;
				}

				$data = self::read_json_file( $path );
				if ( empty( $data ) ) {
					continue;
				}

				$styles[ $slug ] = array(
					'slug'     => $slug,
					'title'    => self::get_style_title( $data, $slug ),
					'group'    => self::get_style_group( $relative ),
					'source'   => 'styles/' . $relative,
					'path'     => $path,
					'data'     => $data,
					'swatches' => self::extract_swatches( $data ),
				);
			}
		}

		uasort(
			$styles,
			static function ( $a, $b ) {
				$group_order = array(
					__( 'Base', TEXT_DOMAIN )            => 0,
					__( 'Styles complets', TEXT_DOMAIN ) => 1,
					__( 'Couleurs', TEXT_DOMAIN )        => 2,
					__( 'Typographie', TEXT_DOMAIN )     => 3,
				);

				$a_order = $group_order[ $a['group'] ] ?? 10;
				$b_order = $group_order[ $b['group'] ] ?? 10;

				if ( $a_order !== $b_order ) {
					return $a_order <=> $b_order;
				}

				return strcasecmp( $a['title'], $b['title'] );
			}
		);

		self::$styles = $styles;

		return self::$styles;
	}

	/**
	 * Read a JSON file as an associative array.
	 *
	 * @param string $path JSON file path.
	 * @return array<string,mixed>
	 */
	private static function read_json_file( $path ) {
		if ( function_exists( 'wp_json_file_decode' ) ) {
			$data = wp_json_file_decode(
				$path,
				array(
					'associative' => true,
				)
			);

			return is_array( $data ) ? $data : array();
		}

		$contents = file_get_contents( $path );
		if ( false === $contents ) {
			return array();
		}

		$data = json_decode( $contents, true );
		return is_array( $data ) ? $data : array();
	}

	/**
	 * Get a display title from a variation file.
	 *
	 * @param array<string,mixed> $data Variation data.
	 * @param string              $slug Variation slug.
	 * @return string
	 */
	private static function get_style_title( array $data, $slug ) {
		if ( isset( $data['title'] ) && is_string( $data['title'] ) && '' !== trim( $data['title'] ) ) {
			return $data['title'];
		}

		$name = basename( $slug );
		return ucwords( str_replace( array( '-', '_' ), ' ', $name ) );
	}

	/**
	 * Get the modal group for a style variation.
	 *
	 * @param string $relative Relative path from /styles.
	 * @return string
	 */
	private static function get_style_group( $relative ) {
		$directory = dirname( $relative );

		if ( '.' === $directory ) {
			return __( 'Styles complets', TEXT_DOMAIN );
		}

		if ( 'colors' === $directory ) {
			return __( 'Couleurs', TEXT_DOMAIN );
		}

		if ( 'typography' === $directory ) {
			return __( 'Typographie', TEXT_DOMAIN );
		}

		return ucwords( str_replace( array( '-', '_' ), ' ', basename( $directory ) ) );
	}

	/**
	 * Extract color swatches from a theme JSON array.
	 *
	 * @param array<string,mixed> $data Theme JSON data.
	 * @return array<int,array<string,string>>
	 */
	private static function extract_swatches( array $data ) {
		$palette = $data['settings']['color']['palette'] ?? array();
		if ( ! is_array( $palette ) ) {
			return array();
		}

		$swatches = array();
		foreach ( $palette as $color ) {
			if ( ! is_array( $color ) || empty( $color['color'] ) || ! is_string( $color['color'] ) ) {
				continue;
			}

			$css_color = self::sanitize_css_color( $color['color'] );
			if ( '' === $css_color ) {
				continue;
			}

			$swatches[] = array(
				'color' => $css_color,
				'name'  => isset( $color['name'] ) && is_string( $color['name'] ) ? $color['name'] : '',
			);

			if ( count( $swatches ) >= 6 ) {
				break;
			}
		}

		return $swatches;
	}

	/**
	 * Sanitize a CSS color value before exposing it to JS.
	 *
	 * @param string $color CSS color candidate.
	 * @return string
	 */
	private static function sanitize_css_color( $color ) {
		$color = trim( $color );

		if ( preg_match( '/^#(?:[0-9a-f]{3}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $color ) ) {
			return $color;
		}

		if ( preg_match( '/^(?:rgb|rgba|hsl|hsla)\([0-9%,.\s-]+\)$/i', $color ) ) {
			return $color;
		}

		return '';
	}

	/**
	 * Get the current selection for UI rendering.
	 *
	 * @return array<string,string>
	 */
	private static function get_current_selection() {
		$selection = self::get_cookie_selection();
		if ( null !== $selection ) {
			return $selection;
		}

		$styles = self::get_styles();
		$style  = self::detect_active_style_from_palette( $styles );

		return self::normalize_selection(
			array(
				'style'      => $style ?: 'default',
				'color'      => '',
				'typography' => '',
			)
		);
	}

	/**
	 * Get the current browser selection from its cookie.
	 *
	 * @return array<string,string>|null
	 */
	private static function get_cookie_selection() {
		if ( empty( $_COOKIE[ COOKIE_SELECTION ] ) || ! is_string( $_COOKIE[ COOKIE_SELECTION ] ) ) {
			return null;
		}

		$raw  = wp_unslash( $_COOKIE[ COOKIE_SELECTION ] );
		$data = json_decode( $raw, true );

		if ( ! is_array( $data ) ) {
			$data = json_decode( rawurldecode( $raw ), true );
		}

		return is_array( $data ) ? self::normalize_selection( $data ) : null;
	}

	/**
	 * Normalize and validate a selection array.
	 *
	 * @param array<string,mixed> $selection Raw selection.
	 * @return array<string,string>
	 */
	private static function normalize_selection( array $selection ) {
		$styles = self::get_styles();

		$normalized = array(
			'style'      => isset( $selection['style'] ) ? self::sanitize_style_key( $selection['style'] ) : 'default',
			'color'      => isset( $selection['color'] ) ? self::sanitize_style_key( $selection['color'] ) : '',
			'typography' => isset( $selection['typography'] ) ? self::sanitize_style_key( $selection['typography'] ) : '',
		);

		if ( ! isset( $styles[ $normalized['style'] ] ) || ! in_array( self::get_style_kind( $styles[ $normalized['style'] ] ), array( 'base', 'complete' ), true ) ) {
			$normalized['style'] = 'default';
		}

		if ( '' !== $normalized['color'] && ( ! isset( $styles[ $normalized['color'] ] ) || 'color' !== self::get_style_kind( $styles[ $normalized['color'] ] ) ) ) {
			$normalized['color'] = '';
		}

		if ( '' !== $normalized['typography'] && ( ! isset( $styles[ $normalized['typography'] ] ) || 'typography' !== self::get_style_kind( $styles[ $normalized['typography'] ] ) ) ) {
			$normalized['typography'] = '';
		}

		return $normalized;
	}

	/**
	 * Get a style kind for UI and selection composition.
	 *
	 * @param array<string,mixed> $style Style definition.
	 * @return string
	 */
	private static function get_style_kind( array $style ) {
		$source = isset( $style['source'] ) ? (string) $style['source'] : '';

		if ( 'theme.json' === $source ) {
			return 'base';
		}

		if ( 0 === strpos( $source, 'styles/colors/' ) ) {
			return 'color';
		}

		if ( 0 === strpos( $source, 'styles/typography/' ) ) {
			return 'typography';
		}

		return 'complete';
	}

	/**
	 * Check whether a selection includes a style.
	 *
	 * @param array<string,string> $selection Current selection.
	 * @param string               $slug      Style slug.
	 * @param string               $kind      Style kind.
	 * @return bool
	 */
	private static function selection_contains_style( array $selection, $slug, $kind ) {
		if ( in_array( $kind, array( 'base', 'complete' ), true ) ) {
			return $selection['style'] === $slug;
		}

		if ( 'color' === $kind ) {
			return $selection['color'] === $slug;
		}

		if ( 'typography' === $kind ) {
			return $selection['typography'] === $slug;
		}

		return false;
	}

	/**
	 * Infer the current style from the active primary color.
	 *
	 * @param array<string,array<string,mixed>> $styles Style definitions.
	 * @return string
	 */
	private static function detect_active_style_from_palette( array $styles ) {
		if ( ! function_exists( 'wp_get_global_settings' ) ) {
			return '';
		}

		$active_palette = wp_get_global_settings( array( 'color', 'palette', 'theme' ) );
		$current        = self::extract_primary_color_from_palette( is_array( $active_palette ) ? $active_palette : array() );

		if ( '' === $current ) {
			return '';
		}

		foreach ( $styles as $slug => $style ) {
			if ( 'default' === $slug || empty( $style['data'] ) || ! is_array( $style['data'] ) ) {
				continue;
			}

			$primary = self::extract_primary_color_from_palette( $style['data']['settings']['color']['palette'] ?? array() );
			if ( '' !== $primary && $primary === $current ) {
				return $slug;
			}
		}

		return '';
	}

	/**
	 * Extract the primary color from a palette.
	 *
	 * @param mixed $palette Palette data.
	 * @return string
	 */
	private static function extract_primary_color_from_palette( $palette ) {
		if ( ! is_array( $palette ) ) {
			return '';
		}

		foreach ( $palette as $color ) {
			if ( ! is_array( $color ) || ( $color['slug'] ?? '' ) !== 'primary' || empty( $color['color'] ) ) {
				continue;
			}

			return strtolower( trim( (string) $color['color'] ) );
		}

		return '';
	}

	/**
	 * Build an empty user global styles payload.
	 *
	 * @return array<string,mixed>
	 */
	private static function get_empty_global_styles_data() {
		return array(
			'version'                     => 3,
			'isGlobalStylesUserThemeJSON' => true,
		);
	}

	/**
	 * Build the request-scoped theme JSON payload for a browser selection.
	 *
	 * @param array<string,string> $selection Normalized selection.
	 * @return array<string,mixed>
	 */
	private static function get_theme_json_data_for_selection( array $selection ) {
		$styles = self::get_styles();
		$data   = self::get_empty_global_styles_data();

		$style_slug = $selection['style'] ?: 'default';
		if ( isset( $styles[ $style_slug ] ) && ! empty( $styles[ $style_slug ]['data'] ) ) {
			$data = self::merge_theme_json_data(
				$data,
				self::get_global_styles_data_from_theme_json( $styles[ $style_slug ]['data'] )
			);
		}

		foreach ( array( 'color', 'typography' ) as $key ) {
			$slug = $selection[ $key ] ?? '';
			if ( '' === $slug || ! isset( $styles[ $slug ] ) || empty( $styles[ $slug ]['data'] ) ) {
				continue;
			}

			$data = self::merge_theme_json_data(
				$data,
				self::get_global_styles_data_from_theme_json( $styles[ $slug ]['data'] )
			);
		}

		return $data;
	}

	/**
	 * Recursively merge theme JSON arrays, replacing list arrays as whole values.
	 *
	 * @param array<string,mixed> $base      Base data.
	 * @param array<string,mixed> $overrides Override data.
	 * @return array<string,mixed>
	 */
	private static function merge_theme_json_data( array $base, array $overrides ) {
		foreach ( $overrides as $key => $value ) {
			if (
				isset( $base[ $key ] )
				&& is_array( $base[ $key ] )
				&& is_array( $value )
				&& ! self::is_list_array( $base[ $key ] )
				&& ! self::is_list_array( $value )
			) {
				$base[ $key ] = self::merge_theme_json_data( $base[ $key ], $value );
				continue;
			}

			$base[ $key ] = $value;
		}

		$base['version']                     = isset( $base['version'] ) ? absint( $base['version'] ) : 3;
		$base['isGlobalStylesUserThemeJSON'] = true;

		return $base;
	}

	/**
	 * Check whether an array is a list.
	 *
	 * @param array<mixed> $array Array to check.
	 * @return bool
	 */
	private static function is_list_array( array $array ) {
		if ( function_exists( 'array_is_list' ) ) {
			return array_is_list( $array );
		}

		return array_keys( $array ) === range( 0, count( $array ) - 1 );
	}

	/**
	 * Convert theme JSON data into a user global styles payload.
	 *
	 * @param mixed $theme_json_data Theme JSON data.
	 * @return array<string,mixed>
	 */
	private static function get_global_styles_data_from_theme_json( $theme_json_data ) {
		$theme_json_data = is_array( $theme_json_data ) ? $theme_json_data : array();
		$data            = self::get_empty_global_styles_data();
		$data['version'] = isset( $theme_json_data['version'] ) ? absint( $theme_json_data['version'] ) : 3;

		if ( ! empty( $theme_json_data['settings'] ) && is_array( $theme_json_data['settings'] ) ) {
			$data['settings'] = $theme_json_data['settings'];
		}

		if ( ! empty( $theme_json_data['styles'] ) && is_array( $theme_json_data['styles'] ) ) {
			$data['styles'] = $theme_json_data['styles'];
		}

		return $data;
	}

	/**
	 * Sanitize a style key while keeping nested variation paths.
	 *
	 * @param mixed $style_key Raw style key.
	 * @return string
	 */
	private static function sanitize_style_key( $style_key ) {
		$style_key = is_string( $style_key ) ? strtolower( trim( $style_key ) ) : '';
		return preg_replace( '/[^a-z0-9_\/-]/', '', $style_key );
	}
}

Plugin::bootstrap();
