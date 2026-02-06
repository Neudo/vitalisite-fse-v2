---
stepsCompleted: ["step-01-validate-prerequisites", "step-02-design-epics"]
inputDocuments:
  - "/Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/_bmad-output/planning-artifacts/prd.md"
  - "/Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/_bmad-output/planning-artifacts/architecture.md"
---

# wordpress-vitalisite-v2-FSE - Epic Breakdown

## Overview

This document provides the complete epic and story breakdown for wordpress-vitalisite-v2-FSE, decomposing the requirements from the PRD and Architecture into implementable stories.

**User Priority:** Epic 1 (Block Patterns Migration) is the highest priority for immediate implementation.

## Requirements Inventory

### Functional Requirements

**FR1:** Migrate 15 Elementor widgets to FSE Block Patterns
**FR2:** Register 3 Custom Post Types (Doctors, Specialities, Testimonials) with custom meta fields
**FR3:** Implement CPT meta fields using Block Bindings API (WordPress 6.5+)
**FR4:** Create contact form block with AJAX submission and email notifications
**FR5:** Migrate Customizer options from Kirki to native WordPress Customizer API
**FR6:** Implement global settings (address, phone, email, booking link) via Customizer
**FR7:** Create opening hours system with detailed per-day configuration
**FR8:** Implement announcement banner system with enable/disable toggle
**FR9:** Create sticky mobile CTA bar with scroll-based animation
**FR10:** Implement Links Page (Linktree alternative) with custom template
**FR11:** Maintain Supabase license validation system
**FR12:** Create FSE templates for all page types (index, single-doctors, archive-doctors, single-specialities, archive-specialities, template-links-list)
**FR13:** Create template parts (header, footer, sticky-cta)
**FR14:** Implement theme.json with complete design system (colors, typography, spacing)
**FR15:** Bundle Swiper.js 12.1.0 for sliders and carousels

### Non-Functional Requirements

**NFR1:** Zero plugin dependencies - all functionality built into theme
**NFR2:** WCAG 2.1 AA accessibility compliance
**NFR3:** RGAA 4.1 compliance (French accessibility standards)
**NFR4:** Mobile-first responsive design
**NFR5:** SEO-optimized semantic HTML
**NFR6:** Performance equal or better than V1 (Elementor-based)
**NFR7:** Optimized asset loading with minimal JavaScript
**NFR8:** Code in English, user-facing content in French
**NFR9:** Commercial product quality for healthcare professionals
**NFR10:** Easy migration path for V1 customers

### Additional Requirements

**From Architecture:**

- Use WordPress 6.0+ FSE capabilities (Block Patterns, Block Themes, Site Editor)
- PHP 7.4+ minimum requirement
- Implement Block Bindings API for CPT meta fields (WordPress 6.5+)
- Bundle Swiper.js 12.1.0 in `/assets/js/vendor/` (latest stable)
- Defer GSAP animations until after frontend is complete (POST-MVP)
- Use hybrid Customizer approach: theme.json for design tokens, native Customizer API for dynamic data
- Implement 4-step Setup Wizard for first-time theme activation (license, doctor info, customization, completion)
- Follow strict naming conventions: `vitalisite_` prefix for PHP functions/hooks/options, BEM-like CSS classes
- Organize code: `/inc/` for PHP classes, `/patterns/` for block patterns, `/templates/` for FSE templates, `/assets/` for CSS/JS
- Use WordPress block comment format for patterns (no HTML brut)
- Implement dev mode detection for cache clearing
- Create modular CSS files enqueued per component
- Use AJAX with nonces for form submissions

### FR Coverage Map

- **FR1:** Epic 1 - Migrer 15 widgets Elementor vers Block Patterns
- **FR2:** Epic 3 - Enregistrer 3 CPTs (Doctors, Specialities, Testimonials)
- **FR3:** Epic 3 - Implémenter meta fields CPT avec Block Bindings API
- **FR4:** Epic 5 - Créer formulaire de contact avec AJAX
- **FR5:** Epic 4 - Migrer Customizer de Kirki vers API native
- **FR6:** Epic 4 - Implémenter global settings via Customizer
- **FR7:** Epic 4 - Créer opening hours system
- **FR8:** Epic 6 - Implémenter announcement banner system
- **FR9:** Epic 6 - Créer sticky mobile CTA bar
- **FR10:** Epic 6 - Implémenter Links Page (Linktree alternative)
- **FR11:** Epic 7 - Maintenir Supabase license validation
- **FR12:** Epic 2 - Créer FSE templates pour tous types de pages
- **FR13:** Epic 2 - Créer template parts (header, footer, sticky-cta)
- **FR14:** Epic 2 - Implémenter theme.json avec design system complet
- **FR15:** Epic 1 - Bundler Swiper.js 12.1.0

