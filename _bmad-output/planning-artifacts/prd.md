---
stepsCompleted: ["step-01-init", "step-02-discovery"]
inputDocuments:
  [
    "/Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/_bmad-output/project-context.md",
  ]
workflowType: "prd"
project_name: "wordpress-vitalisite-v2-FSE"
user_name: "Quentin"
date: "2026-02-04T11:07:16+01:00"
documentCounts:
  briefCount: 0
  researchCount: 0
  brainstormingCount: 0
  projectDocsCount: 1
---

# Product Requirements Document - Vitalisite V2 FSE

**Author:** Quentin  
**Date:** 2026-02-04  
**Version:** 2.0.0  
**Status:** Planning Phase

---

## 📋 Executive Summary

**Product Name:** Vitalisite V2 FSE (Full Site Editing)  
**Product Type:** Premium WordPress FSE Theme for Healthcare Professionals  
**Target Market:** French-speaking medical practitioners (doctors, dentists, therapists, clinics)

### Vision

Migrate Vitalisite from an Elementor-dependent theme (V1) to a **pure Full Site Editing (FSE) theme** with **zero plugin dependencies**, providing healthcare professionals with a modern, maintainable, and performant website solution.

### Business Goals

1. **Eliminate Elementor Dependency** - Remove reliance on Elementor page builder
2. **Zero Plugin Dependencies** - All functionality built into the theme using WordPress core features
3. **Feature Parity** - Maintain all V1 features in FSE-native implementation
4. **Commercial Product** - Sell to healthcare professionals at €89.99+ price point
5. **Modern Architecture** - Leverage WordPress 6.0+ FSE capabilities (Block Patterns, Block Themes, Site Editor)

---

## 🎯 Project Context

### Migration Overview

**From:** Vitalisite V1 (Elementor-based)

- Theme: `vitalisite` (Tailwind CSS + Elementor)
- Plugin 1: `vitalisite-core` (CPTs, Customizer, License)
- Plugin 2: `elementor-vitalisite` (15 custom widgets)

**To:** Vitalisite V2 FSE

- Theme: `vitalisite-fse` (Pure FSE, Block Patterns)
- **No plugins required** - All features native to theme
- WordPress 6.0+ Block Editor as page builder

### Why This Migration?

1. **Elementor Limitations:**
   - Heavy performance overhead
   - Vendor lock-in
   - Licensing costs for users
   - Complexity for non-technical users

2. **FSE Advantages:**
   - Native WordPress experience
   - Better performance
   - No plugin dependencies
   - Future-proof architecture
   - Easier maintenance

---

## 🔍 Feature Analysis - V1 Inventory

### Custom Post Types (3 Total)

#### 1. **Doctors CPT** (`doctors`)

**Current Implementation:**

- Slug: `/docteurs/`
- Supports: `title` only
- REST API enabled
- Menu icon: `dashicons-id`

**Meta Fields:**

- `_doctor_name` - Prénom
- `_doctor_last_name` - Nom
- `_doctor_photo` - Photo (attachment ID)
- `_doctor_speciality` - Spécialité (relationship to specialities CPT)
- `_doctor_phone_number` - Numéro de téléphone
- `_doctor_available_online` - Disponible en ligne (checkbox)

**FSE Migration Strategy:**

- ✅ Keep as CPT (register in `functions.php`)
- ✅ Convert meta boxes to **Block Editor custom fields** (ACF-style or core block bindings)
- ✅ Create block patterns for doctor profiles
- ✅ Create Query Loop patterns for doctor listings

---

#### 2. **Specialities/Services CPT** (`specialities`)

**Current Implementation:**

- Slug: `/specialites/`
- Elementor page builder support
- Archive and single templates

**FSE Migration Strategy:**

- ✅ Keep as CPT
- ✅ Create FSE templates (`templates/single-specialities.html`, `templates/archive-specialities.html`)
- ✅ Create block patterns for service pages
- ✅ Use core blocks for content (no Elementor)

---

#### 3. **Testimonials CPT** (`testimonials`)

**Current Implementation:**

- Slug: `/temoignages/`
- Custom meta boxes for author info
- Display widgets integration

**FSE Migration Strategy:**

- ✅ Keep as CPT
- ✅ Create testimonial block patterns
- ✅ Create Query Loop patterns for testimonial carousels
- ✅ Use core `core/quote` or custom block for display

---

### Elementor Widgets → Block Patterns (15 Total)

