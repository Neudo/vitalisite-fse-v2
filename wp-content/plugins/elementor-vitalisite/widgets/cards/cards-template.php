<?php
$unique_id = uniqid('cards-');
$secondary_color = get_theme_mod('secondary_color', '#ffcc53');
?>
<div class="max-w-6xl mx-auto mt-8 lg:mt-16">
    <h2 class="reveal-title text-center text-4xl lg:text-5xl font-bold mb-4 lg:mb-8"><?= !empty($settings['cards_title']) ? $settings['cards_title'] : 'Lorem ipsum dolor sit amet' ?></h2>
    <div class="text-center text-slate-500">
        <?= !empty($settings['cards_description']) ? $settings['cards_description'] : '<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>' ?>
    </div>
    <div class="flex flex-wrap gap-4 md:gap-8 mt-8 lg:mt-16 justify-start mx-auto">
        <?php foreach ($settings['list'] as $index => $card) :?>
            <div class="reveal-y2 relative shadow-md border-2 border-slate-200 rounded-3xl px-4 py-6 md:p-8 lg:p-12 flex flex-col gap-4 w-full <?= count($settings['list']) === 3 && $index === 0 ? '':'md:basis-[calc(50%-1rem)]'?> <?= !empty($card['list_cta_url']['url']) ? 'hover:scale-[1.02] duration-300  ease-in-out' : '' ?> ">
                    <h3 class="text-2xl font-thin"><?= !empty($card['list_title']) ? $card['list_title'] : 'Lorem ipsum' ?></h3>
                <div class="wysiwyg"><?= !empty($card['list_content']) ? $card['list_content'] : '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>' ?></div>
                <?php if (!empty($card['list_cta_url']['url'])) :
                    $cta_data = array(
                        'cta_text' => $card['list_cta_label'],
                        'cta_link' => $card['list_cta_url']['url'],
                        'cta_classes' => 'mt-4',
                        'cta_target' => $card['list_cta_url']['is_external'] === 'on' ? '_blank' : '_self',
                        'enable_download' => $card['list_enable_download'] === 'yes',
                        'download_file' => $card['list_download_file'],
                    );
                    include get_template_directory() . '/template-parts/components/cta.php';
                    ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
