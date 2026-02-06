---
stepsCompleted:
  [
    "step-01-init",
    "step-02-context",
    "step-03-starter",
    "step-04-decisions",
    "step-05-patterns",
    "step-06-structure",
    "step-07-validation",
  ]
inputDocuments:
  - "/Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/_bmad-output/planning-artifacts/prd.md"
  - "/Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/_bmad-output/project-context.md"
workflowType: "architecture"
project_name: "wordpress-vitalisite-v2-FSE"
user_name: "Quentin"
date: "2026-02-06T10:15:16+01:00"
documentCounts:
  prdCount: 1
  uxDesignCount: 0
  researchCount: 0
  projectDocsCount: 1
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

## Project Context Analysis

### Requirements Overview

**Functional Requirements:**

Le projet nécessite la migration de 15 widgets Elementor vers des block patterns FSE natifs, incluant : Hero sections, Sliders, Bento Grid, Accordions, Cards, Text+Image, Forms (AJAX), Testimonials, Doctor Profiles, Before/After, Opening Hours, Video embeds, et Pricing.

3 Custom Post Types doivent être maintenus (Doctors, Specialities, Testimonials) avec leurs templates FSE et meta fields. Le système de Customizer (actuellement Kirki) doit être migré vers l'API native pour gérer les paramètres globaux (adresse, téléphone, horaires, liens RDV).

**Non-Functional Requirements:**

- **Performance** : Élimination de la surcharge Elementor, zéro dépendance plugin
- **Accessibilité** : WCAG 2.1 AA + RGAA 4.1 (obligatoire pour produit commercial santé) - Le site doit être navigable au clavier et adapté aux technologies assistives
- **Maintenabilité** : Architecture FSE pure, pas de vendor lock-in
- **Utilisabilité** : Patterns intuitifs pour professionnels de santé non-techniques
- **Sécurité** : Validation formulaires, protection CSRF, intégration licence Supabase

**Scale & Complexity:**

- **Domaine principal** : WordPress Full Site Editing (Frontend + Theme Architecture)
- **Niveau de complexité** : Moyenne-Haute
- **Composants architecturaux estimés** : 20-25
  - 15+ block patterns (conversions widgets)
  - 3 CPT avec templates/patterns FSE
  - Système Customizer natif
  - Système formulaires AJAX
  - Intégration API Supabase (licence)
  - Template parts (header, footer, sticky CTA)

### Technical Constraints & Dependencies

**Contraintes imposées :**

- WordPress 6.0+ requis (FSE)
- PHP 7.4+ minimum
- Zéro plugin tiers (tout dans le thème)
- `theme.json` v3 avec restrictions intentionnelles (palette couleurs stricte, spacing/typography limités)
- Migration Kirki → Customizer API natif obligatoire

**Dépendances externes :**

- Supabase API (validation licence)
- Swiper.js (sliders) - à bundler dans thème
- Potentiel GSAP (animations) - décision à prendre

### Cross-Cutting Concerns Identified

1. **Accessibilité** : ARIA, contraste couleurs, navigation clavier sur tous les patterns
2. **Internationalisation** : Code anglais / Contenu utilisateur français
3. **Asset Management** : Enqueue CSS/JS modulaire, cache busting via version thème
4. **Dev Mode** : Auto-clear caches theme.json et patterns
5. **Responsive Design** : Mobile-first, breakpoints cohérents
6. **SEO** : HTML sémantique, structured data professionnels santé
7. **Validation** : Formulaires, meta boxes, Customizer options
8. **Documentation** : Patterns auto-explicatifs pour utilisateurs non-dev

## Starter Template Evaluation

### Primary Technology Domain

**WordPress Full Site Editing (FSE) Theme** - Projet existant en cours de développement

### Existing Architectural Foundation

**Rationale:** Ce projet utilise WordPress FSE natif sans starter template tiers. L'architecture est construite directement sur les capacités FSE de WordPress 6.0+, permettant un contrôle total sur le design system et évitant toute dépendance externe.

**Architectural Decisions Already Established:**

**Design System (theme.json v3):**

- Palette de 13 couleurs sémantiques (primary, secondary, contrast, base, + accents et états)
- 4 gradients prédéfinis (primary, secondary, calm, light)
- Système typographique fluide avec 7 tailles (x-small → xx-large)
- 3 familles de poltes système (sans-serif, serif, monospace) pour performance optimale
- Système d'espacement à 7 niveaux avec clamp() pour fluidité (2XS → 2XL)
- 4 ombres prédéfinies (small → extra-large)
- Layout responsive (contentSize: 740px, wideSize: 1260px)

