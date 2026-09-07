<?php
/**
 * Plugin Name: WP Rocket | Prevent Cache Generation for Active Carts
 * Description: Prevents WP Rocket from generating page-cache files when the WooCommerce "woocommerce_items_in_cart" cookie is present. Existing cache files can still be served.
 * Version: 1.1.0
 * Author: WP Rocket Support
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 7.4
 */

defined( 'ABSPATH' ) || exit;

/**
 * Apply the cache-generation restriction only to frontend page requests.
 *
 * Registering the filter at template_redirect prevents it from interfering
 * with WP Rocket configuration and rewrite-rule generation in the admin area.
 */
function wpr_cart_cookie_register_cache_generation_filter() {
	add_filter(
		'do_rocket_generate_caching_files',
		'wpr_cart_cookie_allow_cache_generation',
		PHP_INT_MAX
	);
}
add_action( 'template_redirect', 'wpr_cart_cookie_register_cache_generation_filter', 0 );

/**
 * Prevent cache generation for requests carrying an active-cart cookie.
 *
 * @param bool $generate Whether WP Rocket may generate a cache file.
 * @return bool
 */
function wpr_cart_cookie_allow_cache_generation( $generate ) {
	if ( ! $generate ) {
		return false;
	}

	return ! isset( $_COOKIE['woocommerce_items_in_cart'] );
}
