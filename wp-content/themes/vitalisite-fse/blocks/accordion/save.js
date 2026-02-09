import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

const VARIANT_CLASSES = {
  simple: "vitalisite-accordion-container",
  legacy: "vitalisite-accordion-container vitalisite-accordion-variant-legacy",
};

export default function save({ attributes }) {
  const { variant } = attributes;

  const blockProps = useBlockProps.save({
    className: VARIANT_CLASSES[variant] || VARIANT_CLASSES.simple,
  });

  return (
    <div {...blockProps}>
      <InnerBlocks.Content />
    </div>
  );
}
