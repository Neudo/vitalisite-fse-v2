import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { reversed, hasBackground } = attributes;

  const classes = [
    "vitalisite-text-image",
    "vitalisite-section",
    reversed ? "is-reversed" : "",
    hasBackground ? "has-background" : "",
  ]
    .filter(Boolean)
    .join(" ");

  const blockProps = useBlockProps.save({ className: classes });

  return (
    <section {...blockProps}>
      <InnerBlocks.Content />
    </section>
  );
}
