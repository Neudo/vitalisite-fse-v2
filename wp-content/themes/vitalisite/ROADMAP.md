# Vitalisite - Product Roadmap

**Current Version:** 1.0.0  
**Last Updated:** 2026-01-09

This document tracks planned features, improvements, and ideas for future versions of Vitalisite.

---

## 🎯 Primary Goal

**Become the reference WordPress theme for health & medical professionals** by providing the most complete, user-friendly solution that eliminates the need for expensive SaaS subscriptions.

---

## 🚀 Planned Features

### v1.1.0 - New Elementor Widgets (In Progress)

#### 1. Avant / Après Comparaison Widget ⭐ COMPLETED

**Status:** ✅ Implemented  
**Target:** v1.1.0  
**Completion:** 2026-01-09

**Features Implemented:**

- ✅ Static side-by-side image display (Avant/Après)
- ✅ Optional carousel mode with Swiper.js
- ✅ Custom navigation buttons (glass-morphism design)
- ✅ Autoplay option for carousel
- ✅ Customizable labels ("Avant"/"Après")
- ✅ Optional widget title and description
- ✅ Responsive design (mobile/desktop)
- ✅ Image centering with fixed height (300px)
- ✅ Privacy disclaimer option
- ✅ French localization (back-office)
- ✅ Tailwind CSS styling
- ✅ Background colors and rounded corners

**Use Cases:** Dentistry, dermatology, physiotherapy, orthodontics, plastic surgery and more

**Business Impact:** HIGH - Visual impact, major differentiator for aesthetic/dental practices

**Technical Notes:**

- Simplified from complex drag-slider to static side-by-side layout
- Uses `object-fit: contain` for proper image scaling
- Custom Swiper navigation with modern glass-morphism styling
- Fully responsive with consistent aspect ratios

---

#### 2. Sticky Mobile CTA Bar ⭐ COMPLETED

**Status:** ✅ Implemented  
**Target:** v1.1.0  
**Completion:** 2026-01-10

**Features Implemented:**

- ✅ Two action types: "Appeler" (Call) and "Prendre rendez-vous" (Book appointment)
- ✅ Auto-prefilled fields from global theme options (phone number, appointment URL)
- ✅ Customizable button text per action type
- ✅ Automatic icons (phone/calendar) based on action type
- ✅ Customizable background color (defaults to primary theme color)
- ✅ Scroll-based animation (appears after 150px scroll, hides when scrolling up)
- ✅ Responsive positioning (full width on mobile, right-aligned on desktop)
- ✅ Desktop hide option
- ✅ Glass-morphism design with backdrop blur
- ✅ WordPress Customizer integration
- ✅ French localization

**Use Cases:** All medical practices needing mobile conversion optimization

**Business Impact:** HIGH - Improves mobile conversion rate with sticky CTAs

**Technical Notes:**

- Template part integrated in footer.php
- Kirki Customizer options with conditional fields
- Pure CSS animations with transform translateY
- Scroll event throttling for performance
- Clean separation of CSS/Tailwind without conflicts

---

#### 3. Insurance/Payment Methods Widget

**Status:** Planning  
**Target:** v1.1.0

**Features:**

- Visual logo grid of accepted insurances
- Payment methods icons (card, cash, check, payment plans)
- Filterable by service type
- "Contact us for insurance questions" CTA
- Responsive grid layout

**Business Impact:** MEDIUM-HIGH - Answers #1 patient question

---

#### 4. Enhanced Opening Hours + Availability Widget ⭐ COMPLETED

**Status:** ✅ Implemented  
**Target:** v1.1.0  
**Completion:** 2026-01-19

**Features Implemented:**

