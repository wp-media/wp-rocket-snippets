<?php
/**
 * Plugin Name: WP Rocket | Don't Cache WP Rest API
 * Description: Force WP Rocket to NOT cache WP REST API
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\dont_cache_wp_rest_api;

defined( 'ABSPATH' ) or die();

function dont_cache_wp_rest_api( $uri ) {

  $uri[] = '/(index.php/)?(.*)wp-json(/.*|$)';

  return $uri;
}

add_filter( 'rocket_cache_reject_uri', __NAMESPACE__ . '\dont_cache_wp_rest_api', PHP_INT_MAX );



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



function deactivate() {

	// Remove all functionality added above.
	remove_filter( 'rocket_cache_reject_uri', 'dont_cache_wp_rest_api', PHP_INT_MAX );

	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );