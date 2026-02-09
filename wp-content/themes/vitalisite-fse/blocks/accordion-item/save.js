import { useBlockProps, RichText, InnerBlocks } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { summary } = attributes;

  const blockProps = useBlockProps.save({
    className: "vitalisite-accordion-item",
  });

  return (
    <details {...blockProps}>
      <RichText.Content tagName="summary" value={summary} />
      <div
        className="wp-block-group"
        style={{ padding: "var(--wp--preset--spacing--40)" }}
      >
        <InnerBlocks.Content />
      </div>
    </details>
  );
}
