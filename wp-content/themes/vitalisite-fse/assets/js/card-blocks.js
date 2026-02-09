(function (blocks, element, blockEditor, components) {
  var el = element.createElement;
  var InnerBlocks = blockEditor.InnerBlocks;
  var useBlockProps = blockEditor.useBlockProps;
  var RichText = blockEditor.RichText;
  var InspectorControls = blockEditor.InspectorControls;
  var PanelBody = components.PanelBody;
  var TextControl = components.TextControl;

  // --- Card Container Block ---
  blocks.registerBlockType("vitalisite/cards-container", {
    title: "Cards Container",
    icon: "grid-view",
    category: "vitalisite-cards",
    description: "A grid container for Vitalisite Cards.",
    keywords: ["grid", "cards", "service"],
    edit: function (props) {
      var blockProps = useBlockProps({ className: "vitalisite-cards-grid" });

      return el(
        "div",
        blockProps,
        el(InnerBlocks, {
          allowedBlocks: ["vitalisite/card"],
          template: [
            [
              "vitalisite/card",
              {
                title: "Consultation",
                description: "Ut enim ad minim veniam...",
              },
            ],
            [
              "vitalisite/card",
              { title: "Urgences", description: "Duis aute irure dolor..." },
            ],
            [
              "vitalisite/card",
              { title: "Suivi", description: "Excepteur sint occaecat..." },
            ],
          ],
        }),
      );
    },
    save: function (props) {
      var blockProps = useBlockProps.save({
        className: "vitalisite-cards-grid",
      });
      return el("div", blockProps, el(InnerBlocks.Content, {}));
    },
  });

  // --- Single Card Block ---
  blocks.registerBlockType("vitalisite/card", {
    title: "Card",
    icon: "index-card",
    category: "vitalisite-cards",
    parent: ["vitalisite/cards-container"],
    attributes: {
      title: {
        type: "string",
        source: "html",
        selector: "h3",
        default: "Titre du service",
      },
      description: {
        type: "string",
        source: "html",
        selector: "p",
        default: "Description du service...",
      },
      ctaText: {
        type: "string",
        default: "En savoir plus",
        source: "html",
        selector: "a",
      },
      ctaUrl: {
        type: "string",
        default: "#",
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var blockProps = useBlockProps({ className: "vitalisite-card" });

      return [
        el(
          InspectorControls,
          { key: "inspector" },
          el(
            PanelBody,
            { title: "Paramètres du bouton" },
            el(TextControl, {
              label: "Lien du bouton",
              value: attributes.ctaUrl,
              onChange: function (value) {
                setAttributes({ ctaUrl: value });
              },
            }),
          ),
        ),
        el(
          "div",
          blockProps,
          el(RichText, {
            tagName: "h3",
            className: "wp-block-heading",
            style: { fontWeight: "300" },
            value: attributes.title,
            onChange: function (value) {
              setAttributes({ title: value });
            },
            placeholder: "Titre...",
          }),
          el(RichText, {
            tagName: "p",
            value: attributes.description,
            onChange: function (value) {
              setAttributes({ description: value });
            },
            placeholder: "Description...",
          }),
          el(
            "div",
            { className: "wp-block-buttons" },
            el(
              "div",
              { className: "wp-block-button is-style-outline" },
              el(RichText, {
                tagName: "a",
                className: "wp-block-button__link",
                value: attributes.ctaText,
                onChange: function (value) {
                  setAttributes({ ctaText: value });
                },
                placeholder: "Texte bouton",
                keepPlaceholderOnFocus: true,
              }),
            ),
          ),
        ),
      ];
    },
    save: function (props) {
      var attributes = props.attributes;
      var blockProps = useBlockProps.save({ className: "vitalisite-card" });

      return el(
        "div",
        blockProps,
        attributes.title &&
          el(RichText.Content, {
            tagName: "h3",
            className: "wp-block-heading",
            style: { fontWeight: "300" },
            value: attributes.title,
          }),
        attributes.description &&
          el(RichText.Content, {
            tagName: "p",
            value: attributes.description,
          }),
        attributes.ctaText &&
          el(
            "div",
            { className: "wp-block-buttons" },
            el(
              "div",
              { className: "wp-block-button is-style-outline" },
              el(
                "a",
                {
                  className: "wp-block-button__link",
                  href: attributes.ctaUrl,
                },
                attributes.ctaText,
              ),
            ),
          ),
      );
    },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components,
);
