document.addEventListener("DOMContentLoaded", function () {
  const el = document.querySelector(".vitalisite-testimonials-swiper");
  if (!el) return;

  const slideCount = el.querySelectorAll(".swiper-slide").length;

  new Swiper(el, {
    slidesPerView: 1,
    spaceBetween: 24,
    pagination: {
      el: ".vitalisite-testimonials-swiper .swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      640: {
        slidesPerView: Math.min(2, slideCount),
      },
      1024: {
        slidesPerView: Math.min(3, slideCount),
      },
    },
  });
});
