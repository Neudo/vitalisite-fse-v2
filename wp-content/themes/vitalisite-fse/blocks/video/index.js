import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  MediaUpload,
  MediaUploadCheck,
} from "@wordpress/block-editor";
import {
  PanelBody,
  SelectControl,
  TextControl,
  Button,
  Disabled,
} from "@wordpress/components";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import metadata from "./block.json";

registerBlockType(metadata.name, {
  edit: function Edit({ attributes, setAttributes }) {
    const {
      videoType,
      youtubeUrl,
      videoId,
      videoUrl,
      posterUrl,
      posterId,
      aspectRatio,
    } = attributes;
    const blockProps = useBlockProps({
      className: "vitalisite-video-block",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Source vidéo", "vitalisite-fse")}>
            <SelectControl
              label={__("Type de vidéo", "vitalisite-fse")}
              value={videoType}
              options={[
                { label: "YouTube", value: "youtube" },
                { label: __("Upload", "vitalisite-fse"), value: "upload" },
              ]}
              onChange={(value) => setAttributes({ videoType: value })}
            />

            {videoType === "youtube" && (
              <TextControl
                label={__("URL YouTube", "vitalisite-fse")}
                value={youtubeUrl}
                onChange={(value) => setAttributes({ youtubeUrl: value })}
                placeholder="https://www.youtube.com/watch?v=..."
              />
            )}

            {videoType === "upload" && (
              <MediaUploadCheck>
                <MediaUpload
                  onSelect={(media) =>
                    setAttributes({ videoId: media.id, videoUrl: media.url })
                  }
                  allowedTypes={["video"]}
                  value={videoId}
                  render={({ open }) => (
                    <>
                      <Button
                        onClick={open}
                        variant="secondary"
                        className="editor-media-placeholder__button"
                      >
                        {videoUrl
                          ? __("Changer la vidéo", "vitalisite-fse")
                          : __("Choisir une vidéo", "vitalisite-fse")}
                      </Button>
                      {videoUrl && (
                        <p
                          style={{
                            marginTop: "8px",
                            fontSize: "12px",
                            wordBreak: "break-all",
                          }}
                        >
                          {videoUrl}
                        </p>
                      )}
                    </>
                  )}
                />
              </MediaUploadCheck>
            )}
          </PanelBody>

          <PanelBody
            title={__("Réglages", "vitalisite-fse")}
            initialOpen={false}
          >
            <SelectControl
              label={__("Ratio", "vitalisite-fse")}
              value={aspectRatio}
              options={[
                { label: "16:9", value: "16/9" },
                { label: "4:3", value: "4/3" },
                { label: "1:1", value: "1/1" },
                { label: "9:16", value: "9/16" },
              ]}
              onChange={(value) => setAttributes({ aspectRatio: value })}
            />

            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) =>
                  setAttributes({ posterId: media.id, posterUrl: media.url })
                }
                allowedTypes={["image"]}
                value={posterId}
                render={({ open }) => (
                  <>
                    <Button onClick={open} variant="secondary">
                      {posterUrl
                        ? __("Changer le poster", "vitalisite-fse")
                        : __("Ajouter un poster", "vitalisite-fse")}
                    </Button>
                    {posterUrl && (
                      <>
                        <img
                          src={posterUrl}
                          alt="poster"
                          style={{
                            marginTop: "8px",
                            maxWidth: "100%",
                            borderRadius: "4px",
                          }}
                        />
                        <Button
                          onClick={() =>
                            setAttributes({ posterId: 0, posterUrl: "" })
                          }
                          variant="link"
                          isDestructive
                          style={{ marginTop: "4px" }}
                        >
                          {__("Supprimer le poster", "vitalisite-fse")}
                        </Button>
                      </>
                    )}
                  </>
                )}
              />
            </MediaUploadCheck>
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <ServerSideRender
            block={metadata.name}
            attributes={attributes}
            key={JSON.stringify(attributes)}
          />
        </div>
      </>
    );
  },
  save: () => null,
});
