<?php
$unique_id = uniqid('testimonials-');
$bg_color = get_theme_mod('main_color', '#051b2e');

// Vérifier la source des témoignages
$source = $settings['testimonials_source'] ?? 'local';
$show_leave_review_cta = ($settings['show_leave_review_cta'] ?? 'no') === 'yes';

if ($source === 'google') {
    // Récupérer les avis Google
    $google_data = vitalisite_get_google_reviews();
    $reviews = $google_data['reviews'] ?? [];
    $place_info = [
        'name' => $google_data['name'] ?? '',
        'rating' => $google_data['rating'] ?? 0,
        'user_ratings_total' => $google_data['user_ratings_total'] ?? 0,
        'has_more' => $google_data['has_more'] ?? false,
        'place_id' => $google_data['place_id'] ?? '',
    ];
} else {
    // Source locale (CPT testimonials)
    $args = [
        'post_type'      => 'testimonials',
        'posts_per_page' => $settings['post_to_display'],
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    $query = new WP_Query($args);
    $reviews = [];
    $place_info = [];
}

?>
<?php if (($source === 'local' && $query->have_posts()) || ($source === 'google' && !empty($reviews))) : ?>
    <div class="max-w-6xl mx-auto mt-8 lg:mt-16">
        <div>
            <h2 class="reveal-title text-center text-4xl lg:text-5xl font-bold mb-4 lg:mb-8"><?= !empty($settings['testimonials_title']) ? $settings['testimonials_title'] : 'Lorem ipsum dolor sit amet' ?></h2>
            <div class="text-center text-slate-500 mb-4">
                <?= !empty($settings['testimonials_description']) ? $settings['testimonials_description'] : '<p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>' ?>
            </div>
            
            <?php if ($source === 'google' && !empty($place_info)): ?>
                <!-- Header Google Reviews -->
                <div class="rounded-2xl py-4 ">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Logo et Rating -->
                        <div class="flex items-center gap-3">
                            <div class="w-[80px] h-auto">
                                <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="Google" class="w-full h-auto">
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl font-bold text-gray-900"><?= number_format($place_info['rating'], 1) ?></span>
                                    <div class="flex">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <svg class="w-4 h-4 <?= $i <= $place_info['rating'] ? 'text-yellow-400' : 'text-gray-300' ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-600"><?= esc_html($place_info['user_ratings_total']) ?> avis</span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-xs text-gray-600"><?= esc_html($place_info['name']) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2">
                            <?php if ($place_info['has_more']): ?>
                                <a href="https://search.google.com/local/reviews?placeid=<?= esc_attr($place_info['place_id']) ?>" 
                                   target="_blank" 
                                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl font-semibold shadow-md transform transition-all duration-300 hover:shadow-lg"
                                   style="background-color: <?= get_theme_mod('primary_cta_color', '#007CBA') ?>; color: <?= get_theme_mod('primary_cta_text_color', '#FFFFFF') ?>;">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm">Voir tous les avis</span>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($show_leave_review_cta && !empty($place_info['place_id'])): ?>
                                <a href="https://search.google.com/local/writereview?placeid=<?= esc_attr($place_info['place_id']) ?>" 
                                   target="_blank" 
                                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl font-semibold border-2 shadow-md transform transition-all duration-300 hover:shadow-lg"
                                   style="border-color: <?= get_theme_mod('primary_cta_color', '#007CBA') ?>; color: <?= get_theme_mod('primary_cta_color', '#007CBA') ?>; background-color: transparent;">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="text-sm">Laisser un avis</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($settings['testimonials_display'])) : ?>
            <?php if ($settings['testimonials_display'] == 'list') : ?>

                <?php if ($source === 'google'): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="flex reveal-y flex-col mb-4 border-2 border-slate-200 rounded-3xl px-4 py-6 md:p-8 lg:p-12 gap-4 h-full">
                            <div class="header flex-grow">
                                <div class="flex items-center gap-3 mb-4">
                                    <?php if (!empty($review['profile_photo_url'])): ?>
                                        <img src="<?= esc_url($review['profile_photo_url']) ?>" alt="<?= esc_attr($review['author_name']) ?>" class="w-12 h-12 rounded-full">
                                    <?php endif; ?>
                                    <div>
                                        <h4 class="font-bold text-lg lg:text-xl"><?= esc_html($review['author_name']) ?></h4>
                                        <div class="flex items-center gap-2">
                                            <div class="flex">
                                                <?= vitalisite_format_rating($review['rating']) ?>
                                            </div>
                                            <span class="text-sm text-gray-600"><?= esc_html($review['relative_time_description']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 leading-relaxed">
                                    <?php 
                                    $review_text = !empty($review['text']) ? esc_html($review['text']) : 'Cet utilisateur a uniquement laissé une évaluation.';
                                    echo $review_text;
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="flex reveal-y flex-col mb-4 border-2 border-slate-200 rounded-3xl px-4 py-6 md:p-8 lg:p-12 gap-4">
                            <div class="header">
                                <h4 class="font-bold text-xl lg:text-2xl mb-4"><?= esc_html(get_the_title()) ?></h4>
                                <p><?= esc_html(get_post_meta(get_the_ID(), '_testimonial_comment', true));?></p>
                            </div>
                            <div class="footer">
                                <?php
                                $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                                $bg_color = get_post_meta(get_the_ID(), '_testimonial_bg_color', true);
                                ?>
                                <div class="rating flex gap-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if ($i <= $rating): ?>
                                            <!-- Étoile pleine -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fcd987" class="size-6 text-yellow-500">
                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                            </svg>
                                        <?php else: ?>
                                            <!-- Étoile vide -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#c4c3c3" class="size-6 text-yellow-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>

            <?php endif; ?>
            <?php if ($settings['testimonials_display'] == 'slider') : ?>
                <div class="swiper swiper-testimonials mt-4">
                    <div class="swiper-wrapper md:h-[245px]">
                        <?php if ($source === 'google'): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="swiper-slide border-2 border-slate-200 rounded-3xl px-4 py-6 md:p-8 lg:p-12 flex flex-col gap-4 h-full">
                                    <div class="header flex-grow">
                                        <div class="flex items-center gap-3 mb-4">
                                            <?php if (!empty($review['profile_photo_url'])): ?>
                                                <img src="<?= esc_url($review['profile_photo_url']) ?>" alt="<?= esc_attr($review['author_name']) ?>" class="w-12 h-12 rounded-full">
                                            <?php endif; ?>
                                            <div>
                                                <h4 class="font-bold text-lg lg:text-xl"><?= esc_html($review['author_name']) ?></h4>
                                                <div class="flex items-center gap-2">
                                                    <div class="flex">
                                                        <?= vitalisite_format_rating($review['rating']) ?>
                                                    </div>
                                                    <span class="text-sm text-gray-600"><?= esc_html($review['relative_time_description']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">
                                    <?php 
                                    $review_text = !empty($review['text']) ? esc_html($review['text']) : 'Cet utilisateur a uniquement laissé une évaluation.';
                                    echo $review_text;
                                    ?>
                                </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <div class="swiper-slide border-2 border-slate-200 rounded-3xl px-4 py-6 md:p-8 lg:p-12 flex flex-col gap-4">
                                    <div class="header">
                                        <h4 class="font-bold text-xl lg:text-2xl mb-4"><?= esc_html(get_the_title()) ?></h4>
                                        <p><?= esc_html(get_post_meta(get_the_ID(), '_testimonial_comment', true));?></p>
                                    </div>
                                    <div class="footer">
                                        <?php
                                        $rating = get_post_meta(get_the_ID(), '_testimonial_rating', true);
                                        $rating = intval($rating);
                                        ?>
                                        <div class="rating flex gap-1">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= $rating): ?>
                                                    <!-- Étoile pleine -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fcd987" class="size-6 text-yellow-500">
                                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                                    </svg>
                                                <?php else: ?>
                                                    <!-- Étoile vide -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#c4c3c3" class="size-6 text-yellow-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                    </svg>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-navigation flex gap-4 mt-8">
                        <div class="button-prev p-4 rounded-full w-fit" style="background-color:<?= get_theme_mod('main_color', '#051b2e') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 <?= is_light_color($bg_color) ? 'text-slate-950' : 'text-slate-200' ?>">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                        </div>
                        <div class="button-next p-4 rounded-full w-fit" style="background-color:<?= get_theme_mod('main_color', '#051b2e') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 <?= is_light_color($bg_color) ? 'text-slate-950' : 'text-slate-200' ?>">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- CTA "Voir tous les avis" pour Google - REMOVED (moved to header) -->

        <!-- CTA "Laisser un avis" pour Google - REMOVED (moved to header) -->
    </div>
<?php endif; ?>

<?php if ($source === 'local'): ?>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