**Block Styling:**

- Styles personnalisés pour blocks core (button, navigation, quote, code, details, etc.)
- Border radius cohérent (6px buttons, 8px images)
- Hover states définis pour interactivité
- Typography weights et line-heights standardisés
- Custom CSS pour comportements spécifiques

**Project Structure:**

```
vitalisite-fse/
├── theme.json          # Design system complet v3
├── functions.php       # Enqueue, CPT registration, dev mode
├── style.css           # Theme header minimal
├── patterns/           # Block patterns PHP (6 actuellement)
├── templates/          # FSE templates HTML (4 actuellement)
├── parts/              # Template parts HTML (2 actuellement)
├── styles/             # Style variations JSON (14 variations)
└── assets/
    ├── styles/         # CSS modulaire par composant
    └── js/             # JavaScript modulaire
```

**Development Experience:**

- Dev mode detection automatique (via `VITALISITE_DEV_MODE` ou `wp_get_environment_type()`)
- Cache auto-clear en mode dev (theme.json et patterns)
- Asset versioning via theme version pour cache busting
- CSS modulaire enqueued par composant avec dépendances
- Editor styles synchronisés avec frontend

**Current Implementation Status:**

- ✅ Design system complet dans theme.json
- ✅ 6 patterns créés (headers, hero banners)
- ✅ 4 templates FSE
- ✅ 14 style variations
- ✅ Dev mode avec auto-refresh
- 🔄 Migration en cours : 15 widgets Elementor → block patterns
- 🔄 À faire : CPT templates, Customizer migration, forms system

## Core Architectural Decisions

### Decision Priority Analysis

**Critical Decisions (Block Implementation):**

1. CPT Meta Fields Management - Block Bindings (WordPress 6.5+)
2. Forms System - Custom Block + AJAX Handler
3. JavaScript Libraries - Bundled in theme
4. Customizer Migration - Hybrid (theme.json + Customizer API)
5. Onboarding System - Setup Wizard (4 steps)

**Important Decisions (Shape Architecture):**

- Supabase API integration for license validation
- Swiper.js for sliders/carousels
- AJAX form submission with nonce protection

**Deferred Decisions (Post-MVP):**

- Animations avancées (GSAP) - À implémenter après frontend complet
- Advanced CPT relationships
- Multi-language support (si demandé)

---

### Data Architecture

**Custom Post Types & Meta Fields:**

- **Decision:** Utiliser Block Bindings natifs (WordPress 6.5+)
- **Rationale:** Approche FSE-native, évite dépendances, meilleure intégration éditeur
- **Implementation:**
  - Enregistrer meta fields avec `show_in_rest` et `type`
  - Utiliser `block bindings API` pour lier blocks aux meta fields
  - Créer patterns avec blocks liés aux CPT fields
- **Affects:** Doctors CPT, Specialities CPT, Testimonials CPT

**License Validation:**

- **Technology:** Supabase API
- **Implementation:** Hook `vitalisite_validate_license` dans setup wizard
- **Storage:** `vitalisite_license_key` option

---

### Forms System

**Decision:** Custom Block + AJAX Handler

- **Rationale:** Contrôle total sur validation, emails, et UX sans dépendance
- **Implementation:**
  - Créer custom block `vitalisite/contact-form` avec InnerBlocks
  - AJAX handler PHP avec `wp_ajax_` hooks
  - Nonce validation pour sécurité CSRF
  - Email via `wp_mail()` avec templates
- **Affects:** Contact forms, appointment request forms

---

### JavaScript Libraries

**Decision:** Bundler dans le thème (`/assets/js/vendor/`)

- **Rationale:** Évite dépendances CDN externes, garantit disponibilité offline, contrôle versions
- **Libraries:**
  - **Swiper.js 12.1.0** - Sliders et carousels (latest stable)
  - **GSAP** - Animations (POST-MVP, à implémenter après frontend complet)
- **Implementation:**
  - Télécharger minified versions
  - Enqueue avec dépendances appropriées
  - Versioning via `VITALISITE_FSE_VERSION`

---

