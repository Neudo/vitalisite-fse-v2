---
project_name: "wordpress-vitalisite-v2-FSE"
user_name: "Quentin"
date: "2026-02-03T20:31:25+01:00"
sections_completed: ["technology_stack"]
existing_patterns_found: 15
---

# Project Context for AI Agents

_This file contains critical rules and patterns that AI agents must follow when implementing code in this project. Focus on unobvious details that agents might otherwise miss._

---

## Product Context & Business Goals

### **CRITICAL: This is a Commercial Product**

**Product Type:** Premium WordPress FSE Theme for Healthcare Professionals

**Target Audience:**

- Healthcare professionals (doctors, clinics, therapists, etc.)
- Non-technical users who need to create professional websites
- French-speaking market (primary language)

**Business Model:**

- **Commercial theme** designed to be sold
- Customers purchase and customize for their own practices
- Must be **user-friendly** for non-developers

### **Design Philosophy (CRITICAL)**

This fundamentally changes how we build:

1. **End-User Autonomy**
   - ✅ Clients MUST be able to create their own pages without coding
   - ✅ Patterns MUST be intuitive and self-explanatory
   - ✅ Block editor experience MUST be simple and guided
   - ❌ NEVER create patterns that require code knowledge

2. **Professional Healthcare Context**
   - ✅ Use medical/healthcare appropriate vocabulary
   - ✅ Maintain professional, trustworthy aesthetic
   - ✅ Consider GDPR/healthcare data privacy in design decisions
   - ✅ Patterns should support typical healthcare use cases (appointments, services, team, testimonials)

3. **Commercial Quality Standards**
   - ✅ Premium quality code and design
   - ✅ Comprehensive documentation for end users
   - ✅ Robust error handling and validation
   - ✅ Accessibility compliance (WCAG)
   - ✅ Performance optimization
   - ❌ NO shortcuts or "good enough" solutions

4. **Pattern Design Principles**
   - ✅ Each pattern should be **complete and ready-to-use**
   - ✅ Provide **multiple variants** for flexibility
   - ✅ Include **helpful placeholder content** that guides users
   - ✅ Use **descriptive names** in the pattern inserter
   - ✅ Patterns should be **visually distinct** in the inserter

### **Content & Language Rules (CRITICAL)**

1. **Pattern Placeholder Content**
   - ✅ ALWAYS use **Lorem ipsum** for default text content in patterns
   - ✅ Use realistic healthcare-appropriate Lorem ipsum when possible
   - ✅ Example: "Lorem ipsum dolor sit amet, consectetur adipiscing elit..."
   - ❌ NEVER use real client data or specific medical information
   - ❌ NEVER use English placeholder text like "Your text here"

2. **Language Convention**
   - ✅ **Code/Technical**: English (file names, folder names, variable names, function names, CSS classes)
   - ✅ **User-Facing**: French (pattern titles, descriptions, placeholder text, UI labels, comments visible to users)
   - ✅ **Examples**:
     - File: `header-minimal.php` ✅
     - Pattern Title: "Header Minimal" ✅
     - Pattern Description: "En-tête épuré pour une apparence moderne" ✅
     - CSS Class: `.vitalisite-header__cta` ✅
     - Button Text (placeholder): "Prendre rendez-vous" ✅

3. **User-Facing Content Rules**
   - ✅ Use **simple, clear French** that non-technical users understand
   - ✅ Avoid technical jargon in pattern names and descriptions
   - ✅ Use healthcare-appropriate terminology
   - ❌ NEVER use terms like "div", "container", "wrapper" in user-facing text
   - ❌ NEVER use English in the WordPress admin/editor interface
   - ✅ **Good**: "Section d'en-tête avec fond coloré"
   - ❌ **Bad**: "Header container with background wrapper"

4. **PHPDoc Comments**
   - ✅ Title, Description, Keywords: **French** (user sees these)
   - ✅ Technical metadata (Slug, Categories, Block Types): **English** (WordPress internals)
   - ✅ Example:
     ```php
     /**
      * Title: En-tête Moderne avec Fond
      * Slug: vitalisite-fse/header-fond
      * Description: Un en-tête élégant avec arrière-plan coloré et bordures arrondies
      * Categories: vitalisite-header
      */
     ```

