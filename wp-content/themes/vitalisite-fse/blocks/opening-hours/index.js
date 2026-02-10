import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ToggleControl, TextareaControl, Disabled } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: function Edit({ attributes, setAttributes }) {
    const { showStatus, showEmergency, emergencyText } = attributes;
    const blockProps = useBlockProps({
      className: "vitalisite-opening-hours-block",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Réglages", "vitalisite-fse")}>
            <ToggleControl
              label={__("Afficher le statut ouvert/fermé", "vitalisite-fse")}
              checked={showStatus}
              onChange={(value) => setAttributes({ showStatus: value })}
            />
            <ToggleControl
              label={__("Afficher le message d'urgence", "vitalisite-fse")}
              checked={showEmergency}
              onChange={(value) => setAttributes({ showEmergency: value })}
            />
            {showEmergency && (
              <TextareaControl
                label={__("Texte d'urgence", "vitalisite-fse")}
                value={emergencyText}
                onChange={(value) => setAttributes({ emergencyText: value })}
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
