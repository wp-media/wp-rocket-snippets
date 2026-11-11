# WP Rocket snippets

A collection of small code snippets and helper plugins that make the WP Media crew's life easier.

> [!IMPORTANT]
> These snippets target specific use cases and may require manual configuration. Review the linked code or README, test it on a staging site, and confirm compatibility with your versions of WordPress, WP Rocket, and any related plugins before using it in production.

## Snippet index

### Cache generation and expiration

| Name | Description / use case |
| --- | --- |
| [Prevent Cache Generation for Active Carts](wp-rocket/cache/wp-rocket-active-cart-cache-generation-guard/) | Prevents a WooCommerce request with an active-cart cookie from generating a public cache file, while still allowing an existing neutral cache file to be served. |
| [Disable Cache Generation for a Dynamic Cookie](wp-rocket/cache/wp-rocket-disable-cache-generation-for-dynamic-cookie/) | Prevents cache generation when a configured dynamic cookie is present while preserving other WP Rocket optimizations. Useful for server-rendered, cookie-dependent content. |
| [Force Cache Lifespan](wp-rocket/cache/wp-rocket-force-cache-lifespan.php) | Immediately removes cache files older than a configurable age. Useful for manually enforcing a shorter cache lifespan. |
| [Don't Cache the WordPress REST API](wp-rocket/cache/wprocket-force-no-cache-rest-api/) | Prevents WP Rocket from caching REST API requests, particularly for affected multisite configurations. |
| [Cache Only Specific Pages for Logged-in Users](wp-rocket/wp-rocket-cache-only-specific-pages-logged-in-users.php) | Limits logged-in-user cache generation to a configurable set of pages or posts. |
| [Optimize WooCommerce Pages Without Caching](wp-rocket/wp-rocket-optimize-no-cache-woocommerce-pages.php) | Applies WP Rocket optimizations to checkout, cart, and account pages while keeping page caching disabled. |

### Cache clearing and invalidation

| Name | Description / use case |
| --- | --- |
| [Prevent Query-string Root Purges](wp-rocket/cache/wp-rocket-cache-prevent-query-root-purge/) | Removes root URLs containing query strings from automatic post-purge lists so they cannot resolve to the domain cache root. |
| [Filter Domains Used for Cache Clearing](wp-rocket/cache/wp-rocket-filter-urls-for-cache-clearing/) | Filters the domain URLs passed to `rocket_clean_domain()`. Useful for Bedrock or custom cache-directory configurations. |
| [Prevent Recursive Folder Cleanup](wp-rocket/cache/wp-rocket-prevent-recursive-cleanup/) | Protects configured language or section folders from recursive cache deletion and removes only their index cache files. |
| [Safe Post Cache Purge on Status Change](wp-rocket/cache/wp-rocket-safe-post-cache-purge/) | Avoids fatal errors when third-party code calls `pre_post_update` with invalid data, while preserving an appropriate cache purge. |
| [Remove Additional URLs from Post Purges](wp-rocket/wp-rocket-cache-no-purge-additional-posts.php) | Stops additional related URLs from being included in WP Rocket's automatic purge when a post is updated. |
| [Remove Additional URLs from Product Purges](wp-rocket/wp-rocket-cache-no-purge-additional-products.php) | Stops additional related URLs from being included in WP Rocket's automatic purge when a WooCommerce product is updated. |
| [Disable Cache Clearing for Terms](wp-rocket/wp-rocket-cache-no-purge-terms.php) | Disables WP Rocket's automatic cache clearing when taxonomy terms are created. |
| [Clear Additional Domains](wp-rocket/wpr-clear-additional-domains.php) | Adds parked or alternate domains to WP Rocket's domain-wide cache-clearing list. |
| [Clear Cache After a Breakdance Save](wp-rocket/wpr-cache-clear-post-after-breakdance-save.php) | Clears a post's cache after the Breakdance builder saves the document. |
| [Clear Cache After a TotalPoll Vote](wp-rocket/wp-rocket-clear-cache-files-after-casting-vote.php) | Clears a post and configured related URLs after a new TotalPoll vote is cast. |
| [Clear Cache After a KK Star Ratings Vote](wp-rocket/wp-rocket-kk-star-ratings-compatibility.php) | Clears the affected post cache after a visitor submits a KK Star Ratings vote. |
| [Clear Cache After WordPress or Plugin Updates](wp-rocket/wp-rocket-purge-cache-when-wp-core-or-plugin-updated.php) | Clears the entire WP Rocket cache after a plugin update or successful WordPress core update. |
| [Clear a CPT Mobile Archive](wp-rocket/various/wp-rocket-clear-cpt-mobile-archive/) | Adds a configurable set of custom-post-type mobile archive URLs to the purge triggered by a post update. |
| [Clear Cache When Files Change](wp-rocket/various/wp-rocket-purge-when-files-modified/) | Cron-friendly script that clears cache, Used CSS, and/or minified files when configured CSS or JavaScript files change. |
| [Reset Multisite Cache Tables After Cleanup](wp-rocket/various/wp-rocket-multisite-reset-cache-tables/) | Marks multisite cache-table rows as pending after cleanup so preload can rebuild erased subsite caches. |

### Preload and cache-table management

| Name | Description / use case |
| --- | --- |
| [Reset the Cache Table](wp-rocket/preload/wp-rocket-cache-reset/) | One-time helper that truncates the cache table, clears cache, and restarts preload from sitemap URLs. |
| [Exclude Attachment URLs from Preload](wp-rocket/preload/wp-rocket-no-preload-attachments/) | Keeps WordPress attachment URLs out of the cache table and preload process. |
| [Exclude Out-of-stock Products from Preload](wp-rocket/wp-rocket-no-preload-for-products-out-of-stock.php) | Prevents out-of-stock WooCommerce product URLs from being added to preload. |
| [Exclude Products in a Category from Preload](wp-rocket/wp-rocket-no-preload-for-product-category.php) | Prevents products in configured WooCommerce categories, such as `sold-out`, from being preloaded. |
| [Exclude URLs from the Cache Table When Preload Is Disabled](wp-rocket/wp-rocket-exclude-urls-from-cache-table-if-preload-disabled.php) | Keeps visited URLs out of the WP Rocket cache table when preload is turned off. |
| [Filter Preload Links](wp-rocket/wpr-filter-rocket_preload_links_config.php) | Adds configured URL patterns to the browser preload-links exclusion list. |
| [Change the Preload User Agent](wp-rocket/wp-rocket-change-preload-user-agent.php) | Customizes the user-agent string sent by WP Rocket preload requests. |
| [Tune Preload and RUCSS Parameters](wp-rocket/wp-rocket-change-parameters-code-snippet) | Adjusts preload and Remove Unused CSS batch sizes, cron intervals, and delay between requests to reduce server load. |
| [Performance Tweaks for Preload and RUCSS](wp-rocket/various/wp-rocket-performance-tweaks/) | Packaged tuning helper for lowering preload/RUCSS CPU load and rejecting suspiciously small Used CSS results. |
| [Show the Cache Generation Source](wp-rocket/wpr-preload-origin.php) | Adds an HTML comment showing whether a page was cached by preload or by a regular visit. |

### CSS and JavaScript optimization

| Name | Description / use case |
| --- | --- |
| [Preserve All Styles from Remove Unused CSS](wp-rocket/remove-unused-css/wpr-rucss-preserve-all-styles.php) | Preserves every inline style and stylesheet from Remove Unused CSS processing. Useful as a broad diagnostic or temporary workaround. |
| [Exclude Inline CSS by Attribute from Remove Unused CSS](wp-rocket/wp-rocket-rucss-exclude-attrs.php) | Preserves configured inline styles whose `id` or `class` attributes must not be removed. |
| [Clear Used CSS After a Theme Update](wp-rocket/wp-rocket-clear-usedcss-after-theme-update.php) | Triggers Used CSS regeneration after a WordPress theme is updated. |
| [Regenerate Critical-path CSS](wp-rocket/wp-rocket-regenerate-cpcss.php) | Standalone script that starts Critical-path CSS regeneration for the legacy asynchronous CSS feature. |
| [Clear Minified Files After an Elementor Draft Save](wp-rocket/wp-rocket-clear-minified-files-after-elementor-draft-is-saved) | Clears minified CSS and JavaScript cache when an Elementor draft is saved. |
| [Programmatically Exclude Scripts from Delay JavaScript](wp-rocket/wp-rocket-exclude-scripts-from-dje.php) | Adds JavaScript files to Delay JavaScript exclusions through code instead of the WP Rocket settings field. |
| [Remove Scripts from Automatic Delay JavaScript Exclusions](wp-rocket/various/wp-rocket-remove-scripts-from-delay-js-automatic-exclusions/) | Allows configured scripts to be delayed even when WP Rocket or an integration excludes them automatically. |
| [Delay the WooCommerce Product Gallery](wp-rocket/wp-rocket-delay-wc-product-gallery.php) | Overrides the WooCommerce product gallery's automatic Delay JavaScript exclusion. |
| [Disable Delay JavaScript by Device Type](wp-rocket/wpr-disable-delay-js-mobile-desktop.php) | Disables Delay JavaScript on either mobile or desktop when separate mobile cache is active. |
| [Find Inline JavaScript](wp-rocket/find-inline-javascript) | Browser-console utility that lists external, delayed, and inline scripts to help identify JavaScript for exclusions or debugging. |

### Critical Images and Priority Elements

| Name | Description / use case |
| --- | --- |
| [Clear Critical Images Data](wp-rocket/critical-images/wp-rocket-clear-critical-images-data.php) | Standalone script that clears Optimize Critical Images data and related cache so it can be regenerated. |
| [Disable Optimize Critical Images for Post Types](wp-rocket/wp-rocket-disable-oci-post-types.php) | Disables Optimize Critical Images on configured post types, such as WooCommerce products. |
| [Clear Related Optimized Critical Images](wp-rocket/wp-rocket-oci-clear-related.php) | Deletes Optimize Critical Images records for URLs related to a post or term purge. |
| [Clear Priority Elements](wp-rocket/priority-elements/wpr-clear-priority-elements.php) | Standalone script that clears Priority Elements data and cache for regeneration. |

### Plugin and service integrations

| Name | Description / use case |
| --- | --- |
| [Purge Cloudflare via Cache Lifespan](wp-rocket/compatibility/wp-rocket-purge-cloudflare-cache-lifespan/) | Synchronizes cache-lifespan purges with Cloudflare APO or Cache Everything through the official Cloudflare plugin. |
| [Disable Automatic Cloudflare Cache Clearing](wp-rocket/wp-rocket-disable-auto-clear-cloudflare-cache.php) | Stops WP Rocket from automatically clearing Cloudflare when the official Cloudflare plugin is active. |
| [Clear and Preload Cache from ManageWP](wp-rocket/managewp-clear-cache.php) | ManageWP PHP snippet that bootstraps WordPress, clears WP Rocket cache, and triggers preload. |
| [Resync Elementor Library Cache](wp-rocket/cache/wp-rocket-elementor-templates-cache-resync/wp-rocket-elementor-templates-cache-resync.php) | Clears cache and triggers preload when a purged URL belongs to the Elementor template library. |
| [Clear WPML Product Translations](wp-rocket/various/wp-rocket-clean-product-related-translations-slugs/) | Clears translated WooCommerce product caches when the main-language product is updated, including setups with translated slugs. |
| [Disable Contact Form 7 Optimization](wp-rocket/various/wp-rocket-disable-cf7-optimization/) | Disables the compatibility optimizations WP Rocket applies to Contact Form 7. |
| [Filter WP Rocket HTTP Request Arguments](wp-rocket/various/wp-rocket-filter-http-request-args/wp-rocket-filter-http-request-args.php) | Adjusts outbound HTTP request arguments used for WP Rocket license validation. |

### Configuration, diagnostics, and administration

| Name | Description / use case |
| --- | --- |
| [Count Cache Files](wp-rocket/wpr-count-cache-files.php) | Lists and counts compressed HTML cache files for the current domain. |
| [Export WP Rocket Settings](wp-rocket/rocket-export-options.php) | Standalone script that downloads the `wp_rocket_settings` option as JSON when normal admin export is unavailable. |
| [Export WP Rocket Settings (alternate)](wp-rocket/wpr-export-settings.php) | Alternate standalone settings exporter for cases where the WordPress backend cannot be accessed. |
| [Send a Direct RUCSS API Request](wp-rocket/wpr-rucss-curl.php) | Sends a configurable cURL request directly to the Remove Unused CSS SaaS for connection testing and troubleshooting. |
| [Varnish Debugger](wp-rocket/various/varnish-debugger.php) | Web form for sending configurable `PURGE` or `BAN` requests to a Varnish endpoint and inspecting the HTTP response. |
| [Remove Last-Modified from `.htaccess` Rules](wp-rocket/wp-rocket-htaccess-no-expires-html.php) | Removes WP Rocket's `Header unset Last-Modified` directive when regenerating `.htaccess`. |
| [Enable Cache and Optimizations for Additional Taxonomies](wp-rocket/wp-rocket-exclude-taxonomies-from-cache-rules.php) | Removes WP Rocket's default restrictions for taxonomies it does not consider valid, allowing their pages to be cached and optimized. |
| [Disable the Rocket Insights Promotion Notice](wp-rocket/wp-rocket-disable-rocket-insights-promotion-notice.php) | Removes the Rocket Insights promotional admin notice registered by WP Rocket. |
| [Reset the RocketCDN CTA](wp-rocket/various/wp-rocket-reset-cta/) | One-time helper that removes the per-user flag hiding the RocketCDN call to action. |