| #   | Widget Name                    | Description                               | FSE Migration Strategy                                             |
| --- | ------------------------------ | ----------------------------------------- | ------------------------------------------------------------------ |
| 1   | **Hero Widget**                | Full-width hero sections with CTA         | ✅ Block Pattern with `core/cover` + `core/buttons`                |
| 2   | **Slider Widget**              | Swiper.js powered image slider            | ✅ Block Pattern with custom JS (Swiper CDN) or native WP carousel |
| 3   | **Bento Grid Widget**          | Modern grid layouts                       | ✅ Block Pattern with `core/columns` + `core/group`                |
| 4   | **Dropdown/Accordion Widget**  | FAQ sections, expandable content          | ✅ Block Pattern with `core/details` (WP 6.3+) or custom block     |
| 5   | **Cards Widget**               | Service cards, team cards                 | ✅ Block Pattern with `core/columns` + `core/group`                |
| 6   | **Text Simple Widget**         | Clean text blocks                         | ✅ Native `core/paragraph` + `core/heading`                        |
| 7   | **Text + Image Widget**        | Combined content sections                 | ✅ Block Pattern with `core/media-text`                            |
| 8   | **Vitalisite Forms Widget**    | Custom contact forms with AJAX            | ⚠️ **CRITICAL** - Create custom block or use `core/form` (WP 6.8+) |
| 9   | **Image Widget**               | Optimized image display                   | ✅ Native `core/image`                                             |
| 10  | **Testimonials Widget**        | Display testimonials carousel             | ✅ Block Pattern with Query Loop + custom styling                  |
| 11  | **Doctor Presentation Widget** | Professional profile display              | ✅ Block Pattern with doctor CPT Query Loop                        |
| 12  | **Before/After Widget** ⭐     | Side-by-side comparison with carousel     | ✅ Block Pattern with custom JS (Swiper)                           |
| 13  | **Opening Hours Widget** ⭐    | Weekly calendar with "Open Now" indicator | ✅ Block Pattern with dynamic PHP + Customizer integration         |
| 14  | **Video Widget** ⭐            | YouTube/Vimeo embed + upload support      | ✅ Block Pattern with `core/embed` + `core/video`                  |
| 15  | **Pricing Widget** ⭐          | Pricing cards with CTAs                   | ✅ Block Pattern with `core/columns` + custom styling              |

---

### Customizer Options (Kirki Framework)

**Current Implementation:** Kirki Framework for WordPress Customizer

**Options to Migrate:**

#### Global Settings

- Practice address
- Phone number
- Email address
- Appointment booking link (Doctolib, Resalib, etc.)
- Contact form email recipient

#### Opening Hours (Enhanced)

- Toggle: Simple vs. Detailed format
- Individual fields for each day (Monday-Sunday)
- Custom time ranges per day

#### Colors & Typography

- Primary/secondary/accent colors
- Custom font selection
- Font sizes and line heights

#### Identity

- Logo upload
- Site icon/favicon

**FSE Migration Strategy:**

- ✅ Use **`theme.json`** for colors, typography, spacing
- ✅ Use **Customizer** for dynamic content (address, phone, hours)
- ⚠️ **Decision needed:** Keep Kirki or migrate to native Customizer API? -> Remove Kirki, use native Customizer API

---

### Special Features

#### 1. **Announcements System**

- Banner display (e.g., "Cabinet fermé cette date")
- Enable/disable toggle
- Custom text, background color, text color

**FSE Migration:**

- ✅ Block Pattern for announcement banner
- ✅ Customizer option to enable/disable
- Do it in time 2 (time 1 = MVP, time 2 = update after MVP)

---

#### 2. **Sticky Mobile CTA Bar** ⭐

- Two action types: "Appeler" / "Prendre rendez-vous"
- Auto-prefilled from global options
- Scroll-based animation

**FSE Migration:**

- ✅ Template Part (`parts/sticky-cta.html`)
- ✅ Custom JS for scroll behavior

---

#### 3. **Links Page (Linktree Alternative)**

- Social bio link page
- Custom meta boxes for unlimited links

**FSE Migration:**

- ✅ Custom FSE template (`templates/template-links-list.html`)
- ✅ Block Pattern for link cards

---

#### 4. **License System**

- Supabase API integration
- License key validation

**FSE Migration:**

- ✅ Keep as-is (PHP in `functions.php`) -> Maybe,cut the functions.php file and put API logic in inc/license.php or other file name To separate the code.

---

## 🚀 Core Requirements - V2 FSE

### Must-Have Features (MVP)

#### 1. **FSE Theme Structure**

- ✅ `theme.json` with complete design system
- ✅ Block templates for all page types
- ✅ Template parts (header, footer, sidebar)
- ✅ Block patterns for all V1 widgets

#### 2. **Custom Post Types**

- ✅ Doctors CPT with custom fields
- ✅ Specialities CPT with custom fields
- ✅ Testimonials CPT with custom fields

#### 3. **Block Patterns (15+ patterns)**

- ✅ Hero patterns (3-5 variations)
- ✅ Service cards patterns
- ✅ Testimonial patterns
- ✅ Doctor profile patterns
- ✅ Before/After comparison pattern
- ✅ Opening hours pattern
- ✅ Pricing pattern
- ✅ Contact form pattern
- ✅ FAQ/Accordion pattern
- ✅ Video embed pattern

