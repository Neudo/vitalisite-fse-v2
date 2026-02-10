import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import { PanelBody, TextControl, ToggleControl, TextareaControl, Button, Disabled } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: function Edit({ attributes, setAttributes }) {
    const {
      beforeImageId, beforeImageUrl,
      afterImageId, afterImageUrl,
      beforeLabel, afterLabel, showLabels,
      showDisclaimer, disclaimerText,
    } = attributes;
    const blockProps = useBlockProps({
      className: "vitalisite-before-after-block",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Images", "vitalisite-fse")}>
            <p style={{ fontWeight: 600, marginBottom: "4px" }}>
              {__("Image Avant", "vitalisite-fse")}
            </p>
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) =>
                  setAttributes({ beforeImageId: media.id, beforeImageUrl: media.url })
                }
                allowedTypes={["image"]}
                value={beforeImageId}
                render={({ open }) => (
                  <>
                    <Button onClick={open} variant="secondary">
                      {beforeImageUrl
                        ? __("Changer", "vitalisite-fse")
                        : __("Choisir une image", "vitalisite-fse")}
                    </Button>
                    {beforeImageUrl && (
                      <img
                        src={beforeImageUrl}
                        alt="before"
                        style={{ marginTop: "8px", maxWidth: "100%", borderRadius: "4px" }}
                      />
                    )}
                  </>
                )}
              />
            </MediaUploadCheck>

            <p style={{ fontWeight: 600, marginBottom: "4px", marginTop: "16px" }}>
              {__("Image Après", "vitalisite-fse")}
            </p>
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) =>
                  setAttributes({ afterImageId: media.id, afterImageUrl: media.url })
                }
                allowedTypes={["image"]}
                value={afterImageId}
                render={({ open }) => (
                  <>
                    <Button onClick={open} variant="secondary">
                      {afterImageUrl
                        ? __("Changer", "vitalisite-fse")
                        : __("Choisir une image", "vitalisite-fse")}
                    </Button>
                    {afterImageUrl && (
                      <img
                        src={afterImageUrl}
                        alt="after"
                        style={{ marginTop: "8px", maxWidth: "100%", borderRadius: "4px" }}
                      />
                    )}
                  </>
                )}
              />
            </MediaUploadCheck>
          </PanelBody>

          <PanelBody title={__("Étiquettes", "vitalisite-fse")} initialOpen={false}>
            <ToggleControl
              label={__("Afficher les étiquettes", "vitalisite-fse")}
              checked={showLabels}
              onChange={(value) => setAttributes({ showLabels: value })}
            />
            {showLabels && (
              <>
                <TextControl
                  label={__("Label Avant", "vitalisite-fse")}
                  value={beforeLabel}
                  onChange={(value) => setAttributes({ beforeLabel: value })}
                />
                <TextControl
                  label={__("Label Après", "vitalisite-fse")}
                  value={afterLabel}
                  onChange={(value) => setAttributes({ afterLabel: value })}
                />
              </>
            )}
          </PanelBody>

          <PanelBody title={__("Avis de non-responsabilité", "vitalisite-fse")} initialOpen={false}>
            <ToggleControl
              label={__("Afficher l'avis", "vitalisite-fse")}
              checked={showDisclaimer}
              onChange={(value) => setAttributes({ showDisclaimer: value })}
            />
            {showDisclaimer && (
              <TextareaControl
                label={__("Texte", "vitalisite-fse")}
                value={disclaimerText}
                onChange={(value) => setAttributes({ disclaimerText: value })}
              />
            )}
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <Disabled>
            <ServerSideRender
              block={metadata.name}
              attributes={attributes}
            />
          </Disabled>
        </div>
      </>
    );
  },
  save: () => null,
});
