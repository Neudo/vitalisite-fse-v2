<?php
$unique_id = uniqid('vitalisite-forms-');
$main_color = get_theme_mod("main_color", "#03045e");
$fill_color = is_light_color($main_color) ? 'fill-slate-950' : 'fill-slate-100';
?>

<div class="lg:flex lg:justify-center mt-14">
    <div class="reveal-y flex flex-col mb-8 lg:mb-0 px-6 py-16 md:py-14 md:px-14 lg:pr-10 lg:w-[50%] rounded-3xl bg-slate-200 lg:justify-center">
        <h1 class="text-3xl mb-4 font-bold"><?= !empty($settings['form_title']) ? $settings['form_title'] : 'Contactez-moi' ?></h1>
        <div class="text-slate-800"><?= !empty($settings['form_description']) ? $settings['form_description'] : 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' ?></div>
            <div class=" gap-2 md:gap-3 flex flex-wrap flex-col mt-6">
                <?php if ($settings['form_address']) : ?>
                    <div class="card flex gap-4 items-center">
                        <div class="card-header p-2 rounded-full " style="background-color:<?=$main_color; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 <?= $fill_color ?>">
                                <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title">
                                Adresse du cabinet
                            </h2>
                            <p class="card-text mb-0 text-slate-500">
                                <?= $settings['form_address'] ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($settings['form_tel']) : ?>
                    <div class="card flex gap-4 items-center">
                        <div class="card-header p-2 rounded-full " style="background-color:<?= $main_color; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 <?= $fill_color ?>">
                                <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title">
                                Téléphone
                            </h2>
                            <p class="card-text mb-0 text-slate-500">
                                <?= $settings['form_tel'] ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($settings['form_email']) : ?>
                    <div class="card flex gap-4 items-center">
                        <div class="card-header p-2 rounded-full " style="background-color:<?= $main_color; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 <?= $fill_color ?>">
                                <path fill-rule="evenodd" d="M17.834 6.166a8.25 8.25 0 1 0 0 11.668.75.75 0 0 1 1.06 1.06c-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788 3.807-3.808 9.98-3.808 13.788 0A9.722 9.722 0 0 1 21.75 12c0 .975-.296 1.887-.809 2.571-.514.685-1.28 1.179-2.191 1.179-.904 0-1.666-.487-2.18-1.164a5.25 5.25 0 1 1-.82-6.26V8.25a.75.75 0 0 1 1.5 0V12c0 .682.208 1.27.509 1.671.3.401.659.579.991.579.332 0 .69-.178.991-.579.3-.4.509-.99.509-1.671a8.222 8.222 0 0 0-2.416-5.834ZM15.75 12a3.75 3.75 0 1 0-7.5 0 3.75 3.75 0 0 0 7.5 0Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title">
                                Email
                            </h2>
                            <a class="card-text mb-0 text-slate-500 underline" href="mailto:<?= $settings['form_email'] ?>">
                                <?= $settings['form_email'] ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($settings['show_hours']) : ?>
                    <div class="card flex gap-4 items-start">
                        <div class="card-header p-2 rounded-full " style="background-color:<?= $main_color ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 <?= $fill_color ?>">
                                <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="card-body w-[280px]">
                            <h2 class="card-title">
                                Horaires de rendez-vous
                            </h2>
                            <p class="card-text mb-0 text-slate-500">
                                <?php if (!get_theme_mod('open_hours_enable')) : ?>
                                    <?= get_theme_mod('open_hours') ?>
                                <?php else : ?>
                                    <div class="grid grid-cols-1 gap-1 text-sm mt-4">
                                        <?php 
                                        $days = [
                                            'monday' => 'Lundi',
                                            'tuesday' => 'Mardi',
                                            'wednesday' => 'Mercredi',
                                            'thursday' => 'Jeudi',
                                            'friday' => 'Vendredi',
                                            'saturday' => 'Samedi',
                                            'sunday' => 'Dimanche'
                                        ];
                                        $i = 0;
                                        foreach ($days as $day_key => $day_label) :
                                            $hours = get_theme_mod('open_hours_' . $day_key, '');
                                            if (!empty($hours)) :
                                        ?>
                                            <div class="flex justify-between px-4 py-1 rounded-sm" <?= $i % 2 == 0 ? 'style="background-color: white"' : '' ?>>
                                                <span class="font-medium text-slate-500"><?= $day_label ?></span>
                                                <span class="text-slate-500"><?= $hours ?></span>
                                            </div>
                                        <?php 
                                            $i++;
                                            endif;
                                        endforeach;
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </p>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    <form id="form-<?php echo esc_attr($unique_id); ?>" class="vitalisite-form rounded-md flex flex-col md:flex-row md:flex-wrap lg:w-[50%] gap-4 md:px-8" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST">
        <input type="hidden" name="action" value="vitalisite_form_handler">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('vitalisite_form_handler'); ?>">

        <!-- Champs obligatoires -->

        <label for="email-<?php echo esc_attr($unique_id); ?>" class="block text-sm font-medium text-gray-900 md:w-[49%]">Email*
            <div class="flex items-center rounded-md mt-2 bg-white pl-3 border-2 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                <input class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" type="email" placeholder="Votre email" id="email-<?php echo esc_attr($unique_id); ?>" name="email" required />
            </div>
        </label>

        <!-- Champs dynamiques -->
        <?php
        if (!empty($settings['form_fields']) && is_array($settings['form_fields'])) :
            foreach ($settings['form_fields'] as $field) :
                if (!isset($field['field_type']) || !isset($field['field_label'])) continue;

                $type = esc_attr($field['field_type']);
                $placeholder = isset($field['field_placeholder']) ? esc_attr($field['field_placeholder']) : '';
                $required = !empty($field['field_required']) ? 'required' : '';
                $name = 'custom_' . sanitize_title($field['field_label']);
                $field_id = esc_attr($name . '-' . $unique_id);
                ?>
                <label class="block text-sm font-medium text-gray-900 md:w-[49%]" for="<?php echo $field_id; ?>"><?php echo esc_html($field['field_label']);echo $required ? '*' : ''; ?>
                    <div class="flex items-center rounded-md mt-2 bg-white pl-3 border-2 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                        <input class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" id="<?php echo $field_id; ?>" name="<?php echo esc_attr($name); ?>" type="<?php echo $type; ?>" placeholder="<?php echo $placeholder; ?>" <?php echo $required; ?> />
                    </div>
                </label>

            <?php
            endforeach;
        endif;
        ?>

        <!-- Champs obligatoires -->

        <label for="subject-<?php echo esc_attr($unique_id); ?>" class="block text-sm font-medium text-gray-900 w-full">Sujet*
            <div class="flex items-center rounded-md mt-2 bg-white pl-3 border-2 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                <input class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" type="text" placeholder="Sujet du message" id="subject-<?php echo esc_attr($unique_id); ?>" name="subject" required />
            </div>
        </label>

        <label class="w-full block text-sm font-medium text-gray-900" for="message-<?php echo esc_attr($unique_id); ?>">Message*
            <div class="flex items-center rounded-md mt-2 bg-white">
                <textarea class="border-2 border-gray-300 rounded-md w-full pl-3 pt-2 h-[190px] text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" id="message-<?php echo esc_attr($unique_id); ?>" name="message" placeholder="Votre message" required></textarea>
            </div>
        </label>

        <?php wp_nonce_field('vitalisite_form_action', 'vitalisite_form_nonce'); ?>
        <button class="button-vitalisite px-8 py-2 text-sm leading-9 rounded-xl relative ease-in duration-300" type="submit">Envoyer</button>
    </form>
</div>
