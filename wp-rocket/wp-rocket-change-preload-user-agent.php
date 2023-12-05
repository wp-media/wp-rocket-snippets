<?php
/**
 * Plugin Name: WP Rocket | Change Preload User Agent
 * Description: Filters the preload user agent
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\preload\user_agent;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

function custom_user_agent( $args ) {

	$args['user-agent'] = 'Fresh User Agent';
	
	return $args;
}
add_filter( 'rocket_preload_url_request_args', __NAMESPACE__ .'\custom_user_agent', PHP_INT_MAX );