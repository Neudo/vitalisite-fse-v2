# Story 1.1: Bundle Swiper.js Library

Status: ready-for-dev

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a theme developer,
I want Swiper.js 12.1.0 bundled in the theme,
So that slider and carousel patterns can function without external CDN dependencies.

## Acceptance Criteria

1. **Given** the theme is installed
   **When** I check `/assets/js/vendor/` directory
   **Then** I should find `swiper.min.js` (version 12.1.0)
   **And** the file should be enqueued in `functions.php` with proper dependencies
   **And** versioning should use `VITALISITE_FSE_VERSION` constant

2. **Given** a page with a slider pattern
   **When** the page loads
   **Then** Swiper.js should be loaded from the theme directory (not CDN)
   **And** no console errors should appear

## Tasks / Subtasks

- [ ] Task 1: Download and Bundle Swiper.js 12.1.0
  - [ ] Create directory `assets/js/vendor/` if it doesn't exist
  - [ ] Download Swiper 12.1.0 minified JS
  - [ ] Download Swiper 12.1.0 minified CSS (if applicable/needed for base styles)
  - [ ] Place files in `assets/js/vendor/swiper.min.js` and `assets/styles/vendor/swiper.min.css` (or similar)

- [ ] Task 2: Enqueue Swiper Assets
  - [ ] Register `swiper-js` in `functions.php` pointing to local file
  - [ ] Register `swiper-css` in `functions.php` pointing to local file
  - [ ] Ensure enqueue uses `VITALISITE_FSE_VERSION` constant for versioning
  - [ ] Create a test shortcode or temp pattern to verify loading

- [ ] Task 3: Verify Implementation
  - [ ] Check browser console for network requests (ensure 200 OK for swiper files)
  - [ ] Check version number in page source matches 12.1.0 (or theme version)
  - [ ] Ensure no console errors related to Swiper

## Dev Notes

- **Architecture:**
  - File path: `wp-content/themes/vitalisite-fse/assets/js/vendor/`
  - Enqueue logic: `wp-content/themes/vitalisite-fse/functions.php`
  - Version constant: `VITALISITE_FSE_VERSION` (defined in functions.php)

- **Source:**
  - Swiper CDN or official repo for 12.1.0 assets.

- **Testing:**
  - Manual verification via browser dev tools (Network tab).
  - Simple console log test: `console.log(Swiper)` to verify global object availability.

### Project Structure Notes

- Alignment with unified project structure (paths, modules, naming).
- **Compliance:** `assets/js/vendor` is the correct location for third-party libs.

### References

- [Epic 1: Block Patterns Migration](_bmad-output/planning-artifacts/epics.md#epic-1-block-patterns-migration-priorité-1)
- [Story 1.1 Criteria](_bmad-output/planning-artifacts/epics.md#story-11-bundle-swiperjs-library)

## Dev Agent Record

### Agent Model Used

Antigravity (simulated create-story)

### Debug Log References

- None

### Completion Notes List

- Story file generated from Epic 1.

### File List

- `assets/js/vendor/swiper.min.js` (New)
- `functions.php` (Modify)
