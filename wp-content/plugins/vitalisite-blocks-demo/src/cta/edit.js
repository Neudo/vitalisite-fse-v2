/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import {
  PanelBody,
  TextControl,
  ToggleControl,
  SelectControl
} from "@wordpress/components";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	const {buttonText, buttonUrl, openInNewTab, variant } = attributes

  const blockProps = useBlockProps({
    className: `vitalisite-cta vitalisite-cta--${variant}`
  });

	return (
<>
      <InspectorControls>
        <PanelBody title={__("Réglages du CTA", "vitalisite")} initialOpen>
          <SelectControl
            label={__("Variante", "vitalisite")}
            value={variant}
            options={[
              { label: __("Primaire", "vitalisite"), value: "primary" },
              { label: __("Outline", "vitalisite"), value: "outline" }
            ]}
            onChange={(value) => setAttributes({ variant: value })}
          />

          <TextControl
            label={__("Texte du bouton", "vitalisite")}
            value={buttonText}
            onChange={(value) => setAttributes({ buttonText: value })}
          />

          <TextControl
            label={__("Lien du bouton", "vitalisite")}
            value={buttonUrl}
            onChange={(value) => setAttributes({ buttonUrl: value })}
            help={__("Ex: /services ou https://…", "vitalisite")}
          />

          <ToggleControl
            label={__("Ouvrir dans un nouvel onglet", "vitalisite")}
            checked={openInNewTab}
            onChange={(value) => setAttributes({ openInNewTab: value })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>


        {/* Bouton visuel dans l’éditeur (pas de navigation) */}
        <div className="vitalisite-cta__actions">
          <span className="vitalisite-cta__button" role="button">
            {buttonText || __("Me contacter", "vitalisite")}
          </span>
          {buttonUrl ? (
            <span className="vitalisite-cta__url">{buttonUrl}</span>
          ) : null}
        </div>
      </div>
    </>
	);
}
