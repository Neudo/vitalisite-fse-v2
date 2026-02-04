/**
 * Header Responsive - Détecte quand le header wrap et passe en mode mobile
 */
(function () {
  "use strict";

  const MOBILE_CLASS = "header-is-mobile";
  const MOBILE_BREAKPOINT = 782;

  /**
   * Vérifie si le header doit passer en mode mobile
   */
  function checkHeaderWrap() {
    const header = document.querySelector(".site-header .header-inner");
    if (!header) return;

    // Forcer le mode mobile si la fenêtre est petite
    if (window.innerWidth <= MOBILE_BREAKPOINT) {
      document.body.classList.add(MOBILE_CLASS);
      return;
    }

    // Vérifier si les éléments wrap
    const logo = header.querySelector(".header-logo");
    const nav = header.querySelector(".header-nav");

    if (!logo || !nav) {
      document.body.classList.remove(MOBILE_CLASS);
      return;
    }

    const logoRect = logo.getBoundingClientRect();
    const navRect = nav.getBoundingClientRect();

    // Si la nav est en dessous du logo, activer le mode mobile
    const isWrapped = navRect.top > logoRect.bottom - 10;

    document.body.classList.toggle(MOBILE_CLASS, isWrapped);
  }

  /**
   * Animation d'entrée du header avec GSAP
   */
  function animateHeader() {
    if (typeof gsap === "undefined") return;

    const header = document.querySelector(".site-header");
    if (!header) return;

    gsap.fromTo(
      header,
      { y: -20, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.5, ease: "power2.out" }
    );
  }

  /**
   * Initialisation
   */
  function init() {
    // Check initial avec délai pour laisser le DOM se stabiliser
    setTimeout(checkHeaderWrap, 100);

    // Animation d'entrée
    animateHeader();

    // Observer le resize
    let resizeTimeout;
    window.addEventListener("resize", function () {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(checkHeaderWrap, 50);
    });

    // ResizeObserver pour plus de précision
    if (typeof ResizeObserver !== "undefined") {
      const header = document.querySelector(".site-header .header-inner");
      if (header) {
        const observer = new ResizeObserver(() => {
          setTimeout(checkHeaderWrap, 10);
        });
        observer.observe(header);
      }
    }
  }

  // Lancer l'initialisation
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
