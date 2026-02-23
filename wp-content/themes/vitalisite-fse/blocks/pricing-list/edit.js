import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

const ALLOWED_BLOCKS = ["vitalisite-fse/pricing-item"];
const TEMPLATE = [
  ["vitalisite-fse/pricing-item", {}],
  ["vitalisite-fse/pricing-item", {}],
];

export default function Edit() {
  const blockProps = useBlockProps({
    className: "vitalisite-pricing-list",
  });

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
