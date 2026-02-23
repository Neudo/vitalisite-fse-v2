import { useBlockProps, RichText } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { title, description, price, buttonText, buttonUrl } = attributes;

  const blockProps = useBlockProps.save({
    className: "vitalisite-pricing-list-card",
  });

  return (
    <div {...blockProps}>
      <div className="vitalisite-pricing-list-card__content">
        <RichText.Content tagName="h3" value={title} />
        <RichText.Content
          tagName="p"
          className="vitalisite-pricing-list-card__description"
          value={description}
        />
      </div>
      <div className="vitalisite-pricing-list-card__action">
        <RichText.Content
          tagName="p"
          className="vitalisite-pricing-list-card__price"
          value={price}
        />
        <div className="wp-block-button btn-primary">
          <a
            className="wp-block-button__link wp-element-button"
            href={buttonUrl}
          >
            <RichText.Content value={buttonText} />
          </a>
        </div>
      </div>
    </div>
  );
}