## Epic List

### Epic 1: Block Patterns Migration (PRIORITÉ #1)

**User Outcome:** Les utilisateurs peuvent créer des pages complètes avec tous les composants visuels de V1 (15 widgets Elementor) en utilisant l'éditeur de blocs WordPress natif.

**FRs covered:** FR1, FR15

**Implementation Notes:**

- Migration des 15 widgets Elementor vers Block Patterns FSE
- Bundle Swiper.js 12.1.0 pour sliders/carousels
- Patterns: Hero (3-5 variations), Slider, Bento Grid, Accordion, Cards, Text+Image, Forms, Testimonials, Doctor Profiles, Before/After, Opening Hours, Video, Pricing
- CSS modulaire par composant (/assets/styles/)
- JavaScript modulaire (slider.js, accordion.js, forms.js)

### Epic 2: Theme Foundation & Design System

**User Outcome:** Le thème a une base solide FSE avec un design system cohérent, permettant une personnalisation visuelle complète sans code.

**FRs covered:** FR14, FR12, FR13

**Implementation Notes:**

- Implémenter theme.json avec design system complet (couleurs Vital Blue/Sky/Ink/Mist, typo Humanist Sans/Classique Serif, spacing)
- Créer templates FSE (index, single-doctors, archive-doctors, single-specialities, archive-specialities, template-links-list)
- Créer template parts (header, footer, sticky-cta)
- Structure de fichiers organisée (/inc/, /patterns/, /templates/, /assets/)

### Epic 3: Custom Post Types & Block Bindings

**User Outcome:** Les utilisateurs peuvent gérer des profils de docteurs, spécialités et témoignages avec des champs personnalisés affichables via l'éditeur de blocs.

**FRs covered:** FR2, FR3

**Implementation Notes:**

- Enregistrer 3 CPTs (Doctors, Specialities, Testimonials) dans /inc/cpt-registration.php
- Implémenter meta fields avec Block Bindings API (WordPress 6.5+) dans /inc/block-bindings.php
- Créer patterns pour afficher les CPTs (doctor-profile, testimonials carousel)
- Templates CPT (single-doctors.html, archive-doctors.html, single-specialities.html, archive-specialities.html)

### Epic 4: Customizer & Dynamic Content

**User Outcome:** Les utilisateurs peuvent configurer les informations de leur cabinet (adresse, téléphone, horaires) via le Customizer WordPress natif, affichées automatiquement dans les patterns.

**FRs covered:** FR5, FR6, FR7

**Implementation Notes:**

- Migrer de Kirki vers Customizer API native dans /inc/customizer.php
- Global settings (adresse, téléphone, email, booking link)
- Opening hours system (détaillé par jour avec toggle simple/détaillé)
- Intégration Customizer ↔ Patterns via `get_theme_mod()`

### Epic 5: Forms & AJAX System

**User Outcome:** Les utilisateurs peuvent recevoir des demandes de contact via un formulaire AJAX intégré, sans plugin externe.

**FRs covered:** FR4

**Implementation Notes:**

- Créer custom contact form block ou utiliser core/form (WP 6.8+)
- AJAX submission avec nonces dans /inc/ajax-handlers.php
- Email notifications via wp_mail()
- Spam protection
- JavaScript dans /assets/js/forms.js

### Epic 6: Advanced Features & Enhancements

**User Outcome:** Les utilisateurs bénéficient de fonctionnalités avancées (CTA sticky, bannière annonces, page liens) pour améliorer l'engagement et la conversion.

**FRs covered:** FR8, FR9, FR10

**Implementation Notes:**

- Announcement banner system (enable/disable toggle via Customizer)
- Sticky mobile CTA bar (scroll-based animation, template part sticky-cta.html)
- Links Page (Linktree alternative) avec template custom template-links-list.html
- Custom JS pour scroll behavior

### Epic 7: License System & Setup Wizard

**User Outcome:** Les nouveaux utilisateurs peuvent activer et configurer le thème facilement via un wizard guidé, avec validation de licence Supabase.

**FRs covered:** FR11

**Implementation Notes:**

