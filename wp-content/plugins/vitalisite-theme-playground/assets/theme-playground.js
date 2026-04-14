(function () {
  "use strict";

  var config = window.vitalisiteThemePlayground || {};
  var root = document.getElementById("vitalisite-theme-playground-root");

  if (!root) {
    return;
  }

  var labels = config.labels || {};
  var styles = Array.isArray(config.styles) ? config.styles : [];
  var cookieName = config.cookieName || "vitalisite_theme_playground_selection";
  var storageKey = config.storageKey || "vitalisiteThemePlaygroundSelection";
  var cookieDays = Number(config.cookieDays || 30);
  var purchaseUrl = typeof config.purchaseUrl === "string" ? config.purchaseUrl : "";
  var styleMap = {};
  var isBusy = false;

  styles.forEach(function (style) {
    if (style && style.slug) {
      styleMap[style.slug] = style;
    }
  });

  var selection = normalizeSelection(config.selection || readSelectionFromRoot() || {});
  syncStoredSelection();

  function text(key, fallback) {
    return labels[key] || fallback;
  }

  function normalizeSelection(value) {
    value = value && typeof value === "object" ? value : {};

    return {
      style: typeof value.style === "string" && value.style ? value.style : "default",
      color: typeof value.color === "string" ? value.color : "",
      typography: typeof value.typography === "string" ? value.typography : "",
    };
  }

  function readSelectionFromRoot() {
    var raw = root.getAttribute("data-selection");

    if (!raw) {
      return null;
    }

    try {
      return JSON.parse(raw);
    } catch (error) {
      return null;
    }
  }

  function readStoredSelection() {
    if (!window.localStorage) {
      return null;
    }

    try {
      var raw = window.localStorage.getItem(storageKey);
      return raw ? normalizeSelection(JSON.parse(raw)) : null;
    } catch (error) {
      return null;
    }
  }

  function writeStoredSelection(nextSelection) {
    if (!window.localStorage) {
      return;
    }

    try {
      window.localStorage.setItem(storageKey, JSON.stringify(nextSelection));
    } catch (error) {
      // Storage may be unavailable in private browsing modes.
    }
  }

  function hasSelectionCookie() {
    return document.cookie.split(";").some(function (cookie) {
      return cookie.trim().indexOf(cookieName + "=") === 0;
    });
  }

  function writeSelectionCookie(nextSelection) {
    var maxAge = Math.max(1, cookieDays) * 24 * 60 * 60;
    var cookie =
      cookieName +
      "=" +
      encodeURIComponent(JSON.stringify(nextSelection)) +
      "; path=/; max-age=" +
      maxAge +
      "; SameSite=Lax";

    if (window.location.protocol === "https:") {
      cookie += "; Secure";
    }

    document.cookie = cookie;
  }

  function selectionsMatch(left, right) {
    left = normalizeSelection(left);
    right = normalizeSelection(right);

    return (
      left.style === right.style &&
      left.color === right.color &&
      left.typography === right.typography
    );
  }

  function syncStoredSelection() {
    var stored = readStoredSelection();

    if (!stored || hasSelectionCookie() || selectionsMatch(stored, selection)) {
      return;
    }

    writeSelectionCookie(stored);
    window.location.reload();
  }

  function createNode(tag, className, content) {
    var node = document.createElement(tag);

    if (className) {
      node.className = className;
    }

    if (typeof content === "string") {
      node.textContent = content;
    }

    return node;
  }

  function appendText(parent, tag, className, content) {
    var node = createNode(tag, className, content);
    parent.appendChild(node);
    return node;
  }

  function createPurchaseLink(className) {
    if (!purchaseUrl) {
      return null;
    }

    var link = createNode("a", className, text("purchase", "Obtenir le thème"));
    link.href = purchaseUrl;
    link.target = "_blank";
    link.rel = "noopener noreferrer";

    return link;
  }

  function groupStyles(items) {
    return items.reduce(function (groups, item) {
      var group = item.group || "Styles";

      if (!groups[group]) {
        groups[group] = [];
      }

      groups[group].push(item);
      return groups;
    }, {});
  }

  function isStyleActive(style) {
    if (!style || !style.slug) {
      return false;
    }

    if (style.kind === "color") {
      return selection.color === style.slug;
    }

    if (style.kind === "typography") {
      return selection.typography === style.slug;
    }

    return selection.style === style.slug;
  }

  function getSelectionSummary() {
    var parts = [];
    var selectedStyle = styleMap[selection.style];
    var selectedColor = styleMap[selection.color];
    var selectedTypography = styleMap[selection.typography];

    if (selectedStyle) {
      parts.push(selectedStyle.title || selectedStyle.slug);
    }

    if (selectedColor) {
      parts.push(selectedColor.title || selectedColor.slug);
    }

    if (selectedTypography) {
      parts.push(selectedTypography.title || selectedTypography.slug);
    }

    return parts.length ? parts.join(" / ") : selection.style;
  }

  function buildSwatches(style) {
    var swatches = createNode("div", "vtp-swatches");
    var colors = Array.isArray(style.swatches) ? style.swatches : [];

    if (!colors.length) {
      swatches.classList.add("vtp-swatches--empty");
      swatches.setAttribute("aria-hidden", "true");
      return swatches;
    }

    colors.forEach(function (swatch) {
      var color = swatch && swatch.color ? swatch.color : "";

      if (!color) {
        return;
      }

      var item = createNode("span", "vtp-swatch");
      item.style.background = color;

      if (swatch.name) {
        item.title = swatch.name;
      }

      swatches.appendChild(item);
    });

    return swatches;
  }

  function createStyleCard(style) {
    var card = createNode("article", "vtp-card");
    var isActive = isStyleActive(style);

    if (isActive) {
      card.classList.add("is-active");
    }

    card.appendChild(buildSwatches(style));

    var content = createNode("div", "vtp-card__content");
    appendText(content, "h3", "vtp-card__title", style.title || style.slug);

    var source = createNode("p", "vtp-card__source");
    source.textContent = text("source", "Source") + " : " + (style.source || "");
    content.appendChild(source);

    var footer = createNode("div", "vtp-card__footer");
    var status = appendText(footer, "span", "vtp-card__status", isActive ? text("active", "Actif") : "");

    if (!isActive) {
      status.setAttribute("aria-hidden", "true");
    }

    var button = createNode("button", "vtp-apply", text("apply", "Appliquer"));
    button.type = "button";
    button.dataset.style = style.slug;
    button.disabled = isActive;
    button.addEventListener("click", function () {
      applyStyle(style);
    });

    footer.appendChild(button);
    content.appendChild(footer);
    card.appendChild(content);

    return card;
  }

  function renderStyleGroups(container) {
    if (!styles.length) {
      appendText(container, "p", "vtp-empty", text("empty", "Aucun style disponible."));
      return;
    }

    var groups = groupStyles(styles);

    Object.keys(groups).forEach(function (groupName) {
      var section = createNode("section", "vtp-group");
      appendText(section, "h3", "vtp-group__title", groupName);

      var grid = createNode("div", "vtp-grid");
      groups[groupName].forEach(function (style) {
        grid.appendChild(createStyleCard(style));
      });

      section.appendChild(grid);
      container.appendChild(section);
    });
  }

  function setBusy(nextBusy) {
    isBusy = nextBusy;
    root.classList.toggle("is-busy", isBusy);

    Array.prototype.forEach.call(root.querySelectorAll("button"), function (button) {
      if (button.classList.contains("vtp-button")) {
        return;
      }

      button.disabled = isBusy || button.closest(".vtp-card.is-active") !== null;
    });
  }

  function setStatus(message) {
    var status = root.querySelector(".vtp-status");

    if (status) {
      status.textContent = message || "";
    }
  }

  function getNextSelection(style) {
    var nextSelection = normalizeSelection(selection);

    if (style.kind === "color") {
      nextSelection.color = style.slug;
      return nextSelection;
    }

    if (style.kind === "typography") {
      nextSelection.typography = style.slug;
      return nextSelection;
    }

    nextSelection.style = style.slug;
    nextSelection.color = "";
    nextSelection.typography = "";

    return nextSelection;
  }

  function applyStyle(style) {
    if (isBusy || !style || !style.slug) {
      return;
    }

    var nextSelection = getNextSelection(style);

    setBusy(true);
    setStatus(text("applying", "Application du style..."));
    writeStoredSelection(nextSelection);
    writeSelectionCookie(nextSelection);
    setStatus(text("reloading", "Style applique. Rechargement..."));

    window.setTimeout(function () {
      window.location.reload();
    }, 120);
  }

  function openModal() {
    root.classList.add("is-open");
    var dialog = root.querySelector(".vtp-dialog");

    if (dialog) {
      dialog.focus();
    }
  }

  function closeModal() {
    if (isBusy) {
      return;
    }

    root.classList.remove("is-open");
  }

  function render() {
    var launcherWrap = createNode("div", "vtp-launcher");
    var launcher = createNode("button", "vtp-button", text("button", "Personnaliser la demo"));
    launcher.type = "button";
    launcher.addEventListener("click", openModal);
    launcherWrap.appendChild(launcher);

    var purchase = createPurchaseLink("vtp-purchase");
    if (purchase) {
      launcherWrap.appendChild(purchase);
    }

    var overlay = createNode("div", "vtp-overlay");
    overlay.addEventListener("click", function (event) {
      if (event.target === overlay) {
        closeModal();
      }
    });

    var dialog = createNode("div", "vtp-dialog");
    dialog.setAttribute("role", "dialog");
    dialog.setAttribute("aria-modal", "true");
    dialog.setAttribute("aria-labelledby", "vtp-title");
    dialog.tabIndex = -1;

    var header = createNode("div", "vtp-header");
    var headerText = createNode("div", "vtp-header__text");
    appendText(headerText, "p", "vtp-kicker", text("activeStyleText", "Selection") + " : " + getSelectionSummary());
    appendText(headerText, "h2", "vtp-title", text("title", "Theme playground")).id = "vtp-title";
    appendText(headerText, "p", "vtp-intro", text("intro", "Choisissez un style."));

    var close = createNode("button", "vtp-close", text("close", "Fermer"));
    close.type = "button";
    close.addEventListener("click", closeModal);

    header.appendChild(headerText);
    header.appendChild(close);

    var body = createNode("div", "vtp-body");
    renderStyleGroups(body);

    var footer = createNode("div", "vtp-footer");
    var status = appendText(footer, "p", "vtp-status", "");
    status.setAttribute("aria-live", "polite");

    var footerPurchase = createPurchaseLink("vtp-purchase vtp-purchase--footer");
    if (footerPurchase) {
      footer.appendChild(footerPurchase);
    }

    dialog.appendChild(header);
    dialog.appendChild(body);
    dialog.appendChild(footer);
    overlay.appendChild(dialog);

    root.appendChild(launcherWrap);
    root.appendChild(overlay);

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeModal();
      }
    });
  }

  render();
})();
