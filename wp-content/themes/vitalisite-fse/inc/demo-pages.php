<?php
/**
 * Vitalisite demo pages generator.
 *
 * @package Vitalisite_FSE
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const OPTION_DEMO_SETUP           = 'vitalisite_demo_setup';
const OPTION_DEMO_PAGES_INSTALLED = 'vitalisite_demo_pages_installed';

/**
 * Get available tone options.
 *
 * @return array<string, array<string, string>>
 */
function get_demo_tone_options() {
	return array(
		'je'   => array(
			'label'       => __( 'Je', 'vitalisite-fse' ),
			'description' => __( 'Idéal pour un praticien indépendant avec une voix plus personnelle.', 'vitalisite-fse' ),
		),
		'nous' => array(
			'label'       => __( 'Nous', 'vitalisite-fse' ),
			'description' => __( 'Adapté à un cabinet, une équipe ou une structure pluridisciplinaire.', 'vitalisite-fse' ),
		),
	);
}

/**
 * Get available writing style options.
 *
 * @return array<string, array<string, string>>
 */
function get_demo_writing_style_options() {
	return array(
		'professionnel' => array(
			'label'       => __( 'Professionnel', 'vitalisite-fse' ),
			'description' => __( 'Sobre, structuré et rassurant pour une présentation claire de la pratique.', 'vitalisite-fse' ),
		),
		'chaleureux'    => array(
			'label'       => __( 'Chaleureux', 'vitalisite-fse' ),
			'description' => __( 'Plus humain et accueillant, avec un langage apaisant et relationnel.', 'vitalisite-fse' ),
		),
		'direct'        => array(
			'label'       => __( 'Direct', 'vitalisite-fse' ),
			'description' => __( 'Concret, lisible et orienté efficacité pour aller à l’essentiel.', 'vitalisite-fse' ),
		),
	);
}

/**
 * Get available demo pages.
 *
 * @return array<string, array<string, string>>
 */
function get_demo_pages_definition() {
	return array(
		'accueil'         => array(
			'label'       => __( 'Accueil', 'vitalisite-fse' ),
			'description' => __( 'Page d’accueil complète avec présentation, prises en charge, tarifs et avis.', 'vitalisite-fse' ),
		),
		'a-propos'        => array(
			'label'       => __( 'À propos', 'vitalisite-fse' ),
			'description' => __( 'Page de présentation du praticien, de l’approche et du parcours.', 'vitalisite-fse' ),
		),
		'tarifs'          => array(
			'label'       => __( 'Tarifs', 'vitalisite-fse' ),
			'description' => __( 'Page dédiée aux honoraires, aux modalités de consultation et aux questions fréquentes.', 'vitalisite-fse' ),
		),
		'contact'         => array(
			'label'       => __( 'Contact', 'vitalisite-fse' ),
			'description' => __( 'Coordonnées, formulaire de contact et horaires du cabinet.', 'vitalisite-fse' ),
		),
		'temoignages'     => array(
			'label'       => __( 'Témoignages', 'vitalisite-fse' ),
			'description' => __( 'Page de réassurance avec avis patients et texte d’introduction.', 'vitalisite-fse' ),
		),
		'faq'             => array(
			'label'       => __( 'FAQ', 'vitalisite-fse' ),
			'description' => __( 'Questions fréquentes autour des rendez-vous, de l’organisation et du suivi.', 'vitalisite-fse' ),
		),
		'infos-pratiques' => array(
			'label'       => __( 'Infos pratiques', 'vitalisite-fse' ),
			'description' => __( 'Horaires, informations d’accès et transports pour préparer la venue au cabinet.', 'vitalisite-fse' ),
		),
	);
}

/**
 * Get demo setup state.
 *
 * @return array<string, mixed>
 */
function get_demo_setup() {
	$saved           = get_option( OPTION_DEMO_SETUP, array() );
	$has_saved_pages = is_array( $saved ) && array_key_exists( 'pages', $saved );
	$defaults = array(
		'tone'                => 'je',
		'writing_style'       => 'professionnel',
		'pages'               => array_keys( get_demo_pages_definition() ),
		'add_pages_to_header' => true,
	);

	$setup = wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );

	if ( ! isset( get_demo_tone_options()[ $setup['tone'] ] ) ) {
		$setup['tone'] = $defaults['tone'];
	}

	if ( ! isset( get_demo_writing_style_options()[ $setup['writing_style'] ] ) ) {
		$setup['writing_style'] = $defaults['writing_style'];
	}

	$available      = array_keys( get_demo_pages_definition() );
	$selected_pages = array_map( 'sanitize_title', (array) $setup['pages'] );
	$setup['pages'] = array_values( array_intersect( $selected_pages, $available ) );

	if ( empty( $setup['pages'] ) && ! $has_saved_pages ) {
		$setup['pages'] = $defaults['pages'];
	}

	$setup['add_pages_to_header'] = ! empty( $setup['add_pages_to_header'] );

	return $setup;
}

/**
 * Persist demo setup.
 *
 * @param array<string, mixed> $changes Setup changes.
 * @return array<string, mixed>
 */
function save_demo_setup( array $changes ) {
	$current = get_demo_setup();

	if ( isset( $changes['tone'] ) ) {
		$tone = sanitize_key( $changes['tone'] );
		if ( isset( get_demo_tone_options()[ $tone ] ) ) {
			$current['tone'] = $tone;
		}
	}

	if ( isset( $changes['writing_style'] ) ) {
		$writing_style = sanitize_key( $changes['writing_style'] );
		if ( isset( get_demo_writing_style_options()[ $writing_style ] ) ) {
			$current['writing_style'] = $writing_style;
		}
	}

	if ( isset( $changes['pages'] ) ) {
		$available       = array_keys( get_demo_pages_definition() );
		$selected_pages  = array_map( 'sanitize_title', (array) $changes['pages'] );
		$current['pages'] = array_values( array_intersect( $selected_pages, $available ) );
	}

	if ( isset( $changes['add_pages_to_header'] ) ) {
		$current['add_pages_to_header'] = ! empty( $changes['add_pages_to_header'] );
	}

	update_option( OPTION_DEMO_SETUP, $current );

	return $current;
}

/**
 * Capture a pattern file and optionally replace some strings.
 *
 * @param string               $slug         Pattern slug without prefix.
 * @param array<string,string> $replacements String replacements.
 * @return string
 */
