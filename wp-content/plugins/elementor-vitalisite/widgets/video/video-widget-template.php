<?php
$settings = $this->get_settings_for_display();

// Récupérer la source et les données vidéo
$video_source = $settings['video_source'] ?? 'url';
$video_url = $settings['video_url'] ?? '';
$video_upload = $settings['video_upload'] ?? '';
$video_title = $settings['video_title'] ?? '';
$video_description = $settings['video_description'] ?? '';
$show_thumbnail = ($settings['show_thumbnail'] ?? 'yes') === 'yes';
$autoplay = ($settings['autoplay'] ?? 'no') === 'yes';
$show_cta = ($settings['show_cta'] ?? 'no') === 'yes';
$cta_text = $settings['cta_text'] ?? 'En savoir plus';
$cta_link = $settings['cta_link'] ?? [];
$video_style = $settings['video_style'] ?? 'rounded';
$content_alignment = $settings['content_alignment'] ?? 'center';

// Classes CSS
$alignment_class = 'text-' . $content_alignment;
$video_class = $video_style === 'rounded' ? 'rounded-2xl' : 'rounded-none';

// Obtenir la couleur du thème pour les CTA
$primary_color = get_theme_mod('primary_cta_color', '#007CBA');
$text_color = get_theme_mod('primary_cta_text_color', '#FFFFFF');

// Variables pour la vidéo
$video_info = [];
$embed_url = '';
$thumbnail_url = '';
$final_video_url = '';

if ($video_source === 'url' && !empty($video_url)) {
    // Mode URL (YouTube/Vimeo)
    $video_info = vitalisite_get_video_info($video_url);
    $embed_params = vitalisite_build_embed_params($autoplay);
    $embed_url = $video_info['embed_url'] . $embed_params;
    
    // Obtenir la miniature
    if ($show_thumbnail) {
        if ($video_info['platform'] === 'vimeo' && !empty($video_info['video_id'])) {
            $thumbnail_url = vitalisite_get_vimeo_thumbnail($video_info['video_id']);
        } else {
            $thumbnail_url = $video_info['thumbnail_url'];
        }
    }
    $final_video_url = $video_url;
    
} elseif ($video_source === 'upload' && !empty($video_upload['url'])) {
    // Mode upload (vidéo locale)
    $final_video_url = $video_upload['url'];
    $embed_url = $video_upload['url'];
    
    // Pour les vidéos uploadées, on n'a pas de miniature automatique
    // L'utilisateur pourrait uploader une miniature séparément si nécessaire
}
?>

