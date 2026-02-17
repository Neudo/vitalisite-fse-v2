/**
 * Responsive Navigation — Vitalisite FSE
 *
 * WP's native overlay menu is disabled (overlayMenu: "never").
 * This script handles everything:
 *   1. Detects overflow via off-screen clone measurement.
 *   2. Creates a burger button (injected into the header).
 *   3. Clones the nav links into a slide-in drawer from the right.
 *   4. ResizeObserver keeps monitoring for viewport changes.
 *
 * Anti-flash: CSS hides the header by default (visibility:hidden).
 * This script adds .is-nav-ready after the first check.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */
(function () {
  "use strict";

  var HEADER_SEL = ".vitalisite-header--minimal";
  var CLASS_DESKTOP = "is-desktop-nav";
  var CLASS_MOBILE = "is-mobile-nav";
  var CLASS_READY = "is-nav-ready";
  var measuring = false;
  var drawerBuilt = false;

  // DOM references (set in init)
  var header, flexContainer, nav, burger, drawer, backdrop;

  /* ------------------------------------------------
   * Helpers
   * ------------------------------------------------ */

  function getFlexContainer(h) {
    return h.querySelector(":scope > .wp-block-group");
  }

  /* ------------------------------------------------
   * Build burger button + drawer (once)
   * ------------------------------------------------ */

  function buildDrawer() {
    if (drawerBuilt) return;
    drawerBuilt = true;

    // --- Burger button ---
    burger = document.createElement("button");
    burger.className = "vitalisite-burger";
    burger.setAttribute("aria-label", "Ouvrir le menu");
    burger.setAttribute("aria-expanded", "false");
    burger.innerHTML =
      '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
      '<line x1="3" y1="6" x2="21" y2="6"/>' +
      '<line x1="3" y1="12" x2="21" y2="12"/>' +
      '<line x1="3" y1="18" x2="21" y2="18"/>' +
      "</svg>";

    // Insert burger into the flex container (after the logo group)
    flexContainer.appendChild(burger);

    // --- Backdrop ---
    backdrop = document.createElement("div");
    backdrop.className = "vitalisite-drawer-backdrop";
    document.body.appendChild(backdrop);

    // --- Drawer panel ---
    drawer = document.createElement("div");
    drawer.className = "vitalisite-drawer";
    drawer.setAttribute("aria-hidden", "true");

    // Close button
    var closeBtn = document.createElement("button");
    closeBtn.className = "vitalisite-drawer__close";
    closeBtn.setAttribute("aria-label", "Fermer le menu");
    closeBtn.innerHTML =
      '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
      '<line x1="18" y1="6" x2="6" y2="18"/>' +
      '<line x1="6" y1="6" x2="18" y2="18"/>' +
      "</svg>";
    drawer.appendChild(closeBtn);

    // Clone nav links into drawer
    var navContent = document.createElement("nav");
    navContent.className = "vitalisite-drawer__nav";
    navContent.setAttribute("aria-label", "Menu principal");

    // Find the UL inside the WP navigation block
    var sourceList = nav.querySelector(".wp-block-navigation__container");
    if (sourceList) {
      var clonedList = sourceList.cloneNode(true);
      navContent.appendChild(clonedList);
    }

    drawer.appendChild(navContent);
    document.body.appendChild(drawer);

    // --- Events ---
    burger.addEventListener("click", openDrawer);
    closeBtn.addEventListener("click", closeDrawer);
    backdrop.addEventListener("click", closeDrawer);

    // Close on Escape
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && drawer.classList.contains("is-open")) {
        closeDrawer();
      }
    });
  }

  function openDrawer() {
    drawer.classList.add("is-open");
    drawer.setAttribute("aria-hidden", "false");
    backdrop.classList.add("is-visible");
    burger.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden";
  }

  function closeDrawer() {
    drawer.classList.remove("is-open");
    drawer.setAttribute("aria-hidden", "true");
    backdrop.classList.remove("is-visible");
    burger.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
  }

  /* ------------------------------------------------
   * Overflow detection via off-screen clone
   * ------------------------------------------------ */

  function checkOverflow() {
    if (measuring || !flexContainer) return;
    measuring = true;

    var clone = flexContainer.cloneNode(true);

    // Remove any burger from the clone (we don't want it in measurement)
    var cloneBurger = clone.querySelector(".vitalisite-burger");
    if (cloneBurger) cloneBurger.remove();

    clone.style.cssText =
      "position:absolute !important;" +
      "top:-9999px !important;" +
      "left:0 !important;" +
      "width:" +
      flexContainer.offsetWidth +
      "px !important;" +
      "display:flex !important;" +
      "flex-wrap:nowrap !important;" +
      "visibility:hidden !important;" +
      "pointer-events:none !important;" +
      "overflow:visible !important;";

    var kids = clone.children;
    for (var i = 0; i < kids.length; i++) {
      kids[i].style.display = "flex";
      kids[i].style.visibility = "visible";
      kids[i].style.opacity = "1";
      kids[i].style.flexShrink = "0";
    }

    document.body.appendChild(clone);
    var isWrapping = clone.scrollWidth > clone.clientWidth;
    document.body.removeChild(clone);

    if (isWrapping) {
      header.classList.remove(CLASS_DESKTOP);
      header.classList.add(CLASS_MOBILE);
      buildDrawer();
    } else {
      header.classList.remove(CLASS_MOBILE);
      header.classList.add(CLASS_DESKTOP);
      // Close drawer if switching back to desktop
      if (drawer && drawer.classList.contains("is-open")) {
        closeDrawer();
      }
    }

    if (!header.classList.contains(CLASS_READY)) {
      header.classList.add(CLASS_READY);
    }

    measuring = false;
  }

  /* ------------------------------------------------
   * Init
   * ------------------------------------------------ */

  function init() {
    header = document.querySelector(HEADER_SEL);
    if (!header) return;

    flexContainer = getFlexContainer(header);
    if (!flexContainer) return;

    nav = header.querySelector(".wp-block-navigation");

    checkOverflow();

    if (typeof ResizeObserver !== "undefined") {
      var ro = new ResizeObserver(function () {
        checkOverflow();
      });
      ro.observe(header);
    } else {
      window.addEventListener("resize", function () {
        checkOverflow();
      });
    }

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(function () {
        checkOverflow();
      });
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
