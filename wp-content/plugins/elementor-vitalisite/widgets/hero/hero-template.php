<?php
$unique_id = uniqid('hero-');?>
<div id="<?= esc_attr($unique_id)?>" class="hero">
    <div class="min-h-[50svh] text-center rounded-3xl bg-cover bg-center overflow-hidden relative w-full before:absolute before:left-0 before:right-0 before:top-0 before:z-10 before:h-full before:w-full before:bg-black before:opacity-30"
         style="background-image: url(<?= $settings['image']['url'] ?>);">
        <div class="flex flex-col items-start justify-between md:justify-start max-w-2xl relative z-20  h-full px-6 py-16 md:py-16 md:px-14">
            <div class="wrapper">
            <h1 class="reveal-y2 text-white text-4xl md:text-7xl mb-4 border-b-2 border-solid border-white pb-2 md:pb-8"><?= !empty($settings['hero_title']) ? $settings['hero_title'] : 'Lorem ipsum dolor sit amet' ?></h1>
            <h2 data-reveal-delay="0.1" class="reveal-y2 text-white text-xl mb-6"><?= !empty($settings['hero_sub_title']) ? $settings['hero_sub_title'] : 'Consectetur adipiscing elit sed do eiusmod' ?></h2>
            <div data-reveal-delay="0.3" class="reveal-y2">
                <?= !empty($settings['hero_content']) ? $settings['hero_content'] : '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>' ?>
            </div>
            </div>
            <?php if ($settings['hero_cta_text'] != '') : ?>
            <div data-reveal-delay="0.8" class="reveal-y2">
                <?php
                $cta_data = array(
                    'cta_text' => $settings['hero_cta_text'],
                    'cta_link' => $settings['hero_cta_link']['url'],
                    'cta_classes' => 'mt-4',
                    'cta_target' => $settings['hero_cta_link']['is_external'] === 'on' ? '_blank' : '_self',
                    'enable_download' => $settings['hero_enable_download'] === 'yes',
                    'download_file' => $settings['hero_download_file'],
                );
                include get_template_directory() . '/template-parts/components/cta.php';
                ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
