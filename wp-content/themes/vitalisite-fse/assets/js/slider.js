/**
 * Vitalisite FSE - Slider Initialization
 *
 * Initializes Swiper.js sliders on the page
 * Reads block attributes from data attributes
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize all sliders on the page
  const sliders = document.querySelectorAll(".vitalisite-slider");

  if (sliders.length > 0) {
    sliders.forEach(function (sliderElement) {
      // Read block attributes from data attributes
      const showNavigation = sliderElement.dataset.showNavigation === "true";
      const showPagination = sliderElement.dataset.showPagination === "true";
      const autoplayDelay =
        parseInt(sliderElement.dataset.autoplayDelay) || 5000;
      const enableLoop = sliderElement.dataset.enableLoop !== "false";

      // Wrap each image in swiper-slide if not already wrapped
      const images = sliderElement.querySelectorAll(
        ".swiper-wrapper > .wp-block-image",
      );
      images.forEach(function (image) {
        if (!image.parentElement.classList.contains("swiper-slide")) {
          const slide = document.createElement("div");
          slide.className = "swiper-slide";
          image.parentNode.insertBefore(slide, image);
          slide.appendChild(image);
        }
      });

      // Create navigation elements if needed
      let nextButton = null;
      let prevButton = null;
      if (showNavigation) {
        nextButton = document.createElement("div");
        nextButton.className = "swiper-button-next";
        prevButton = document.createElement("div");
        prevButton.className = "swiper-button-prev";
        sliderElement.appendChild(nextButton);
        sliderElement.appendChild(prevButton);
      }

      // Create pagination element if needed
      let pagination = null;
      if (showPagination) {
        pagination = document.createElement("div");
        pagination.className = "swiper-pagination";
        sliderElement.appendChild(pagination);
      }

      // Initialize Swiper
      new Swiper(sliderElement, {
        // Loop slides
        loop: enableLoop,

        // Auto-rotation
        autoplay: {
          delay: autoplayDelay,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },

        // Navigation arrows (only if enabled)
        navigation: showNavigation
          ? {
              nextEl: nextButton,
              prevEl: prevButton,
            }
          : false,

        // Pagination dots (only if enabled)
        pagination: showPagination
          ? {
              el: pagination,
              clickable: true,
              dynamicBullets: false,
            }
          : false,

        // Slides configuration
        slidesPerView: 1,
        spaceBetween: 0,

        // Effects
        effect: "slide",
        speed: 600,

        // Accessibility
        a11y: {
          enabled: true,
          prevSlideMessage: "Diapositive précédente",
          nextSlideMessage: "Diapositive suivante",
          firstSlideMessage: "Première diapositive",
          lastSlideMessage: "Dernière diapositive",
          paginationBulletMessage: "Aller à la diapositive {{index}}",
        },

        // Keyboard control
        keyboard: {
          enabled: true,
          onlyInViewport: true,
        },

        // Touch/swipe
        touchRatio: 1,
        touchAngle: 45,
        grabCursor: true,
      });
    });
  }
});