- ✅ Visual weekly calendar display with responsive grid
- ✅ "Open Now" / "Closed" indicator with color coding (green/red)
- ✅ Current day highlighting with theme colors
- ✅ Emergency contact display outside business hours
- ✅ Click to call during open hours (conditional phone CTA)
- ✅ Appointment booking CTA (always available)
- ✅ Modern design with theme color integration
- ✅ Animated pulse indicator for "Open Now" status
- ✅ Emergency text with theme-colored styling
- ✅ Responsive layout (1-4 columns based on screen size)
- ✅ French localization (back-office)
- ✅ Integration with WordPress Customizer settings
- ✅ Shadow effects and smooth transitions
- ✅ Custom CTA buttons with icons and hover effects

**Use Cases:** All medical practices needing clear, professional hours display

**Business Impact:** HIGH - Professional appearance, improves patient trust and conversion rates

**Technical Notes:**

- Uses existing WordPress Customizer settings for hours
- Dynamic color integration with theme primary colors
- Responsive grid with Tailwind CSS
- Manual hex-to-RGB conversion for theme compatibility
- Conditional CTA display based on business hours
- Clean separation of display logic and styling

---

#### 6. Google Reviews/Testimonials Aggregator Widget ⭐ COMPLETED

**Status:** Planning  
**Target:** v1.1.0 or v1.2.0

**Features:**

- Auto-pull from Google My Business API
- Star rating display
- Filter by rating/date
- Highlight specific testimonials
- "Write a review" CTA
- Verified patient badge option
- Integration with existing Testimonials CPT

**Business Impact:** HIGH - Social proof drives conversions

---

#### 7. Credentials & Certifications Showcase Widget

**Status:** Planning  
**Target:** v1.1.0 or v1.2.0

**Features:**

- Logo grid of certifications/memberships
- Hover for details
- Link to verification (medical board, associations)
- Awards/recognitions section
- Years of experience counter
- Education timeline

**Business Impact:** MEDIUM - Builds trust and authority

---

#### 8. Video Embed Widget (Medical-Optimized) ⭐ COMPLETED

**Status:** ✅ Implemented  
**Target:** v1.2.0  
**Completion:** 2026-01-20

**Features Implemented:**

- ✅ Dual source: YouTube/Vimeo URL input OR video upload (MP4/WebM/OGG)
- ✅ Automatic platform detection (YouTube/Vimeo)
- ✅ Optional title and description with WYSIWYG editor
- ✅ Optional CTA button with theme color integration
- ✅ Responsive iframe embed with aspect ratio (16:9)
- ✅ HTML5 video player for uploaded files with controls
- ✅ Thumbnail preview option with play button overlay (URL source only)
- ✅ Autoplay settings (muted for browser compatibility)
- ✅ Style options (rounded/sharp corners)
- ✅ Content alignment (left/center/right)
- ✅ Fallback for unsupported URLs
- ✅ French localization (back-office)
- ✅ Tailwind CSS styling with theme integration
- ✅ Hover effects and smooth transitions

**Use Cases:** Patient education videos, procedure demonstrations, practice presentations, treatment explanations, promotional content, hosted video content

**Business Impact:** HIGH - Improves patient education and engagement, reduces consultation time, enables professional video hosting

**Technical Notes:**

- Dual source system: URL (YouTube/Vimeo) + Upload (MP4/WebM/OGG)
- API integration for Vimeo thumbnails
- Embed parameters optimization (no related videos, modest branding)
- HTML5 video player with multiple format support
- Responsive design with proper aspect ratios
- Theme color integration for CTAs
- Clean separation of display logic and helper functions
- JavaScript-free thumbnail-to-video toggle

---

#### 9. Newsletter/Email Signup Widget

**Status:** Planning  
**Target:** v1.2.0

**Features:**

- Simple email collection form
- GDPR compliance checkbox
- Custom success message
- Integration with email marketing services (Mailchimp, Sendinblue)
- "Get health tips + practice updates" messaging

**Business Impact:** LOW-MEDIUM - List building for marketing

---

#### 10. Pricing Widget ⭐ NEW ⭐ COMPLETED

