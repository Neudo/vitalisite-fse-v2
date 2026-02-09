import { useBlockProps, RichText } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { title, description, ctaText, ctaUrl } = attributes;

  const blockProps = useBlockProps.save({
    className: "vitalisite-card",
  });

  return (
    <div {...blockProps}>
      {title && (
        <RichText.Content
          tagName="h3"
          className="wp-block-heading"
          style={{ fontWeight: "300" }}
          value={title}
        />
      )}
      {description && (
        <RichText.Content
          tagName="p"
          value={description}
        />
      )}
      {ctaText && (
        <div className="wp-block-buttons">
          <div className="wp-block-button is-style-outline">
            <a className="wp-block-button__link" href={ctaUrl}>
              {ctaText}
            </a>
          </div>
        </div>
      )}
    </div>
  );
}