### **Impact on Development**

When creating new features, ALWAYS ask:

- Can a non-technical healthcare professional use this?
- Is it obvious what this pattern does?
- Does it require any coding knowledge?
- Is it appropriate for a medical/healthcare context?
- Does it meet commercial product quality standards?

---

## Accessibility & RGAA Compliance

### **CRITICAL: Accessibility is Mandatory**

As a commercial product for healthcare professionals, accessibility is both a legal requirement and a moral imperative.

### **Standards to Follow**

1. **WCAG 2.1 Level AA** (minimum)
   - ✅ All patterns MUST meet WCAG 2.1 AA standards
   - ✅ Aim for AAA where feasible
   - ✅ Test with automated tools (WAVE, axe DevTools)

2. **RGAA 4.1** (Référentiel Général d'Amélioration de l'Accessibilité)
   - ✅ French government accessibility standard
   - ✅ Required for public sector clients
   - ✅ Aligns with WCAG 2.1 but has specific French requirements

### **Color Contrast Requirements**

**Text Contrast Ratios:**

- ✅ Normal text (< 18pt): **4.5:1** minimum
- ✅ Large text (≥ 18pt or 14pt bold): **3:1** minimum
- ✅ UI components and graphics: **3:1** minimum

**Theme Color Compliance:**

```css
/* Pre-validated combinations */
✅ vital-ink (#0F172A) on vital-mist (#F1F5F9) = 14.8:1 (Excellent)
✅ vital-blue (#0B3D91) on vital-mist (#F1F5F9) = 7.2:1 (Good)
✅ vital-sky (#6EC1E4) on vital-ink (#0F172A) = 5.1:1 (Good)
⚠️ vital-sky (#6EC1E4) on vital-mist (#F1F5F9) = 2.9:1 (FAILS - use for decorative only)
```

**Rules:**

- ✅ ALWAYS verify contrast ratios when creating new color combinations
- ❌ NEVER use vital-sky on vital-mist for text
- ✅ Use online tools: WebAIM Contrast Checker, Contrast Ratio

### **Keyboard Navigation**

**Requirements:**

- ✅ ALL interactive elements MUST be keyboard accessible
- ✅ Visible focus indicators (`:focus`, `:focus-visible`)
- ✅ Logical tab order (use `tabindex` only when necessary)
- ✅ Skip links for navigation
- ❌ NEVER trap keyboard focus
- ❌ NEVER rely solely on hover states

**Focus Styles:**

```css
/* Minimum focus indicator */
:focus-visible {
  outline: 2px solid var(--wp--preset--color--vital-blue);
  outline-offset: 2px;
}
```

### **Semantic HTML**

**Rules:**

- ✅ Use proper heading hierarchy (h1 → h2 → h3, no skipping)
- ✅ Use semantic elements: `<nav>`, `<main>`, `<article>`, `<aside>`, `<footer>`
- ✅ Use `<button>` for actions, `<a>` for navigation
- ❌ NEVER use `<div>` or `<span>` for interactive elements
- ✅ Use lists (`<ul>`, `<ol>`) for grouped content

### **ARIA Best Practices**

**When to Use ARIA:**

- ✅ Use ARIA when semantic HTML is insufficient
- ✅ Common attributes: `aria-label`, `aria-labelledby`, `aria-describedby`
- ✅ Landmark roles when HTML5 semantics aren't supported
- ❌ NEVER override native semantics with ARIA

**Examples:**

```html
<!-- Good: Descriptive button -->
<button aria-label="Prendre rendez-vous avec le Dr. Martin">Réserver</button>

<!-- Good: Navigation landmark -->
<nav aria-label="Navigation principale">
  <!-- navigation items -->
</nav>

<!-- Good: Form label association -->
<label for="patient-name">Nom du patient</label>
<input id="patient-name" type="text" required aria-required="true" />
```

### **Images & Media**

**Alt Text Rules:**