- Maintenir Supabase license validation dans /inc/license.php
- Setup Wizard 4 étapes (license, doctor info, customization, done) dans /inc/setup-wizard.php
- Migration depuis OLD-VERSION
- Assets admin (wizard.css, wizard.js) dans /assets/admin/

## Epic 1: Block Patterns Migration

### Story 1.1: Bundle Swiper.js Library

As a theme developer,
I want Swiper.js 12.1.0 bundled in the theme,
So that slider and carousel patterns can function without external CDN dependencies.

**Acceptance Criteria:**

**Given** the theme is installed
**When** I check `/assets/js/vendor/` directory
**Then** I should find `swiper.min.js` (version 12.1.0)
**And** the file should be enqueued in `functions.php` with proper dependencies
**And** versioning should use `VITALISITE_FSE_VERSION` constant

**Given** a page with a slider pattern
**When** the page loads
**Then** Swiper.js should be loaded from the theme directory (not CDN)
**And** no console errors should appear

---

### Story 1.2: Hero Block Patterns (3-5 variations)

As a healthcare professional,
I want multiple hero section variations,
So that I can create impactful landing pages that match my brand.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I open the pattern inserter and search for "hero"
**Then** I should see 3-5 hero pattern variations (hero-banniere, hero-banniere-v2, hero-banniere-v3)
**And** each pattern should use `core/cover` + `core/buttons` blocks
**And** patterns should be in category `vitalisite-fse/hero`

**Given** I insert a hero pattern
**When** the pattern is rendered
**Then** it should display full-width with responsive images
**And** CTA buttons should be properly styled
**And** text should be readable with proper contrast (WCAG 2.1 AA)
**And** pattern should work on mobile, tablet, and desktop

**Given** a hero pattern file (e.g., `patterns/hero-banniere.php`)
**When** I view the file
**Then** it should have PHPDoc header with title, slug, description, categories
**And** it should use WordPress block comment format
**And** CSS should be in `/assets/styles/hero.css` and enqueued

---

### Story 1.3: Slider Block Pattern with Swiper

As a healthcare professional,
I want an image slider pattern,
So that I can showcase my clinic facilities or before/after photos.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "slider" in patterns
**Then** I should find `vitalisite-fse/slider` pattern
**And** pattern should use Swiper.js 12.1.0 for carousel functionality

**Given** I insert the slider pattern
**When** the page loads
**Then** images should slide automatically with smooth transitions
**And** navigation arrows should be visible and functional
**And** pagination dots should indicate current slide
**And** slider should be touch-enabled on mobile devices

**Given** the slider pattern file
**When** I view `patterns/slider.php`
**Then** it should have proper PHPDoc header
**And** JavaScript init code should be in `/assets/js/slider.js`
**And** CSS should be in `/assets/styles/slider.css`
**And** both files should be enqueued with Swiper.js as dependency

---

### Story 1.4: Bento Grid Block Pattern

As a healthcare professional,
I want a modern grid layout pattern,
So that I can display services or features in an organized, visually appealing way.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "bento" or "grid" in patterns
**Then** I should find `vitalisite-fse/bento-grid` pattern
**And** pattern should use `core/columns` + `core/group` blocks

**Given** I insert the bento grid pattern
**When** rendered on desktop
**Then** grid should display in asymmetric layout (bento style)
**And** grid items should have proper spacing and alignment

**Given** the pattern is viewed on mobile
**When** screen width is < 768px
**Then** grid should stack vertically
**And** maintain readability and visual hierarchy

**Given** the pattern file
**When** I view `patterns/bento-grid.php`
**Then** CSS should be in `/assets/styles/bento-grid.css`
**And** grid should use CSS Grid or Flexbox
**And** pattern should follow BEM naming (`.vitalisite-bento-grid`)

---

### Story 1.5: Accordion/Dropdown Block Pattern

As a healthcare professional,
I want an FAQ accordion pattern,
So that I can display frequently asked questions in a compact, user-friendly format.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "accordion" or "faq" in patterns
**Then** I should find `vitalisite-fse/accordion` pattern
**And** pattern should use `core/details` block (WordPress 6.3+) or custom implementation

**Given** I insert the accordion pattern
**When** a user clicks an accordion header
**Then** the content should expand smoothly
**And** only one accordion item should be open at a time (optional behavior)
**And** keyboard navigation should work (Enter/Space to toggle)

**Given** the accordion is rendered
**When** I test accessibility
**Then** ARIA attributes should be present (aria-expanded, aria-controls)
**And** screen readers should announce state changes
**And** focus indicators should be visible