function render_demo_pattern_content( $slug, array $replacements = array() ) {
	$file = get_theme_file_path( 'patterns/' . $slug . '.php' );

	if ( ! file_exists( $file ) ) {
		return '';
	}

	ob_start();
	include $file;
	$content = trim( ob_get_clean() );

	return apply_demo_replacements( $content, $replacements );
}

/**
 * Apply string replacements to generated content.
 *
 * @param string               $content      Content.
 * @param array<string,string> $replacements Replacements.
 * @return string
 */
function apply_demo_replacements( $content, array $replacements ) {
	if ( empty( $replacements ) ) {
		return $content;
	}

	return strtr( $content, $replacements );
}

/**
 * Get default cabinet context merged with saved settings.
 *
 * @param string $tone Selected tone.
 * @return array<string, string>
 */
function get_demo_cabinet_context( $tone ) {
	$cabinet = get_option( OPTION_CABINET, array() );

	$defaults = array(
		'doctor_name'      => 'nous' === $tone ? __( 'Cabinet Vitalisite', 'vitalisite-fse' ) : __( 'Dr. Prénom Nom', 'vitalisite-fse' ),
		'doctor_specialty' => __( 'Spécialité du cabinet', 'vitalisite-fse' ),
		'phone'            => '01 42 42 42 42',
		'email'            => 'contact@cabinet.fr',
		'address'          => __( '12 rue de la Santé, 75014 Paris', 'vitalisite-fse' ),
		'appointment_url'  => '',
	);

	foreach ( $defaults as $key => $value ) {
		if ( ! empty( $cabinet[ $key ] ) ) {
			$defaults[ $key ] = (string) $cabinet[ $key ];
		}
	}

	return $defaults;
}

/**
 * Get dynamic replacements from saved options.
 *
 * @param string $tone Selected tone.
 * @return array<string, string>
 */
function get_demo_dynamic_replacements( $tone ) {
	$cabinet = get_demo_cabinet_context( $tone );

	return array(
		'Dr. Prenom Nom'                    => $cabinet['doctor_name'],
		'Dr. Prénom Nom'                    => $cabinet['doctor_name'],
		'Nom du praticien'                  => $cabinet['doctor_name'],
		'Specialite du cabinet'             => $cabinet['doctor_specialty'],
		'Spécialité du cabinet'             => $cabinet['doctor_specialty'],
		'Adresse du cabinet'                => $cabinet['address'],
		'Telephone du cabinet'              => $cabinet['phone'],
		'Téléphone du cabinet'              => $cabinet['phone'],
		'contact@cabinet.fr'                => $cabinet['email'],
		'Cabinet Vitalisite'                => 'nous' === $tone ? $cabinet['doctor_name'] : 'Cabinet Vitalisite',
	);
}

/**
 * Build a FAQ section with custom items.
 *
 * @param string                                         $title FAQ section title.
 * @param array<int, array{question:string,answer:string}> $items FAQ items.
 * @return string
 */
