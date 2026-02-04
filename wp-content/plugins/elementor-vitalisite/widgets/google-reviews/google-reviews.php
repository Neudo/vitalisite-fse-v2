<?php
/**
 * Elementor Widget for Google Reviews
 *
 * @package vitalisite
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_Google_Reviews extends \Elementor\Widget_Base {

    public function get_name() {
        return 'google-reviews';
    }

    public function get_title() {
        return esc_html__('Avis Google', 'vitalisite');
    }

    public function get_icon() {
        return 'eicon-star-o';
    }

    public function get_categories() {
        return ['vitalisite'];
    }

    public function get_keywords() {
        return ['google', 'reviews', 'avis', 'rating', 'stars'];
    }

    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Contenu', 'vitalisite'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Afficher le titre', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Oui', 'vitalisite'),
                'label_off' => esc_html__('Non', 'vitalisite'),
            ]
        );

        $this->add_control(
            'custom_title',
            [
                'label' => esc_html__('Titre personnalisé', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Nos avis Google', 'vitalisite'),
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_overall_rating',
            [
                'label' => esc_html__('Afficher la note globale', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Oui', 'vitalisite'),
                'label_off' => esc_html__('Non', 'vitalisite'),
            ]
        );

        $this->add_control(
            'show_total_reviews',
            [
                'label' => esc_html__('Afficher le nombre total d\'avis', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Oui', 'vitalisite'),
                'label_off' => esc_html__('Non', 'vitalisite'),
            ]
        );

        $this->add_control(
            'reviews_count',
            [
                'label' => esc_html__('Nombre d\'avis à afficher', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__('Afficher "Lire plus"', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Oui', 'vitalisite'),
                'label_off' => esc_html__('Non', 'vitalisite'),
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Afficher la date', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => esc_html__('Oui', 'vitalisite'),
                'label_off' => esc_html__('Non', 'vitalisite'),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'vitalisite'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Mise en page', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grille', 'vitalisite'),
                    'carousel' => esc_html__('Carrousel', 'vitalisite'),
                    'list' => esc_html__('Liste', 'vitalisite'),
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Colonnes', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'condition' => [
                    'layout' => ['grid', 'carousel'],
                ],
            ]
        );

        $this->add_control(
            'card_style',
            [
                'label' => esc_html__('Style des cartes', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Défaut', 'vitalisite'),
                    'minimal' => esc_html__('Minimal', 'vitalisite'),
                    'bordered' => esc_html__('Avec bordure', 'vitalisite'),
                    'shadow' => esc_html__('Avec ombre', 'vitalisite'),
                ],
            ]
        );

        $this->add_control(
            'star_color',
            [
                'label' => esc_html__('Couleur des étoiles', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fcd987',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Couleur du texte', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#374151',
            ]
        );

        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__('Couleur de fond', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_responsive_control(
            'spacing',
            [
                'label' => esc_html__('Espacement entre les avis', 'vitalisite'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .google-review-card' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Get Google Reviews data
        $reviews_data = vitalisite_get_google_reviews();
        
        if (empty($reviews_data)) {
            echo '<div class="google-reviews-error text-center py-12">';
            echo '<p class="text-gray-600">' . esc_html__('Aucun avis trouvé ou configuration incorrecte. Veuillez vérifier votre clé API et Place ID dans les options du thème.', 'vitalisite') . '</p>';
            echo '</div>';
            return;
        }
        
        if (empty($reviews_data['reviews'])) {
            echo '<div class="google-reviews-no-reviews text-center py-12">';
            echo '<p class="text-gray-600">' . esc_html__('Aucun avis trouvé pour cet établissement.', 'vitalisite') . '</p>';
            if (!empty($reviews_data['name'])) {
                echo '<p class="text-sm text-gray-500 mt-2">' . sprintf(esc_html__('Établissement: %s', 'vitalisite'), esc_html($reviews_data['name'])) . '</p>';
            }
            echo '</div>';
            return;
        }
        
        $reviews = array_slice($reviews_data['reviews'], 0, $settings['reviews_count']);
        $layout = $settings['layout'];
        $columns = $settings['columns'];
        $card_style = $settings['card_style'];
        
        // Generate CSS classes
        $container_classes = [
            'google-reviews-container',
            'w-full',
        ];
        
        if ($layout === 'grid') {
            $container_classes[] = 'grid grid-cols-1 md:grid-cols-' . $columns . ' gap-6';
        } elseif ($layout === 'carousel') {
            $container_classes[] = 'google-reviews-carousel relative';
        } elseif ($layout === 'list') {
            $container_classes[] = 'space-y-6';
        }

        echo '<div class="' . esc_attr(implode(' ', $container_classes)) . '">';

        // Header avec logo Google et note globale
        echo '<div class="google-reviews-header text-center mb-12">';
        
        // Logo Google et note
        echo '<div class="flex flex-col items-center gap-4">';
        echo '<div class="flex items-center gap-3">';
        echo '<svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>';
        
        if ($settings['show_overall_rating'] === 'yes') {
            echo '<div class="flex items-center gap-2">';
            echo '<div class="flex items-center">' . vitalisite_format_rating($reviews_data['rating']) . '</div>';
            echo '<span class="text-2xl font-bold text-gray-900">' . esc_html($reviews_data['rating']) . '</span>';
            if ($settings['show_total_reviews'] === 'yes') {
                echo '<span class="text-gray-600 ml-1">(' . esc_html($reviews_data['user_ratings_total']) . ')</span>';
            }
            echo '</div>';
        }
        echo '</div>';
        
        if ($settings['show_title'] === 'yes') {
            echo '<h2 class="text-3xl font-bold text-gray-900 mt-2">' . esc_html($settings['custom_title']) . '</h2>';
        }
        
        echo '</div>';
        echo '</div>';

        // Reviews
        if ($layout === 'carousel') {
            echo '<div class="google-reviews-swiper swiper overflow-hidden">';
            echo '<div class="swiper-wrapper -mr-6">';
        }

        foreach ($reviews as $index => $review) {
            $this->render_review_card($review, $settings, $index);
        }

        if ($layout === 'carousel') {
            echo '</div>';
            echo '<div class="swiper-pagination mt-6"></div>';
            echo '<div class="swiper-button-next !right-2 !top-1/2 !-translate-y-1/2 !w-10 !h-10 !bg-white/90 !backdrop-blur !rounded-full !shadow-lg !flex items-center !justify-center !text-gray-700 hover:!bg-white transition-all">';
            echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>';
            echo '</div>';
            echo '<div class="swiper-button-prev !left-2 !top-1/2 !-translate-y-1/2 !w-10 !h-10 !bg-white/90 !backdrop-blur !rounded-full !shadow-lg !flex items-center !justify-center !text-gray-700 hover:!bg-white transition-all">';
            echo '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';

        // Add styles and scripts
        $this->add_render_styles();
        $this->add_carousel_script();
    }

    private function render_review_card($review, $settings, $index = 0) {
        $card_classes = [
            'google-review-card',
            'bg-white',
            'p-6',
            'rounded-xl',
            'shadow-sm',
            'border',
            'border-gray-100',
            'transition-all',
            'duration-300',
            'hover:shadow-md',
            'hover:border-gray-200',
        ];

        if ($settings['layout'] === 'carousel') {
            $card_classes[] = 'mr-6';
            $card_classes[] = 'flex-shrink-0';
            $card_classes[] = 'w-80';
        }

        echo '<div class="' . esc_attr(implode(' ', $card_classes)) . '">';

        // Header with author and rating
        echo '<div class="flex items-start justify-between mb-4">';
        echo '<div class="flex items-center gap-3">';
        if (!empty($review['profile_photo_url'])) {
            echo '<img src="' . esc_url($review['profile_photo_url']) . '" alt="' . esc_attr($review['author_name']) . '" class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100">';
        } else {
            echo '<div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-lg">';
            echo esc_html(substr(strtoupper($review['author_name']), 0, 1));
            echo '</div>';
        }
        echo '<div>';
        echo '<div class="font-semibold text-gray-900">' . esc_html($review['author_name']) . '</div>';
        echo '<div class="flex items-center gap-1 mt-1">' . vitalisite_format_rating($review['rating']) . '</div>';
        if ($settings['show_date'] === 'yes' && !empty($review['relative_time_description'])) {
            echo '<div class="text-sm text-gray-500 mt-1">' . esc_html($review['relative_time_description']) . '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';

        // Review text
        if (!empty($review['text'])) {
            $text_length = strlen($review['text']);
            $max_length = 200;
            
            echo '<div class="review-text text-gray-700 leading-relaxed">';
            if ($text_length > $max_length && $settings['show_read_more'] === 'yes') {
                echo '<span class="review-text-short">' . esc_html(substr($review['text'], 0, $max_length)) . '...</span>';
                echo '<span class="review-text-full hidden">' . esc_html($review['text']) . '</span>';
                echo '<button class="read-more-btn text-blue-600 font-medium mt-3 hover:text-blue-700 transition-colors" data-index="' . esc_attr($index) . '">' . esc_html__('Lire plus', 'vitalisite') . '</button>';
            } else {
                echo esc_html($review['text']);
            }
            echo '</div>';
        }

        echo '</div>';
    }

    private function add_render_styles() {
        $settings = $this->get_settings_for_display();
        
        echo '<style>';
        echo '.google-reviews-container .stars svg { color: ' . esc_attr($settings['star_color']) . '; width: 20px; height: 20px; }';
        echo '.google-reviews-container .read-more-btn { cursor: pointer; }';
        echo '.google-reviews-container .review-text-full { display: none; }';
        echo '.google-reviews-container .review-text-short { display: block; }';
        echo '.google-reviews-container .review-text.expanded .review-text-short { display: none; }';
        echo '.google-reviews-container .review-text.expanded .review-text-full { display: block; }';
        echo '.swiper-pagination-bullet { background: #e5e7eb; opacity: 1; }';
        echo '.swiper-pagination-bullet-active { background: #3b82f6; }';
        echo '</style>';
        
        // JavaScript pour "Lire plus"
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const readMoreBtns = document.querySelectorAll(".read-more-btn");
            readMoreBtns.forEach(btn => {
                btn.addEventListener("click", function() {
                    const reviewText = this.closest(".review-text");
                    const isExpanded = reviewText.classList.contains("expanded");
                    
                    if (isExpanded) {
                        reviewText.classList.remove("expanded");
                        this.textContent = "' . esc_html__('Lire plus', 'vitalisite') . '";
                    } else {
                        reviewText.classList.add("expanded");
                        this.textContent = "' . esc_html__('Lire moins', 'vitalisite') . '";
                    }
                });
            });
        });
        </script>';
    }
    
    private function add_carousel_script() {
        if (!wp_script_is('swiper', 'registered')) {
            wp_register_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true);
        }
        
        wp_enqueue_script('swiper');
        
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const swiperContainers = document.querySelectorAll(".google-reviews-swiper");
            swiperContainers.forEach(container => {
                new Swiper(container, {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    loop: true,
                    pagination: {
                        el: container.querySelector(".swiper-pagination"),
                        clickable: true,
                    },
                    navigation: {
                        nextEl: container.querySelector(".swiper-button-next"),
                        prevEl: container.querySelector(".swiper-button-prev"),
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });
            });
        });
        </script>';
    }
}
