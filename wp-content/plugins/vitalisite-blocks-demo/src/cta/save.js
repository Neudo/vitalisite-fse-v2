/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({attributes}) {
	const {buttonText, buttonUrl, openInNewTab, variant} = attributes;


	const blockProps = useBlockProps.save({
    className: `vitalisite-cta vitalisite-cta--${variant}`
  });

	const target = openInNewTab ? "_blank" : undefined;
    const rel = openInNewTab ? "noopener noreferrer" : undefined;


	return (
    <div {...blockProps}>
        <a className="vitalisite-cta__button" href={buttonUrl || "#"} target={target} rel={rel}>
          {buttonText}
        </a>
    </div>
	);
}
