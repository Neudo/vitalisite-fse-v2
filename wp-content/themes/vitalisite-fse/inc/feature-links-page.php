<?php
/**
 * Links Page feature.
 *
 * Adds a repeater-style metabox on pages using the "template-links" template.
 * Each link has: emoji/icon, label, URL, and display order.
 * Also renders the links dynamically via render_block on post-content.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

namespace Vitalisite_FSE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add excerpt support to pages (used as description on the links page).
 */
function links_page_add_excerpt_support() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', __NAMESPACE__ . '\links_page_add_excerpt_support' );

/**
 * Register the meta box for the links page.
 */
function links_page_add_meta_box() {
	add_meta_box(
		'vitalisite_links_page',
		__( 'Liens de la page', 'vitalisite-fse' ),
		__NAMESPACE__ . '\links_page_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\links_page_add_meta_box' );

/**
 * Toggle metabox visibility + hide block editor when template-links is active.
 */
function links_page_meta_box_js() {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}
	?>
	<style id="vitalisite-links-editor-hide">
		/* Hide the block editor canvas (both iframe and non-iframe variants) */
		body.vitalisite-links-template .editor-visual-editor,
		body.vitalisite-links-template .edit-post-visual-editor,
		body.vitalisite-links-template .editor-editor-canvas__iframe,
		body.vitalisite-links-template .editor-canvas__iframe,
		body.vitalisite-links-template iframe[name="editor-canvas"] {
			display: none !important;
		}
		/* Also hide the block inserter toolbar */
		body.vitalisite-links-template .edit-post-header-toolbar__inserter-toggle,
		body.vitalisite-links-template .editor-document-tools__inserter-toggle {
			display: none !important;
		}
		/* Notice banner */
		.vitalisite-links-editor-notice {
			display: none;
			background: #f0f6fc;
			border-left: 4px solid #0B3D91;
			border-radius: 2px;
			padding: 16px 20px;
			margin: 16px 20px;
			font-size: 14px;
			color: #1d2327;
			line-height: 1.6;
		}
		.vitalisite-links-editor-notice strong { display: block; margin-bottom: 4px; }
		body.vitalisite-links-template .vitalisite-links-editor-notice {
			display: block;
		}
	</style>
	<script>
	(function(){
		var TEMPLATE_SLUG = 'template-links';
		var noticeInjected = false;

		function update(){
			var box = document.getElementById('vitalisite_links_page');
			var tpl = '';
			if(window.wp && wp.data && wp.data.select('core/editor')){
				tpl = wp.data.select('core/editor').getEditedPostAttribute('template') || '';
			}
			var isLinks = (tpl === TEMPLATE_SLUG);

			// Toggle metabox
			if(box) box.style.display = isLinks ? '' : 'none';

			// Toggle body class to hide/show block editor via CSS
			document.body.classList.toggle('vitalisite-links-template', isLinks);

			// Inject info notice once
			if(isLinks && !noticeInjected){
				injectNotice();
				noticeInjected = true;
			}

			// Open the excerpt panel when on links template
			if(isLinks && window.wp && wp.data && wp.data.dispatch){
				var prefs = wp.data.select('core/editor');
				if(prefs && !prefs.isEditorPanelOpened('post-excerpt')){
					wp.data.dispatch('core/editor').toggleEditorPanelOpened('post-excerpt');
				}
			}
		}

		function injectNotice(){
			var target = document.querySelector('.editor-header') ||
			             document.querySelector('.edit-post-header') ||
			             document.querySelector('.interface-interface-skeleton__header');
			if(!target) return;
			var notice = document.createElement('div');
			notice.className = 'vitalisite-links-editor-notice';
			notice.innerHTML = '<strong>📋 Page de liens</strong>Le contenu est géré via la boîte « Liens de la page » ci-dessous. L\'éditeur de blocs est désactivé sur ce template.';
			target.after(notice);
		}

		if(window.wp && wp.data && wp.data.subscribe){
			wp.data.subscribe(update);
		}
		document.addEventListener('DOMContentLoaded', function(){
			setTimeout(update, 800);
		});
	})();
	</script>
	<?php
}
add_action( 'admin_footer', __NAMESPACE__ . '\links_page_meta_box_js' );

