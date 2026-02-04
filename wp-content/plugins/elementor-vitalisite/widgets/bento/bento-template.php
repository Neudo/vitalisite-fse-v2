<?php
$bg_color = get_theme_mod('main_color', '#051b2e' );
$text_color = is_light_color($bg_color) ? 'text-slate-950' : 'text-slate-200';
$title_color = is_light_color($bg_color) ? 'text-slate-950' : 'text-slate-100';
$unique_id = uniqid('bento-');
?>


<div id="<?= esc_attr($unique_id)?>" class="bento flex flex-col lg:flex-row gap-4 lg:gap-8 mt-6">
    <div class="rounded-3xl flex lg:gap-x-8 bg-slate-100 lg:w-2/3 flex-col lg:flex-row px-6 py-16  md:py-16 md:px-14">
        <h2 class="reveal-title text-4xl lg:text-4xl font-bold mb-4 lg:w-1/2"><?= !empty($settings['bento_title_left']) ? $settings['bento_title_left'] : 'Lorem ipsum dolor sit amet' ?></h2>
        <div class="lg:w-1/2 text-slate-500"><?= !empty($settings['bento_content_left']) ? $settings['bento_content_left'] : '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>' ?></div>
    </div>
    <div class="reveal-y rounded-3xl px-6 py-16 md:py-16 md:px-14 lg:w-1/3 lg:flex lg:flex-col lg:justify-center" style="background-color: <?= get_theme_mod('main_color', '#051b2e') ?>">
        <h2 class="reveal-title text-xl lg:text-3xl font-bold mb-4 <?= $title_color ?>"><?= !empty($settings['bento_title_right']) ? $settings['bento_title_right'] : 'Consectetur adipiscing' ?></h2>
        <div class="<?= $text_color ?>">
            <?= !empty($settings['bento_content_right']) ? $settings['bento_content_right'] : '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>' ?>
        </div>
    </div>
</div>