- ✅ ALL images MUST have `alt` attributes
- ✅ Decorative images: `alt=""` (empty, not missing)
- ✅ Informative images: Descriptive alt text in French
- ✅ Complex images (charts, diagrams): Provide long description
- ❌ NEVER use "image of" or "picture of" in alt text

**Examples:**

```html
<!-- Decorative -->
<img src="divider.svg" alt="" role="presentation" />

<!-- Informative -->
<img src="doctor.jpg" alt="Dr. Sophie Martin, médecin généraliste" />

<!-- Functional (button) -->
<button>
  <img src="calendar.svg" alt="Prendre rendez-vous" />
</button>
```

### **Forms Accessibility**

**Requirements:**

- ✅ ALL form inputs MUST have associated `<label>` elements
- ✅ Use `<fieldset>` and `<legend>` for grouped inputs
- ✅ Provide clear error messages
- ✅ Use `aria-invalid` and `aria-describedby` for errors
- ✅ Required fields: use `required` attribute + visual indicator

**Example:**

```html
<fieldset>
  <legend>Informations de contact</legend>

  <label for="email">Email <span aria-label="requis">*</span></label>
  <input
    id="email"
    type="email"
    required
    aria-required="true"
    aria-describedby="email-error"
  />
  <span id="email-error" class="error" role="alert">
    Veuillez entrer une adresse email valide
  </span>
</fieldset>
```

### **Screen Reader Considerations**

**Rules:**

- ✅ Test with screen readers (NVDA, JAWS, VoiceOver)
- ✅ Provide skip navigation links
- ✅ Use `aria-live` for dynamic content updates
- ✅ Ensure content order makes sense when linearized
- ❌ NEVER hide content with `display: none` if it should be read

### **Testing Checklist**

Before releasing any pattern:

1. ✅ Run automated accessibility audit (WAVE, axe)
2. ✅ Test keyboard navigation (Tab, Shift+Tab, Enter, Space, Esc)
3. ✅ Verify color contrast ratios
4. ✅ Test with screen reader (at least VoiceOver on Mac)
5. ✅ Validate HTML semantics
6. ✅ Check focus indicators are visible
7. ✅ Test with browser zoom (200%, 400%)
8. ✅ Verify responsive behavior doesn't break accessibility

### **Resources**

- **WCAG 2.1**: https://www.w3.org/WAI/WCAG21/quickref/
- **RGAA 4.1**: https://accessibilite.numerique.gouv.fr/
- **WebAIM Contrast Checker**: https://webaim.org/resources/contrastchecker/
- **ARIA Authoring Practices**: https://www.w3.org/WAI/ARIA/apg/

## BMAD Workflows & Development Tools

### **Available Workflows**

This project uses BMAD (Build, Manage, Automate, Deploy) workflows for standardized development processes. AI agents should leverage these workflows instead of creating ad-hoc solutions.

**Planning Workflows:**

- `/create-prd` - Create Product Requirements Documents
- `/create-architecture` - Architectural decision facilitation
- `/create-ux-design` - UX design specification (use this for new patterns!)
- `/create-epics-and-stories` - Break down requirements into stories
- `/create-product-brief` - Product brief creation

**Development Workflows:**

- `/quick-dev` - Flexible development with optional planning
- `/dev-story` - Execute user stories with full validation
- `/quick-spec` - Create implementation-ready tech specs

**Documentation Workflows:**

- `/document-project` - Comprehensive brownfield project documentation
- `/generate-project-context` - Create/update this project-context.md file

**Quality & Review:**

- `/code-review` - Adversarial senior developer code review
- `/check-implementation-readiness` - Validate PRD/Architecture/Stories before implementation

**Agents:**

- `/ux-designer` - UX Designer agent (Sally)
- `/pm` - Product Manager agent
- `/architect` - Architect agent
- `/dev` - Developer agent

### **When to Use Workflows**

**Creating New Patterns:**

1. Use `/ux-designer` to design the pattern UX
2. Use `/quick-spec` to create technical specification
3. Use `/dev-story` or `/quick-dev` to implement

**Major Features:**