### Customizer Migration (Kirki → Native)

**Decision:** Hybrid - theme.json + Customizer API natif

- **Rationale:** Séparer design system statique (theme.json) des données dynamiques (Customizer)
- **theme.json:** Couleurs, typographie, spacing (design tokens)
- **Customizer API:** Adresse cabinet, téléphone, email, horaires, lien RDV
- **Migration Path:**
  - Retirer dépendance Kirki
  - Utiliser `$wp_customize->add_setting()` et `$wp_customize->add_control()`
  - Créer sections logiques (Contact Info, Opening Hours, Booking, etc.)

---

### Onboarding System

**Decision:** Setup Wizard (4 étapes) - Migration depuis vitalisite-fse-OLD-VERSION

- **Trigger:** Première activation du thème (via `get_option('vitalisite_setup_complete')`)
- **Steps:**
  1. **License** - Validation clé de licence Supabase
  2. **Doctor Info** - Nom, spécialité, adresse, téléphone, email, photo, lien RDV
  3. **Customization** - Couleurs (primary, secondary, accent), typographies
  4. **Done** - Confirmation + liens vers Site Editor

**Implementation:**

- **Class:** `Vitalisite_Setup_Wizard` (Singleton)
- **Location:** `inc/setup-wizard.php`
- **Admin Page:** `themes.php?page=vitalisite-setup-wizard`
- **Redirect Logic:** `admin_init` hook vérifie `vitalisite_setup_complete`
- **Data Storage:**
  - `vitalisite_license_key` (option)
  - `vitalisite_doctor_info` (option array)
  - `vitalisite_setup_complete` (option boolean)
  - theme.json (couleurs/fonts)

**Assets:**

- `/assets/admin/wizard.css` - Styles du wizard
- `/assets/admin/wizard.js` - Interactions (upload photo, preview couleurs)

---

### Decision Impact Analysis

**Implementation Sequence:**

1. Setup Wizard migration (foundation pour onboarding)
2. Customizer API migration (données dynamiques)
3. CPT Block Bindings (meta fields FSE-native)
4. Custom Form Block (remplacement Elementor Forms)
5. JavaScript libraries bundling (Swiper.js)
6. Block patterns création (15 widgets → patterns)

**Cross-Component Dependencies:**

- Setup Wizard → Customizer (sauvegarde données)
- Setup Wizard → theme.json (couleurs/fonts)
- CPT Block Bindings → Patterns (affichage données)
- Forms Block → AJAX Handler (soumission)
- Patterns → JavaScript Libraries (sliders, animations)

## Implementation Patterns & Consistency Rules

### Pattern Categories Defined

**Critical Conflict Points Identified:** 8 catégories où les agents IA pourraient faire des choix différents

### Naming Patterns

**PHP Naming Conventions:**

- **Functions:** `vitalisite_` prefix + snake_case (ex: `vitalisite_register_patterns()`)
- **Classes:** PascalCase avec `Vitalisite_` prefix (ex: `Vitalisite_Setup_Wizard`)
- **Hooks:** `vitalisite_` prefix + snake_case (ex: `vitalisite_validate_license`)
- **Options:** `vitalisite_` prefix + snake_case (ex: `vitalisite_setup_complete`)

**File Naming:**

- **Patterns:** kebab-case avec type prefix (ex: `header-minimal.php`, `hero-banniere-v2.php`)
- **Templates:** kebab-case (ex: `single-doctors.html`, `archive-specialities.html`)
- **CSS:** kebab-case (ex: `header.css`, `hero.css`)
- **JavaScript:** kebab-case (ex: `wizard.js`, `slider.js`)

**CSS Class Naming (BEM-like):**

- **Pattern:** `vitalisite-{component}__{element}--{modifier}`
- **Examples:**
  - `.vitalisite-header__bg`
  - `.vitalisite-header__cta--primary`
  - `.vitalisite-wizard-step--active`

**Block Pattern Naming:**

- **Slug:** `vitalisite-fse/{pattern-name}` (ex: `vitalisite-fse/header-minimal`)
- **Category:** `vitalisite-{type}` (ex: `vitalisite-header`, `banniere-vitalisite`)

### Structure Patterns

**Project Organization:**

