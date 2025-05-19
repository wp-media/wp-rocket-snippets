<?php
/**
 * Plugin Name: WP Rocket | filter HTTP Request args for WP Rocket
 * Description: Filter HTTP requests args to allow license validation "WP Rocket".
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'http_request_args', function( $args, $url ) {
		$args['reject_unsafe_urls'] = false;
	
	return $args;
}, 10, 2 );