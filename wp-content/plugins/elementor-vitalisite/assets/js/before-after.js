/**
 * Before/After Comparison - Simplified
 * Static side-by-side images with optional Swiper carousel
 */

function initBeforeAfter() {
  const swipers = document.querySelectorAll(".vitalisite-before-after-swiper");

  swipers.forEach((swiperEl) => {
    if (swiperEl.swiper) return;

    const autoplayEnabled = swiperEl.dataset.autoplay === "yes";

    const config = {
      slidesPerView: 1,
      spaceBetween: 30,
      navigation: {
        nextEl: swiperEl.querySelector(".swiper-button-next"),
        prevEl: swiperEl.querySelector(".swiper-button-prev"),
      },
      pagination: {
        el: swiperEl.querySelector(".swiper-pagination"),
        clickable: true,
      },
    };

    if (autoplayEnabled) {
      config.autoplay = {
        delay: 3000,
        disableOnInteraction: false,
      };
    }

    if (typeof Swiper !== "undefined") {
      new Swiper(swiperEl, config);
    }
  });
}

document.addEventListener("DOMContentLoaded", initBeforeAfter);

if (typeof elementorFrontend !== "undefined") {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/vitalisite_before_after",
    function ($scope) {
      initBeforeAfter();
    }
  );
}
