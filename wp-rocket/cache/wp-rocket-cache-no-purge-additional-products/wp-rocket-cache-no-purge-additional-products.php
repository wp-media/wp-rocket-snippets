<?php
/**
 * Plugin Name: WP Rocket | Remove additional URLs from product purge
 * Description: Removes additional URLs from WP Rocket’s automatic cache purging when a product is updated. Optionally applies only when a WooCommerce order changes stock (products with stock management enabled), skips the homepage and ignores selected products.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-snippets/tree/main/wp-rocket/cache/wp-rocket-cache-no-purge-additional-products/
 * Version:     2.0.1
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 *
 * Requires WP Rocket 3.19+ for SKIP_HOME (rocket_clean_home_after_clean_post).
 *
 * ONLY_ON_ORDERS works by listening to WooCommerce's order stock updates
 * (stock reduced or restored). It therefore only applies to products with
 * stock management enabled ("Track stock quantity"). Orders for products
 * without stock management don't update the product, so WP Rocket doesn't
 * clear any cache for them in the first place.
 */

namespace WP_Rocket\Helpers\cache\no_purge_product_urls;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/* ------------------------------------------------------------------------
 * EDIT THESE SETTINGS
 * --------------------------------------------------------------------- */

/**
 * true  = only change the purge when a WooCommerce order reduces or
 *         restores stock (products with stock management enabled).
 *         Manual product edits keep WP Rocket's normal purge.
 * false = original behavior: change the purge on every product update.
 */
const ONLY_ON_ORDERS = true;

/**
 * true = also keep the homepage cache (by default WP Rocket clears it
 *        every time a product is cleared).
 */
const SKIP_HOME = true;

/**
 * Product IDs that should not clear anything at all (not even their own
 * page). Use the parent ID for variable products. Example: [ 123, 456 ]
 * If one of these products goes out of stock or back in stock, its own
 * page is still cleared so availability stays correct.
 */
const EXCLUDED_PRODUCT_IDS = [];

/* ------------------------------------------------------------------------
 * STOP EDITING
 * --------------------------------------------------------------------- */

/**
 * Track whether WooCommerce is changing stock for an order.
 *
 * Between woocommerce_can_(reduce|restore)_order_stock and
 * woocommerce_(reduce|restore)_order_stock, WooCommerce saves each ordered
 * product, which triggers WP Rocket's purge.
 */
function in_order( $set = null ) {
	static $active = false;
	if ( null !== $set ) {
		$active = (bool) $set;
	}
	return $active;
}
foreach ( [ 'woocommerce_can_reduce_order_stock', 'woocommerce_can_restore_order_stock' ] as $hook ) {
	add_filter( $hook, function ( $can ) {
		if ( $can ) {
			in_order( true );
		}
		return $can;
	}, PHP_INT_MAX );
}
foreach ( [ 'woocommerce_reduce_order_stock', 'woocommerce_restore_order_stock' ] as $hook ) {
	add_action( $hook, function () {
		in_order( false );
	}, PHP_INT_MIN );
}

/**
 * Variable products: WooCommerce saves the parent later, on shutdown
 * (deferred product sync). Remember parents touched by an order so that
 * save counts as part of the order too.
 */
function parent_id( $id ) {
	$id = (int) $id;
	if ( 'product_variation' === get_post_type( $id ) ) {
		$parent = (int) wp_get_post_parent_id( $id );
		return $parent ? $parent : $id;
	}
	return $id;
}
function order_parents( $add = null ) {
	static $ids = [];
	if ( null !== $add ) {
		$ids[ (int) $add ] = true;
	}
	return $ids;
}
function in_deferred_sync( $set = null ) {
	static $active = false;
	if ( null !== $set ) {
		$active = (bool) $set;
	}
	return $active;
}
foreach ( [ 'woocommerce_variation_set_stock', 'woocommerce_variation_set_stock_status' ] as $hook ) {
	add_action( $hook, function ( $product ) {
		if ( in_order() ) {
			order_parents( parent_id( is_object( $product ) ? $product->get_id() : $product ) );
		}
	}, 1 );
}
add_action( 'shutdown', function () { in_deferred_sync( true ); }, 9 );
add_action( 'shutdown', function () { in_deferred_sync( false ); }, 11 );

/**
 * Should we change the purge for this post?
 */
function applies_to( $post_id ) {
	$post_id = (int) $post_id;

	if ( ! $post_id || 'product' !== get_post_type( parent_id( $post_id ) ) ) {
		return false;
	}

	if ( ! ONLY_ON_ORDERS ) {
		return true;
	}

	return in_order() || ( in_deferred_sync() && isset( order_parents()[ parent_id( $post_id ) ] ) );
}

function is_excluded( $post_id ) {
	return in_array( parent_id( $post_id ), array_map( 'intval', EXCLUDED_PRODUCT_IDS ), true );
}

/**
 * The post WP Rocket is currently clearing (the archive filter below
 * doesn't receive it).
 */
function current_post( $set = null ) {
	static $id = 0;
	if ( null !== $set ) {
		$id = (int) $set;
	}
	return $id;
}
add_action( 'before_rocket_clean_post', function ( $post ) {
	current_post( $post->ID );
} );

/**
 * Exclude URLs WP Rocket’s automatic cache purging.
 *
 * @param  array    $urls Array with URLs to be purged.
 * @param  \WP_Post $post The post being cleared.
 * @return array          Modified array with URLs to be purged.
 */
function disable_cache_clearing_files( $urls, $post = null ) {
	if ( ! is_object( $post ) || ! applies_to( $post->ID ) ) {
		return $urls;
	}

	if ( is_excluded( $post->ID ) ) {
		return [];
	}

	// Keep only the product page itself.
	return array_slice( (array) $urls, 0, 1 );
}
add_filter( 'rocket_post_purge_urls', __NAMESPACE__ . '\disable_cache_clearing_files', PHP_INT_MAX, 2 );

// Don't clear the product's category/tag archives (only for the posts this applies to).
add_filter( 'rocket_post_terms_urls', function ( $urls ) {
	return applies_to( current_post() ) ? [] : $urls;
}, PHP_INT_MAX );

// Keep the homepage cache.
add_filter( 'rocket_clean_home_after_clean_post', function ( $clean, $post_id = 0 ) {
	if ( applies_to( $post_id ) && ( SKIP_HOME || is_excluded( $post_id ) ) ) {
		return false;
	}
	return $clean;
}, PHP_INT_MAX, 2 );

// Excluded product sold out / back in stock: still clear its own page.
foreach ( [ 'woocommerce_product_set_stock_status', 'woocommerce_variation_set_stock_status' ] as $hook ) {
	add_action( $hook, function ( $product_id ) {
		if ( ! function_exists( 'rocket_clean_files' ) || ! applies_to( $product_id ) || ! is_excluded( $product_id ) ) {
			return;
		}
		$url = get_permalink( parent_id( $product_id ) );
		if ( $url ) {
			rocket_clean_files( [ $url ] );
		}
	}, 10, 1 );
}
