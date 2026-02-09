import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const { title, description, ctaText, ctaUrl } = attributes;

  const blockProps = useBlockProps({
    className: "vitalisite-card",
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Paramètres du bouton", "vitalisite-fse")}>
          <TextControl
            label={__("Lien du bouton", "vitalisite-fse")}
            value={ctaUrl}
            onChange={(value) => setAttributes({ ctaUrl: value })}
            help={__("Ex: /services ou https://…", "vitalisite-fse")}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <RichText
          tagName="h3"
          className="wp-block-heading"
          style={{ fontWeight: "300" }}
          value={title}
          onChange={(value) => setAttributes({ title: value })}
          placeholder={__("Titre...", "vitalisite-fse")}
        />
        <RichText
          tagName="p"
          value={description}
          onChange={(value) => setAttributes({ description: value })}
          placeholder={__("Description...", "vitalisite-fse")}
        />
        <div className="wp-block-buttons">
          <div className="wp-block-button is-style-outline">
            <RichText
              tagName="a"
              className="wp-block-button__link"
              value={ctaText}
              onChange={(value) => setAttributes({ ctaText: value })}
              placeholder={__("Texte bouton", "vitalisite-fse")}
            />
          </div>
        </div>
      </div>
    </>
  );
}
