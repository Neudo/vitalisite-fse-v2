const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");
const CopyWebpackPlugin = require("copy-webpack-plugin");

const blocks = [
  "slider",
  "cards-container",
  "card",
  "accordion",
  "accordion-item",
  "text-image",
  "testimonials",
  "video",
  "before-after",
  "opening-hours",
  "contact-form",
];

module.exports = {
  ...defaultConfig,
  entry: Object.fromEntries(
    blocks.map((block) => [
      `${block}/index`,
      path.resolve(process.cwd(), "blocks", block, "index.js"),
    ]),
  ),
  plugins: [
    ...(defaultConfig.plugins || []),
    new CopyWebpackPlugin({
      patterns: blocks.map((block) => ({
        from: path.resolve(process.cwd(), "blocks", block, "block.json"),
        to: path.resolve(process.cwd(), "build", block, "block.json"),
      })),
    }),
  ],
};
