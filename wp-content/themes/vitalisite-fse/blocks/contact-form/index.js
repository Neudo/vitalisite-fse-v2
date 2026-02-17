import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";
import { Disabled, Placeholder } from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: function Edit({ attributes }) {
    const blockProps = useBlockProps({
      className: "vitalisite-contact-form-editor",
    });

    return (
      <div {...blockProps}>
        <Disabled>
          <ServerSideRender block={metadata.name} attributes={attributes} />
        </Disabled>
      </div>
    );
  },
  save: () => null,
});
