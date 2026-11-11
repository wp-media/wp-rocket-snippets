# WP Rocket | Prevent Query Root Purge

Removes query-string root URLs from WP Rocket's automatic cache purging when a post is updated.

🚧&#160;&#160;**ADVANCED CUSTOMIZATION, HANDLE WITH CARE!**

## Prevent query-string URLs from resolving to the cache root

This helper removes URLs such as:

- `https://example.com/?document_template=2583`
- `https://example.com?example=value`

It keeps normal URLs and query-string URLs with a non-root path, such as:

- `https://example.com/product/example-product/`
- `https://example.com/product/example-product/?example=value`

WP Rocket applies the `rocket_post_purge_urls` filter before passing the post purge list to `rocket_clean_files()`. Query strings are not part of the cache filesystem path, so a query-string URL whose path is `/` could otherwise resolve to the domain's cache root.

This helper only filters automatic post purge lists. It does not filter URLs passed directly to `rocket_clean_files()` by custom code.

## Installation

1. Download the ZIP file.
2. In WordPress, go to **Plugins > Add New > Upload Plugin**.
3. Upload the ZIP file and activate **WP Rocket | Prevent Query Root Purge**.

To be used with:

- WP Rocket
- Any WordPress setup where root query-string URLs can enter an automatic post purge list

Last tested with:

- WP Rocket 3.23.x
- WordPress 7.x
