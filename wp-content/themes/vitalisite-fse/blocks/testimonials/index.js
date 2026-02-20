import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
  PanelBody,
  RangeControl,
  ToggleControl,
  SelectControl,
  TextControl,
  ExternalLink,
  Disabled,
} from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: function Edit({ attributes, setAttributes }) {
    const {
      count,
      showRating,
      testimonials_source,
      show_google_header,
      googlePlaceId,
    } = attributes;
    const blockProps = useBlockProps({
      className: "vitalisite-testimonials-carousel",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Réglages", "vitalisite-fse")}>
            <SelectControl
              label={__("Source des témoignages", "vitalisite-fse")}
              value={testimonials_source}
              options={[
                {
                  label: __("Mes témoignages rédigés", "vitalisite-fse"),
                  value: "local",
                },
                {
                  label: __("Avis Google My Business", "vitalisite-fse"),
                  value: "google",
                },
              ]}
              onChange={(value) =>
                setAttributes({ testimonials_source: value })
              }
            />
            {testimonials_source === "local" && (
              <RangeControl
                label={__("Nombre de témoignages", "vitalisite-fse")}
                value={count}
                onChange={(value) => setAttributes({ count: value })}
                min={1}
                max={12}
              />
            )}
            <ToggleControl
              label={__("Afficher les étoiles", "vitalisite-fse")}
              checked={showRating}
              onChange={(value) => setAttributes({ showRating: value })}
            />
            {testimonials_source === "google" && (
              <>
                <ToggleControl
                  label={__("Afficher l'en-tête Google", "vitalisite-fse")}
                  checked={show_google_header}
                  onChange={(value) =>
                    setAttributes({ show_google_header: value })
                  }
                  help={__(
                    "Logo Google, note globale et boutons CTA",
                    "vitalisite-fse",
                  )}
                />
                <TextControl
                  label={__("Google Place ID", "vitalisite-fse")}
                  value={googlePlaceId}
                  onChange={(value) => setAttributes({ googlePlaceId: value })}
                  placeholder="ChIJ..."
                  help={
                    <>
                      {__(
                        "Comment trouver votre Google Place ID ? ",
                        "vitalisite-fse",
                      )}
                      <ExternalLink href="https://docs.vitalisite.fr/google-place-id">
                        {__("Documentation Vitalisite", "vitalisite-fse")}
                      </ExternalLink>
                    </>
                  }
                />
              </>
            )}
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
