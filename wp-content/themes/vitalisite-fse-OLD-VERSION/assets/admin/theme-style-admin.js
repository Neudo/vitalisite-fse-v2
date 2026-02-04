/**
 * JavaScript pour la page de sélection du style du thème
 *
 * @package Vitalisite_FSE
 */

(function ($) {
  "use strict";

  $(document).ready(function () {
    initStyleSelector();
  });

  /**
   * Initialise le sélecteur de style
   */
  function initStyleSelector() {
    const $options = $(".vitalisite-style-option");
    const $radios = $options.find('input[type="radio"]');

    // Gestion du clic sur les options
    $options.on("click", function (e) {
      const $option = $(this);
      const $radio = $option.find('input[type="radio"]');

      // Désélectionner toutes les options
      $options.removeClass("selected");

      // Sélectionner l'option cliquée
      $option.addClass("selected");
      $radio.prop("checked", true);
    });

    // Mise à jour visuelle lors du changement de radio
    $radios.on("change", function () {
      $options.removeClass("selected");
      $(this).closest(".vitalisite-style-option").addClass("selected");
    });

    // Initialiser l'état sélectionné
    $radios
      .filter(":checked")
      .closest(".vitalisite-style-option")
      .addClass("selected");
  }
})(jQuery);
