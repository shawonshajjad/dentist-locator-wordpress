# Dentist Locator with Interactive Australia Map

A custom WordPress directory plugin for discovering dental practices through an interactive SVG map of Australia and AJAX-powered search. The project combines a dedicated Dentist custom post type, structured practice metadata, state-based browsing, and a responsive frontend finder.

## Highlights

- **Dentist Custom Post Type** for managing dental practices in WordPress
- **Interactive SVG map of Australia** covering WA, NT, SA, QLD, NSW, ACT, VIC and TAS
- **AJAX search** without full-page reloads
- Search by practice/doctor text, location and taxonomy data
- **State-based filtering** directly from the map
- Dentist metadata including address, phone, email, website, postcode, category and state
- **Configurable no-results experience** through WordPress admin settings
- Responsive frontend interface
- Lightweight implementation using WordPress APIs, PHP, JavaScript and CSS

## How It Works

1. Administrators create and maintain records in the **Dentists List** custom post type.
2. Practice details are stored as WordPress post metadata.
3. The `[dentist_locator]` shortcode renders the public finder.
4. Visitors can enter a search term or select an Australian state on the SVG map.
5. JavaScript sends the request to WordPress AJAX endpoints and updates the result area dynamically.

## Shortcode

```text
[dentist_locator]
```

Add the shortcode to any WordPress page where the locator should appear.

## Project Structure

```text
dentist-locator-wordpress/
├── dentist-locator.php
├── README.md
└── assets/
    ├── css/
    │   └── dentist-locator.css
    └── js/
        └── dentist-locator.js
```

## Technical Overview

- WordPress Custom Post Types
- Post Meta / Metadata API
- WordPress Settings API
- `admin-ajax.php` AJAX handlers
- Shortcode API
- Interactive inline SVG
- Vanilla JavaScript
- Responsive CSS

## Installation

1. Download or clone the repository.
2. Copy it to `wp-content/plugins/dentist-locator-wordpress/`.
3. Activate the plugin from **Plugins** in WordPress.
4. Add dentist records from the WordPress dashboard.
5. Place `[dentist_locator]` on the required page.

## Portfolio Note

This repository demonstrates a custom WordPress directory/search solution built around a real-world location-discovery workflow rather than a generic listing template. The map, search, custom content model and administrative settings are implemented as plugin functionality.

## Author

**Sajjadur Rahaman Shawon**  
GitHub: https://github.com/shawonshajjad