1. Use `/create-prd` for requirements
2. Use `/create-architecture` for technical decisions
3. Use `/create-epics-and-stories` to break down work
4. Use `/dev-story` for each story

**Documentation:**

- Use `/document-project` when project structure changes significantly
- Use `/generate-project-context` when new patterns/rules emerge

### **Workflow Location**

All workflows are located in: `{project-root}/_bmad/bmm/workflows/`

**Rules:**

- ✅ Check if a workflow exists before creating custom solutions
- ✅ Follow workflow instructions exactly
- ✅ Workflows are optimized for AI agent execution
- ❌ Don't skip workflow steps or try to "shortcut"

---

## Technology Stack & Versions

### WordPress Theme

- **Type**: Full Site Editing (FSE) Block Theme
- **Theme Name**: Vitalisite FSE
- **Version**: 0.1.3
- **Text Domain**: `vitalisite-fse`
- **WordPress**: 6.0+ (tested up to 6.7)
- **PHP**: 7.4+
- **License**: GPL-2.0-or-later

### Theme Configuration

- **theme.json**: Version 3 schema
- **Layout**: Full-width content (`contentSize: 100%`, `wideSize: 100%`)
- **Appearance Tools**: Disabled (manual control)

---

## Critical Implementation Rules

### Color Palette (MUST USE)

The theme defines a custom color palette that MUST be used consistently:

```json
{
  "vital-blue": "#0B3D91", // Primary brand color
  "vital-sky": "#6EC1E4", // Secondary/accent
  "vital-ink": "#0F172A", // Text color
  "vital-mist": "#F1F5F9" // Background color
}
```

**Rules:**

- ✅ ALWAYS use CSS variables: `var(--wp--preset--color--vital-blue)`
- ❌ NEVER use custom colors or gradients (disabled in theme.json)
- ❌ NEVER use default WordPress color palette (disabled)

### Typography System

**Font Families:**

- **Body**: `system-sans` (system-ui, -apple-system, Segoe UI, Roboto)
- **Headings**: `system-serif` (ui-serif, Georgia)
- **Alternative Sans**: `humanist-sans` (Trebuchet MS, Segoe UI)
- **Alternative Serif**: `classique-serif` (Georgia, Times New Roman)

**Rules:**

- ✅ Use CSS variables: `var(--wp--preset--font-family--system-sans)`
- ❌ NO custom font sizes (disabled)
- ❌ NO line-height, font-weight, text-decoration overrides (disabled)
- ✅ Fluid typography is ENABLED

### CSS Organization

**Structure:**

```
wp-content/themes/vitalisite-fse/
├── style.css              # Theme header only, minimal styles
├── assets/styles/
│   ├── header.css        # Header-specific styles
│   └── hero.css          # Hero section styles
```

**Rules:**

- ✅ CSS files MUST be enqueued in `functions.php`
- ✅ CSS files MUST be added to `add_editor_style()` for block editor
- ✅ Use BEM-like naming: `.vitalisite-header__bg`, `.vitalisite-header__cta`
- ✅ Organize by component, not by page

### Block Patterns

**Pattern Categories (Custom):**

- `vitalisite-header` - Header patterns
- `vitalisite-footer` - Footer patterns
- `banniere-vitalisite` - Banner patterns
- `vitalisite` - General patterns

**Pattern File Naming:**

```
patterns/
├── header-{variant}.php    # e.g., header-fond.php, header-minimal.php
├── hero-{variant}.php      # e.g., hero-banniere.php, hero-banniere-v2.php
└── footer-{variant}.php
```

**Pattern Structure (CRITICAL):**

```php
<?php
/**
 * Title: {Human Readable Name}
 * Slug: vitalisite-fse/{pattern-slug}
 * Description: {Description}
 * Categories: {vitalisite-category}
 * Keywords: {comma, separated, keywords}
 * Viewport Width: 1400
 * Block Types: core/template-part/{type}
 * Post Types: wp_template
 * Inserter: true
 */
?>
<!-- wp:group {...} -->
...
<!-- /wp:group -->
```

**Rules:**