**Given** the pattern file
**When** I view `patterns/accordion.php`
**Then** JavaScript should be in `/assets/js/accordion.js`
**And** CSS should be in `/assets/styles/accordion.css`
**And** animation should be smooth (CSS transitions)

---

### Story 1.6: Cards Block Pattern

As a healthcare professional,
I want service/team cards pattern,
So that I can showcase my services or team members in a grid layout.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "cards" in patterns
**Then** I should find `vitalisite-fse/cards` pattern
**And** pattern should use `core/columns` + `core/group` for card structure

**Given** I insert the cards pattern
**When** rendered
**Then** cards should display in responsive grid (3 columns desktop, 2 tablet, 1 mobile)
**And** each card should have image, title, description, and optional CTA button
**And** cards should have consistent height and spacing

**Given** a user hovers over a card
**When** on desktop
**Then** card should have subtle hover effect (shadow, transform, etc.)
**And** transition should be smooth

**Given** the pattern file
**When** I view `patterns/cards.php`
**Then** CSS should be in `/assets/styles/cards.css`
**And** cards should use BEM naming (`.vitalisite-card`, `.vitalisite-card__title`)

---

### Story 1.7: Text + Image Block Pattern

As a healthcare professional,
I want text and image combination patterns,
So that I can create engaging content sections with visual support.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "text image" in patterns
**Then** I should find `vitalisite-fse/text-image` pattern
**And** pattern should use `core/media-text` block

**Given** I insert the text+image pattern
**When** rendered
**Then** image and text should be side-by-side on desktop
**And** image should be above text on mobile (stacked)
**And** image should maintain aspect ratio
**And** text should be properly aligned and readable

**Given** the pattern
**When** I test responsiveness
**Then** layout should adapt smoothly across breakpoints
**And** images should be optimized (lazy loading)

**Given** the pattern file
**When** I view `patterns/text-image.php`
**Then** minimal custom CSS should be needed (leverage core blocks)
**And** any custom styles should be in `/assets/styles/text-image.css`

---

### Story 1.8: Contact Form Block Pattern

As a healthcare professional,
I want a contact form pattern,
So that patients can send me inquiries directly from my website.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "contact" or "form" in patterns
**Then** I should find `vitalisite-fse/contact-form` pattern
**And** pattern should use custom form block or `core/form` (WP 6.8+)

**Given** I insert the contact form pattern
**When** rendered
**Then** form should have fields: Name, Email, Phone, Message
**And** all fields should have proper labels and placeholders (French)
**And** Email field should validate email format
**And** Phone field should accept French phone format

**Given** a user submits the form
**When** all fields are valid
**Then** form should submit via AJAX (no page reload)
**And** success message should display
**And** form should be cleared after successful submission

**Given** form submission fails
**When** server returns error
**Then** error message should display
**And** form data should be preserved

**Given** the pattern file
**When** I view `patterns/contact-form.php`
**Then** JavaScript should be in `/assets/js/forms.js`
**And** CSS should be in `/assets/styles/forms.css`
**And** AJAX handler should be referenced (implemented in Epic 5)

---

### Story 1.9: Testimonials Block Pattern

As a healthcare professional,
I want a testimonials pattern,
So that I can display patient reviews to build trust.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "testimonials" in patterns
**Then** I should find `vitalisite-fse/testimonials` pattern
**And** pattern should use `core/quote` or custom blocks

**Given** I insert the testimonials pattern
**When** rendered
**Then** testimonials should display in grid or carousel format
**And** each testimonial should show quote, author name, and optional photo
**And** testimonials should be properly styled with quotation marks

**Given** testimonials are displayed as carousel
**When** page loads
**Then** carousel should auto-rotate every 5 seconds
**And** navigation controls should be visible
**And** carousel should pause on hover

**Given** the pattern file
**When** I view `patterns/testimonials.php`
**Then** CSS should be in `/assets/styles/testimonials.css`
**And** if carousel, JavaScript should use Swiper.js
**And** pattern should integrate with Testimonials CPT (Epic 3)

---

### Story 1.10: Doctor Presentation Block Pattern

As a healthcare professional,
I want a doctor profile pattern,
So that I can showcase my team's expertise and credentials.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "doctor" in patterns
**Then** I should find `vitalisite-fse/doctor-profile` pattern
**And** pattern should display doctor photo, name, specialty, and bio