#### 4. **Customizer Integration**

- ✅ Global settings (address, phone, email)
- ✅ Opening hours (detailed per day)
- ✅ Appointment booking link
- ✅ Announcement banner settings
- ✅ Sticky CTA settings

#### 5. **Forms System**

- ✅ Contact form block (AJAX submission)
- ✅ Email notifications
- ✅ Spam protection (nonce)

#### 6. **Performance**

- ✅ Zero plugin dependencies
- ✅ Optimized asset loading
- ✅ Minimal JavaScript

---

## 🎨 Design System (theme.json)

### Color Palette

- **Vital Blue** (#0B3D91) - Primary
- **Vital Sky** (#6EC1E4) - Secondary
- **Vital Ink** (#0F172A) - Text
- **Vital Mist** (#F1F5F9) - Background

### Typography

- **Humanist Sans** - Trebuchet MS, Segoe UI
- **Classique Serif** - Georgia, Times New Roman

---

## 🛠️ Technical Architecture

### Theme Structure

```
vitalisite-fse/
├── theme.json
├── functions.php
├── style.css
├── assets/
│   ├── styles/
│   ├── js/
│   └── images/
├── parts/
│   ├── header.html
│   ├── footer.html
│   └── sticky-cta.html
├── templates/
│   ├── index.html
│   ├── single-doctors.html
│   ├── archive-doctors.html
│   ├── single-specialities.html
│   ├── archive-specialities.html
│   └── template-links-list.html
└── patterns/
    ├── header-*.php
    ├── hero-*.php
    ├── services-*.php
    ├── testimonials-*.php
    ├── doctors-*.php
    ├── before-after.php
    ├── opening-hours.php
    ├── pricing-*.php
    ├── contact-form.php
    └── faq-accordion.php
```

---

## 📊 Success Criteria

### Functional Requirements

- ✅ All V1 features available in V2
- ✅ Zero plugin dependencies
- ✅ Block Editor as primary page builder
- ✅ Performance equal or better than V1

### Non-Functional Requirements

- ✅ WCAG 2.1 AA accessibility compliance
- ✅ RGAA 4.1 compliance
- ✅ Mobile-first responsive design
- ✅ SEO-optimized semantic HTML

### Business Requirements

- ✅ Easy migration path for V1 customers
- ✅ Comprehensive documentation

---

## 🚧 Open Questions & Decisions

### 1. **Forms System**

**Challenge:** Elementor Forms Widget → FSE equivalent  
**Options:**

- A) Create custom contact form block
- B) Use WordPress 6.8+ native `core/form` block
- C) Recommend third-party form plugin (breaks zero-dependency goal)

**Decision:** A or B, will see what is better maybe b ?

---

### 2. **Kirki Framework**

**Challenge:** Kirki dependency for Customizer  
**Options:**

- A) Keep Kirki (adds plugin dependency)
- B) Migrate to native Customizer API

**Decision:** B

---

### 3. **JavaScript Libraries**

**Challenge:** Swiper.js, GSAP for animations  
**Options:**

- A) Bundle in theme
- B) Load from CDN
- C) Replace with CSS-only solutions

**Decision:** A -> if you have suggestions, let me know.

---

## 📅 Implementation Phases

### Phase 1: Foundation (Weeks 1-2)

- Setup `theme.json` with design system
- Create base templates and template parts
- Register CPTs in `functions.php`
- Setup Customizer options

### Phase 2: Core Patterns (Weeks 3-4)

- Header/footer patterns
- Hero patterns (3-5 variations)
- Service card patterns
- Testimonial patterns

### Phase 3: Advanced Patterns (Weeks 5-6)

- Before/After pattern
- Opening hours pattern
- Pricing patterns
- Contact form pattern
- FAQ/Accordion pattern

### Phase 4: CPT Integration (Week 7)

- Doctor profile templates and patterns
- Specialities templates and patterns
- Testimonials templates and patterns

### Phase 5: Dynamic Features (Week 8)

- Sticky CTA implementation
- Announcement banner system
- Forms AJAX handling
- Links page template

### Phase 6: Polish & Testing (Weeks 9-10)

- Accessibility audit
- Performance optimization
- Browser testing
- Documentation

---

## 📚 Reference Documents

- ✅ [`project-context.md`](file:///Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/_bmad-output/project-context.md)
- ✅ [`FEATURES.md`](file:///Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/wp-content/themes/vitalisite/FEATURES.md)
- ✅ [`ROADMAP.md`](file:///Users/quentin/Documents/sites/free/Medi-site/Vitalisite/wordpress-vitalisite-v2-FSE/wp-content/themes/vitalisite/ROADMAP.md)

---

**Next Steps:**

1. Review and approve this PRD
2. Make decisions on open questions (forms, Kirki, dynamic content)
3. Create detailed Architecture document
4. Create Epics & Stories for implementation