/**
 * Render the repeater metabox.
 */
function links_page_render_meta_box( $post ) {
	$links = get_post_meta( $post->ID, '_vitalisite_links', true );
	if ( ! is_array( $links ) ) {
		$links = array();
	}
	$links_title       = get_post_meta( $post->ID, '_vitalisite_links_title', true );
	$links_description = get_post_meta( $post->ID, '_vitalisite_links_description', true );

	wp_nonce_field( 'vitalisite_save_links', 'vitalisite_links_nonce' );
	?>
	<style>
		.vitalisite-links-meta { margin-bottom: 20px; }
		.vitalisite-links-meta .form-row { margin-bottom: 12px; }
		.vitalisite-links-meta label { display: block; margin-bottom: 4px; font-weight: 600; }
		.vitalisite-links-meta .description { color: #666; font-style: italic; font-size: 12px; margin-top: 4px; }
		.vitalisite-links-meta hr { border: none; border-top: 1px solid #ddd; margin: 16px 0; }
		.vitalisite-links-repeater { width: 100%; }
		.vitalisite-links-repeater__item {
			display: grid;
			grid-template-columns: 60px 1fr 1.5fr 60px 40px;
			gap: 8px;
			align-items: center;
			padding: 8px 0;
			border-bottom: 1px solid #eee;
		}
		.vitalisite-links-repeater__item:last-child { border-bottom: none; }
		.vitalisite-links-repeater__header {
			display: grid;
			grid-template-columns: 60px 1fr 1.5fr 60px 40px;
			gap: 8px;
			padding: 6px 0;
			font-weight: 600;
			font-size: 12px;
			color: #666;
			border-bottom: 2px solid #ddd;
		}
		.vitalisite-links-repeater input[type="text"],
		.vitalisite-links-repeater input[type="url"],
		.vitalisite-links-repeater input[type="number"] {
			width: 100%;
		}
		.vitalisite-links-repeater__remove {
			color: #b32d2e;
			cursor: pointer;
			background: none;
			border: none;
			font-size: 18px;
			line-height: 1;
		}
		.vitalisite-links-repeater__remove:hover { color: #a00; }
		.vitalisite-links-repeater__add { margin-top: 12px; }
	</style>

	<div class="vitalisite-links-meta">
		<div class="form-row">
			<label for="vitalisite_links_title"><?php esc_html_e( 'Titre', 'vitalisite-fse' ); ?></label>
			<input type="text" id="vitalisite_links_title" name="vitalisite_links_title" value="<?php echo esc_attr( $links_title ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Ex: Dr. Dupont', 'vitalisite-fse' ); ?>">
			<span class="description"><?php esc_html_e( 'Titre affiché en haut de la page de liens. Laissez vide pour utiliser le nom du médecin.', 'vitalisite-fse' ); ?></span>
		</div>
		<div class="form-row">
			<label for="vitalisite_links_description"><?php esc_html_e( 'Description', 'vitalisite-fse' ); ?></label>
			<textarea id="vitalisite_links_description" name="vitalisite_links_description" rows="3" class="widefat" placeholder="<?php esc_attr_e( 'Courte description affichée sous le titre…', 'vitalisite-fse' ); ?>"><?php echo esc_textarea( $links_description ); ?></textarea>
		</div>
		<hr>
	</div>

	<div class="vitalisite-links-repeater" id="vitalisite-links-repeater">
		<div class="vitalisite-links-repeater__header">
			<span><?php esc_html_e( 'Icône', 'vitalisite-fse' ); ?></span>
			<span><?php esc_html_e( 'Titre', 'vitalisite-fse' ); ?></span>
			<span><?php esc_html_e( 'URL', 'vitalisite-fse' ); ?></span>
			<span><?php esc_html_e( 'Ordre', 'vitalisite-fse' ); ?></span>
			<span></span>
		</div>
		<div id="vitalisite-links-list">
			<?php
			if ( ! empty( $links ) ) {
				usort( $links, function( $a, $b ) {
					return ( (int) ( $a['order'] ?? 0 ) ) - ( (int) ( $b['order'] ?? 0 ) );
				});
				foreach ( $links as $i => $link ) {
					links_page_render_row( $i, $link );
				}
			}
			?>
		</div>
		<button type="button" class="button vitalisite-links-repeater__add" id="vitalisite-links-add">
			+ <?php esc_html_e( 'Ajouter un lien', 'vitalisite-fse' ); ?>
		</button>
	</div>

	<script>
	(function(){
		var list = document.getElementById('vitalisite-links-list');
		var addBtn = document.getElementById('vitalisite-links-add');
		var idx = <?php echo count( $links ); ?>;

		addBtn.addEventListener('click', function(){
			var row = document.createElement('div');
			row.className = 'vitalisite-links-repeater__item';
			row.innerHTML =
				'<input type="text" name="vitalisite_links['+idx+'][icon]" value="🔗" placeholder="📌">' +
				'<input type="text" name="vitalisite_links['+idx+'][label]" value="" placeholder="<?php echo esc_attr__( 'Mon lien', 'vitalisite-fse' ); ?>">' +
				'<input type="url" name="vitalisite_links['+idx+'][url]" value="" placeholder="https://…">' +
				'<input type="number" name="vitalisite_links['+idx+'][order]" value="'+((idx+1)*10)+'" min="0" step="1">' +
				'<button type="button" class="vitalisite-links-repeater__remove" title="<?php echo esc_attr__( 'Supprimer', 'vitalisite-fse' ); ?>">×</button>';
			list.appendChild(row);
			idx++;
		});

		list.addEventListener('click', function(e){
			if(e.target.classList.contains('vitalisite-links-repeater__remove')){
				e.target.closest('.vitalisite-links-repeater__item').remove();
			}
		});
	})();
	</script>
	<?php
}

/**
 * Render a single repeater row.
 */
function links_page_render_row( $index, $link ) {
	$icon  = isset( $link['icon'] ) ? $link['icon'] : '🔗';
	$label = isset( $link['label'] ) ? $link['label'] : '';
	$url   = isset( $link['url'] ) ? $link['url'] : '';
	$order = isset( $link['order'] ) ? (int) $link['order'] : ( ( $index + 1 ) * 10 );
	?>
	<div class="vitalisite-links-repeater__item">
		<input type="text" name="vitalisite_links[<?php echo $index; ?>][icon]" value="<?php echo esc_attr( $icon ); ?>" placeholder="📌">
		<input type="text" name="vitalisite_links[<?php echo $index; ?>][label]" value="<?php echo esc_attr( $label ); ?>" placeholder="<?php esc_attr_e( 'Mon lien', 'vitalisite-fse' ); ?>">
		<input type="url" name="vitalisite_links[<?php echo $index; ?>][url]" value="<?php echo esc_attr( $url ); ?>" placeholder="https://…">
		<input type="number" name="vitalisite_links[<?php echo $index; ?>][order]" value="<?php echo esc_attr( $order ); ?>" min="0" step="1">
		<button type="button" class="vitalisite-links-repeater__remove" title="<?php esc_attr_e( 'Supprimer', 'vitalisite-fse' ); ?>">×</button>
	</div>
	<?php
}

/**
 * Save the links meta.
 */
function links_page_save_meta( $post_id ) {
	if ( ! isset( $_POST['vitalisite_links_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['vitalisite_links_nonce'], 'vitalisite_save_links' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw_links = isset( $_POST['vitalisite_links'] ) ? $_POST['vitalisite_links'] : array();
	$clean     = array();

	if ( is_array( $raw_links ) ) {
		foreach ( $raw_links as $link ) {
			if ( empty( $link['label'] ) && empty( $link['url'] ) ) {
				continue;
			}
			$clean[] = array(
				'icon'  => sanitize_text_field( $link['icon'] ?? '🔗' ),
				'label' => sanitize_text_field( $link['label'] ?? '' ),
				'url'   => esc_url_raw( $link['url'] ?? '' ),
				'order' => absint( $link['order'] ?? 0 ),
			);
		}
	}

	usort( $clean, function( $a, $b ) {
		return $a['order'] - $b['order'];
	});

	update_post_meta( $post_id, '_vitalisite_links', $clean );

	if ( isset( $_POST['vitalisite_links_title'] ) ) {
		update_post_meta( $post_id, '_vitalisite_links_title', sanitize_text_field( $_POST['vitalisite_links_title'] ) );
	}
	if ( isset( $_POST['vitalisite_links_description'] ) ) {
		update_post_meta( $post_id, '_vitalisite_links_description', sanitize_textarea_field( $_POST['vitalisite_links_description'] ) );
	}
}
add_action( 'save_post_page', __NAMESPACE__ . '\links_page_save_meta' );

/**
 * Render the links page content via render_block filter.
 *
 * When the page uses the template-links template, replace
 * the post-content block output with our custom rendering.
 */
function render_links_page_content( $block_content, $block ) {
	if ( 'core/post-content' !== $block['blockName'] ) {
		return $block_content;
	}

	if ( ! is_page() ) {
		return $block_content;
	}

	$post = get_queried_object();
	if ( ! $post || 'template-links' !== get_page_template_slug( $post->ID ) ) {
		return $block_content;
	}

	$cabinet = get_option( 'vitalisite_cabinet', array() );
	$photo_id  = ! empty( $cabinet['doctor_photo'] ) ? absint( $cabinet['doctor_photo'] ) : 0;
	$photo_url = $photo_id ? wp_get_attachment_image_url( $photo_id, 'medium' ) : '';
	$specialty = ! empty( $cabinet['doctor_specialty'] ) ? $cabinet['doctor_specialty'] : '';

	$custom_title = get_post_meta( $post->ID, '_vitalisite_links_title', true );
	$name         = ! empty( $custom_title ) ? $custom_title : ( ! empty( $cabinet['doctor_name'] ) ? $cabinet['doctor_name'] : get_bloginfo( 'name' ) );

	$custom_desc  = get_post_meta( $post->ID, '_vitalisite_links_description', true );
	$description  = ! empty( $custom_desc ) ? $custom_desc : get_the_excerpt( $post->ID );

	$links = get_post_meta( $post->ID, '_vitalisite_links', true );
	if ( ! is_array( $links ) ) {
		$links = array();
	}

	usort( $links, function( $a, $b ) {
		return ( (int) ( $a['order'] ?? 0 ) ) - ( (int) ( $b['order'] ?? 0 ) );
	});

	ob_start();
	?>
	<div class="vitalisite-links">
		<div class="vitalisite-links__header">
			<?php if ( $photo_url ) : ?>
				<img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="vitalisite-links__avatar">
			<?php endif; ?>
			<h1 class="vitalisite-links__name"><?php echo esc_html( $name ); ?></h1>
			<?php if ( $specialty ) : ?>
				<p class="vitalisite-links__subtitle"><?php echo esc_html( $specialty ); ?></p>
			<?php endif; ?>
			<?php if ( $description ) : ?>
				<p class="vitalisite-links__description"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $links ) ) : ?>
		<div class="vitalisite-links__list">
			<?php foreach ( $links as $link ) :
				if ( empty( $link['url'] ) ) continue;
			?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="vitalisite-links__item" target="_blank" rel="noopener noreferrer">
					<?php if ( ! empty( $link['icon'] ) ) : ?>
						<span class="vitalisite-links__icon"><?php echo esc_html( $link['icon'] ); ?></span>
					<?php endif; ?>
					<span class="vitalisite-links__label"><?php echo esc_html( $link['label'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<p class="vitalisite-links__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
	</div>
	<?php
	return ob_get_clean();
}
add_filter( 'render_block', __NAMESPACE__ . '\render_links_page_content', 10, 2 );
