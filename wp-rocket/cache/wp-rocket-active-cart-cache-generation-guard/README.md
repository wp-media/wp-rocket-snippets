# WP Rocket | Prevent Cache Generation for Active Carts

This helper prevents a request carrying WooCommerce's standard
`woocommerce_items_in_cart` cookie from generating or overwriting a public
WP Rocket cache file.

It separates **cache delivery** from **cache generation**:

- Without the cookie, WP Rocket can deliver and generate cache normally.
- With the cookie, an existing public cache file can still be delivered.
- With the cookie and no existing cache file, WordPress generates the response
  dynamically, but WP Rocket does not save that response to the public cache.

The helper preserves any earlier decision made by WP Rocket not to generate a
cache file.

## Why use it?

Some WooCommerce themes render the current cart into the initial PHP-generated
HTML. If an active-cart request generates a public cache file, that personalized
mini-cart markup can become part of the shared page. This helper prevents the
active-cart request from becoming the source of that cache file without
excluding the shopper from receiving an existing neutral cached page.

## Requirements

- WP Rocket
- WooCommerce
- PHP 7.4 or newer
- A mini-cart that restores or synchronizes the shopper's cart client-side

## Installation

1. Test the helper on a staging site first.
2. Upload the plugin ZIP through **Plugins > Add New > Upload Plugin**.
3. Activate **WP Rocket | Prevent Cache Generation for Active Carts**.
4. Clear the existing WP Rocket cache once so previously generated files are
   removed.

## Important considerations

- Do not add `woocommerce_items_in_cart` to WP Rocket's **Never Cache Cookies**
  setting when using this helper. That setting also prevents cache delivery,
  which defeats the purpose of this approach.
- The public cached HTML must be visitor-neutral. The actual cart must be
  restored client-side using Cart Fragments, AJAX, the WooCommerce Store API,
  or an equivalent implementation.
- On a cache miss, an active-cart visitor receives a dynamically generated
  response, but that request will not warm the cache.
- Requests without the cookie, including anonymous visitors and WP Rocket
  Preload, can continue generating cache normally.
- The helper protects only requests identified by the
  `woocommerce_items_in_cart` cookie. It does not detect other forms of
  visitor-specific content.

## Technical implementation

The plugin uses WP Rocket's `do_rocket_generate_caching_files` filter. It
returns `false` when `woocommerce_items_in_cart` is present and otherwise
preserves WP Rocket's cache-generation decision.
