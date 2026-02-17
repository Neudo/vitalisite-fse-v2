/**
 * Vitalisite Setup Wizard — License activation/deactivation + next button gating.
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */
(function () {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var activateBtn = document.getElementById("vitalisite-activate-license");
    var deactivateBtn = document.getElementById(
      "vitalisite-deactivate-license",
    );
    var feedback = document.getElementById("vitalisite-license-feedback");
    var nextBtn = document.getElementById("vitalisite-wizard-next");

    /**
     * Unlock the "Suivant" button after successful activation.
     */
    function unlockNextButton() {
      if (!nextBtn) return;
      var link = document.createElement("a");
      link.href =
        nextBtn.getAttribute("data-href") ||
        vitalisiteWizard.settingsUrl.replace(
          "vitalisite-settings",
          "vitalisite-wizard",
        ) + "&step=2";
      link.className = "button button-primary button-hero";
      link.id = "vitalisite-wizard-next";
      link.textContent = nextBtn.textContent;
      nextBtn.parentNode.replaceChild(link, nextBtn);
      nextBtn = link;
    }

    if (activateBtn) {
      activateBtn.addEventListener("click", function () {
        var keyInput = document.getElementById("vitalisite-license-key");
        var key = keyInput ? keyInput.value.trim() : "";

        if (!key) {
          showFeedback(
            feedback,
            "Veuillez saisir une clé de licence.",
            "error",
          );
          return;
        }

        activateBtn.disabled = true;
        activateBtn.textContent = "Vérification…";

        var formData = new FormData();
        formData.append("action", "vitalisite_activate_license");
        formData.append("license_key", key);
        formData.append("_wpnonce", vitalisiteWizard.nonce);

        fetch(vitalisiteWizard.ajaxUrl, {
          method: "POST",
          body: formData,
          credentials: "same-origin",
        })
          .then(function (r) {
            return r.json();
          })
          .then(function (result) {
            if (result.success) {
              showFeedback(feedback, result.data.message, "success");
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              showFeedback(feedback, result.data.message, "error");
              activateBtn.disabled = false;
              activateBtn.textContent = "Activer la licence";
            }
          })
          .catch(function () {
            showFeedback(feedback, "Erreur réseau. Réessayez.", "error");
            activateBtn.disabled = false;
            activateBtn.textContent = "Activer la licence";
          });
      });
    }

    if (deactivateBtn) {
      deactivateBtn.addEventListener("click", function () {
        if (!confirm("Êtes-vous sûr de vouloir désactiver la licence ?")) {
          return;
        }

        deactivateBtn.disabled = true;
        deactivateBtn.textContent = "Désactivation…";

        var formData = new FormData();
        formData.append("action", "vitalisite_deactivate_license");
        formData.append("_wpnonce", vitalisiteWizard.nonce);

        fetch(vitalisiteWizard.ajaxUrl, {
          method: "POST",
          body: formData,
          credentials: "same-origin",
        })
          .then(function (r) {
            return r.json();
          })
          .then(function (result) {
            if (result.success) {
              showFeedback(feedback, result.data.message, "success");
              setTimeout(function () {
                location.reload();
              }, 1000);
            } else {
              showFeedback(feedback, result.data.message, "error");
              deactivateBtn.disabled = false;
              deactivateBtn.textContent = "Désactiver";
            }
          })
          .catch(function () {
            showFeedback(feedback, "Erreur réseau. Réessayez.", "error");
            deactivateBtn.disabled = false;
            deactivateBtn.textContent = "Désactiver";
          });
      });
    }
  });

  function showFeedback(el, message, type) {
    if (!el) return;
    el.textContent = message;
    el.className =
      "vitalisite-wizard__feedback vitalisite-wizard__feedback--" + type;
    el.removeAttribute("hidden");
  }
})();