```
vitalisite-fse/
├── inc/                    # PHP includes (classes, functions)
│   ├── setup-wizard.php
│   ├── customizer.php
│   └── cpt-registration.php
├── patterns/               # Block patterns (PHP)
├── templates/              # FSE templates (HTML)
├── parts/                  # Template parts (HTML)
├── styles/                 # Style variations (JSON)
└── assets/
    ├── styles/            # CSS modulaire
    ├── js/                # JavaScript modulaire
    │   └── vendor/        # Bibliothèques tierces
    └── admin/             # Assets admin (wizard, etc.)
```

**File Organization Rules:**

- ✅ Un fichier par pattern dans `/patterns`
- ✅ CSS enqueued par composant (pas de monolithe)
- ✅ JavaScript vendor dans `/assets/js/vendor/`
- ✅ Classes PHP dans `/inc/` avec un fichier par classe

### Format Patterns

**PHPDoc Headers (Patterns):**

```php
/**
 * Title: {Nom Français Lisible}
 * Slug: vitalisite-fse/{pattern-slug}
 * Description: {Description en français}
 * Categories: {vitalisite-category}
 * Keywords: {mots, clés, français}
 * Viewport Width: 1400
 * Block Types: core/template-part/{type}
 * Inserter: true
 */
```

**Block Comment Format:**

- ✅ TOUJOURS utiliser `<!-- wp:{block-type} {json} -->`
- ❌ JAMAIS de HTML brut dans les patterns
- ✅ Attributs en JSON valide

**CSS Variable Usage:**

- ✅ Couleurs: `var(--wp--preset--color--primary)`
- ✅ Fonts: `var(--wp--preset--font-family--primary)`
- ✅ Spacing: `var(--wp--preset--spacing--50)`
- ✅ Custom: `var(--wp--custom--image-radius)`

### WordPress-Specific Patterns

**CPT Registration:**

- **Location:** `inc/cpt-registration.php`
- **Hook:** `init` action
- **Meta Fields:** Enregistrer avec `show_in_rest => true` et `type`
- **Block Bindings:** Utiliser API native WordPress 6.5+

**Enqueue Pattern:**

```php
wp_enqueue_style(
    'vitalisite-fse-{name}',
    get_template_directory_uri() . '/assets/styles/{name}.css',
    array('vitalisite-fse'),  // Dépendance
    wp_get_theme()->get('Version')
);
```

**Customizer Pattern:**

```php
$wp_customize->add_setting('vitalisite_{setting}', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'refresh',
));
```

### Communication Patterns

**Hook Naming:**

- **Actions:** `vitalisite_{action}` (ex: `vitalisite_validate_license`)
- **Filters:** `vitalisite_{filter}` (ex: `vitalisite_doctor_info`)

**AJAX Patterns:**

- **Action:** `wp_ajax_vitalisite_{action}`
- **Nonce:** `vitalisite_{action}_nonce`
- **Response:** JSON avec `success` boolean et `data` object

### Process Patterns

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

**Cache Clearing (Dev Mode):**

- ✅ Auto-clear theme.json cache: `WP_Theme_JSON_Resolver::clean_cached_data()`
- ✅ Auto-clear patterns cache: `wp_clean_themes_cache(false)`
- ✅ Hook: `init` action

### Enforcement Guidelines

**All AI Agents MUST:**

- Utiliser le prefix `vitalisite_` pour toutes les fonctions/hooks/options
- Suivre BEM-like pour les classes CSS (`.vitalisite-{component}__`)
- Enregistrer CSS/JS avec versioning via `wp_get_theme()->get('Version')`
- Utiliser block comments WordPress (`<!-- wp:... -->`) dans patterns
- Documenter patterns avec PHPDoc headers complets en français
- Respecter l'organisation des fichiers (`inc/`, `patterns/`, `assets/`)

**Pattern Enforcement:**

- Vérifier via code review que tous les prefixes sont corrects
- Valider que les patterns utilisent block comments (pas HTML brut)
- S'assurer que CSS variables sont utilisées (pas de couleurs hardcodées)
- Confirmer que les assets sont enqueued avec dépendances

### Pattern Examples

**Good Example - Pattern:**

```php
/**
 * Title: Header Minimal
 * Slug: vitalisite-fse/header-minimal
 * Description: En-tête épuré pour une apparence moderne
 * Categories: vitalisite-header
 */
?>
<!-- wp:group {"className":"vitalisite-header"} -->
<div class="wp-block-group vitalisite-header">
    <!-- wp:site-logo /-->
</div>
<!-- /wp:group -->
```

