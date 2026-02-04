# Vitalisite - Complete Feature List

**Version:** 1.0.0  
**Last Updated:** 2026-01-09

This document provides a comprehensive inventory of all features available in the Vitalisite WordPress theme for medical websites.

---

## 🎨 Core Theme Features

### Design & Frontend

- **Modern Tailwind CSS Framework** - Utility-first CSS with custom medical-focused design
- **Responsive Design** - Mobile-first approach, optimized for all devices
- **GSAP Animations** - Smooth scroll animations and interactive elements via GSAP + ScrollTrigger
- **Alpine.js Integration** - Lightweight JavaScript framework for interactive components
- **Swiper.js Slider** - Modern touch slider for carousels and galleries
- **Custom Typography** - Tailwind Typography integration with customizable prose styles

### Navigation & Menus

- **Primary Navigation Menu** - Fully customizable header menu
- **Footer Menu** - Dedicated footer navigation
- **Custom Menu Walker** - Advanced submenu support with chevron indicators
- **Mobile-Responsive Navigation** - Toggle submenu functionality
- **Appointment CTA Button** - Integrated booking button in navigation with custom link

### Color Intelligence

- **Automatic Color Contrast Detection** - `is_light_color()` function calculates luminance
- **W3C Compliant Luminance Calculation** - Ensures accessibility standards
- **Dynamic Text Color Adjustment** - Automatically adjusts text color based on background

---

## 🔌 Custom Plugins

### Vitalisite Core Plugin (v1.0.2)

#### Custom Post Types (CPT)

1. **Services/Specialties CPT** (`specialities`)

    - Dedicated post type for medical services/specialties
    - Elementor page builder support
    - Custom meta boxes for service details
    - Archive and single page templates
    - Custom slug: `/specialites/`

2. **Testimonials CPT** (`testimonials`)

    - Patient testimonials management
    - Custom meta boxes for author info
    - Display widgets integration
    - Custom slug: `/temoignages/`

3. **Announcements System**
    - Banner announcement display (e.g., "Cabinet fermé cette date")
    - Enable/disable toggle
    - Custom text input
    - Background color picker
    - Text color picker
    - Admin menu interface

#### Customizer Options (Kirki Framework)

**Global Settings:**

- Practice address
- Phone number
- Email address
- Appointment booking link (Doctolib, Resalib, etc.)
- Contact form email recipient

**Opening Hours (Enhanced):**

- Toggle between simple and detailed format
- Individual fields for each day of the week:
    - Monday through Sunday
    - Custom time ranges per day
    - Placeholder examples
- Backward compatible with simple format
- Display widget for Elementor forms

**Contact Information:**

- Dedicated contact settings panel
- Email configuration for forms

**Typography:**

- Custom font selection
- Font size controls
- Line height adjustments

**Colors:**

- Primary color picker
- Secondary color picker
- Accent colors
- Background colors
- Text colors

**Identity:**

- Logo upload
- Site icon/favicon
- Brand customization

**Page Settings:**

- Custom page templates
- Layout options

**Navigation Menus:**

- Menu styling options
- Mobile menu customization

#### Welcome Screen

- Theme activation guide
- Required plugins checklist
- Customization guide
- Help resources
- Quick start documentation

#### License System

- API integration with Supabase
- License key validation
- Activation status checking
- Feature gating based on license status

---

### Elementor Vitalisite Plugin (v1.0.1)

#### Custom Elementor Widgets (11 Total)

1. **Hero Widget**

    - Full-width hero sections
    - Custom styling options
    - Call-to-action integration

2. **Slider Widget**

    - Swiper.js powered
    - Touch-enabled
    - Multiple slide layouts

3. **Bento Grid Widget**

    - Modern grid layouts
    - Responsive columns
    - Medical content display

4. **Dropdown Widget**

    - Accordion functionality
    - FAQ sections
    - Expandable content

5. **Cards Widget**

    - Service cards
    - Team member cards
    - Info boxes

6. **Text Simple Widget**

    - Clean text blocks
    - Typography controls

7. **Text + Image Widget**

    - Combined content sections
    - Image positioning options
    - Responsive layouts

8. **Vitalisite Forms Widget**

    - Custom contact forms
    - AJAX form submission
    - Dynamic field support
    - Email notifications
    - Nonce security
    - Custom field validation
    - Sends to customizer email setting

9. **Image Widget**

    - Optimized image display
    - Custom styling

10. **Testimonials Widget**

    - Display patient testimonials
    - Carousel/grid layouts
    - Star ratings support

11. **Doctor Presentation Widget**
    - Professional profile display
    - Credentials showcase
    - Photo integration

#### Elementor Enhancements

- **Custom Vitalisite Category** - All widgets organized in dedicated category
- **Hidden Default Categories** - Cleaner widget panel (hides WordPress, Basic, General, Pro, Theme Elements)
- **Custom Styling** - Pre-built Tailwind CSS styles for all widgets
- **Template Auto-Import** - Pre-built page templates imported on activation
- **Elementor Settings Auto-Configuration** - Disables color/typography schemes, enables CPT support

