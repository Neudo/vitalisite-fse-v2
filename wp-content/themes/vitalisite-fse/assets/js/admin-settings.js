/**
 * Vitalisite Admin Settings JS.
 *
 * Handles:
 * - Media uploader for image fields
 * - Hours table: disable time inputs when "closed" is checked
 */

(function ($) {
  "use strict";

  /* ---- Media uploader ---- */

  $(document).on("click", ".vitalisite-upload-btn", function (e) {
    e.preventDefault();

    var targetId = $(this).data("target");
    var $input = $("#" + targetId);
    var $preview = $("#" + targetId + "-preview");
    var $removeBtn = $(this).siblings(".vitalisite-remove-btn");

    var frame = wp.media({
      title: "Choisir une image",
      button: { text: "Sélectionner" },
      multiple: false,
      library: { type: "image" },
    });

    frame.on("select", function () {
      var attachment = frame.state().get("selection").first().toJSON();
      $input.val(attachment.id);
      $preview.html(
        '<img src="' +
          (attachment.sizes.thumbnail
            ? attachment.sizes.thumbnail.url
            : attachment.url) +
          '" alt="" style="max-width:150px;height:auto;border-radius:50%;">'
      );
      if ($removeBtn.length === 0) {
        $(
          '<button type="button" class="button vitalisite-remove-btn" data-target="' +
            targetId +
            '">Supprimer</button>'
        ).insertAfter($(e.currentTarget));
      }
    });

    frame.open();
  });

  $(document).on("click", ".vitalisite-remove-btn", function (e) {
    e.preventDefault();
    var targetId = $(this).data("target");
    $("#" + targetId).val("");
    $("#" + targetId + "-preview").html("");
    $(this).remove();
  });

  /* ---- Hours table: toggle time inputs ---- */

  function toggleTimeInputs($checkbox) {
    var $row = $checkbox.closest("tr");
    var isChecked = $checkbox.is(":checked");
    $row.find('input[type="time"]').prop("disabled", isChecked);
    $row.toggleClass("vitalisite-day-disabled", isChecked);
  }

  // Init on page load.
  $(".vitalisite-day-closed").each(function () {
    toggleTimeInputs($(this));
  });

  // On change.
  $(document).on("change", ".vitalisite-day-closed", function () {
    toggleTimeInputs($(this));
  });
})(jQuery);