**Anti-Pattern - HTML Brut:**

```php
❌ <div class="header">
    <img src="logo.png" />
</div>
```

**Good Example - CSS:**

```css
.vitalisite-header__cta {
  background: var(--wp--preset--color--primary);
  padding: var(--wp--preset--spacing--40);
}
```

**Anti-Pattern - Hardcoded:**

```css
❌ .header-button {
  background: #0b3d91;
  padding: 10px;
}
```

## Project Structure & Boundaries

### Complete Project Directory Structure

```
vitalisite-fse/
├── theme.json                    # Design system FSE v3 (couleurs, typo, spacing)
├── style.css                     # Theme header (metadata WordPress)
├── functions.php                 # Enqueue assets, hooks, dev mode
├── CHANGELOG.md                  # Historique des versions
├── .gitattributes               # Configuration Git
│
├── inc/                          # PHP includes (À CRÉER)
│   ├── setup-wizard.php         # Setup wizard 4 étapes (migration OLD-VERSION)
│   ├── customizer.php           # Customizer API natif (migration Kirki)
│   ├── cpt-registration.php    # Enregistrement CPTs + meta fields
│   ├── block-bindings.php       # Block bindings API (WordPress 6.5+)
│   └── ajax-handlers.php        # Handlers AJAX pour formulaires
│
├── patterns/                     # Block patterns PHP (6 actuellement)
│   ├── header.php               # Header avec fond
│   ├── header-minimal.php       # Header épuré
│   ├── hero-banniere.php        # Hero v1
│   ├── hero-banniere-v2.php     # Hero v2
│   ├── hero-banniere-v3.php     # Hero v3
│   ├── footer-simple.php        # Footer simple
│   └── [À CRÉER: 9+ patterns]   # Accordion, Cards, Forms, Testimonials, etc.
│
├── templates/                    # FSE templates HTML (4 actuellement)
│   ├── index.html               # Template par défaut
│   ├── front-page.html          # Page d'accueil
│   ├── page.html                # Page standard
│   ├── home.html                # Blog home
│   └── [À CRÉER: CPT templates] # single-doctors.html, archive-specialities.html
│
├── parts/                        # Template parts HTML (2 actuellement)
│   ├── header.html              # Header part
│   ├── footer.html              # Footer part
│   └── [À CRÉER]                # sticky-cta.html
│
├── styles/                       # Style variations JSON (14 variations)
│   ├── blue-medical.json
│   ├── green-wellness.json
│   └── [12 autres variations]
│
└── assets/
    ├── styles/                   # CSS modulaire (2 actuellement)
    │   ├── header.css
    │   ├── hero.css
    │   └── [À CRÉER]            # accordion.css, cards.css, forms.css, etc.
    │
    ├── js/                       # JavaScript modulaire (À CRÉER)
    │   ├── vendor/              # Bibliothèques tierces
    │   │   ├── swiper.min.js   # Sliders/carousels
    │   │   └── [gsap.min.js]   # Animations (optionnel)
    │   ├── slider.js            # Init Swiper
    │   ├── accordion.js         # Accordions interactifs
    │   └── forms.js             # AJAX form submission
    │
    └── admin/                    # Assets admin (À CRÉER)
        ├── wizard.css           # Styles setup wizard
        └── wizard.js            # Interactions wizard (upload, preview)
```

### Architectural Boundaries

**WordPress FSE Boundaries:**

- **theme.json** = Design system (couleurs, typo, spacing) - Modifiable via Setup Wizard
- **Customizer** = Données dynamiques (adresse, téléphone, horaires, RDV) - API native
- **Block Patterns** = Composants réutilisables - Insertion via éditeur
- **Templates** = Structure pages - FSE editor
- **CPT** = Contenus structurés (Doctors, Specialities, Testimonials) - Block bindings

**Data Boundaries:**

- **Options WordPress:** `vitalisite_license_key`, `vitalisite_doctor_info`, `vitalisite_setup_complete`
- **CPT Meta Fields:** Enregistrés avec `show_in_rest => true` pour block bindings
- **Supabase API:** Validation licence (externe, async)

**Component Boundaries:**

- **Patterns** → Autonomes, pas de dépendances entre patterns
- **CSS** → Modulaire par composant, enqueued séparément
- **JavaScript** → Modulaire, enqueued avec dépendances explicites

