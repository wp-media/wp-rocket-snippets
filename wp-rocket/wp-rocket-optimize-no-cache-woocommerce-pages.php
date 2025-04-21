<?php
/**
 * Plugin Name: WP Rocket | Optimize WooCommerce default pages
 * Description: Enables optimizations for checkout, cart, account pages while keeping caching disabled.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2019
 */

namespace WP_Rocket\Helpers\cache\woocommerce\enable_optimizations;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

add_action( 'wp_rocket_loaded', function(){
$container = apply_filters( 'rocket_container', [] );
if ( ! $container ) {
	return;
}
$event_manager = $container->get( 'event_manager' );
$woocommerce_subscriber = $container->get( 'woocommerce_subscriber' );
$event_manager->remove_callback( 'rocket_cache_reject_uri', [$woocommerce_subscriber, 'exclude_pages' ] );
});

// Exclude WooCommerce pages from page caching.
function no_cache_for_woocommerce_pages( $filter ) {
	
	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return $urls;
	}
	$excluded_ids[] = wc_get_page_id( 'checkout' ); //checkout.
	$excluded_ids[] = wc_get_page_id( 'cart' ); //cart.
	$excluded_ids[] = wc_get_page_id( 'myaccount' ); //myaccount.
	
	if ( ( function_exists( 'is_page' ) && is_page( $excluded_ids ) ) || ( function_exists( 'is_single' ) && is_single( $excluded_ids ) ) ) {
		return false;
	}
	
	return $filter;
}
add_filter( 'do_rocket_generate_caching_files', __NAMESPACE__ . '\no_cache_for_woocommerce_pages' );

// Override WP Rocket's default behavior about DONOTCACHEPAGE.
add_filter( 'rocket_override_donotcachepage', '__return_true', PHP_INT_MAX );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' )
	  || ! function_exists( 'rocket_generate_config_file' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();

	// Regenerate WP Rocket config file.
	rocket_generate_config_file();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 */
function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'wp_rocket_loaded', __NAMESPACE__ . '\do_stuff' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
