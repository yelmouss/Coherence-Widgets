# Coherence Widgets Bundle

**Extension site:** https://www.agence-coherence.fr/

**Developed by:** yelmouss

**Supported by:** the Coherence team

---

## Overview

The **Coherence Widgets** plugin provides a collection of premium Elementor widgets:
- **Slider Coherence** – advanced hero carousel with repeater slides, full styling control, autoplay, and custom animations.
- **Popup Coherence** – fully customizable pop‑up widget supporting multiple trigger types (click, page load, scroll, exit‑intent), overlay styling, animation, and accessibility (ARIA roles, focus trap).
- Additional widgets: Before/After, Testimonial, Pricing, Features, Divider.

All widgets follow WordPress coding standards, are translatable, and integrate seamlessly with Elementor.

---

## Installation
1. Upload the `Coherence Widgets` folder to `wp-content/plugins/`.
2. Activate the plugin from the WordPress admin.
3. Ensure Elementor (minimum version 3.0) is installed and active.
4. The widgets appear under the **Coherence** category in Elementor’s panel.

---

## Usage Highlights
### Slider Coherence
- Add unlimited slides via a repeater.
- Customize background image, overlay colour, text position, card background, button text/link.
- Control autoplay, speed, and animation (fade, slide, zoom).

### Popup Coherence
- Choose trigger: **Click** (CSS selector), **Page Load**, **Scroll** (percentage), **Exit‑Intent**.
- Set overlay colour, popup background, text colour, and entry animation.
- Include image, title, description, and CTA button per slide.
- Accessible close button with ARIA label and focus management.

---

## Assets
- JavaScript: `assets/js/coherence-popup.js` (handles triggers, opening/closing, animations, focus trapping).
- CSS: `assets/css/coherence-popup.css` (modern overlay, responsive layout, smooth transitions).
- Widget scripts/styles are registered automatically when the plugin loads.

---

## Development
- **Repository:** https://github.com/yelmouss/Coherence-Widgets (mirrored under `yelmouss/Coherence-Widgets`).
- To add new widgets, create a class extending `\Elementor\Widget_Base` in the `widgets/` directory and register it in `coherence-widgets.php`.
- Run `npm run dev` if you add new JS/CSS build steps (future extensions).

---

## Support
- Open issues on GitHub or contact **support@agence-coherence.fr** for assistance.

---

*© 2026 Agence Coherence – All rights reserved.*
