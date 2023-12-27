# WP Rocket | Reset Cache Table

Resets the cache table to its original state. Useful when a cache table is bloated, and you want to start from scratch. Thisis a one-time use plugin, upon activation this helper will:
- Truncate wpr_rocket_cache table
- Clear WP Rocket’s cache
- Deactivate and Reactivate WP Rocket’s Preload, so the process starts fresh, with the sitemap URLs only

Last tested with:
* WP Rocket {3.15.6}
* WordPress {6.4.2}
