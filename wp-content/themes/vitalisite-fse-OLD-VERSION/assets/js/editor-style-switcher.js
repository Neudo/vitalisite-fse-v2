/**
 * Script pour synchroniser la classe du style actif dans l'éditeur
 */
(function () {
  "use strict";

  const STYLE_CLASSES = [
    "theme-style-default",
    "theme-style-bento",
    "theme-style-minimal",
  ];

  function labelToClass(label) {
    return "theme-style-" + label.toLowerCase().trim();
  }

  function applyStyleClass(doc, styleClass) {
    if (!doc?.body) return;
    STYLE_CLASSES.forEach((cls) => doc.body.classList.remove(cls));
    doc.body.classList.add(styleClass);
  }

  function getEditorIframe() {
    return document.querySelector('iframe[name="editor-canvas"]');
  }

  function applyStyleEverywhere(styleClass) {
    applyStyleClass(document, styleClass);
    const iframe = getEditorIframe();
    if (iframe?.contentDocument) {
      applyStyleClass(iframe.contentDocument, styleClass);
    }
  }

  function detectActiveStyle() {
    const activeButton = document.querySelector(
      ".edit-site-global-styles-variations_item.is-active"
    );
    const label = activeButton?.getAttribute("aria-label");
    return label ? labelToClass(label) : "theme-style-default";
  }

  function init() {
    // Observer pour les boutons de style
    const observer = new MutationObserver(() => {
      const container = document.querySelector(
        ".edit-site-global-styles-style-variations-container"
      );

      if (container && !container.dataset.listenerAdded) {
        container.dataset.listenerAdded = "true";

        container.addEventListener("click", (e) => {
          const button = e.target.closest(
            ".edit-site-global-styles-variations_item"
          );
          if (button) {
            const label = button.getAttribute("aria-label");
            if (label) {
              setTimeout(() => applyStyleEverywhere(labelToClass(label)), 50);
            }
          }
        });

        // Style initial
        applyStyleEverywhere(detectActiveStyle());
      }

      // Appliquer sur l'iframe si elle existe
      const iframe = getEditorIframe();
      if (iframe?.contentDocument?.body) {
        const currentStyle = detectActiveStyle();
        const hasStyle = STYLE_CLASSES.some((cls) =>
          iframe.contentDocument.body.classList.contains(cls)
        );
        if (!hasStyle) {
          applyStyleClass(iframe.contentDocument, currentStyle);
        }
      }
    });

    observer.observe(document.body, { childList: true, subtree: true });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
