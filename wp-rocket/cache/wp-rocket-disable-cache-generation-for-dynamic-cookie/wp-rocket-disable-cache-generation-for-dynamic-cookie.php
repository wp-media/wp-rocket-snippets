<?php
/**
 * Plugin Name: WP Rocket | Disable Cache Generation for Dynamic Cookie
 * Description: Disables cache files generation when a registered dynamic cookie is set, while preserving other WP Rocket optimization features.
 * Version:     1.1.0
 * Author:      WP Rocket Support Team    
 * Author URI:  http://wp-rocket.me/    
 * License:     GNU General Public License v2 or later    
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * Copyright SAS WP MEDIA 2026    
 */    

defined( 'ABSPATH' ) || exit;

/**
 * Register as dynamic cookie so WP Rocket is cookie-context aware.
 *
 * @param array $cookies Dynamic cookies list.
 * @return array
 */
function register_dynamic_cookie( array $cookies ) {

	// Edit below: add the cookie name.
	//$cookies[] = 'my_dynamic_cookie';
    // STOP EDITING
	return $cookies;
}
add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\register_dynamic_cookie' );


/**
 * Apply cache-generation restriction only on frontend requests.
 */
function wpr_register_cache_generation_filter() {
	add_filter(
		'do_rocket_generate_caching_files',
		'wpr_dynamic_cookie_maybe_disable_cache_generation',
		PHP_INT_MAX
	);
}
add_action( 'template_redirect', 'wpr_register_cache_generation_filter', 0 );

/**
 * Prevent WP Rocket from generating a cache file when the registered cookie is present.
 *
 * @param bool $generate Whether WP Rocket may generate a cache file.
 * @return bool
 */
function wpr_dynamic_cookie_maybe_disable_cache_generation( $generate ) {
	if ( ! $generate ) {
		return false;
	}
	// Edit below: replace 'dynamic_cookie' with your registered cookie in line 25.
	return ! isset( $_COOKIE['my_dynamic_cookie'] );
    // STOP EDITING
}

// STOP EDITING

// Remove .htaccess rewrites, since we need to detect the cookie
add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );

/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 * @author Caspar Hübinger
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

/**
 * Add customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function activate() {

	// Add customizations upon activation.
	add_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
	add_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\register_dynamic_cookie' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activate' );

/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 * @author Caspar Hübinger
 */
function deactivate() {

	// Remove customizations upon deactivation.
	remove_filter( 'rocket_htaccess_mod_rewrite', '__return_false' );
	remove_filter( 'rocket_cache_dynamic_cookies', __NAMESPACE__ . '\register_dynamic_cookie' );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );
