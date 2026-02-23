import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

export default function Edit({ attributes, setAttributes }) {
  const { title, description, price, buttonText, buttonUrl } = attributes;

  const blockProps = useBlockProps({
    className: "vitalisite-pricing-list-card",
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Bouton", "vitalisite-fse")}>
          <TextControl
            label={__("URL du bouton", "vitalisite-fse")}
            value={buttonUrl}
            onChange={(value) => setAttributes({ buttonUrl: value })}
          />
        </PanelBody>
      </InspectorControls>
      <div {...blockProps}>
        <div className="vitalisite-pricing-list-card__content">
          <RichText
            tagName="h3"
            value={title}
            onChange={(value) => setAttributes({ title: value })}
            placeholder={__("Titre du service...", "vitalisite-fse")}
          />
          <RichText
            tagName="p"
            className="vitalisite-pricing-list-card__description"
            value={description}
            onChange={(value) => setAttributes({ description: value })}
            placeholder={__("Description...", "vitalisite-fse")}
          />
        </div>
        <div className="vitalisite-pricing-list-card__action">
          <RichText
            tagName="p"
            className="vitalisite-pricing-list-card__price"
            value={price}
            onChange={(value) => setAttributes({ price: value })}
            placeholder="00€"
          />
          <div className="wp-block-button btn-primary">
            <RichText
              tagName="span"
              className="wp-block-button__link wp-element-button"
              value={buttonText}
              onChange={(value) => setAttributes({ buttonText: value })}
              placeholder={__("Texte du bouton...", "vitalisite-fse")}
            />
          </div>
        </div>
      </div>
    </>
  );
}
