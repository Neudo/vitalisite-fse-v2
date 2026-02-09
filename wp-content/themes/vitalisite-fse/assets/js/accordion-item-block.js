(function (blocks, element, blockEditor) {
  var el = element.createElement;
  var InnerBlocks = blockEditor.InnerBlocks;
  var useBlockProps = blockEditor.useBlockProps;
  var RichText = blockEditor.RichText;

  blocks.registerBlockType("vitalisite/accordion-item", {
    title: "Accordion Item",
    icon: "arrow-down-alt2",
    category: "vitalisite-accordion",
    parent: ["vitalisite/accordion"],
    attributes: {
      summary: {
        type: "string",
        source: "html",
        selector: "summary",
        default: "Question ?",
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;
      var blockProps = useBlockProps({
        className: "vitalisite-accordion-item",
      });

      return el(
        "details",
        blockProps,
        el(RichText, {
          tagName: "summary",
          value: attributes.summary,
          onChange: function (value) {
            setAttributes({ summary: value });
          },
          placeholder: "Question du FAQ...",
          keepPlaceholderOnFocus: true,
        }),
        el(
          "div",
          { className: "vitalisite-accordion-content" },
          el(InnerBlocks, {
            template: [["core/paragraph", { content: "Réponse..." }]],
          }),
        ),
      );
    },
    save: function (props) {
      var attributes = props.attributes;
      var blockProps = useBlockProps.save({
        className: "vitalisite-accordion-item",
      });

      return el(
        "details",
        blockProps,
        el(RichText.Content, {
          tagName: "summary",
          value: attributes.summary,
        }),
        el(
          "div",
          {
            className: "wp-block-group",
            style: { padding: "var(--wp--preset--spacing--40)" },
          },
          el(InnerBlocks.Content, {}),
        ),
      );
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