**Given** I insert the doctor profile pattern
**When** rendered
**Then** doctor photo should be circular or rounded
**And** name should be prominent (heading)
**And** specialty should be displayed below name
**And** bio should be readable with proper typography

**Given** multiple doctors are displayed
**When** using grid layout
**Then** profiles should be consistent in height and spacing
**And** layout should be responsive (3 cols desktop, 2 tablet, 1 mobile)

**Given** the pattern file
**When** I view `patterns/doctor-profile.php`
**Then** CSS should be in `/assets/styles/doctor-profile.css`
**And** pattern should integrate with Doctors CPT via Query Loop (Epic 3)

---

### Story 1.11: Before/After Block Pattern

As a healthcare professional,
I want a before/after comparison pattern,
So that I can showcase treatment results visually.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "before after" in patterns
**Then** I should find `vitalisite-fse/before-after` pattern
**And** pattern should use Swiper.js for comparison slider

**Given** I insert the before/after pattern
**When** rendered
**Then** two images should be overlaid with draggable divider
**And** user can drag divider left/right to compare images
**And** divider should have visual indicator (handle)

**Given** the pattern is on mobile
**When** user touches divider
**Then** divider should follow touch movement smoothly
**And** images should update in real-time

**Given** the pattern file
**When** I view `patterns/before-after.php`
**Then** JavaScript should be in `/assets/js/before-after.js`
**And** CSS should be in `/assets/styles/before-after.css`
**And** Swiper.js effect should be used for comparison

---

### Story 1.12: Opening Hours Block Pattern

As a healthcare professional,
I want an opening hours pattern,
So that patients can see when my practice is open.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "hours" or "opening" in patterns
**Then** I should find `vitalisite-fse/opening-hours` pattern
**And** pattern should display weekly schedule

**Given** I insert the opening hours pattern
**When** rendered
**Then** each day of the week should be listed (Monday-Sunday)
**And** hours should be displayed for each day
**And** current day should be highlighted
**And** "Open Now" indicator should show if currently open

**Given** opening hours are configured in Customizer
**When** pattern is rendered
**Then** hours should be pulled from `get_theme_mod('vitalisite_opening_hours')`
**And** hours should update when Customizer settings change

**Given** the pattern file
**When** I view `patterns/opening-hours.php`
**Then** PHP logic should calculate "Open Now" status
**And** CSS should be in `/assets/styles/opening-hours.css`
**And** pattern should integrate with Customizer (Epic 4)

---

### Story 1.13: Video Embed Block Pattern

As a healthcare professional,
I want a video embed pattern,
So that I can showcase video content (YouTube, Vimeo, or uploaded videos).

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "video" in patterns
**Then** I should find `vitalisite-fse/video` pattern
**And** pattern should use `core/embed` + `core/video` blocks

**Given** I insert the video pattern with YouTube URL
**When** rendered
**Then** video should be embedded responsively (16:9 aspect ratio)
**And** video should be centered with proper spacing
**And** thumbnail should load before play (lazy loading)

**Given** I insert the video pattern with uploaded video
**When** rendered
**Then** video player should use native HTML5 controls
**And** video should be responsive
**And** poster image should be displayed before play

**Given** the pattern file
**When** I view `patterns/video.php`
**Then** minimal custom CSS should be needed
**And** any custom styles should be in `/assets/styles/video.css`
**And** pattern should support both embed and upload methods

---

### Story 1.14: Pricing Block Pattern

As a healthcare professional,
I want a pricing table pattern,
So that I can display my service prices clearly.

**Acceptance Criteria:**

**Given** I'm in the WordPress Block Editor
**When** I search for "pricing" in patterns
**Then** I should find `vitalisite-fse/pricing` pattern
**And** pattern should use `core/columns` for pricing cards

**Given** I insert the pricing pattern
**When** rendered
**Then** pricing cards should display in grid (3 columns desktop, 1 mobile)
**And** each card should show: service name, price, description, CTA button
**And** featured/recommended plan should be visually distinct

**Given** a user views pricing cards
**When** on desktop
**Then** cards should have equal height
**And** hover effect should highlight the card
**And** CTA buttons should be aligned at bottom

**Given** the pattern file
**When** I view `patterns/pricing.php`
**Then** CSS should be in `/assets/styles/pricing.css`
**And** pricing should use BEM naming (`.vitalisite-pricing`, `.vitalisite-pricing__card`)
**And** featured card should have modifier class (`.vitalisite-pricing__card--featured`)