### Requirements to Structure Mapping

**Epic: Migration Elementor → FSE (15 widgets)**

| Widget Elementor | →   | Block Pattern                     | Fichier                                                    |
| ---------------- | --- | --------------------------------- | ---------------------------------------------------------- |
| Hero Sections    | →   | `vitalisite-fse/hero-*`           | `patterns/hero-*.php`                                      |
| Sliders          | →   | `vitalisite-fse/slider`           | `patterns/slider.php` + `assets/js/slider.js`              |
| Bento Grid       | →   | `vitalisite-fse/bento-grid`       | `patterns/bento-grid.php`                                  |
| Accordions       | →   | `vitalisite-fse/accordion`        | `patterns/accordion.php` + `assets/js/accordion.js`        |
| Cards            | →   | `vitalisite-fse/cards`            | `patterns/cards.php`                                       |
| Text+Image       | →   | `vitalisite-fse/text-image`       | `patterns/text-image.php`                                  |
| Forms (AJAX)     | →   | `vitalisite/contact-form` (block) | `inc/ajax-handlers.php` + `assets/js/forms.js`             |
| Testimonials     | →   | `vitalisite-fse/testimonials`     | `patterns/testimonials.php`                                |
| Doctor Profiles  | →   | CPT + pattern                     | `inc/cpt-registration.php` + `patterns/doctor-profile.php` |
| Before/After     | →   | `vitalisite-fse/before-after`     | `patterns/before-after.php`                                |
| Opening Hours    | →   | Customizer + pattern              | `inc/customizer.php` + `patterns/opening-hours.php`        |
| Video embeds     | →   | `vitalisite-fse/video`            | `patterns/video.php`                                       |
| Pricing          | →   | `vitalisite-fse/pricing`          | `patterns/pricing.php`                                     |

**Epic: CPT Migration (3 types)**

- **Doctors CPT:** `inc/cpt-registration.php` + `templates/single-doctors.html` + `patterns/doctor-*.php`
- **Specialities CPT:** `inc/cpt-registration.php` + `templates/archive-specialities.html`
- **Testimonials CPT:** `inc/cpt-registration.php` + pattern integration

**Epic: Customizer Migration (Kirki → Native)**

- **Location:** `inc/customizer.php`
- **Sections:** Contact Info, Opening Hours, Booking Links, Social Media
- **Integration:** Patterns récupèrent données via `get_theme_mod()`

**Epic: Onboarding System**

- **Location:** `inc/setup-wizard.php`
- **Assets:** `assets/admin/wizard.css`, `assets/admin/wizard.js`
- **Flow:** License → Doctor Info → Customization → Done

### Integration Points

**Internal Communication:**

- **Patterns ↔ Customizer:** `get_theme_mod('vitalisite_phone')` dans patterns
- **Patterns ↔ CPT:** Block bindings API pour afficher meta fields
- **Forms ↔ AJAX:** `wp_ajax_vitalisite_submit_form` handler
- **Setup Wizard ↔ theme.json:** Modification couleurs/fonts via PHP

**External Integrations:**

- **Supabase API:** Validation licence via hook `vitalisite_validate_license`
- **Swiper.js:** Bundled dans `/assets/js/vendor/`, init via `slider.js`
- **Email:** `wp_mail()` pour formulaires de contact

**Data Flow:**

1. **Setup Wizard** → Sauvegarde options + modifie theme.json
2. **Customizer** → Sauvegarde theme_mods
3. **Patterns** → Récupèrent données via `get_theme_mod()` et block bindings
4. **Forms** → AJAX → PHP handler → Email + response JSON

### File Organization Patterns

**Configuration Files:**

- `theme.json` - Root (design system)
- `functions.php` - Root (enqueue, hooks, dev mode)

**Source Organization:**

- `/inc/` - PHP classes et fonctions (un fichier par classe)
- `/patterns/` - Un fichier PHP par pattern
- `/templates/` - Un fichier HTML par template
- `/parts/` - Un fichier HTML par template part

**Asset Organization:**

- `/assets/styles/` - Un fichier CSS par composant
- `/assets/js/` - Un fichier JS par fonctionnalité
- `/assets/js/vendor/` - Bibliothèques tierces (Swiper, GSAP)
- `/assets/admin/` - Assets admin (wizard)

