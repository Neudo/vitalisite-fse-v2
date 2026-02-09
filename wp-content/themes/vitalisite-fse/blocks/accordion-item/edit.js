import { useBlockProps, RichText, InnerBlocks } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
  const { summary } = attributes;

  const blockProps = useBlockProps({
    className: "vitalisite-accordion-item",
  });

  return (
    <details {...blockProps}>
      <RichText
        tagName="summary"
        value={summary}
        onChange={(value) => setAttributes({ summary: value })}
        placeholder={__("Question du FAQ...", "vitalisite-fse")}
      />
      <div className="vitalisite-accordion-content">
        <InnerBlocks
          template={[
            ["core/paragraph", { content: __("Réponse...", "vitalisite-fse") }],
          ]}
          templateLock="all"
        />
      </div>
    </details>
  );
}
