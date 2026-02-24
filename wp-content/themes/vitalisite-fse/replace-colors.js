const fs = require("fs");
const path = require("path");

const MAPPINGS = {
  "--wp--preset--color--base-soft": "--wp--preset--color--surface",
  "--wp--preset--color--base": "--wp--preset--color--bg",
  "--wp--preset--color--ink-soft": "--wp--preset--color--muted",
  "--wp--preset--color--ink": "--wp--preset--color--text",
  "--wp--preset--color--primary-foreground": "--wp--preset--color--on-primary",
  "--wp--preset--color--secondary-foreground":
    "--wp--preset--color--on-secondary",
  "has-base-soft-background-color": "has-surface-background-color",
  "has-base-background-color": "has-bg-background-color",
  "has-ink-soft-color": "has-muted-color",
  "has-ink-color": "has-text-color",
  "has-primary-foreground-color": "has-on-primary-color",
  "has-secondary-foreground-color": "has-on-secondary-color",
};

function processDirectory(dir) {
  const files = fs.readdirSync(dir);

  for (const file of files) {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);

    if (stat.isDirectory()) {
      processDirectory(fullPath);
    } else if (stat.isFile() && /\.(css|html|php|js)$/.test(file)) {
      let content = fs.readFileSync(fullPath, "utf8");
      let changed = false;

      for (const [oldVar, newVar] of Object.entries(MAPPINGS)) {
        if (content.includes(oldVar)) {
          content = content.replace(new RegExp(oldVar, "g"), newVar);
          changed = true;
        }
      }

      if (changed) {
        fs.writeFileSync(fullPath, content);
        console.log(`Updated: ${fullPath}`);
      }
    }
  }
}

const themeDir =
  "/Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/wp-content/themes/vitalisite-fse";
const targetDirs = [
  "assets/styles",
  "templates",
  "patterns",
  "parts",
  "blocks",
];

for (const dir of targetDirs) {
  processDirectory(path.join(themeDir, dir));
}

console.log("Replacement complete.");
