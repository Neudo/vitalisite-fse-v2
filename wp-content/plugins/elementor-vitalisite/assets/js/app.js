document.addEventListener('DOMContentLoaded', function() {
    const sliderSection = document.querySelectorAll('.swiper-section');
    const sliderTestimonials = document.querySelectorAll('.swiper-testimonials');
    if (sliderSection) {
        const swiper = new Swiper('.swiper-section', {
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                1200: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 2.2,
                },
                568: {
                    slidesPerView: 1.5,
                }
            },
            navigation: {
                nextEl: ".button-next",
                prevEl: ".button-prev",
            },
        });
    }

    if (sliderTestimonials) {
        const swiperTesimonials = new Swiper('.swiper-testimonials', {
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                1200: {
                    slidesPerView: 1.3,
                },
            },
            navigation: {
                nextEl: ".button-next",
                prevEl: ".button-prev",
            },
        });
    }
});