<?php if (!empty($final_video_url)): ?>
    <div class="video-widget max-w-6xl mx-auto mt-8 lg:mt-16 mb-8 lg:mb-16">
        <!-- Header avec titre et description -->
        <?php if (!empty($video_title) || !empty($video_description)): ?>
            <div class="video-header mb-8 lg:mb-12 <?= esc_attr($alignment_class) ?>">
                <?php if (!empty($video_title)): ?>
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4 text-gray-800">
                        <?= esc_html($video_title) ?>
                    </h2>
                <?php endif; ?>
                
                <?php if (!empty($video_description)): ?>
                    <div class="text-gray-600 max-w-3xl <?= $content_alignment === 'center' ? 'mx-auto' : '' ?>">
                        <?= wp_kses_post($video_description) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Conteneur vidéo -->
        <div class="video-container mb-8 lg:mb-12">
            <?php if ($video_source === 'url' && $show_thumbnail && !empty($thumbnail_url)): ?>
                <!-- Mode miniature avec clic pour lecture (YouTube/Vimeo) -->
                <div class="video-thumbnail-wrapper relative <?= esc_attr($video_class) ?> overflow-hidden shadow-lg cursor-pointer group"
                     onclick="this.style.display='none'; document.getElementById('video-<?= esc_attr($this->get_id()) ?>').style.display='block';">
                    <img src="<?= esc_url($thumbnail_url) ?>" 
                         alt="<?= esc_attr($video_title ?: 'Vidéo') ?>" 
                         class="w-full h-auto object-cover">
                    
                    <!-- Bouton de lecture -->
                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300">
                        <div class="bg-white rounded-full p-4 shadow-xl transform scale-100 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-12 h-12 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Vidéo embed -->
            <div id="video-<?= esc_attr($this->get_id()) ?>" 
                 class="<?= $video_source === 'url' && $show_thumbnail && !empty($thumbnail_url) ? 'hidden' : '' ?>">
                <div class="video-embed-wrapper <?= esc_attr($video_class) ?> overflow-hidden shadow-lg">
                    <?php if ($video_source === 'url'): ?>
                        <!-- YouTube/Vimeo embed -->
                        <?php if ($video_info['platform'] === 'youtube'): ?>
                            <iframe src="<?= esc_url($embed_url) ?>" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen
                                    class="w-full aspect-video">
                            </iframe>
                        <?php elseif ($video_info['platform'] === 'vimeo'): ?>
                            <iframe src="<?= esc_url($embed_url) ?>" 
                                    frameborder="0" 
                                    allow="autoplay; fullscreen; picture-in-picture" 
                                    allowfullscreen
                                    class="w-full aspect-video">
                            </iframe>
                        <?php else: ?>
                            <!-- Fallback pour les autres URLs -->
                            <div class="w-full aspect-video bg-gray-100 flex items-center justify-center">
                                <div class="text-center p-8">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-600 mb-2">URL non supportée</p>
                                    <p class="text-sm text-gray-500">Utilisez YouTube ou Vimeo</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php elseif ($video_source === 'upload'): ?>
                        <!-- Vidéo uploadée (HTML5 video) -->
                        <video 
                            class="w-full aspect-video"
                            controls
                            <?php if ($autoplay): ?>autoplay muted<?php endif; ?>
                            playsinline>
                            <source src="<?= esc_url($embed_url) ?>" type="video/mp4">
                            <source src="<?= esc_url($embed_url) ?>" type="video/webm">
                            <source src="<?= esc_url($embed_url) ?>" type="video/ogg">
                            <p>Votre navigateur ne supporte pas la lecture vidéo.</p>
                        </video>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- CTA optionnel -->
        <?php if ($show_cta && !empty($cta_link['url'])): ?>
            <div class="video-cta mt-8 <?= esc_attr($alignment_class) ?>">
                <a href="<?= esc_url($cta_link['url']) ?>" 
                   <?php if (!empty($cta_link['is_external'])) echo 'target="_blank"'; ?>
                   <?php if (!empty($cta_link['nofollow'])) echo 'rel="nofollow"'; ?>
                   class="inline-flex items-center px-6 py-3 rounded-xl font-semibold shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg"
                   style="background-color: <?= esc_attr($primary_color) ?>; color: <?= esc_attr($text_color) ?>;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    <span><?= esc_html($cta_text) ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .video-embed-wrapper iframe,
        .video-embed-wrapper video {
            width: 100%;
            height: 100%;
            display: block;
        }
        
        .video-widget {
            clear: both;
            overflow: hidden;
        }
        
        .video-container {
            clear: both;
            overflow: hidden;
        }
    </style>
<?php else: ?>
    <!-- Message si aucune vidéo fournie -->
    <div class="video-widget-placeholder max-w-6xl mx-auto mt-8 lg:mt-16">
        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-600 text-lg font-medium mb-2">Aucune vidéo configurée</p>
            <p class="text-gray-500">
                <?php if ($video_source === 'url'): ?>
                    Veuillez ajouter une URL YouTube ou Vimeo dans les paramètres du widget
                <?php else: ?>
                    Veuillez uploader une vidéo dans les paramètres du widget
                <?php endif; ?>
            </p>
        </div>
    </div>
<?php endif; ?>
