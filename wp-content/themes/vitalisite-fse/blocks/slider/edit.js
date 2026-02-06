import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, ToggleControl, RangeControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import "./editor.scss";

const ALLOWED_BLOCKS = ["core/image"];

const TEMPLATE = [
  ["core/image", { url: "", alt: __("Image 1", "vitalisite-fse") }],
  ["core/image", { url: "", alt: __("Image 2", "vitalisite-fse") }],
  ["core/image", { url: "", alt: __("Image 3", "vitalisite-fse") }],
  ["core/image", { url: "", alt: __("Image 4", "vitalisite-fse") }],
];

export default function Edit({ attributes, setAttributes }) {
  const { showNavigation, showPagination, autoplayDelay, enableLoop } =
    attributes;

  const blockProps = useBlockProps({
    className: "vitalisite-slider-wrapper",
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Paramètres du slider", "vitalisite-fse")}>
          <ToggleControl
            label={__("Afficher la navigation", "vitalisite-fse")}
            checked={showNavigation}
            onChange={(value) => setAttributes({ showNavigation: value })}
            help={__("Afficher les flèches de navigation", "vitalisite-fse")}
          />
          <ToggleControl
            label={__("Afficher la pagination", "vitalisite-fse")}
            checked={showPagination}
            onChange={(value) => setAttributes({ showPagination: value })}
            help={__("Afficher les points de pagination", "vitalisite-fse")}
          />
          <ToggleControl
            label={__("Activer la boucle", "vitalisite-fse")}
            checked={enableLoop}
            onChange={(value) => setAttributes({ enableLoop: value })}
            help={__(
              "Revenir au début quand la dernière image est atteinte",
              "vitalisite-fse",
            )}
          />
          <RangeControl
            label={__("Délai autoplay (ms)", "vitalisite-fse")}
            value={autoplayDelay}
            onChange={(value) => setAttributes({ autoplayDelay: value })}
            min={1000}
            max={10000}
            step={500}
            help={__(
              "Temps en millisecondes entre chaque slide",
              "vitalisite-fse",
            )}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <div className="vitalisite-slider swiper">
          <div className="swiper-wrapper editor-preview">
            <InnerBlocks
              allowedBlocks={ALLOWED_BLOCKS}
              template={TEMPLATE}
              templateLock={false}
              renderAppender={InnerBlocks.ButtonBlockAppender}
            />
          </div>

          {showNavigation && (
            <>
              <div className="swiper-button-next"></div>
              <div className="swiper-button-prev"></div>
            </>
          )}

          {showPagination && <div className="swiper-pagination"></div>}
        </div>
      </div>
    </>
  );
}
