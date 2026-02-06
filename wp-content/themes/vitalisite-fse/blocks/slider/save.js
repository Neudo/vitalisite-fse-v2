import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function save({ attributes }) {
  const { showNavigation, showPagination, autoplayDelay, enableLoop } =
    attributes;

  const blockProps = useBlockProps.save({
    className: "vitalisite-slider-wrapper",
  });

  return (
    <div {...blockProps}>
      <div
        className="vitalisite-slider swiper"
        data-show-navigation={showNavigation}
        data-show-pagination={showPagination}
        data-autoplay-delay={autoplayDelay}
        data-enable-loop={enableLoop}
      >
        <div className="swiper-wrapper">
          <InnerBlocks.Content />
        </div>
      </div>
    </div>
  );
}
