const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const path = require("path");

module.exports = {
  ...defaultConfig,
  entry: {
    "slider/index": path.resolve(process.cwd(), "blocks", "slider", "index.js"),
  },
};