**Status:** In Development  
**Target:** v1.1.0  
**Priority:** HIGH

**Features:**

- Optional title and description
- Repeater for pricing cards with:
  - Card title
  - Optional background color
  - Price display
  - Optional CTA per card (with download support)
- Global CTA at bottom (appointment booking)
- Responsive card grid layout
- Customizable styling and colors
- French localization

**Business Impact:** HIGH - Essential for service-based medical practices, direct revenue driver

**Use Cases:** Consultations, treatments, packages, memberships

---

### v1.3.0 - Booking System Plugin (SaaS Model)

#### 11. Booking System Plugin ⭐ MAJOR FEATURE

**Status:** Concept Phase  
**Target:** v1.3.0  
**Business Model:** €19/month subscription with 1-3 months free trial

**MVP Features:**

- WordPress admin calendar interface
- Email reminders (patient + practitioner)
- Patient database (name, lastname, email, phone, notes)
- Front-end booking interface:
    - List view
    - Calendar view
- Simple time slot management
- Booking confirmation system
- Basic availability management

**Dream Features (Future):**

- Google Calendar sync (import existing appointments)
- Doctolib-style patient flow (choose specialty → date → time)
- SMS reminders
- Anti-bot protection (reCAPTCHA)
- Payment integration
- Recurring appointments
- Cancellation/rescheduling
- Multi-practitioner support
- Waiting list functionality

**Business Impact:** VERY HIGH - Recurring revenue stream, major differentiator, replaces expensive SaaS

---

### v2.0+ - Future Considerations

#### 12. Patient Journey Timeline Widget

**Status:** Ideas  
**Target:** v2.0+

**Potential for:**

- Integration with Specialties CPT
- Step-by-step treatment process visualization
- "How it works" section for complex treatments

---

## 💡 Feature Ideas (Deferred/Rejected)

**Not implementing (for now):**

- Video consultation widget (too complex, third-party solutions exist)
- Patient portal login (too heavy, security concerns)
- Symptom checker (liability issues)
- Medical forms download center (niche use case)
- Live chat (third-party solutions better)
- Multi-office map widget (Google Maps embed sufficient)
- Prescription refill forms (regulatory complexity)
- Waitlist signup (can be added to booking plugin later)

---

## 🔄 Continuous Improvements

### Code Quality

- [ ] Refactor legacy code
- [ ] Improve code documentation
- [ ] Standardize coding conventions
- [ ] Performance optimization
- [ ] Security audit

### User Experience

- [ ] Simplify customizer interface
- [ ] Add more pre-built templates
- [ ] Improve onboarding flow
- [ ] Enhanced documentation
- [ ] Video tutorials

### Technical Debt

- [ ] Update dependencies
- [ ] Improve error handling
- [ ] Add automated testing
- [ ] Better logging system
- [ ] Code cleanup

---

## 💡 Feature Ideas (Unsorted)

_This section will be populated during brainstorming sessions and user feedback collection._

---

## 📊 Version History

### v1.0.0 (Current - Live)

- Initial release
- 11 custom Elementor widgets
- 3 custom post types
- Advanced customizer with Kirki
- Linktree-style page template
- License management system
- Auto-setup on activation
- Complete documentation

---

## 🎯 Success Metrics

**Current Status:**

- Active Paid Users: 1
- Price Point: €89.99
- Conversion Rate: TBD

**Goals:**

- Increase user base
- Improve conversion rate
- Reduce support requests
- Increase customer satisfaction
- Build market reputation

---

## 📝 Notes

- Focus on features that drive sales
- Prioritize features that differentiate from competitors
- Consider features that reduce dependency on external SaaS
- Balance between feature richness and simplicity
- Maintain code quality and performance

---

**Next Steps:**

1. Complete brainstorming session to identify high-value features
2. Conduct competitive analysis
3. Survey potential customers for pain points
4. Prioritize roadmap based on business impact
5. Plan v1.1.0 release scope
