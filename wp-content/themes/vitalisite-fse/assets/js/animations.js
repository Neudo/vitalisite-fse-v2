/**
 * Vitalisite FSE - Scroll Animations (Class-Based)
 * ================================================
 * GSAP + ScrollTrigger — toutes les animations en Y uniquement.
 *
 * CLASSE            EFFET
 * .reveal-y         Fade-up (opacity 0→1, y 40→0)
 * .reveal-stagger   Container : ses enfants directs font un stagger fade-up
 * .reveal-parallax  Cover block : l'image + le filtre font un parallax subtil
 * .reveal-count     Nombre : count-up de 0 à la valeur textuelle
 * .reveal-scale-x   Séparateur : scale scaleX 0→1 depuis la gauche
 * .reveal-video     Bloc vidéo : fade-up + léger scale
 *
 * Toutes les animations sont désactivées si prefers-reduced-motion est actif.
 */

(function () {
  "use strict";

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
  if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined")
    return;

  gsap.registerPlugin(ScrollTrigger);

  const DEFAULT_START = "top 88%";
  const DEFAULT_EASE = "power2.out";

  // Sélectionne la toute première section/groupe de la page
  const firstSection = document.querySelector(
    "main > section, main > .wp-block-group",
  );

  // Vérifie si un élément est contenu dans la première section
  const isInFirstSection = (el) => {
    if (!firstSection) return false;
    return firstSection.contains(el);
  };

  // ==========================================================================
  // .reveal-y — Fade-up simple
  // ==========================================================================
  document.querySelectorAll(".reveal-y").forEach((el) => {
    if (isInFirstSection(el)) return;

    gsap.from(el, {
      scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
      y: 20,
      opacity: 0,
      duration: 0.4,
      ease: DEFAULT_EASE,
    });
  });

  // ==========================================================================
  // .reveal-stagger — Enfants directs en stagger fade-up
  // ==========================================================================
  document.querySelectorAll(".reveal-stagger").forEach((container) => {
    if (isInFirstSection(container)) return;

    const children = Array.from(container.children);
    if (!children.length) return;

    gsap.from(children, {
      scrollTrigger: { trigger: container, start: "top 85%", once: true },
      y: 50,
      opacity: 0,
      duration: 0.6,
      ease: DEFAULT_EASE,
      stagger: 0.1,
    });
  });

  // ==========================================================================
  // .reveal-parallax — Image de fond + filtre overlay (Cover block)
  //    Cible : l'enfant .wp-block-cover__image-background ET le .has-background-dim
  // ==========================================================================
  document.querySelectorAll(".reveal-parallax").forEach((cover) => {
    const targets = cover.querySelectorAll(
      ".wp-block-cover__image-background, .wp-block-cover__background",
    );
    if (!targets.length) return;

    gsap.to(targets, {
      scrollTrigger: {
        trigger: cover,
        start: "top top",
        end: "bottom top",
        scrub: true,
      },
      y: -80,
      ease: "none",
    });
  });

  // ==========================================================================
  // .reveal-count — Count-up numérique
  // ==========================================================================
  document.querySelectorAll(".reveal-count").forEach((el) => {
    if (isInFirstSection(el)) return;

    const raw = el.textContent.trim();
    const target = parseInt(raw, 10);
    if (isNaN(target)) return;

    const suffix = raw.replace(/[0-9]/g, "");
    const obj = { val: 0 };

    gsap.to(obj, {
      scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
      val: target,
      duration: 1.2,
      ease: DEFAULT_EASE,
      onUpdate() {
        el.textContent = Math.round(obj.val) + suffix;
      },
    });
  });

  // ==========================================================================
  // .reveal-scale-x — Séparateur / trait horizontal
  // ==========================================================================
  document.querySelectorAll(".reveal-scale-x").forEach((el) => {
    if (isInFirstSection(el)) return;

    gsap.from(el, {
      scrollTrigger: { trigger: el, start: "top 90%", once: true },
      scaleX: 0,
      transformOrigin: "left center",
      duration: 0.6,
      ease: DEFAULT_EASE,
    });
  });

  // ==========================================================================
  // .reveal-video — Bloc vidéo : fade-up + léger scale-down
  // ==========================================================================
  document.querySelectorAll(".reveal-video").forEach((el) => {
    if (isInFirstSection(el)) return;

    gsap.from(el, {
      scrollTrigger: { trigger: el, start: "top 88%", once: true },
      y: 60,
      scale: 0.97,
      opacity: 0,
      duration: 0.8,
      ease: DEFAULT_EASE,
    });
  });

  // ==========================================================================
  // .reveal-before-after — Avant/Après : 2 images en stagger décalé
  //    Cible les deux moitiés du composant custom
  // ==========================================================================
  document.querySelectorAll(".reveal-before-after").forEach((el) => {
    if (isInFirstSection(el)) return;

    const before = el.querySelector(
      ".before-after__before, .ba-before, [data-before]",
    );
    const after = el.querySelector(
      ".before-after__after,  .ba-after,  [data-after]",
    );

    const targets = [before, after].filter(Boolean);
    if (!targets.length) {
      // Fallback : anime le bloc entier
      gsap.from(el, {
        scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: DEFAULT_EASE,
      });
      return;
    }

    gsap.from(targets, {
      scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
      y: 50,
      opacity: 0,
      duration: 0.7,
      ease: DEFAULT_EASE,
      stagger: 0.2,
    });
  });
})();
