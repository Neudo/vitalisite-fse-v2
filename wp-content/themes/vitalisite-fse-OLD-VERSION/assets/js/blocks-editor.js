/**
 * Vitalisite FSE - Blocks Editor Scripts
 *
 * @package Vitalisite_FSE
 * @since 1.0.0
 */

(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { InspectorControls, useBlockProps } = wp.blockEditor;
  const { PanelBody, RangeControl, ToggleControl, SelectControl } =
    wp.components;
  const { __ } = wp.i18n;
  const { useSelect } = wp.data;
  const { Spinner } = wp.components;
  const el = wp.element.createElement;

  // Bloc Témoignages
  registerBlockType("vitalisite/testimonials", {
    title: __("Témoignages Vitalisite", "vitalisite-fse"),
    description: __("Affiche les témoignages patients", "vitalisite-fse"),
    category: "widgets",
    icon: "testimonial",
    keywords: ["testimonials", "témoignages", "avis", "patients"],
    supports: {
      html: false,
      align: ["wide", "full"],
    },
    attributes: {
      count: { type: "number", default: 3 },
      columns: { type: "number", default: 3 },
      showRating: { type: "boolean", default: true },
      showDate: { type: "boolean", default: false },
      layout: { type: "string", default: "grid" },
    },
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el(
        "div",
        blockProps,
        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: __("Paramètres", "vitalisite-fse") },
            el(RangeControl, {
              label: __("Nombre de témoignages", "vitalisite-fse"),
              value: attributes.count,
              onChange: (value) => setAttributes({ count: value }),
              min: 1,
              max: 12,
            }),
            el(RangeControl, {
              label: __("Colonnes", "vitalisite-fse"),
              value: attributes.columns,
              onChange: (value) => setAttributes({ columns: value }),
              min: 1,
              max: 4,
            }),
            el(ToggleControl, {
              label: __("Afficher les étoiles", "vitalisite-fse"),
              checked: attributes.showRating,
              onChange: (value) => setAttributes({ showRating: value }),
            }),
            el(ToggleControl, {
              label: __("Afficher la date", "vitalisite-fse"),
              checked: attributes.showDate,
              onChange: (value) => setAttributes({ showDate: value }),
            })
          )
        ),
        el(
          "div",
          { className: "vitalisite-block-preview" },
          el(
            "div",
            { className: "vitalisite-block-preview__icon" },
            el("span", { className: "dashicons dashicons-testimonial" })
          ),
          el("p", {}, __("Bloc Témoignages", "vitalisite-fse")),
          el(
            "small",
            {},
            attributes.count +
              " témoignages en " +
              attributes.columns +
              " colonnes"
          )
        )
      );
    },
    save: function () {
      return null; // Rendu côté serveur
    },
  });

  // Bloc Spécialités
  registerBlockType("vitalisite/specialities", {
    title: __("Spécialités Vitalisite", "vitalisite-fse"),
    description: __("Affiche les spécialités médicales", "vitalisite-fse"),
    category: "widgets",
    icon: "portfolio",
    keywords: ["specialities", "spécialités", "services"],
    supports: {
      html: false,
      align: ["wide", "full"],
    },
    attributes: {
      count: { type: "number", default: 6 },
      columns: { type: "number", default: 3 },
      showDescription: { type: "boolean", default: true },
      showIcon: { type: "boolean", default: true },
      showImage: { type: "boolean", default: false },
      linkToSingle: { type: "boolean", default: true },
    },
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el(
        "div",
        blockProps,
        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: __("Paramètres", "vitalisite-fse") },
            el(RangeControl, {
              label: __("Nombre de spécialités", "vitalisite-fse"),
              value: attributes.count,
              onChange: (value) => setAttributes({ count: value }),
              min: 1,
              max: 12,
            }),
            el(RangeControl, {
              label: __("Colonnes", "vitalisite-fse"),
              value: attributes.columns,
              onChange: (value) => setAttributes({ columns: value }),
              min: 1,
              max: 4,
            }),
            el(ToggleControl, {
              label: __("Afficher la description", "vitalisite-fse"),
              checked: attributes.showDescription,
              onChange: (value) => setAttributes({ showDescription: value }),
            }),
            el(ToggleControl, {
              label: __("Afficher l'icône", "vitalisite-fse"),
              checked: attributes.showIcon,
              onChange: (value) => setAttributes({ showIcon: value }),
            }),
            el(ToggleControl, {
              label: __("Afficher l'image", "vitalisite-fse"),
              checked: attributes.showImage,
              onChange: (value) => setAttributes({ showImage: value }),
            }),
            el(ToggleControl, {
              label: __("Lien vers la page", "vitalisite-fse"),
              checked: attributes.linkToSingle,
              onChange: (value) => setAttributes({ linkToSingle: value }),
            })
          )
        ),
        el(
          "div",
          { className: "vitalisite-block-preview" },
          el(
            "div",
            { className: "vitalisite-block-preview__icon" },
            el("span", { className: "dashicons dashicons-portfolio" })
          ),
          el("p", {}, __("Bloc Spécialités", "vitalisite-fse")),
          el(
            "small",
            {},
            attributes.count +
              " spécialités en " +
              attributes.columns +
              " colonnes"
          )
        )
      );
    },
    save: function () {
      return null;
    },
  });

  // Bloc Équipe
  registerBlockType("vitalisite/team", {
    title: __("Équipe Vitalisite", "vitalisite-fse"),
    description: __("Affiche l'équipe médicale", "vitalisite-fse"),
    category: "widgets",
    icon: "groups",
    keywords: ["team", "équipe", "doctors", "médecins"],
    supports: {
      html: false,
      align: ["wide", "full"],
    },
    attributes: {
      count: { type: "number", default: 4 },
      columns: { type: "number", default: 4 },
      showSpeciality: { type: "boolean", default: true },
      showPhone: { type: "boolean", default: false },
      showBookingButton: { type: "boolean", default: true },
      showOnlineStatus: { type: "boolean", default: true },
    },
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const blockProps = useBlockProps();

      return el(
        "div",
        blockProps,
        el(
          InspectorControls,
          {},
          el(
            PanelBody,
            { title: __("Paramètres", "vitalisite-fse") },
            el(RangeControl, {
              label: __("Nombre de membres", "vitalisite-fse"),
              value: attributes.count,
              onChange: (value) => setAttributes({ count: value }),
              min: 1,
              max: 12,
            }),
            el(RangeControl, {
              label: __("Colonnes", "vitalisite-fse"),
              value: attributes.columns,
              onChange: (value) => setAttributes({ columns: value }),
              min: 1,
              max: 4,
            }),
            el(ToggleControl, {
              label: __("Afficher la spécialité", "vitalisite-fse"),
              checked: attributes.showSpeciality,
              onChange: (value) => setAttributes({ showSpeciality: value }),
            }),
            el(ToggleControl, {
              label: __("Afficher le téléphone", "vitalisite-fse"),
              checked: attributes.showPhone,
              onChange: (value) => setAttributes({ showPhone: value }),
            }),
            el(ToggleControl, {
              label: __("Afficher le bouton RDV", "vitalisite-fse"),
              checked: attributes.showBookingButton,
              onChange: (value) => setAttributes({ showBookingButton: value }),
            }),
            el(ToggleControl, {
              label: __("Afficher le statut en ligne", "vitalisite-fse"),
              checked: attributes.showOnlineStatus,
              onChange: (value) => setAttributes({ showOnlineStatus: value }),
            })
          )
        ),
        el(
          "div",
          { className: "vitalisite-block-preview" },
          el(
            "div",
            { className: "vitalisite-block-preview__icon" },
            el("span", { className: "dashicons dashicons-groups" })
          ),
          el("p", {}, __("Bloc Équipe", "vitalisite-fse")),
          el(
            "small",
            {},
            attributes.count + " membres en " + attributes.columns + " colonnes"
          )
        )
      );
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
