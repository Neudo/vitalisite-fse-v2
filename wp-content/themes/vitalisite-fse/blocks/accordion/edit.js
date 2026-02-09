import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import "./editor.scss";

const ALLOWED_BLOCKS = ["vitalisite-fse/accordion-item"];

const TEMPLATE = [
  ["vitalisite-fse/accordion-item", { summary: "Question 1 ?" }],
  ["vitalisite-fse/accordion-item", { summary: "Question 2 ?" }],
];

const VARIANT_CLASSES = {
  simple: "vitalisite-accordion-container",
  legacy: "vitalisite-accordion-container vitalisite-accordion-variant-legacy",
};

export default function Edit({ attributes, setAttributes }) {
  const { variant } = attributes;

  const blockProps = useBlockProps({
    className: VARIANT_CLASSES[variant] || VARIANT_CLASSES.simple,
  });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Style de l'accordéon", "vitalisite-fse")}>
          <SelectControl
            label={__("Variante", "vitalisite-fse")}
            value={variant}
            options={[
              {
                label: __("Simple (minimaliste)", "vitalisite-fse"),
                value: "simple",
              },
              {
                label: __("Boxed (coloré)", "vitalisite-fse"),
                value: "legacy",
              },
            ]}
            onChange={(value) => setAttributes({ variant: value })}
          />
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        <InnerBlocks
          allowedBlocks={ALLOWED_BLOCKS}
          template={TEMPLATE}
          templateLock={false}
          renderAppender={InnerBlocks.ButtonBlockAppender}
        />
      </div>
    </>
  );
}
