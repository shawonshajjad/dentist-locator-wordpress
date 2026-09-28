# Dentist Locator with Interactive Australia Map

A portfolio-grade WordPress directory/search plugin for Australian dental practices.

## Engineering highlights

- Namespaced-by-prefix class architecture with separated responsibilities
- Public AJAX search protected by a WordPress nonce
- Strict request allowlisting, sanitization and escaped output
- Bounded queries rather than unbounded `posts_per_page => -1`
- Search supports WordPress title/content search plus selected structured meta
- Frontend assets load only when the shortcode is rendered
- Accessible search controls, keyboard-operable state controls and ARIA live results
- Abortable AJAX requests and user-facing network/error handling
- Lazy-loaded images and safe external links
- Sanitized Settings API values
- Translation-ready user-facing strings
- REST-enabled Dentist CPT

## Structure

```
dentist-locator.php
includes/
  class-dl-plugin.php
  class-dl-post-type.php
  class-dl-search.php
  class-dl-settings.php
templates/
  locator.php
  dentist-card.php
assets/
  css/dentist-locator.css
  js/dentist-locator.js
```

## Installation

1. Copy the plugin directory into `wp-content/plugins/`.
2. Activate **Dentist Locator with Interactive Australia Map**.
3. Add dentist records under **Dentists**.
4. Configure **Dentists → Locator Settings**.
5. Add `[dentist_locator]` to a page.

## Security

The public search endpoint verifies a nonce, allowlists filter types/state values, unslashes and sanitizes request values, limits input length and result count, and escapes output at render time.

## Accessibility

The locator uses native buttons for state selection, visible keyboard focus, associated labels, a named search button, an ARIA live result region and reduced-motion support.

## Performance

Results are bounded to 50 records per request, unnecessary term-cache work is disabled, stale frontend requests are aborted, images are lazy loaded, and plugin assets are enqueued only when the shortcode renders.

## Author

Shajjadur Rahaman Shawon
