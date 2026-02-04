<?php
$unique_id = uniqid('text-simple-');
$secondary_color = get_theme_mod('secondary_color', '#ffcc53');
$has_bg = $settings['has_bg'];

$title_color = 'text-slate-950';
$text_color = 'text-slate-700';
?>
<div class="max-w-6xl mx-auto mt-8 lg:mt-16 rounded-3xl <?= $has_bg === 'yes' ? 'px-4 py-8 md:p-14 reveal-y bg-slate-100' : '' ?>" >
    <h2 <?= $has_bg === 'yes' ? 'data-reveal-delay=".3"' : ''?> class="reveal-y2 text-4xl lg:text-5xl font-bold mb-8 lg:mb-12 <?= esc_attr($title_color); ?>">
        <?= !empty($settings['text_simple_title']) ? esc_html($settings['text_simple_title']) : 'Lorem ipsum dolor sit amet' ?>
    </h2>
    <div class="wysiwyg <?php echo esc_attr($text_color); ?>">
        <?= !empty($settings['text_simple_content']) ? wp_kses_post($settings['text_simple_content']) : '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>' ?>
    </div>
    <?php if (!empty($settings['cta_link']) && !empty($settings['cta_text'])) {

        $cta_data = array(
            'cta_text' => $settings['cta_text'],
            'cta_link' => $settings['cta_link']['url'],
            'cta_classes' => 'mt-4',
            'cta_target' => $settings['cta_link']['is_external'] === 'on' ? '_blank' : '_self',
            'enable_download' => $settings['text_simple_enable_download'] === 'yes',
            'download_file' => $settings['text_simple_download_file'],
        );
        include get_template_directory() . '/template-parts/components/cta.php';
    } ?>
</div>