- ✅ ALL patterns MUST have complete PHPDoc headers
- ✅ Slug MUST start with `vitalisite-fse/`
- ✅ Use ONLY allowed categories (others are unregistered)
- ❌ NEVER use core WordPress patterns (disabled)
- ❌ NEVER use remote patterns from WordPress.org (disabled)

### Style Variations

**Available Variations:**

- `clinique.json` - Clinical/medical theme
- `mineral.json` - Mineral/natural theme
- `nocturne.json` - Dark/night theme
- `solaire.json` - Bright/solar theme

**Rules:**

- ✅ Style variations override `theme.json` settings
- ✅ Each variation is a complete theme.json structure

### Development Mode

**Dev Mode Detection:**

```php
function vitalisite_is_dev_mode() {
    if (defined('VITALISITE_DEV_MODE') && VITALISITE_DEV_MODE) {
        return true;
    }
    if (function_exists('wp_get_environment_type')) {
        return wp_get_environment_type() === 'local';
    }
    return false;
}
```

**Rules:**

- ✅ In dev mode, theme and pattern caches are AUTOMATICALLY cleared on `init`
- ✅ Use `WP_Theme_JSON_Resolver::clean_cached_data()` for JSON changes
- ✅ Use `wp_clean_themes_cache(false)` for pattern changes

### Custom CSS Variables

**Available:**

```css
--wp--custom--image-radius: 20px --wp--custom--hero-max-width: 100%
  --wp--custom--hero-pad-x: 0px;
```

**Rules:**

- ✅ Access via `var(--wp--custom--image-radius)`
- ✅ Images have automatic border-radius applied

### Block Settings Restrictions

**Disabled Features (theme.json):**

- ❌ Border controls (radius, color, style, width)
- ❌ Background images
- ❌ Custom colors and gradients
- ❌ Spacing controls (margin, padding, blockGap) - EXCEPT padding on `core/group`
- ❌ Typography controls (fontSize, lineHeight, fontWeight, etc.)

**Rules:**

- ✅ Work within these constraints - they are INTENTIONAL
- ✅ Use CSS classes for styling, not inline block styles
- ❌ DO NOT try to enable these features

### Enqueue Pattern

**CSS Enqueue:**

```php
wp_enqueue_style(
    'vitalisite-fse-{name}',
    get_template_directory_uri() . '/assets/styles/{name}.css',
    array('vitalisite-fse'),  // Dependency on main stylesheet
    wp_get_theme()->get('Version')
);
```

**Rules:**

- ✅ ALWAYS use theme version for cache busting
- ✅ ALWAYS set dependency on `vitalisite-fse` main stylesheet
- ✅ Use `get_template_directory_uri()` for paths

---

## Naming Conventions

### CSS Classes

- **Pattern**: `vitalisite-{component}__{element}--{modifier}`
- **Examples**:
  - `.vitalisite-header__bg`
  - `.vitalisite-header__cta`
  - `.vitalisite-header--minimal`

### File Names

- **Patterns**: `{type}-{variant}.php` (kebab-case)
- **Styles**: `{component}.css` (kebab-case)
- **Functions**: `vitalisite_{function_name}()` (snake_case with prefix)

---

## WordPress Block Editor Specifics

### Block Comments (CRITICAL)

- ✅ ALL blocks MUST use WordPress block comment syntax
- ✅ Format: `<!-- wp:{block-type} {json-attributes} -->`
- ✅ Closing: `<!-- /wp:{block-type} -->`
- ❌ NEVER write plain HTML in patterns - use block comments

### Common Blocks

```html
<!-- wp:group {attributes} -->
<!-- wp:paragraph {attributes} -->
<!-- wp:buttons {attributes} -->
<!-- wp:button -->
<!-- wp:navigation {attributes} -->
<!-- wp:site-logo {attributes} -->
<!-- wp:site-title {attributes} -->
```

---

## Testing & Validation

### Before Committing

1. ✅ Test in WordPress block editor
2. ✅ Verify pattern appears in inserter
3. ✅ Check responsive behavior
4. ✅ Validate CSS enqueued correctly
5. ✅ Clear caches if in dev mode

---

_Document created: 2026-02-03T20:31:25+01:00_