### Development Workflow Integration

**Development Server:**

- WordPress local (MAMP, Local, etc.)
- Dev mode: `define('VITALISITE_DEV_MODE', true)` ou `wp_get_environment_type() === 'local'`
- Auto-clear caches: theme.json et patterns

**Build Process:**

- Pas de build nécessaire (thème WordPress pur)
- Assets déjà minifiés (vendor libs)
- Versioning via `wp_get_theme()->get('Version')`

**Deployment:**

- Upload thème via FTP ou WordPress admin
- Activation → Setup Wizard automatique
- Validation licence Supabase

## Architecture Validation Results

### Coherence Validation ✅

**Decision Compatibility:**

- ✅ WordPress 6.0+ FSE + PHP 7.4+ = Compatible
- ✅ Block Bindings (WP 6.5+) + FSE = Natif et cohérent
- ✅ Supabase API (externe) + WordPress hooks = Intégration propre
- ✅ Swiper.js 12.1.0 bundled + WordPress enqueue = Pas de conflit CDN
- ✅ Customizer API natif + theme.json = Séparation claire (dynamique vs statique)

**Pattern Consistency:**

- ✅ Naming: Prefix `vitalisite_` cohérent (PHP, hooks, options, CSS)
- ✅ Structure: Organisation FSE standard (patterns/, templates/, parts/, assets/)
- ✅ Format: Block comments WordPress obligatoires, pas de HTML brut
- ✅ Communication: Hooks WordPress natifs, AJAX avec nonces

**Structure Alignment:**

- ✅ `/inc/` pour PHP classes = Support décisions (wizard, customizer, CPT, bindings, AJAX)
- ✅ `/patterns/` pour block patterns = Migration 15 widgets Elementor
- ✅ `/assets/js/vendor/` pour libs tierces = Bundling Swiper.js 12.1.0
- ✅ Boundaries claires: Patterns autonomes, CSS modulaire, JS avec dépendances

### Requirements Coverage Validation ✅

**Epic Coverage:**

- ✅ **Migration Elementor → FSE (15 widgets):** Block patterns + JS modulaire
- ✅ **CPT Migration (3 types):** Block bindings + templates FSE
- ✅ **Customizer Migration (Kirki → Native):** Customizer API + sections
- ✅ **Onboarding System:** Setup Wizard 4 étapes

**Functional Requirements Coverage:**

- ✅ 15 Block Patterns: Architecture définie (patterns/, assets/styles/, assets/js/)
- ✅ 3 CPT + Meta Fields: Block bindings API (inc/cpt-registration.php, inc/block-bindings.php)
- ✅ Forms AJAX: Custom block + handler (inc/ajax-handlers.php, assets/js/forms.js)
- ✅ Customizer: API native (inc/customizer.php)
- ✅ Setup Wizard: 4 étapes (inc/setup-wizard.php, assets/admin/)

**Non-Functional Requirements Coverage:**

- ✅ **Performance:** Zéro plugin, assets minifiés, dev mode cache clearing
- ✅ **Accessibilité:** WCAG 2.1 AA + RGAA 4.1 (patterns avec ARIA, navigation clavier)
- ✅ **Maintenabilité:** FSE pur, pas de vendor lock-in, code modulaire
- ✅ **Utilisabilité:** Patterns intuitifs, Setup Wizard onboarding
- ✅ **Sécurité:** Nonces AJAX, validation formulaires, sanitization

### Implementation Readiness Validation ✅

**Decision Completeness:**

- ✅ CPT Meta Fields: Block Bindings (WordPress 6.5+)
- ✅ Forms System: Custom Block + AJAX Handler
- ✅ JS Libraries: Swiper.js 12.1.0 (latest stable), GSAP (POST-MVP)
- ✅ Customizer: Hybrid (theme.json + API native)
- ✅ Onboarding: Setup Wizard 4 étapes

**Structure Completeness:**

- ✅ Directory tree complet avec fichiers existants et à créer
- ✅ Mapping 15 widgets → patterns spécifiques
- ✅ Mapping 3 CPT → inc/ + templates/
- ✅ Assets organization claire (styles/, js/, js/vendor/, admin/)

**Pattern Completeness:**