---

## 🚀 Automation & Setup Features

### Theme Activation

- **Auto-redirect to Plugin Installation** - Guides users to install required plugins
- **Default Page Creation** - Automatically creates Home and Blog pages
- **Front Page Configuration** - Sets static homepage automatically
- **Elementor Configuration** - Auto-configures Elementor settings for optimal use

### Required Plugins (TGM Plugin Activation)

**Mandatory:**

- Elementor
- Kirki Customizer Framework
- Elementor Vitalisite (bundled)
- Vitalisite Core (bundled)
- Secure Custom Fields (ACF alternative)

**Recommended:**

- Image Optimization
- All in One SEO Pack

### Template System

- **Pre-built Page Templates** - JSON-based Elementor templates
- **Auto-import on Activation** - Templates available immediately
- **Medical-Focused Designs** - Ready-to-use layouts for medical practices

---

## 📄 Special Page Templates

### Links Page (Linktree Alternative)

- **Social Bio Link Page** - Like Linktree for Instagram/TikTok bios
- **Custom Meta Boxes** - Add unlimited links
- **Responsive Design** - Mobile-optimized
- **Custom Template** - Dedicated page template
- **Easy Management** - Simple admin interface

---

## 🎯 Frontend Features

### Forms & Contact

- **AJAX Contact Forms** - No page reload
- **Custom Field Support** - Dynamic form fields with `custom_` prefix
- **Email Notifications** - Automatic email sending
- **Spam Protection** - WordPress nonce verification
- **Validation** - Email and field validation

### Performance

- **Optimized Asset Loading** - Conditional script/style loading
- **CDN Integration** - GSAP, Alpine.js, Swiper from CDN
- **Minified Scripts** - Production-ready JS/CSS
- **Cache Busting** - Version-based asset URLs

### SEO & Accessibility

- **Semantic HTML5** - Proper markup structure
- **RSS Feed Support** - Automatic feed links
- **Title Tag Management** - WordPress title tag support
- **Responsive Embeds** - YouTube, Vimeo, etc.
- **Editor Styles** - WYSIWYG matches frontend

---

## 🛠️ Developer Features

### Code Architecture

- **Modular Structure** - Organized includes directory
- **Constants System** - Centralized configuration
- **Template Tags** - Custom helper functions
- **Template Functions** - Theme enhancement hooks
- **Custom Walker Classes** - Advanced menu control

### Build System

- **npm Scripts** - `dev`, `watch`, `bundle`
- **Tailwind CSS Compilation** - JIT mode
- **esbuild Integration** - Fast JavaScript bundling
- **Production Bundling** - Automated theme packaging
- **Version Management** - Automatic version stamping

### Extensibility

- **Action Hooks** - WordPress standard hooks
- **Filter Hooks** - Customization points
- **Plugin API** - Easy plugin integration
- **Child Theme Support** - Standard WordPress child theme compatibility

---

## 📱 Technical Specifications

### WordPress Compatibility

- **Minimum WordPress Version:** 5.0+
- **Tested up to:** Latest WordPress version
- **PHP Version:** 7.4+
- **Elementor Version:** 3.25.0+

### Frontend Technologies

- Tailwind CSS 3.x
- Alpine.js 3.x
- GSAP 3.12.7
- Swiper 10.0
- Vanilla JavaScript

### Backend Technologies

- PHP 7.4+
- WordPress REST API
- Kirki Framework 4.x
- TGM Plugin Activation

---

## 🔐 Security Features

- **Nonce Verification** - All AJAX requests protected
- **Data Sanitization** - Input cleaning on all forms
- **Email Validation** - Built-in email verification
- **License Validation** - API-based license checking
- **Secure File Access** - ABSPATH checks throughout

---

## 📊 Business Features

### License Management

- **Supabase Integration** - Cloud-based license storage
- **API Validation** - Real-time license checking
- **Customer Data Tracking** - Usage analytics
- **Feature Gating** - License-based feature access

### Documentation

- **Screenshot-Based Guides** - Visual documentation on vitalisite.com
- **Welcome Screen** - In-dashboard help
- **Customization Guides** - Step-by-step tutorials

---

## 🎨 Customization Capabilities

Users can customize:

- ✅ Colors (primary, secondary, accents)
- ✅ Typography (fonts, sizes, weights)
- ✅ Logo and branding
- ✅ Navigation menus
- ✅ Contact information
- ✅ Opening hours (per day)
- ✅ Appointment booking links
- ✅ Page layouts via Elementor
- ✅ All widget content and styling
- ✅ Announcement banners
- ✅ Footer content

---

## 📦 Included Assets

- Custom fonts directory structure
- Icon system integration
- Image optimization support
- Upload directory management
- Asset URL helpers

---

**Note:** This theme is specifically designed for medical and healthcare professionals including doctors, dentists, therapists, clinics, and medical practices.
