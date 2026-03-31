#!/usr/bin/env bash

set -euo pipefail

THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
THEME_SLUG="$(basename "$THEME_DIR")"
ZIP_BASENAME="vitalisite"
DIST_DIR="$THEME_DIR/dist"
TMP_DIR="$DIST_DIR/.tmp-export"
SKIP_BUILD=false

if [[ "${1:-}" == "--skip-build" ]]; then
  SKIP_BUILD=true
fi

STYLE_CSS="$THEME_DIR/style.css"

if [[ ! -f "$STYLE_CSS" ]]; then
  echo "style.css introuvable dans $THEME_DIR" >&2
  exit 1
fi

VERSION="$(
  sed -n 's/^Version:[[:space:]]*//p' "$STYLE_CSS" | head -n 1 | tr -d '\r'
)"

if [[ -z "$VERSION" ]]; then
  echo "Impossible de lire la version depuis style.css" >&2
  exit 1
fi

ZIP_NAME="${ZIP_BASENAME}-${VERSION}.zip"
ZIP_PATH="$DIST_DIR/$ZIP_NAME"

mkdir -p "$DIST_DIR"
rm -rf "$TMP_DIR"
mkdir -p "$TMP_DIR/$THEME_SLUG"

if [[ "$SKIP_BUILD" != true ]]; then
  if command -v pnpm >/dev/null 2>&1; then
    (cd "$THEME_DIR" && pnpm build)
  else
    echo "pnpm est requis pour lancer le build. Utilise --skip-build si le build est deja pret." >&2
    exit 1
  fi
fi

if [[ -f "$THEME_DIR/.distignore" ]]; then
  rsync -a --delete \
    --exclude-from="$THEME_DIR/.distignore" \
    "$THEME_DIR/" "$TMP_DIR/$THEME_SLUG/"
else
  rsync -a --delete "$THEME_DIR/" "$TMP_DIR/$THEME_SLUG/"
fi

find "$DIST_DIR" -maxdepth 1 -type f -name "${ZIP_BASENAME}-*.zip" ! -name "$ZIP_NAME" -delete
rm -f "$ZIP_PATH"

(
  cd "$TMP_DIR"
  zip -qr "$ZIP_PATH" "$THEME_SLUG"
)

rm -rf "$TMP_DIR"

echo "Export prod cree : $ZIP_PATH"