function build_demo_faq_section( $title, array $items ) {
	ob_start();
	?>
<!-- wp:group {"tagName":"section","className":"vitalisite-accordion-wrapper vitalisite-accordion-variant-simple vitalisite-section","layout":{"type":"constrained"}} -->
<section class="wp-block-group vitalisite-accordion-wrapper vitalisite-accordion-variant-simple vitalisite-section">

	<!-- wp:heading {"textAlign":"center","level":2,"className":"mb-60 reveal-y"} -->
	<h2 class="wp-block-heading has-text-align-center mb-60 reveal-y"><?php echo esc_html( $title ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:vitalisite-fse/accordion {"variant":"simple"} -->
	<div class="wp-block-vitalisite-fse-accordion vitalisite-accordion-container">
		<?php foreach ( $items as $item ) : ?>
			<!-- wp:vitalisite-fse/accordion-item -->
			<details class="wp-block-vitalisite-fse-accordion-item vitalisite-accordion-item reveal-y">
				<summary><?php echo esc_html( $item['question'] ); ?></summary>
				<div class="wp-block-group" style="padding:var(--wp--preset--spacing--40)">
					<!-- wp:paragraph -->
					<p><?php echo esc_html( $item['answer'] ); ?></p>
					<!-- /wp:paragraph -->
				</div>
			</details>
			<!-- /wp:vitalisite-fse/accordion-item -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:vitalisite-fse/accordion -->

</section>
<!-- /wp:group -->
	<?php

	return trim( ob_get_clean() );
}

/**
 * Build a page hero with a real image block, not a background-only banner.
 *
 * @param string $title     Hero title.
 * @param string $lead      Hero lead.
 * @param string $secondary Secondary button label.
 * @return string
 */
function build_demo_image_hero( $title, $lead, $secondary = '' ) {
	return render_demo_pattern_content(
		'hero-image-bottom',
		array(
			'Un accompagnement rassurant a chaque etape du parcours de soin' => $title,
			'Je vous recois sur rendez-vous dans un cadre de prise en charge serein, avec une approche attentive et personnalisee.' => $lead,
			'Decouvrir les prises en charge' => $secondary ?: __( 'Découvrir la page', 'vitalisite-fse' ),
		)
	);
}

/**
 * Build the content for a generated page.
 *
 * @param string $slug          Page slug.
 * @param string $tone          Tone slug.
 * @param string $writing_style Writing style slug.
 * @return string
 */
function build_demo_page_content( $slug, $tone = 'je', $writing_style = 'professionnel' ) {
	$dynamic = get_demo_dynamic_replacements( $tone );

	switch ( $slug ) {
		case 'accueil':
			return build_demo_page_home( $tone, $writing_style, $dynamic );
		case 'a-propos':
			return build_demo_page_about( $tone, $writing_style, $dynamic );
		case 'tarifs':
			return build_demo_page_pricing( $tone, $writing_style, $dynamic );
		case 'contact':
			return build_demo_page_contact( $tone, $writing_style, $dynamic );
		case 'temoignages':
			return build_demo_page_testimonials( $tone, $writing_style, $dynamic );
		case 'faq':
			return build_demo_page_faq( $tone, $writing_style, $dynamic );
		case 'infos-pratiques':
			return build_demo_page_practical_info( $tone, $writing_style, $dynamic );
		default:
			return '';
	}
}

/**
 * Build the home page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_home( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$copy = array(
		'professionnel' => array(
			'hero_title' => $is_team ? 'Nous vous accompagnons avec une prise en charge claire, structurée et personnalisée' : 'Je vous accompagne avec une prise en charge claire, structurée et personnalisée',
			'hero_lead'  => $is_team ? 'Nous recevons chaque patient dans un cadre professionnel et rassurant, afin de proposer un accompagnement adapté à ses besoins.' : 'Je reçois chaque patient dans un cadre professionnel et rassurant, afin de proposer un accompagnement adapté à ses besoins.',
			'bento_h2'   => $is_team ? 'Une pratique fondée sur l’écoute et la clarté' : 'Ma pratique repose sur l’écoute et la clarté',
			'bento_p1'   => $is_team ? 'Nous prenons le temps de comprendre votre situation, vos attentes et vos besoins pour proposer un accompagnement cohérent et lisible.' : 'Je prends le temps de comprendre votre situation, vos attentes et vos besoins pour proposer un accompagnement cohérent et lisible.',
			'bento_p2'   => $is_team ? 'Notre objectif est d’offrir un suivi sérieux, accessible et rassurant, avec des explications claires à chaque étape de la consultation.' : 'Mon objectif est d’offrir un suivi sérieux, accessible et rassurant, avec des explications claires à chaque étape de la consultation.',
			'bento_side' => $is_team ? 'Pourquoi consulter le cabinet' : 'Pourquoi me consulter',
		),
		'chaleureux'    => array(
			'hero_title' => $is_team ? 'Nous vous accueillons avec attention dans un cadre rassurant et bienveillant' : 'Je vous accueille avec écoute et bienveillance dans un cadre rassurant',
			'hero_lead'  => $is_team ? 'Chaque consultation est pensée comme un temps d’échange, d’écoute et d’accompagnement, à votre rythme et selon vos besoins.' : 'Chaque consultation est pensée comme un temps d’échange, d’écoute et d’accompagnement, à votre rythme et selon vos besoins.',
			'bento_h2'   => $is_team ? 'Une pratique pensée pour mettre en confiance' : 'Une pratique pensée pour vous mettre en confiance',
			'bento_p1'   => $is_team ? 'Nous accordons une place importante à l’écoute, à la qualité de l’accueil et à la simplicité des explications données pendant le suivi.' : 'J’accorde une place importante à l’écoute, à la qualité de l’accueil et à la simplicité des explications données pendant le suivi.',
			'bento_p2'   => $is_team ? 'Notre accompagnement s’appuie sur un cadre serein, des repères clairs et une relation professionnelle construite dans la durée.' : 'Mon accompagnement s’appuie sur un cadre serein, des repères clairs et une relation professionnelle construite dans la durée.',
			'bento_side' => $is_team ? 'Ce qui fait la différence' : 'Pourquoi me consulter',
		),
		'direct'        => array(
			'hero_title' => $is_team ? 'Nous vous recevons pour faire le point simplement et vous orienter efficacement' : 'Je vous reçois pour faire le point simplement et vous orienter efficacement',
			'hero_lead'  => $is_team ? 'Consultations claires, informations concrètes et accompagnement adapté à votre situation dès le premier rendez-vous.' : 'Consultations claires, informations concrètes et accompagnement adapté à votre situation dès le premier rendez-vous.',
			'bento_h2'   => $is_team ? 'Une prise en charge claire du premier rendez-vous au suivi' : 'Une prise en charge claire du premier rendez-vous au suivi',
			'bento_p1'   => $is_team ? 'Nous expliquons les étapes de consultation, les modalités de suivi et les points importants de manière simple et directe.' : 'J’explique les étapes de consultation, les modalités de suivi et les points importants de manière simple et directe.',
			'bento_p2'   => $is_team ? 'L’objectif est de vous donner des repères rapides, utiles et faciles à comprendre pour avancer sereinement.' : 'L’objectif est de vous donner des repères rapides, utiles et faciles à comprendre pour avancer sereinement.',
			'bento_side' => $is_team ? 'Une organisation lisible' : 'Pourquoi me consulter',
		),
	);

	$copy = $copy[ $writing_style ];

	$content  = render_demo_pattern_content(
		'hero-side-image',
		array_merge(
			$dynamic,
			array(
				'Des consultations personnalisees dans un cadre professionnel et rassurant' => $copy['hero_title'],
				"J'accompagne mes patients avec une approche claire, accessible et personnalisee, adaptee aux besoins du quotidien." => $copy['hero_lead'],
				'Decouvrir le cabinet' => $is_team ? 'Découvrir le cabinet' : 'Découvrir ma pratique',
			)
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'bento-grid',
		array(
			'Une pratique claire et rassurante' => $copy['bento_h2'],
			'Je peux mettre en avant ici ce qui structure ma pratique : ecoute, disponibilite, rigueur du suivi et clarte des informations transmises.' => $copy['bento_p1'],
			'Le format bento me permet de valoriser ma posture professionnelle sans alourdir la lecture ni surcharger une page d\'accueil.' => $copy['bento_p2'],
			'Pourquoi me consulter' => $copy['bento_side'],
			'Informations claires, accompagnement personnalise et cadre de consultation professionnel.' => $is_team ? 'Accueil soigné, informations claires et accompagnement personnalisé.' : 'Accueil soigné, informations claires et accompagnement personnalisé.',
			'Une variante tres utile pour presenter mes engagements avec un rendu plus editorial.' => $is_team ? 'Un bon moyen de présenter les engagements du cabinet sans alourdir la page d’accueil.' : 'Un bon moyen de présenter mes engagements sans alourdir la page d’accueil.',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'cards',
		array(
			'Des prises en charge claires et adaptees' => $is_team ? 'Les consultations que nous proposons' : 'Les consultations que je propose',
			'Je peux utiliser cette section pour presenter mes specialites, les besoins frequemment rencontres et la maniere dont j\'accompagne mes patients.' => $is_team ? 'Cette section permet de présenter clairement les principaux motifs de consultation et les besoins que nous accompagnons au cabinet.' : 'Cette section permet de présenter clairement les principaux motifs de consultation et les besoins que j’accompagne au cabinet.',
			'Consultation initiale' => 'Première consultation',
			'Premier rendez-vous pour faire le point sur votre situation, comprendre vos besoins et definir une prise en charge adaptee.' => 'Un premier rendez-vous pour faire le point, comprendre votre situation et définir une prise en charge adaptée.',
			'Suivi personnalise' => 'Suivi personnalisé',
			'Consultations de suivi pour ajuster l\'accompagnement, repondre a l\'evolution des symptomes et maintenir les progres dans la duree.' => 'Un accompagnement dans la durée pour ajuster le suivi, répondre à l’évolution de vos besoins et maintenir les progrès.',
			'Prevention et conseils' => 'Prévention et conseils',
			'Accompagnement, education et recommandations concretes pour prendre soin de votre sante au quotidien en toute serenite.' => 'Des recommandations concrètes pour mieux comprendre votre santé, prévenir certaines difficultés et avancer avec plus de sérénité.',
			'Decouvrir' => 'Découvrir',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'doctor-presentation-v2',
		array_merge(
			$dynamic,
			array(
				'Je presente ici ma posture de soin, ma relation au patient et les grands axes de mon accompagnement avec un ton simple et professionnel.' => $is_team ? 'Nous présentons ici notre manière de travailler, notre relation aux patients et les grands axes de notre accompagnement.' : 'Je présente ici ma posture de soin, ma relation au patient et les grands axes de mon accompagnement avec un ton simple et professionnel.',
			)
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'slider',
		array(
			'Le cabinet en images' => $is_team ? 'Un aperçu du cabinet' : 'Un aperçu de mon cabinet',
			'Je peux presenter ici le cadre de consultation, l\'ambiance du cabinet et quelques reperes visuels utiles pour aider le patient a se projeter avant son rendez-vous.' => $is_team ? 'Une section visuelle permet aux futurs patients de se projeter dans l’espace de consultation avant même leur premier rendez-vous.' : 'Une section visuelle permet aux futurs patients de se projeter dans l’espace de consultation avant même leur premier rendez-vous.',
			'Decouvrir le cabinet' => $is_team ? 'Découvrir le cabinet' : 'Découvrir ma pratique',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'pricing',
		array(
			'Je presente ici mes principaux actes avec une lecture rapide, rassurante et facile a comprendre.' => $is_team ? 'Nous présentons ici les principaux actes du cabinet avec une lecture rapide, rassurante et facile à comprendre.' : 'Je présente ici mes principaux actes avec une lecture rapide, rassurante et facile à comprendre.',
			'Séance de suivi' => 'Consultation de suivi',
			'Voir les tarifs detailles' => 'Voir les tarifs détaillés',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'testimonials',
		array(
			'Les avis patients renforcent la confiance et donnent un apercu concret de l\'experience de consultation.' => $is_team ? 'Les avis patients renforcent la confiance et donnent un aperçu concret de l’expérience au cabinet.' : 'Les avis patients renforcent la confiance et donnent un aperçu concret de l’expérience de consultation.',
			'Voir les avis' => 'Voir les témoignages',
		)
	);

	return $content;
}

/**
 * Build the about page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_about( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$intro = array(
		'professionnel' => $is_team ? 'Nous présentons ici notre approche, notre posture de soin et les repères qui structurent l’accompagnement proposé au cabinet.' : 'Je présente ici mon approche, ma posture de soin et les repères qui structurent l’accompagnement proposé au cabinet.',
		'chaleureux'    => $is_team ? 'Cette page permet de découvrir notre manière de travailler, l’attention portée à l’accueil et le cadre dans lequel nous accompagnons chaque patient.' : 'Cette page permet de découvrir ma manière de travailler, l’attention portée à l’accueil et le cadre dans lequel j’accompagne chaque patient.',
		'direct'        => $is_team ? 'Cette page résume notre méthode, notre parcours et les points essentiels pour comprendre rapidement le fonctionnement du cabinet.' : 'Cette page résume ma méthode, mon parcours et les points essentiels pour comprendre rapidement mon fonctionnement.',
	);

	$content  = build_demo_image_hero(
		$is_team ? 'À propos du cabinet' : 'À propos de ma pratique',
		$intro[ $writing_style ],
		$is_team ? 'Découvrir le cabinet' : 'Découvrir ma pratique'
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'doctor-presentation-skills',
		array_merge(
			$dynamic,
			array(
				'Je peux utiliser cette variante pour valoriser ma specialite, ma posture de soin et une image de cabinet plus haut de gamme.' => $is_team ? 'Nous utilisons cette section pour présenter notre posture de soin, notre spécialité et le cadre dans lequel nous accompagnons les patients.' : 'J’utilise cette section pour présenter ma posture de soin, ma spécialité et le cadre dans lequel j’accompagne mes patients.',
				'J\'y presente mon approche, mes valeurs, mon cadre de consultation et la qualite du suivi propose aux patients.' => $is_team ? 'Notre approche repose sur une écoute attentive, des explications claires et un suivi pensé pour rester lisible à chaque étape.' : 'Mon approche repose sur une écoute attentive, des explications claires et un suivi pensé pour rester lisible à chaque étape.',
			)
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'bento-grid',
		array(
			'Une pratique claire et rassurante' => $is_team ? 'Une pratique fondée sur l’écoute et la régularité' : 'Ma pratique repose sur l’écoute et la clarté',
			'Je peux mettre en avant ici ce qui structure ma pratique : ecoute, disponibilite, rigueur du suivi et clarte des informations transmises.' => $is_team ? 'Nous prenons le temps de comprendre chaque situation afin de proposer un accompagnement cohérent, progressif et adapté aux besoins du patient.' : 'Je prends le temps de comprendre votre contexte, vos attentes et vos besoins afin de proposer un accompagnement cohérent, progressif et adapté.',
			'Le format bento me permet de valoriser ma posture professionnelle sans alourdir la lecture ni surcharger une page d\'accueil.' => $is_team ? 'Notre objectif est d’offrir un cadre de consultation rassurant, des explications claires et une relation professionnelle construite dans la durée.' : 'Mon objectif est d’offrir un cadre de consultation rassurant, des explications claires et une relation professionnelle construite dans la durée.',
			'Pourquoi me consulter' => $is_team ? 'Pourquoi cette approche' : 'Pourquoi cette approche',
			'Informations claires, accompagnement personnalise et cadre de consultation professionnel.' => 'Écoute, clarté et accompagnement progressif.',
			'Une variante tres utile pour presenter mes engagements avec un rendu plus editorial.' => $is_team ? 'Une manière simple de présenter les engagements et les valeurs du cabinet.' : 'Une manière simple de présenter mes engagements et les valeurs qui guident ma pratique.',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'doctor-formations',
		array(
			'Formations &amp; Diplômes' => 'Parcours & formations',
			'Je presente ici les grandes etapes de mon parcours avec des intitules credibles, sobres et faciles a personnaliser.' => $is_team ? 'Nous présentons ici les grandes étapes de notre parcours, les formations qui structurent la pratique du cabinet et la logique de perfectionnement continu.' : 'Je présente ici les grandes étapes de mon parcours, les formations qui structurent ma pratique et la logique de perfectionnement continu.',
			'Formation principale ou diplome de reference' => 'Formation principale ou diplôme de référence',
			'Universite ou institut de formation' => 'Université ou institut de formation',
			'Ajoutez ici une courte description de la formation, de ses apports et de ce qu\'elle renforce dans votre pratique au quotidien.' => 'Cette formation a permis de structurer la pratique, d’approfondir les fondamentaux et de renforcer les bases d’un accompagnement sérieux et personnalisé.',
			'Perfectionnement ou formation complementaire' => 'Perfectionnement ou formation complémentaire',
			'Centre de formation reconnu' => 'Centre de formation reconnu',
			'Cette ligne peut mettre en avant une competence specifique, une approche complementaire ou une expertise plus ciblee.' => 'Cette ligne met en avant une compétence plus ciblée, une approche complémentaire ou une expertise utile pour enrichir la pratique au quotidien.',
			'Formation continue' => 'Formation continue',
			'Organisme professionnel' => 'Organisme professionnel',
			'Chaque annee' => 'Chaque année',
			'Je peux utiliser cette derniere ligne pour montrer que ma pratique evolue, se met a jour et s\'inscrit dans une demarche de qualite continue.' => $is_team ? 'Cette dernière ligne permet de montrer que le cabinet s’inscrit dans une démarche de qualité continue et de mise à jour régulière des pratiques.' : 'Cette dernière ligne permet de montrer que ma pratique s’inscrit dans une démarche de qualité continue et de mise à jour régulière.',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'image-simple',
		array(
			'Le cabinet en image' => $is_team ? 'Un cabinet pensé pour accueillir' : 'Un espace pensé pour accueillir',
			'Une section tres simple pour valoriser un espace de consultation, un equipement ou une ambiance de cabinet.' => $is_team ? 'Cette section montre comment valoriser l’ambiance du cabinet, un espace de consultation ou un équipement spécifique sans alourdir la page.' : 'Cette section montre comment valoriser l’ambiance du cabinet, un espace de consultation ou un équipement spécifique sans alourdir la page.',
		)
	);

	return apply_demo_replacements( $content, $dynamic );
}

/**
 * Build the pricing page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_pricing( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$hero_intro = array(
		'professionnel' => $is_team ? 'Nous présentons ici nos honoraires de façon simple et transparente, afin de vous permettre de préparer votre rendez-vous sereinement.' : 'Je présente ici mes honoraires de façon simple et transparente, afin de vous permettre de préparer votre rendez-vous sereinement.',
		'chaleureux'    => $is_team ? 'Cette page vous aide à comprendre les principales consultations proposées, dans un esprit de clarté et de confiance.' : 'Cette page vous aide à comprendre les principales consultations proposées, dans un esprit de clarté et de confiance.',
		'direct'        => $is_team ? 'Retrouvez ici les principaux rendez-vous proposés au cabinet, leurs modalités et leurs tarifs.' : 'Retrouvez ici les principaux rendez-vous proposés, leurs modalités et leurs tarifs.',
	);

	$faq_items = array(
		array(
			'question' => 'Comment choisir le bon type de rendez-vous ?',
			'answer'   => $is_team ? 'Si vous consultez pour la première fois, la première consultation est généralement la formule la plus adaptée. En cas de doute, nous pouvons vous orienter.' : 'Si vous consultez pour la première fois, la première consultation est généralement la formule la plus adaptée. En cas de doute, je peux vous orienter.',
		),
		array(
			'question' => 'Le règlement se fait-il au cabinet ?',
			'answer'   => 'Le règlement s’effectue à l’issue de la consultation, selon les modalités habituelles du cabinet.',
		),
		array(
			'question' => 'Puis-je poser une question avant de réserver ?',
			'answer'   => $is_team ? 'Oui, nous restons disponibles pour vous aider à choisir la consultation la plus pertinente selon votre situation.' : 'Oui, je reste disponible pour vous aider à choisir la consultation la plus pertinente selon votre situation.',
		),
		array(
			'question' => 'Les consultations sont-elles sur rendez-vous ?',
			'answer'   => 'Oui, les rendez-vous sont organisés afin de garantir un accueil serein et un temps de consultation adapté.',
		),
		array(
			'question' => 'Puis-je retrouver les tarifs avant de confirmer ?',
			'answer'   => 'Oui, cette page est pensée pour donner une lecture claire des honoraires avant toute prise de rendez-vous.',
		),
	);

	$content  = build_demo_image_hero(
		$is_team ? 'Nos tarifs' : 'Mes tarifs',
		$hero_intro[ $writing_style ],
		'Comprendre les consultations'
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'pricing-list',
		array(
			'Honoraires et consultations' => 'Honoraires et consultations',
			'Je detaille ici mes consultations pour permettre une lecture simple des modalites et des tarifs.' => $is_team ? 'Nous détaillons ici les principaux rendez-vous proposés au cabinet afin de permettre une lecture simple des modalités et des tarifs.' : 'Je détaille ici mes consultations pour permettre une lecture simple des modalités et des tarifs.',
			'Premiere consultation' => 'Première consultation',
			"Ce premier rendez-vous permet de faire le point sur votre situation, d'identifier vos besoins et de definir une prise en charge claire. C'est le temps ideal pour presenter le contexte, poser vos questions et construire un accompagnement adapte." => 'Ce premier rendez-vous permet de faire le point sur votre situation, d’identifier vos besoins et de définir une prise en charge claire. C’est le temps idéal pour présenter le contexte, poser vos questions et construire un accompagnement adapté.',
			'Consultation de suivi' => 'Consultation de suivi',
			"Destinee aux patients deja suivis, cette consultation permet d'ajuster l'accompagnement, de faire le point sur l'evolution des symptomes et de proposer des recommandations concretes entre deux rendez-vous." => 'Destinée aux patients déjà suivis, cette consultation permet d’ajuster l’accompagnement, de faire le point sur l’évolution de la situation et de proposer des recommandations concrètes entre deux rendez-vous.',
			'Bilan approfondi ou acte specifique' => 'Bilan approfondi ou acte spécifique',
			'Cette formule convient lorsque la situation demande davantage de temps d\'analyse, un bilan plus complet ou un accompagnement cible. Elle permet de valoriser un acte plus technique tout en restant tres lisible pour le patient.' => 'Cette formule convient lorsque la situation demande davantage de temps d’analyse, un bilan plus complet ou un accompagnement ciblé. Elle permet de valoriser un acte plus technique tout en restant très lisible pour le patient.',
			'Me contacter' => 'Me contacter',
		)
	);
	$content .= "\n\n";
	$content .= build_demo_faq_section( 'Questions fréquentes', $faq_items );

	return apply_demo_replacements( $content, $dynamic );
}

/**
 * Build the contact page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_contact( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$hero_intro = array(
		'professionnel' => $is_team ? 'Nous restons disponibles pour répondre à vos questions, vous orienter vers le bon rendez-vous et vous accueillir au cabinet dans les meilleures conditions.' : 'Je reste disponible pour répondre à vos questions, vous orienter vers le bon rendez-vous et vous accueillir au cabinet dans les meilleures conditions.',
		'chaleureux'    => $is_team ? 'Cette page vous permet de nous contacter simplement et de trouver les informations utiles avant votre venue.' : 'Cette page vous permet de me contacter simplement et de trouver les informations utiles avant votre venue.',
		'direct'        => $is_team ? 'Retrouvez ici nos coordonnées, le formulaire de contact et les horaires du cabinet.' : 'Retrouvez ici mes coordonnées, le formulaire de contact et mes horaires de consultation.',
	);

	$content  = build_demo_image_hero(
		$is_team ? 'Nous contacter' : 'Me contacter',
		$hero_intro[ $writing_style ],
		'Voir les horaires'
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'contact-form-v3',
		array_merge(
			$dynamic,
			array(
				'Me contacter' => $is_team ? 'Nous contacter' : 'Me contacter',
				'Une question ? Je vous reponds dans les meilleurs delais et je vous accueille dans un cadre de consultation serein et professionnel.' => $is_team ? 'Une question ? Nous vous répondons dans les meilleurs délais et vous accueillons dans un cadre de consultation serein et professionnel.' : 'Une question ? Je vous réponds dans les meilleurs délais et je vous accueille dans un cadre de consultation serein et professionnel.',
			)
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'opening-hours',
		array(
			'Mes horaires de consultation' => $is_team ? 'Nos horaires de consultation' : 'Mes horaires de consultation',
			'Retrouvez ici mes jours de consultation et les moments ou je peux vous recevoir sur rendez-vous.' => $is_team ? 'Retrouvez ici les jours de consultation et les moments où nous pouvons vous recevoir sur rendez-vous.' : 'Retrouvez ici mes jours de consultation et les moments où je peux vous recevoir sur rendez-vous.',
		)
	);

	return apply_demo_replacements( $content, $dynamic );
}

/**
 * Build the testimonials page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_testimonials( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$hero_intro = array(
		'professionnel' => $is_team ? 'Les témoignages permettent de mieux comprendre l’expérience au cabinet et la qualité de l’accompagnement proposé.' : 'Les témoignages permettent de mieux comprendre l’expérience de consultation et la qualité de l’accompagnement proposé.',
		'chaleureux'    => $is_team ? 'Les avis patients reflètent la relation de confiance qui se construit au fil des consultations.' : 'Les avis patients reflètent la relation de confiance qui se construit au fil des consultations.',
		'direct'        => $is_team ? 'Cette page rassemble des retours patients pour illustrer concrètement la qualité du suivi proposé.' : 'Cette page rassemble des retours patients pour illustrer concrètement la qualité du suivi proposé.',
	);

	$content  = build_demo_image_hero(
		$is_team ? 'Les avis de nos patients' : 'Les avis de mes patients',
		$hero_intro[ $writing_style ],
		'Comprendre l’expérience patient'
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'video',
		array(
			'Decouvrez mon cabinet en video' => $is_team ? 'Présenter le cabinet en vidéo' : 'Présenter ma pratique en vidéo',
			'La video me permet de presenter l\'ambiance du cabinet, mon approche et la relation de confiance que je souhaite installer.' => $is_team ? 'Une vidéo peut compléter les avis patients en donnant un aperçu plus humain de l’ambiance du cabinet, de l’accueil et du cadre de consultation.' : 'Une vidéo peut compléter les avis patients en donnant un aperçu plus humain de ma pratique, de l’accueil et du cadre de consultation.',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'testimonials',
		array(
			'Ce que disent mes patients' => $is_team ? 'Ce que disent nos patients' : 'Ce que disent mes patients',
			'Les avis patients renforcent la confiance et donnent un apercu concret de l\'experience de consultation.' => $is_team ? 'Ces avis permettent de mieux comprendre l’expérience vécue au cabinet et le cadre dans lequel nous accompagnons nos patients.' : 'Ces avis permettent de mieux comprendre l’expérience vécue en consultation et le cadre dans lequel j’accompagne mes patients.',
			'Voir les avis' => 'Prendre rendez-vous',
		)
	);

	return apply_demo_replacements( $content, $dynamic );
}

/**
 * Build the FAQ page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_faq( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$hero_intro = array(
		'professionnel' => 'Retrouvez ici les réponses aux questions les plus souvent posées avant une première consultation.',
		'chaleureux'    => 'Cette page aide à aborder un premier rendez-vous plus sereinement, avec des repères simples et rassurants.',
		'direct'        => 'Les réponses ci-dessous vont à l’essentiel pour préparer votre rendez-vous et comprendre le fonctionnement du cabinet.',
	);

	$faq_items = array(
		array(
			'question' => 'Quand puis-je prendre rendez-vous ?',
			'answer'   => $is_team ? 'Vous pouvez prendre rendez-vous selon les créneaux disponibles au cabinet. En cas de doute, nous pouvons vous orienter.' : 'Vous pouvez prendre rendez-vous selon les créneaux disponibles au cabinet. En cas de doute, je peux vous orienter.',
		),
		array(
			'question' => 'Faut-il préparer quelque chose avant la consultation ?',
			'answer'   => 'Il est souvent utile de venir avec les documents importants liés à votre situation : comptes rendus, examens ou informations utiles selon votre motif de consultation.',
		),
		array(
			'question' => 'Comment se déroule le suivi ?',
			'answer'   => 'Le suivi dépend de votre situation, de vos besoins et de l’évolution observée. Chaque rendez-vous permet de faire le point et d’ajuster l’accompagnement si nécessaire.',
		),
		array(
			'question' => 'Puis-je vous contacter avant de réserver ?',
			'answer'   => $is_team ? 'Oui, vous pouvez nous contacter pour poser une question pratique ou être orienté vers la consultation la plus adaptée.' : 'Oui, vous pouvez me contacter pour poser une question pratique ou être orienté vers la consultation la plus adaptée.',
		),
		array(
			'question' => 'Le cabinet reçoit-il uniquement sur rendez-vous ?',
			'answer'   => 'Oui, les consultations s’effectuent sur rendez-vous afin de garantir un accueil plus serein et un temps de prise en charge adapté.',
		),
	);

	$content  = build_demo_image_hero(
		'Questions fréquentes',
		$hero_intro[ $writing_style ],
		'Préparer le rendez-vous'
	);
	$content .= "\n\n";
	$content .= build_demo_faq_section( 'Avant votre rendez-vous', $faq_items );
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'contact-form',
		array(
			'Nous contacter' => $is_team ? 'Vous ne trouvez pas votre réponse ?' : 'Vous ne trouvez pas votre réponse ?',
			'Une question ? N\'hésitez pas à nous envoyer un message, nous vous répondrons dans les plus brefs délais.' => $is_team ? 'Si votre question concerne votre situation, le déroulé d’un rendez-vous ou le type de consultation à privilégier, nous restons disponibles pour vous orienter simplement.' : 'Si votre question concerne votre situation, le déroulé d’un rendez-vous ou le type de consultation à privilégier, je reste disponible pour vous orienter simplement.',
		)
	);

	return apply_demo_replacements( $content, $dynamic );
}

/**
 * Build the practical info page content.
 *
 * @param string               $tone          Tone slug.
 * @param string               $writing_style Writing style slug.
 * @param array<string,string> $dynamic       Dynamic replacements.
 * @return string
 */
function build_demo_page_practical_info( $tone, $writing_style, array $dynamic ) {
	$is_team = 'nous' === $tone;

	$hero_intro = array(
		'professionnel' => 'Retrouvez ici les informations utiles pour préparer votre venue au cabinet : horaires, accès et transports.',
		'chaleureux'    => 'Cette page rassemble les repères pratiques pour venir au cabinet plus sereinement.',
		'direct'        => 'Horaires, accès et transports : tout ce qu’il faut pour préparer votre rendez-vous rapidement.',
	);

	$content  = build_demo_image_hero(
		'Infos pratiques',
		$hero_intro[ $writing_style ],
		'Voir les accès'
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'image-simple',
		array(
			'Le cabinet en image' => 'Préparer votre venue',
			'Une section tres simple pour valoriser un espace de consultation, un equipement ou une ambiance de cabinet.' => 'Cette section permet de montrer le lieu, l’environnement du cabinet ou un repère visuel utile pour aider les patients à se projeter avant leur rendez-vous.',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'opening-hours',
		array(
			'Mes horaires de consultation' => $is_team ? 'Nos horaires de consultation' : 'Mes horaires de consultation',
			'Retrouvez ici mes jours de consultation et les moments ou je peux vous recevoir sur rendez-vous.' => $is_team ? 'Retrouvez ici les jours de consultation et les moments où nous pouvons vous recevoir sur rendez-vous.' : 'Retrouvez ici mes jours de consultation et les moments où je peux vous recevoir sur rendez-vous.',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'slider',
		array(
			'Le cabinet en images' => 'Repères visuels',
			'Je peux presenter ici le cadre de consultation, l\'ambiance du cabinet et quelques reperes visuels utiles pour aider le patient a se projeter avant son rendez-vous.' => 'Le carrousel peut présenter l’entrée, la salle d’attente, la salle de consultation ou tout repère utile pour faciliter la venue au cabinet.',
			'Decouvrir le cabinet' => 'Voir l’itinéraire',
		)
	);
	$content .= "\n\n";
	$content .= render_demo_pattern_content(
		'cards',
		array(
			'Des prises en charge claires et adaptees' => 'Accès et transports',
			'Je peux utiliser cette section pour presenter mes specialites, les besoins frequemment rencontres et la maniere dont j\'accompagne mes patients.' => 'Cette section permet d’indiquer simplement les moyens d’accès au cabinet et les repères utiles pour préparer votre venue.',
			'Consultation initiale' => 'Bus',
			'Premier rendez-vous pour faire le point sur votre situation, comprendre vos besoins et definir une prise en charge adaptee.' => 'Lignes de bus à proximité du cabinet avec arrêt situé à quelques minutes à pied.',
			'Suivi personnalise' => 'Métro',
			'Consultations de suivi pour ajuster l\'accompagnement, repondre a l\'evolution des symptomes et maintenir les progres dans la duree.' => 'Station de métro la plus proche, accès simple et pratique pour les patients venant de Paris ou de la périphérie.',
			'Prevention et conseils' => 'RER',
			'Accompagnement, education et recommandations concretes pour prendre soin de votre sante au quotidien en toute serenite.' => 'Connexion rapide depuis les grands axes franciliens avec une solution utile pour les patients venant de plus loin.',
			'Decouvrir' => 'Voir l’itinéraire',
		)
	);

	return apply_demo_replacements( $content, $dynamic );
}

/**
 * Install selected demo pages.
 *
 * @param string   $tone                Tone slug.
 * @param string   $writing_style       Writing style slug.
 * @param string[] $selected_pages      Selected page slugs.
 * @param bool     $add_pages_to_header Whether to add generated pages to header navigation.
 * @return int[] Created page IDs keyed by slug.
 */
function install_demo_pages( $tone = 'je', $writing_style = 'professionnel', array $selected_pages = array(), $add_pages_to_header = false ) {
	$definitions = get_demo_pages_definition();
	$available   = array_keys( $definitions );
	$pages       = array_values( array_intersect( array_map( 'sanitize_title', $selected_pages ), $available ) );

	if ( empty( $pages ) ) {
		return array();
	}

	$created = array();

	foreach ( $pages as $slug ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );

		if ( $existing instanceof \WP_Post ) {
			$created[ $slug ] = (int) $existing->ID;
			continue;
		}

		$page_content = build_demo_page_content( $slug, $tone, $writing_style );

		if ( '' === trim( $page_content ) ) {
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $definitions[ $slug ]['label'],
				'post_name'    => $slug,
				'post_content' => $page_content,
			),
			true
		);

		if ( is_wp_error( $page_id ) ) {
			continue;
		}

		$created[ $slug ] = (int) $page_id;
	}

	if ( isset( $created['accueil'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $created['accueil'] );
	}

	$installed = get_option( OPTION_DEMO_PAGES_INSTALLED, array() );
	$installed = array_values(
		array_unique(
			array_merge(
				is_array( $installed ) ? $installed : array(),
				array_keys( $created )
			)
		)
	);
	update_option( OPTION_DEMO_PAGES_INSTALLED, $installed );

	if ( $add_pages_to_header ) {
		add_demo_pages_to_header_navigation( $created );
	}

	return $created;
}

/**
 * Add generated demo pages to the header navigation block.
 *
 * @param array<string,int> $page_ids Page IDs keyed by demo page slug.
 * @return bool
 */
function add_demo_pages_to_header_navigation( array $page_ids ) {
	if ( empty( $page_ids ) || ! post_type_exists( 'wp_navigation' ) ) {
		return false;
	}

	$navigation_id = get_header_navigation_post_id();
	if ( $navigation_id <= 0 ) {
		return false;
	}

	$navigation = get_post( $navigation_id );
	if ( ! $navigation instanceof \WP_Post || 'wp_navigation' !== $navigation->post_type ) {
		return false;
	}

	$definitions       = get_demo_pages_definition();
	$existing_page_ids = get_navigation_page_ids_from_content( (string) $navigation->post_content );
	$new_links         = array();

	foreach ( $definitions as $slug => $definition ) {
		if ( empty( $page_ids[ $slug ] ) ) {
			continue;
		}

		$page_id = absint( $page_ids[ $slug ] );
		if ( in_array( $page_id, $existing_page_ids, true ) ) {
			continue;
		}

		$url = get_permalink( $page_id );
		if ( ! $url ) {
			continue;
		}

		$new_links[] = build_navigation_page_link_block(
			$definition['label'],
			$page_id,
			$url
		);
	}

	if ( empty( $new_links ) ) {
		return false;
	}

	$content = trim( (string) $navigation->post_content );
	$content = '' === $content ? implode( "\n", $new_links ) : $content . "\n" . implode( "\n", $new_links );

	$result = wp_update_post(
		array(
			'ID'           => $navigation_id,
			'post_content' => wp_slash( $content ),
		),
		true
	);

	return ! is_wp_error( $result );
}

/**
 * Build a serialized navigation-link block for a page.
 *
 * @param string $label   Link label.
 * @param int    $page_id Page ID.
 * @param string $url     Page URL.
 * @return string
 */
function build_navigation_page_link_block( $label, $page_id, $url ) {
	$attrs = array(
		'label'          => $label,
		'type'           => 'page',
		'id'             => absint( $page_id ),
		'url'            => $url,
		'kind'           => 'post-type',
		'isTopLevelLink' => true,
	);

	return '<!-- wp:navigation-link ' . wp_json_encode( $attrs ) . ' /-->';
}

/**
 * Get the wp_navigation post referenced by the header template part.
 *
 * @return int
 */
function get_header_navigation_post_id() {
	$content = get_header_template_part_content();
	$ref     = '' !== $content ? find_navigation_ref_in_blocks( parse_blocks( $content ) ) : 0;

	if ( $ref > 0 && 'wp_navigation' === get_post_type( $ref ) ) {
		return $ref;
	}

	$navigation_posts = get_posts(
		array(
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'post_type'              => 'wp_navigation',
			'posts_per_page'         => 2,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	return 1 === count( $navigation_posts ) ? (int) $navigation_posts[0] : 0;
}

/**
 * Get header template part content from the customized template or theme file.
 *
 * @return string
 */
function get_header_template_part_content() {
	if ( function_exists( 'get_block_template' ) ) {
		$template = get_block_template( get_stylesheet() . '//header', 'wp_template_part' );
		if ( $template && ! empty( $template->content ) ) {
			return (string) $template->content;
		}
	}

	$file = get_theme_file_path( 'parts/header.html' );
	if ( is_readable( $file ) ) {
		$content = file_get_contents( $file );
		return false === $content ? '' : (string) $content;
	}

	return '';
}

/**
 * Find the first core/navigation ref inside parsed blocks.
 *
 * @param array<int,array<string,mixed>> $blocks Parsed blocks.
 * @return int
 */
function find_navigation_ref_in_blocks( array $blocks ) {
	foreach ( $blocks as $block ) {
		if ( 'core/navigation' === ( $block['blockName'] ?? '' ) && ! empty( $block['attrs']['ref'] ) ) {
			return absint( $block['attrs']['ref'] );
		}

		if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
			$ref = find_navigation_ref_in_blocks( $block['innerBlocks'] );
			if ( $ref > 0 ) {
				return $ref;
			}
		}
	}

	return 0;
}

/**
 * Extract page IDs already present in a navigation post.
 *
 * @param string $content Navigation post content.
 * @return int[]
 */
function get_navigation_page_ids_from_content( $content ) {
	$page_ids = array();
	$blocks   = parse_blocks( $content );

	foreach ( $blocks as $block ) {
		$page_ids = array_merge( $page_ids, get_navigation_page_ids_from_block( $block ) );
	}

	return array_values( array_unique( array_map( 'absint', $page_ids ) ) );
}

/**
 * Extract page IDs recursively from a navigation block.
 *
 * @param array<string,mixed> $block Parsed block.
 * @return int[]
 */
function get_navigation_page_ids_from_block( array $block ) {
	$page_ids = array();

	if (
		'core/navigation-link' === ( $block['blockName'] ?? '' )
		&& 'page' === ( $block['attrs']['type'] ?? '' )
		&& ! empty( $block['attrs']['id'] )
	) {
		$page_ids[] = absint( $block['attrs']['id'] );
	}

	if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
		foreach ( $block['innerBlocks'] as $inner_block ) {
			$page_ids = array_merge( $page_ids, get_navigation_page_ids_from_block( $inner_block ) );
		}
	}

	return $page_ids;
}
