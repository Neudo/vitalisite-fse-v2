<?php
$unique_id = uniqid('text-image-');
$main_color = get_theme_mod('main_color', '#051b2e' );
$has_bg = $settings['has_bg'];
$title_color= is_light_color($main_color) ? 'text-slate-950' : 'text-slate-100';
$text_color = is_light_color($main_color) ? 'text-slate-800' : 'text-slate-200';
$way = $settings['way'];
?>

<div class="max-w-6xl mx-auto mt-8 lg:mt-16 rounded-3xl <?= $has_bg === 'yes' ? 'px-4 py-8 md:p-16 ' : '' ?>" <?= $has_bg === 'yes' ? 'style="background-color: ' . esc_attr($main_color) . '"' : ''; ?>>
    <h2 class="reveal-title text-center text-4xl lg:text-5xl font-bold mb-8 lg:mb-12 <?= $has_bg === 'yes' ? esc_attr($title_color) : 'text-slate-850' ?>">
        <?= !empty($settings['text_image_title']) ? esc_html($settings['text_image_title']) : 'Lorem ipsum dolor sit amet' ?>
    </h2>
    <div class="<?= $way === 'yes' ? 'lg:flex-row flex-col-reverse' : 'lg:flex-row-reverse flex-col-reverse' ?>   flex gap-4 items-center">
        <div class="lg:min-w-[50%]">
            <div class="wysiwyg <?= $has_bg === 'yes' && !is_light_color($main_color) ? 'dark' : '' ?> <?= $has_bg === 'yes' ? esc_attr($text_color) . ' lg:p-8' : 'text-slate-500 lg:px-8'  ?>">
                <?= !empty($settings['text_image_content']) ? wp_kses_post($settings['text_image_content']) : '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>' ?>
            </div>
        </div>
        <?php if (!empty($settings['image_url']['url'])) : ?>
            <div class="rounded-3xl overflow-hidden mb-10 lg:mb-0 reveal-y">
                <img src="<?= esc_url($settings['image_url']['url']); ?>" alt="<?= esc_attr($settings['text_image_title']); ?>" class="w-full">
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($settings['cta_text'])) : ?>
        <div class="flex justify-center mt-8">
            <?php
            $cta_data = array(
                'cta_text' => $settings['cta_text'],
                'cta_link' => $settings['cta_link']['url'],
                'cta_classes' => '',
                'cta_target' => $settings['cta_link']['is_external'] === 'on' ? '_blank' : '_self',
                'enable_download' => $settings['text_image_enable_download'] === 'yes',
                'download_file' => $settings['text_image_download_file'],
            );
            include get_template_directory() . '/template-parts/components/cta.php';
            ?>
        </div>
    <?php endif; ?>

</div>