import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import "./editor.scss";

const ALLOWED_BLOCKS = ["vitalisite-fse/card"];

const TEMPLATE = [
  [
    "vitalisite-fse/card",
    {
      title: "Consultation",
      description: "Ut enim ad minim veniam...",
    },
  ],
  [
    "vitalisite-fse/card",
    {
      title: "Urgences",
      description: "Duis aute irure dolor...",
    },
  ],
];

export default function Edit() {
  const blockProps = useBlockProps();

  return (
    <div {...blockProps}>
      <InnerBlocks
        allowedBlocks={ALLOWED_BLOCKS}
        template={TEMPLATE}
        templateLock={false}
        renderAppender={InnerBlocks.ButtonBlockAppender}
      />
    </div>
  );
}
