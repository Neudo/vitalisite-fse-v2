<?php
/**
 * vitalisite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package vitalisite
 */

if ( ! defined( 'VITALISITE_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'VITALISITE_VERSION', '1.0.0' );
}

if ( ! defined( 'VITALISITE_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `vitalisite_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'VITALISITE_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'vitalisite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vitalisite_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on vitalisite, use a find and replace
		 * to change 'vitalisite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'vitalisite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'vitalisite' ),
				'menu-2' => __( 'Footer Menu', 'vitalisite' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
		add_editor_style( 'style-editor-extra.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'vitalisite_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vitalisite_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'vitalisite' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'vitalisite' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'vitalisite_widgets_init' );

/**
 * Enqueue scripts and styles.
 */


// The proper way to enqueue GSAP script in WordPress

// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
function theme_gsap_script()
{
	// The core GSAP library
	wp_enqueue_script('gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', array(), false, true);
	// ScrollTrigger - with gsap.js passed as a dependency
	wp_enqueue_script('gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js', array('gsap-js'), false, true);
	// Your animation code file - with gsap.js passed as a dependency
	wp_enqueue_script('gsap-js2', get_template_directory_uri() . '/js/app.js', array('gsap-js'), false, true);
}

add_action('wp_enqueue_scripts', 'theme_gsap_script');


function vitalisite_scripts() {
	wp_enqueue_style( 'vitalisite-style', get_stylesheet_uri(), array(), VITALISITE_VERSION );
	wp_enqueue_script( 'vitalisite-script', get_template_directory_uri() . '/javascript/script.js', array(), VITALISITE_VERSION, true );
	wp_enqueue_script('alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vitalisite_scripts' );

/**
 * Enqueue the block editor script.
 */
function vitalisite_enqueue_block_editor_script() {
	if ( is_admin() ) {
		wp_enqueue_script(
			'vitalisite-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			VITALISITE_VERSION,
			true
		);
		wp_add_inline_script( 'vitalisite-editor', "tailwindTypographyClasses = '" . esc_attr( VITALISITE_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'vitalisite_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function vitalisite_tinymce_add_class( $settings ) {
	$settings['body_class'] = VITALISITE_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'vitalisite_tinymce_add_class' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Elementor Site Import.
 */
require get_template_directory() . '/inc/elementor-site-import.php';

/**
 * Opening Hours Functions.
 */
require get_template_directory() . '/inc/opening-hours-functions.php';

/**
 * Google Reviews - Simplified version
*/
require_once get_template_directory() . '/inc/google-reviews-functions.php';
require_once get_template_directory() . '/inc/customizer-google-reviews.php';
require_once get_template_directory() . '/inc/google-reviews-configure.php';
require_once get_template_directory() . '/inc/debug-cache-cleaner.php';

/**
 * Video Widget Functions.
 */
require get_template_directory() . '/inc/video-functions.php';

//Start custom function


/**
 * @return void
 * Const to use everywhere
 */

function constants()
{
	define( 'CONST_VITALISITE_NAME', 'vitalisite' );
	define('CONST_VITALISITE_DIR', get_template_directory());
	define('CONST_VITALISITE_URI', get_template_directory_uri());
	define('CONST_VITALISITE_ADMIN', admin_url());
	define('CONST_VITALISITE_ADMIN_DIR', get_template_directory() .  '/admin/');
	define('CONST_VITALISITE_ASSETS_URI', CONST_VITALISITE_URI . '/assets/');
	define('CONST_VITALISITE_ASSETS_FONTS_URI', CONST_VITALISITE_URI . '/assets/fonts');
	$wp_upload_arr = wp_get_upload_dir();
	define( 'CONST_VITALISITE_UPLOAD_DIR', $wp_upload_arr['basedir'] . '/' . strtolower( sanitize_file_name( CONST_VITALISITE_NAME ) ) . '/' );
	define( 'CONST_VITALISITE_UPLOAD_URL', $wp_upload_arr['baseurl'] . '/' . strtolower( sanitize_file_name( CONST_VITALISITE_NAME ) ) . '/' );
}



function add_menu_link_class($atts, $item, $args) {
	$atts['class'] = 'nav-link text-slate-100 hover:text-slate-300';
	return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 10, 3);

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$has_children = in_array('menu-item-has-children', $classes);

		$output .= '<li class="relative float-left">';
		if($has_children ) {
		$output .= '<div class="flex items-center toggle-submenu">';
		}

		// Lien principal
		$output .= '<a href="' . esc_url($item->url) . '" class="block p-2 text-primary">';
		$output .= esc_html($item->title);
		$output .= '</a>';

		// Ajout du bouton chevron si sous-menu
		if ($has_children) {
			$output .= '<button>
                            <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>';
			$output .= '</div>';
		}
	}

	public function start_lvl(&$output, $depth = 0, $args = null) {
		$output .= '<ul class="sub-menu w-max ml-[20px] flex-col hidden mt-2 space-y-2 pl-4 lg:p-6 border-l border-gray-300">';
	}

	public function end_el(&$output, $item, $depth = 0, $args = null) {
		$output .= '</li>';
	}

	public function end_lvl(&$output, $depth = 0, $args = null) {
		$output .= '</ul>';
	}
}

add_filter('wp_nav_menu_items', function ($items, $args) {
	$link_appointment = get_theme_mod('link_appointment');
	if ($args->theme_location === 'menu-1' && !empty($link_appointment)) {
		$button = '<li class="book-button-desktop mt-4 ml-16 lg:mt-0">';
		$button .= '<a href="' . esc_url($link_appointment) . '" target="_blank" class="cta text-sm py-2 px-4 rounded-full flex items-center transition-all duration-300 ease-in-out">';
		$button .= '<svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="white" viewBox="0 0 24 24"><path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" /><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" /></svg>';
		$button .= '<span id="book-button" class="ml-2 hidden md:block">Prendre rendez-vous</span>';
		$button .= '</a>';
		$button .= '</li>';
		$items .= $button;
	}
	return $items;
}, 10, 2);


// Check colors luminance

function is_light_color($hex) {
	// Supprimer le # si présent
	$hex = ltrim($hex, '#');

	// Convertir en RGB
	if (strlen($hex) == 3) {
		$r = hexdec(str_repeat(substr($hex, 0, 1), 2));
		$g = hexdec(str_repeat(substr($hex, 1, 1), 2));
		$b = hexdec(str_repeat(substr($hex, 2, 1), 2));
	} else {
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));
	}

	// Calculer la luminosité (formule de W3C)
	$luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

	// Retourne vrai si la couleur est claire
	return $luminance > 0.5;
}

// Install required plugins

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'vitalisite_register_required_plugins');

function vitalisite_register_required_plugins() {
	$plugins = [
		[
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'required' => true,
		],
		[
			'name'     => 'Kirki Customizer Framework',
			'slug'     => 'kirki',
			'required' => true,
		],
		[
			'name'     => 'Elementor Vitalisite', // Plugin custom
			'slug'     => 'elementor-vitalisite',
			'source'   => get_template_directory() . '/plugins/elementor-vitalisite.zip',
			'required' => true,
		],
		[
			'name'     => 'Vitalisite Core', // Plugin custom
			'slug'     => 'vitalisite-core',
			'source'   => get_template_directory() . '/plugins/vitalisite-core.zip',
			'required' => true,
		],
		[
			'name'     => 'Secure Custom Fields',
			'slug'     => 'secure-custom-fields',
			'required' => true,
		],
		[
			'name'     => 'Image Optimization',
			'slug'     => 'image-optimization',
			'required' => false,
		],
		[
			'name'     => 'All in One SEO Pack',
			'slug'     => 'all-in-one-seo-pack',
			'required' => false,
		],
	];

	$config = [
		'id'           => 'vitalisite',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
	];

	tgmpa($plugins, $config);
}

function vitalisite_setup_default_pages() {
	// Vérifier les réglages actuels
	$front_page = get_option('page_on_front');
	$blog_page = get_option('page_for_posts');


	if ($front_page && $blog_page) {
		return; // Rien à faire si les pages sont déjà définies
	}

	// Définition des pages à créer
	$pages = [
		'home' => [
			'title' => 'Accueil',
			'content' => 'Bienvenue sur votre site.',
			'option' => 'page_on_front'
		],
		'blog' => [
			'title' => 'Blog',
			'content' => '',
			'option' => 'page_for_posts'
		]
	];


	$created_pages = [];

	foreach ($pages as $key => $page) {
		if (!get_option($page['option'])) {
			$page_id = wp_insert_post([
				'post_title'   => $page['title'],
				'post_content' => $page['content'],
				'post_status'  => 'publish',
				'post_type'    => 'page'
			]);

			if ($page_id) {
				update_option($page['option'], $page_id);
				$created_pages[] = $page['title'];
			}
		}
	}

	if (!empty($created_pages)) {
		update_option('show_on_front', 'page');
	}

}
add_action('after_switch_theme', 'vitalisite_setup_default_pages');

function vitalisite_elementor_settings() {
	update_option('elementor_disable_color_schemes', 'yes');
	update_option('elementor_disable_typography_schemes', 'yes');

	$elementor_cpt_support = get_option('elementor_cpt_support', []);

	$required_cpts = ['post', 'page', 'specialites'];

	foreach ($required_cpts as $cpt) {
		if (!in_array($cpt, $elementor_cpt_support)) {
			$elementor_cpt_support[] = $cpt;
		}
	}

	update_option('elementor_cpt_support', $elementor_cpt_support);
}
add_action('after_switch_theme', 'vitalisite_elementor_settings');

function vitalisite_set_default_opening_hours() {
    // Ne s'exécute qu'une seule fois
    if (get_option('vitalisite_opening_hours_set', false)) {
        return;
    }

    // Configuration par défaut des horaires
    $default_hours = [
        'monday'    => ['closed' => false, 'open' => '09:00', 'close' => '18:00'],
        'tuesday'   => ['closed' => false, 'open' => '09:00', 'close' => '18:00'],
        'wednesday' => ['closed' => false, 'open' => '09:00', 'close' => '18:00'],
        'thursday'  => ['closed' => false, 'open' => '09:00', 'close' => '18:00'],
        'friday'    => ['closed' => false, 'open' => '09:00', 'close' => '18:00'],
        'saturday'  => ['closed' => true,  'open' => '09:00', 'close' => '18:00'],
        'sunday'    => ['closed' => true,  'open' => '09:00', 'close' => '18:00'],
    ];

    // Enregistrer chaque jour dans les options du thème
    foreach ($default_hours as $day => $hours) {
        set_theme_mod("open_hours_{$day}_closed", $hours['closed']);
        set_theme_mod("open_hours_{$day}_open", $hours['open']);
        set_theme_mod("open_hours_{$day}_close", $hours['close']);
    }

    // Marquer que les horaires ont été configurés
    update_option('vitalisite_opening_hours_set', true);
    
    // Log pour débogage (optionnel)
    error_log('Vitalisite: Opening hours defaults set successfully');
}
add_action('after_switch_theme', 'vitalisite_set_default_opening_hours');

function redirectToActivateTheme() {
	return wp_redirect(get_site_url() . '/wp-admin/themes.php?page=install-required-plugins');
}
add_action('after_switch_theme', 'redirectToActivateTheme');
