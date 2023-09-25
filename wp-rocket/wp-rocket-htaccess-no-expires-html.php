<?php
/**
 * Plugin Name: WP Rocket | Remove Last-Modified from .htaccess rules
 * Description: Remove Last-Modified from .htaccess rules.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2021
 */
 
 namespace WP_Rocket\Helpers\htaccess\remove_last_modified;


// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function remove_htaccess_last_modified( $rules ) {
	
	$rules = str_replace( 'Header unset Last-Modified' . PHP_EOL, '', $rules );
	return $rules;
}

add_filter('rocket_htaccess_files_match', __NAMESPACE__ . '\remove_htaccess_last_modified');


/**
 * Updates .htaccess, regenerates WP Rocket config file.
 *
 */
function flush_wp_rocket() {

	if ( ! function_exists( 'flush_rocket_htaccess' ) ) {
		return false;
	}

	// Update WP Rocket .htaccess rules.
	flush_rocket_htaccess();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\flush_wp_rocket' );


/**
 * Removes customizations, updates .htaccess, regenerates config file.
 *
 */
function deactivate() {
	
	remove_filter( 'rocket_htaccess_files_match', __NAMESPACE__ . '\remove_htaccess_last_modified' );
	
	// Flush .htaccess rules, and regenerate WP Rocket config file.
	flush_wp_rocket();
	
}

register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate' );

