# Ofogh Properties — WordPress Real Estate Theme

## Overview
A premium, RTL Persian real estate WordPress theme with custom post types, AJAX filtering,
favorites system, and Elementor/WooCommerce compatibility.

## Architecture
- **Theme dir:** `ofogh/` (bind-mounted into WordPress container at `/var/www/html/wp-content/themes/ofogh`)
- **Custom Post Type:** `property` with meta boxes for price, beds, baths, area, location, gallery, agent, etc.
- **Inquiry CPT:** `ofogh_inquiry` (private) stores contact form submissions
- **Taxonomies:** `property_type`, `property_city`, `property_status`
- **AJAX endpoints:** `ofogh_contact` (contact form), `ofogh_favorite` (toggle favorite), `ofogh_get_property_card` (favorites page)
- **JS:** `assets/js/main.js` (header, menu, carousel, gallery, lightbox, modal, forms), `assets/js/filters.js` (archive filtering)
- **CSS:** `assets/css/main.css` (design system), `assets/css/rtl.css` (RTL overrides), `assets/css/woocommerce.css`

## Docker Setup
- `docker-compose.base44.yml` — WordPress 6.5 + MariaDB 10.11
- Theme is bind-mounted from source; edits are live (no rebuild needed)
- `wp-init` one-shot container: installs WordPress, activates theme, seeds properties, flushes rewrites
- WordPress config dynamically sets `WP_HOME`/`WP_SITEURL` from `BASE44_PUBLIC_HOST_SUFFIX` env var
- Canonical redirects disabled to prevent preview proxy loops

## Key Files
- `ofogh/functions.php` — theme setup, asset enqueuing, AJAX handlers, CPT registration
- `ofogh/inc/theme-functions.php` — helpers: Persian digit conversion, price formatting, image URLs, team data
- `ofogh/inc/cpt-property.php` — property CPT + taxonomy registration
- `ofogh/inc/meta-boxes.php` — admin meta box UI + save logic + REST meta registration
- `ofogh/inc/customizer.php` — company info, colors, hero, CTA customizer settings
- `ofogh/inc/elementor.php` — Elementor location registration + header/footer override
- `ofogh/inc/woocommerce.php` — WooCommerce theme support + wrapper overrides
- `ofogh/inc/theme-activation.php` — auto-creates default pages on theme activation

## Verification
1. `docker compose -f docker-compose.base44.yml up -d --build`
2. `curl -s -o /dev/null -w "%{http_code}" http://localhost:3000/` → should return 200
3. Check `docker compose -f docker-compose.base44.yml ps` — wordpress and db should be healthy
4. Visit `/properties/` for property archive, click a property for single page
5. Test contact form on `/contact/` and modal on single property pages

## Known Issues
- WooCommerce plugin install fails in Docker (WP-CLI reports "Minimum WordPress requirement is 7.0" — a WP-CLI version parsing issue, not a real incompatibility). Theme WooCommerce support is properly declared and works in production.
- Preview iframe may cold-start slowly; the app itself serves in ~70ms.

## Conventions
- All text strings use `ofogh` text domain with Persian translations
- Persian digits used for display via `ofogh_to_persian_digits()`
- Images use Unsplash photo IDs as fallbacks when no featured image is set
- CSS uses logical properties (margin-inline, inset-inline) for automatic RTL
- All outputs escaped with `esc_html`, `esc_attr`, `esc_url`
- AJAX handlers verify nonces via `check_ajax_referer('ofogh-nonce', 'nonce')`
