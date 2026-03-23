/**
 * Vitalisite FSE - Scroll Animations (Class-Based)
 * ================================================
 * GSAP + ScrollTrigger — motion system léger, sobre et premium.
 *
 * CLASSE            EFFET
 * .reveal-y         Fade-up simple et propre
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

  const root = document.documentElement;
  const DEFAULT_START = "top 90%";
  const DEFAULT_EASE = "power3.out";
  const DEFAULT_DURATION = 0.78;
  const DEFAULT_DISTANCE = 32;
  const DEFAULT_STAGGER = 0.12;
  const INTRO_MAX_SCROLL = 64;

  // Sélectionne la toute première section/groupe de la page
  const firstSection = document.querySelector(
    "main > section, main > .wp-block-group",
  );

  const toArray = (value) => Array.from(value || []);
  const unique = (items) => Array.from(new Set(items.filter(Boolean)));

  // Vérifie si un élément est contenu dans la première section
  const isInFirstSection = (el) => {
    if (!firstSection) return false;
    return firstSection.contains(el);
  };

  const isHandledByStagger = (el) => {
    if (!el || !el.parentElement) return false;
    return Boolean(el.parentElement.closest(".reveal-stagger"));
  };

  const setWillChange = (targets) => {
    gsap.set(targets, { willChange: "transform, opacity" });
  };

  const clearAnimatedProps = (targets) => {
    gsap.set(targets, {
      clearProps: "transform,opacity,visibility,willChange",
    });
  };

  const getRevealSettings = (el, overrides = {}) => {
    const isSoft = el.classList.contains("reveal-y--soft");
    const isStrong = el.classList.contains("reveal-y--strong");
    const y = isSoft ? 18 : isStrong ? 44 : DEFAULT_DISTANCE;

    return {
      autoAlpha: 1,
      y: 0,
      duration: isSoft ? 0.64 : isStrong ? 0.92 : DEFAULT_DURATION,
      ease: DEFAULT_EASE,
      force3D: true,
      overwrite: "auto",
      ...overrides,
    };
  };

  const getInitialRevealState = (el, overrides = {}) => {
    const isSoft = el.classList.contains("reveal-y--soft");
    const isStrong = el.classList.contains("reveal-y--strong");
    const y = isSoft ? 18 : isStrong ? 44 : DEFAULT_DISTANCE;

    return {
      y,
      autoAlpha: 0,
      force3D: true,
      ...overrides,
    };
  };

  const getScrollRevealTargets = () =>
    unique([
      ...toArray(
        document.querySelectorAll(
          ".reveal-y, .reveal-video, .reveal-before-after, .vitalisite-accordion-item",
        ),
      ).filter((el) => !isHandledByStagger(el)),
      ...toArray(document.querySelectorAll(".reveal-stagger")).flatMap((container) =>
        toArray(container.children).filter(
          (child) =>
            !child.hasAttribute("hidden") &&
            !child.matches("script, style, template"),
        ),
      ),
    ]);

  const shouldRunIntroSequence = (introTextTargets, introMediaTargets) => {
    if (!firstSection || window.scrollY > INTRO_MAX_SCROLL) return false;
    return Boolean(introTextTargets.length || introMediaTargets.length);
  };

  const runIntroSequence = (introTextTargets, introMediaTargets) => {
    if (!shouldRunIntroSequence(introTextTargets, introMediaTargets)) {
      return false;
    }

    setWillChange([...introTextTargets, ...introMediaTargets]);

    const timeline = gsap.timeline({
      defaults: { ease: DEFAULT_EASE },
      onComplete() {
        clearAnimatedProps([...introTextTargets, ...introMediaTargets]);
      },
    });

    if (introMediaTargets.length) {
      timeline.to(
        introMediaTargets,
        {
          autoAlpha: 1,
          y: 0,
          duration: 1.05,
        },
        0,
      );
    }

    if (introTextTargets.length) {
      timeline.to(
        introTextTargets,
        {
          y: 0,
          autoAlpha: 1,
          duration: 0.72,
          stagger: 0.1,
        },
        introMediaTargets.length ? 0.08 : 0,
      );
    }

    return true;
  };

  const introTextTargets = unique([
    ...toArray(
      firstSection?.querySelectorAll(
        ".vitalisite-hero__title, .vitalisite-hero__lead, .vitalisite-hero__actions, .hero-image-bg__content h1, .hero-image-bg__content h2, .hero-image-bg__content p, .hero-image-bg__content .wp-block-buttons, .hero-image-bg__content .vitalisite-social-links, .vitalisite-doctor-cover__card, .vitalisite-doctor-cover .vitalisite-social-links, .reveal-y, .reveal-stagger > *",
      ) || [],
    ),
  ]);

  const introMediaTargets = unique([
    firstSection?.querySelector(
      ".hero-side-image .wp-block-image, .vitalisite-hero-custom-bg img, .vitalisite-doctor-cover__photo img",
    ),
  ]);

  getScrollRevealTargets().forEach((el) => {
    gsap.set(el, getInitialRevealState(el));
  });

  introMediaTargets.forEach((el) => {
    gsap.set(el, getInitialRevealState(el, { y: 26 }));
  });

  root.classList.remove("vitalisite-motion-pending");

  const hasPlayedIntro = runIntroSequence(introTextTargets, introMediaTargets);

  // ==========================================================================
  // .reveal-y — Fade-up simple
  // ==========================================================================
  document
    .querySelectorAll(".reveal-y, .vitalisite-accordion-item")
    .forEach((el) => {
      if ((hasPlayedIntro && isInFirstSection(el)) || isHandledByStagger(el))
        return;

      gsap.to(el, {
        scrollTrigger: {
          trigger: el,
          start: el.dataset.revealStart || DEFAULT_START,
          once: true,
        },
        ...getRevealSettings(el),
        onStart() {
          setWillChange(el);
        },
        onComplete() {
          clearAnimatedProps(el);
        },
      });
    });

  // ==========================================================================
  // .reveal-stagger — Enfants directs en stagger fade-up
  // ==========================================================================
  document.querySelectorAll(".reveal-stagger").forEach((container) => {
    if (hasPlayedIntro && isInFirstSection(container)) return;

    const children = unique(
      Array.from(container.children).filter(
        (child) =>
          !child.hasAttribute("hidden") &&
          !child.matches("script, style, template"),
      ),
    );

    if (!children.length) return;

    gsap.set(children, getInitialRevealState(children[0] || container, { y: 28 }));

    gsap.to(children, {
      scrollTrigger: {
        trigger: container,
        start: container.dataset.revealStart || "top 87%",
        once: true,
      },
      ...getRevealSettings(children[0] || container, {
        duration: 0.72,
      }),
      stagger: parseFloat(container.dataset.revealStagger || DEFAULT_STAGGER),
      onStart() {
        setWillChange(children);
      },
      onComplete() {
        clearAnimatedProps(children);
      },
    });
  });

  // ==========================================================================
  // .reveal-parallax — Image de fond + filtre overlay (Cover block)
  //    Cible : l'enfant .wp-block-cover__image-background ET le .has-background-dim
  // ==========================================================================
  document.querySelectorAll(".reveal-parallax").forEach((cover) => {
    let targets = toArray(
      cover.querySelectorAll(
      ".wp-block-cover__image-background, .wp-block-cover__background",
      ),
    );

    if (!targets.length) {
      const customHero = cover.closest(".vitalisite-hero-custom-cover");
      if (customHero) {
        targets = toArray(
          customHero.querySelectorAll(
            ".vitalisite-hero-custom-bg, .vitalisite-hero-custom-bg img",
          ),
        );
      }
    }

    if (!targets.length) return;

    gsap.to(targets, {
      scrollTrigger: {
        trigger: cover.closest(".vitalisite-hero-custom-cover") || cover,
        start: "top bottom",
        end: "bottom top",
        scrub: true,
      },
      y: -56,
      scale: 1.08,
      ease: "none",
    });
  });

  // ==========================================================================
  // .reveal-count — Count-up numérique
  // ==========================================================================
  document.querySelectorAll(".reveal-count").forEach((el) => {
    if (hasPlayedIntro && isInFirstSection(el)) return;

    const raw = el.textContent.trim();
    const target = parseInt(raw, 10);
    if (isNaN(target)) return;

    const suffix = raw.replace(/[0-9]/g, "");
    const obj = { val: 0 };

    gsap.to(obj, {
      scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
      val: target,
      duration: 1,
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
    if (hasPlayedIntro && isInFirstSection(el)) return;

    gsap.from(el, {
      scrollTrigger: { trigger: el, start: "top 90%", once: true },
      scaleX: 0,
      transformOrigin: "left center",
      duration: 0.7,
      ease: DEFAULT_EASE,
    });
  });

  // ==========================================================================
  // .reveal-video — Bloc vidéo : fade-up + léger scale-down
  // ==========================================================================
  document.querySelectorAll(".reveal-video").forEach((el) => {
    if (hasPlayedIntro && isInFirstSection(el)) return;

    gsap.to(el, {
      scrollTrigger: { trigger: el, start: "top 88%", once: true },
      ...getRevealSettings(el, {
        y: 0,
        duration: 0.82,
      }),
      onStart() {
        setWillChange(el);
      },
      onComplete() {
        clearAnimatedProps(el);
      },
    });
  });

  // ==========================================================================
  // .reveal-before-after — Avant/Après : 2 images en stagger décalé
  //    Cible les deux moitiés du composant custom
  // ==========================================================================
  document.querySelectorAll(".reveal-before-after").forEach((el) => {
    if (hasPlayedIntro && isInFirstSection(el)) return;

    const before = el.querySelector(
      ".before-after__before, .ba-before, [data-before]",
    );
    const after = el.querySelector(
      ".before-after__after,  .ba-after,  [data-after]",
    );

    const targets = [before, after].filter(Boolean);
    if (!targets.length) {
      // Fallback : anime le bloc entier
      gsap.to(el, {
        scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
        ...getRevealSettings(el, {
          y: 0,
          duration: 0.82,
        }),
        onStart() {
          setWillChange(el);
        },
        onComplete() {
          clearAnimatedProps(el);
        },
      });
      return;
    }

    gsap.to(targets, {
      scrollTrigger: { trigger: el, start: DEFAULT_START, once: true },
      ...getRevealSettings(el, {
        y: 0,
        duration: 0.76,
      }),
      stagger: 0.14,
      onStart() {
        setWillChange(targets);
      },
      onComplete() {
        clearAnimatedProps(targets);
      },
    });
  });
})();