- ✅ PHP Naming: Functions, classes, hooks, options
- ✅ File Naming: Patterns, templates, CSS, JS
- ✅ CSS Classes: BEM-like avec prefix vitalisite-
- ✅ Block Patterns: Slug, category, PHPDoc headers
- ✅ WordPress Patterns: CPT registration, enqueue, customizer, AJAX

### Gap Analysis Results

**Critical Gaps:** ✅ Aucun

**Important Gaps:** ✅ Résolus

- ✅ Swiper.js version spécifiée: 12.1.0 (latest stable)
- ✅ GSAP décision finalisée: POST-MVP (après frontend complet)

**Nice-to-Have Gaps:** 💡 3 identifiés (non-bloquants)

1. Pattern Examples: Ajouter exemples concrets pour chaque widget
2. Accessibility Checklist: Détailler WCAG/RGAA requirements par pattern
3. Dev Tooling: Recommandations linters (PHP_CodeSniffer, ESLint)

### Architecture Completeness Checklist

**✅ Requirements Analysis**

- [x] Project context thoroughly analyzed
- [x] Scale and complexity assessed (Medium-High, 20-25 components)
- [x] Technical constraints identified (WP 6.0+, PHP 7.4+, FSE, zero plugins)
- [x] Cross-cutting concerns mapped (Accessibility, i18n, assets, dev mode, responsive, SEO)

**✅ Architectural Decisions**

- [x] Critical decisions documented (CPT bindings, forms, JS libs, customizer, onboarding)
- [x] Technology stack fully specified (WordPress FSE, Supabase, Swiper.js 12.1.0)
- [x] Integration patterns defined (Patterns ↔ Customizer, Patterns ↔ CPT, Forms ↔ AJAX)
- [x] Performance considerations addressed (Zero plugins, minified assets, cache clearing)

**✅ Implementation Patterns**

- [x] Naming conventions established (PHP, files, CSS, blocks)
- [x] Structure patterns defined (inc/, patterns/, templates/, assets/)
- [x] Communication patterns specified (Hooks, AJAX, block bindings)
- [x] Process patterns documented (Dev mode, enqueue, customizer)

**✅ Project Structure**

- [x] Complete directory structure defined (vitalisite-fse/ avec tous fichiers)
- [x] Component boundaries established (FSE, Customizer, CPT, Patterns)
- [x] Integration points mapped (15 widgets → patterns, 3 CPT → bindings)
- [x] Requirements to structure mapping complete (Table détaillée)

### Architecture Readiness Assessment

**Overall Status:** ✅ **READY FOR IMPLEMENTATION**

**Confidence Level:** **High** (100%)

- Architecture cohérente et complète
- Tous les requirements couverts
- Patterns clairs pour agents IA
- Toutes les décisions finalisées

**Key Strengths:**

1. **FSE Pure:** Zéro dépendance plugin, architecture WordPress native
2. **Patterns Complets:** Naming, structure, format très détaillés
3. **Boundaries Claires:** Séparation theme.json/Customizer, patterns autonomes
4. **Migration Path:** Setup Wizard OLD-VERSION bien documenté
5. **Mapping Précis:** 15 widgets → patterns spécifiques avec fichiers
6. **Versions Spécifiées:** Swiper.js 12.1.0, GSAP post-MVP

**Areas for Future Enhancement:**

1. Ajouter pattern examples concrets (post-implémentation)
2. Détailler accessibility checklist WCAG/RGAA
3. Recommander dev tooling (linters, formatters)
4. Implémenter GSAP animations (après frontend complet)

### Implementation Handoff

**AI Agent Guidelines:**

- Follow all architectural decisions exactly as documented
- Use implementation patterns consistently (prefix `vitalisite_`, BEM-like CSS, block comments)
- Respect project structure (inc/, patterns/, templates/, assets/)
- Refer to this document for all architectural questions
- Use Swiper.js 12.1.0 for sliders (latest stable)
- Defer GSAP animations until after frontend is complete

**First Implementation Priorities:**

1. **Créer `/inc/` directory** et migrer `setup-wizard.php` depuis OLD-VERSION
2. **Bundler Swiper.js 12.1.0** dans `/assets/js/vendor/`
3. **Créer patterns manquants** (9+ patterns: accordion, cards, forms, etc.)
4. **Implémenter CPT registration** avec block bindings (inc/cpt-registration.php)
5. **Migrer Customizer** de Kirki vers API native (inc/customizer.php)

**Architecture Document Complete** ✅
