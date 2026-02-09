(function (blocks, element, blockEditor) {
  var el = element.createElement;
  var InnerBlocks = blockEditor.InnerBlocks;
  var useBlockProps = blockEditor.useBlockProps;

  blocks.registerBlockType("vitalisite/accordion", {
    title: "Accordion Container",
    icon: "list-view",
    category: "vitalisite-accordion",
    attributes: {
      blockGap: {
        type: "string",
        default: "0",
      },
    },
    edit: function (props) {
      var blockProps = useBlockProps({
        className: "vitalisite-accordion-container",
      });

      return el(
        "div",
        blockProps,
        el(InnerBlocks, {
          allowedBlocks: ["vitalisite/accordion-item"],
          template: [["vitalisite/accordion-item", { summary: "Question ?" }]],
          templateLock: false,
        }),
      );
    },
    save: function (props) {
      var blockProps = useBlockProps.save({
        className: "vitalisite-accordion-container",
      });

      return el("div", blockProps, el(InnerBlocks.Content, {}));
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
