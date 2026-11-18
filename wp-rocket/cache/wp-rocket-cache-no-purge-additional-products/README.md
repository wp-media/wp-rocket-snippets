# WP Rocket | Remove additional URLs from product purge

Limits WP Rocket's automatic cache clearing when a WooCommerce product is updated, so only the product page is cleared and the related pages (shop page, product categories/tags and, optionally, the homepage) stay cached.

By default it only does this when the update comes from a **WooCommerce order** (stock reduced or restored). Manual product edits in the admin keep WP Rocket's normal purge.

Useful for busy stores where every order clears the homepage, shop and category pages over and over, for example during a sale. Related issue: [wp-media/wp-rocket#2287](https://github.com/wp-media/wp-rocket/issues/2287).

📥 Download: [wp-rocket-cache-no-purge-additional-products.zip](wp-rocket-cache-no-purge-additional-products.zip)

---

## Why orders clear the cache

When an order reduces (or a cancellation restores) stock on a product with stock management enabled, WooCommerce saves the product. That triggers `clean_post_cache`, and WP Rocket's `rocket_clean_post()` then clears the product, the shop page, its category/tag archives and the homepage ([How often is the cache cleared?](https://docs.wp-rocket.me/article/78-how-often-is-the-cache-updated)).

---

## Settings

Edit the constants at the top of the plugin file before uploading it.

| Setting | Default | What it does |
| --- | --- | --- |
| `ONLY_ON_ORDERS` | `true` | `true`: only trim the purge while WooCommerce is reducing or restoring order stock. Manual edits purge as usual. `false`: trim the purge on every product update (the previous behavior of this snippet). |
| `SKIP_HOME` | `true` | Also keep the homepage cache when the purge is trimmed (`rocket_clean_home_after_clean_post`, WP Rocket 3.19+). |
| `EXCLUDED_PRODUCT_IDS` | `[]` | Products that clear nothing at all when the purge is trimmed. Use the parent ID for variable products. If one of them goes out of stock (or back in stock), its own page is still cleared. Example: `[ 123, 456 ]` |

---

## What gets cleared

| Event | Without the helper | With the helper (defaults) |
| --- | --- | --- |
| Order / cancellation changes stock | Product, shop, categories/tags, homepage | Product page only |
| Order on a product in `EXCLUDED_PRODUCT_IDS` | Product, shop, categories/tags, homepage | Nothing (own page only if its stock status changes) |
| Manual product edit | Product, shop, categories/tags, homepage | Same as without the helper |
| Posts, pages, other post types | Unchanged | Unchanged |

Variable products are covered too. WooCommerce saves the parent product later in the same request (the shutdown "deferred product sync"), and the helper treats that save as part of the order.

---

## Replacing the previous version

This helper replaces the old single-file snippet `wp-rocket/wp-rocket-cache-no-purge-additional-products.php` (no version number). If a site already uses it:

1. Deactivate and delete **WP Rocket | Remove additional URLs from product purge** (the old version) from **Plugins**, or remove the old file if it was added as an MU plugin or snippet. Don't run both at the same time.
2. Pick the settings:
   - **Same behavior as before** (only the product page is cleared on every product update, manual edits included): set `ONLY_ON_ORDERS` to `false` and `SKIP_HOME` to `false`.
   - **Recommended**: keep the defaults. Orders only clear the product page and keep the homepage. Manual edits clear everything as usual.
3. Upload the new zip in **Plugins > Add New > Upload Plugin** and activate it.

Differences from the old version, even with the "same behavior" settings:

- The old version excluded the `product_cat` taxonomy for **every** post. The new one only skips the category/tag archives for the products it applies to, and covers product tags as well.
- The old version detected the product from the first purge URL (`url_to_postid()`). The new one uses the post object WP Rocket passes to `rocket_post_purge_urls`.
- The old version still cleared the homepage on every product update. The new one keeps it when `SKIP_HOME` is `true`.

---

## Notes

- `ONLY_ON_ORDERS` relies on WooCommerce's order stock updates, so it only applies to products with stock management enabled (**Track stock quantity**). Orders for products without stock management don't update the product, so WP Rocket doesn't clear any cache for them in the first place.
- Because related pages stay cached during orders, the shop and category pages may show older stock information until the next manual save, cache clear or Cache Lifespan run.
- To check what's being cleared, use the [WP Rocket | Logging cache clearing](https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-logging-cache-clearing) helper. Orders show `wc_reduce_stock_levels` / `wc_increase_stock_levels` in the call stack.

---

## Last tested with:
* WP Rocket 3.23.x
* WooCommerce 11.3.x
* WordPress 7.1.x
