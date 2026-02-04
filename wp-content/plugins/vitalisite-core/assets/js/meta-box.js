jQuery(document).ready(function ($) {
  if (document.getElementById("testimonial_comment")) {
    updateCharCount();
  }

  if (document.getElementById("add-link-row")) {
    repeaterLinks();
    toggleLinksListMetaBox();
  }
  let mediaUploader;
  $("#photo_button").click(function (e) {
    e.preventDefault();

    // Si le Media Uploader existe déjà, on l'ouvre
    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    // Sinon, on le crée
    mediaUploader = wp.media({
      title: "Choisissez une image",
      button: {
        text: "Utiliser cette image",
      },
      multiple: false,
    });

    // Quand une image est sélectionnée
    mediaUploader.on("select", function () {
      const attachment = mediaUploader
          .state()
          .get("selection")
          .first()
          .toJSON();
      $("#photo").val(attachment.id); // ID de l'image
      $("#photo_preview").attr("src", attachment.url).show();
      $("#photo_remove").show();
    });

    mediaUploader.open();
  });
  $("#photo_remove").click(function (e) {
    e.preventDefault();
    $("#photo").val("");
    $("#photo_preview").hide();
    $(this).hide();
  });

  function updateCharCount() {
    let textarea = document.getElementById("testimonial_comment");
    let count = textarea.value.length;

    document.getElementById("char-count").textContent =
        count + " / 300 caractères.";
    textarea.addEventListener("input", updateCharCount);
  }

  function repeaterLinks() {
    const addBtn = document.getElementById("add-link-row");
    const container = document.getElementById("repeater-links");

    let index = 1;

    addBtn.addEventListener("click", () => {
      const row = document.createElement("div");
      row.className = "repeater-row";
      row.style.marginBottom = "10px";
      row.innerHTML = `
                <input type="text" name="my_links[${index}][href]" placeholder="URL" >
                <input type="text" name="my_links[${index}][label]" placeholder="Label">
                <button type="button" class="remove-link-row">Supprimer</button>
            `;
      container.appendChild(row);
      index++;
    });

    container.addEventListener("click", function (e) {
      if (e.target.classList.contains("remove-link-row")) {
        e.target.parentNode.remove();
      }
    });
  }

  function toggleLinksListMetaBox() {
    const { subscribe, select } = wp.data;
    const metaBox = document.getElementById('links_list_meta');

    function toggleMetaBox() {
      const template = select('core/editor').getEditedPostAttribute('template');
      if (template === 'template-links-list.php') {
        metaBox && (metaBox.style.display = 'block');
      } else {
        metaBox && (metaBox.style.display = 'none');
      }
    }

    // Initial check
    toggleMetaBox();

    // Watch for template change
    subscribe(toggleMetaBox);

  }
});
