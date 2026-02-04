<?php
$unique_id = uniqid('dropdown-');
$bg_color = get_theme_mod('main_color', '#000000');
?>
<div class="max-w-6xl mx-auto mt-8 lg:mt-16">
    <h2 class="reveal-title text-center text-4xl lg:text-5xl font-bold mb-4 lg:mb-8"><?= !empty($settings['dropdown_title']) ? $settings['dropdown_title'] : 'Lorem ipsum dolor sit amet' ?></h2>
    <div class="text-center text-slate-500">
        <?= !empty($settings['dropdown_description']) ? $settings['dropdown_description'] : '<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>' ?>
    </div>

    <?php if (!empty($settings['list'])) : ?>
        <div class="flex-col flex flex-wrap gap-4 justify-center mt-8 lg:mt-16">
            <?php
            $settings = $this->get_settings_for_display();
            $list = $settings['list'];
            foreach ($list as $item) {
                $title = $item['list_title'];
                $content = $item['list_content'];
                ?>
                <div x-data="{ open: false }" class="reveal-y2 border rounded-lg overflow-hidden shadow-sm">
                    <button @click="open = !open" class="w-full flex gap-1 items-center justify-between p-6 font-bold text-left bg-white hover:bg-slate-100 transition-all duration-300">
                        <?= !empty($item['list_title']) ? esc_html($item['list_title']) : 'Lorem ipsum dolor sit amet' ?>
                        <span :class="open ? 'close' : ''"  class="cross block"></span>
                    </button>
                    <div x-show="open" x-transition class="p-4 md:p-10">
                        <?= !empty($item['list_content']) ? wp_kses_post($item['list_content']) : '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>' ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if ($settings['dropdown_button_link'] != '' && $settings['dropdown_button_label'] != '') :
        $cta_data = array(
            'cta_text' => $settings['dropdown_button_label'],
            'cta_link' => $settings['dropdown_button_link']['url'],
            'cta_classes' => 'mt-4 md:mt-8 mx-auto',
            'cta_target' => $settings['dropdown_button_link']['is_external'] === 'on' ? '_blank' : '_self',
            'enable_download' => $settings['dropdown_enable_download'] === 'yes',
            'download_file' => $settings['dropdown_download_file'],
        );
        include get_template_directory() . '/template-parts/components/cta.php';

    endif; ?>
</div>