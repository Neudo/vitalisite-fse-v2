import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
} from "@wordpress/block-editor";
import { PanelBody, ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import "./editor.scss";

const TEMPLATE = [
  [
    "core/columns",
    { verticalAlignment: "center" },
    [
      [
        "core/column",
        { width: "50%" },
        [
          ["core/heading", { level: 2, content: "Titre de la section" }],
          [
            "core/paragraph",
            {
              content:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            },
          ],
          ["core/buttons", {}, [["core/button", { text: "En savoir plus" }]]],
        ],
      ],
      [
        "core/column",
        { width: "50%" },
        [
          [
            "core/image",
            {
              sizeSlug: "large",
              className: "vitalisite-rounded-image",
            },
          ],
        ],
      ],
    ],
  ],
];

export default function Edit({ attributes, setAttributes }) {
  const { reversed, hasBackground } = attributes;

  const classes = [
    "vitalisite-text-image",
    "vitalisite-section",
    reversed ? "is-reversed" : "",
    hasBackground ? "has-background" : "",
  ]
    .filter(Boolean)
    .join(" ");

  const blockProps = useBlockProps({ className: classes });

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Mise en page", "vitalisite-fse")}>
          <ToggleControl
            label={__("Inverser l'ordre", "vitalisite-fse")}
            help={
              reversed
                ? __("Image à gauche, texte à droite", "vitalisite-fse")
                : __("Texte à gauche, image à droite", "vitalisite-fse")
            }
            checked={reversed}
            onChange={(value) => setAttributes({ reversed: value })}
          />
          <ToggleControl
            label={__("Afficher un fond", "vitalisite-fse")}
            help={
              hasBackground
                ? __("Fond coloré avec padding", "vitalisite-fse")
                : __("Pas de fond", "vitalisite-fse")
            }
            checked={hasBackground}
            onChange={(value) => setAttributes({ hasBackground: value })}
          />
        </PanelBody>
      </InspectorControls>

      <section {...blockProps}>
        <InnerBlocks template={TEMPLATE} />
      </section>
    </>
  );
}
