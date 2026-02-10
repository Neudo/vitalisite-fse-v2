import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
  PanelBody,
  RangeControl,
  ToggleControl,
  Disabled,
} from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: function Edit({ attributes, setAttributes }) {
    const { count, showRating } = attributes;
    const blockProps = useBlockProps({
      className: "vitalisite-testimonials-carousel",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Réglages", "vitalisite-fse")}>
            <RangeControl
              label={__("Nombre de témoignages", "vitalisite-fse")}
              value={count}
              onChange={(value) => setAttributes({ count: value })}
              min={1}
              max={12}
            />
            <ToggleControl
              label={__("Afficher les étoiles", "vitalisite-fse")}
              checked={showRating}
              onChange={(value) => setAttributes({ showRating: value })}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <Disabled>
            <ServerSideRender block={metadata.name} attributes={attributes} />
          </Disabled>
        </div>
      </>
    );
  },
  save: () => null,
});
