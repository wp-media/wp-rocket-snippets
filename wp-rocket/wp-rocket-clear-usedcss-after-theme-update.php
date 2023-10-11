<?php
/**
 * Plugin Name: WP Rocket | Clear Used CSS after theme update
 * Description: Trigger a Used CSS regeneration after the theme has been updated
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\wp_rocket_clear_usedcss_theme_update;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();



// Clear Used CSS function
function wpr_clear_unused_css() {
if (defined('WP_ROCKET_VERSION')) {
	// access rocket's injection container
	$container = apply_filters( 'rocket_container', null );
	// get the rucss subscriber from the container
	$subscriber = $container->get('rucss_admin_subscriber');
	// call the truncate method.
	$subscriber->truncate_used_css();
}
}

// Trigger the cleanup
function wpr_rocket_clean_cache_theme_update( $wp_upgrader, $hook_extra ) {
	if ( ! isset( $hook_extra['action'] ) || 'update' !== $hook_extra['action'] ) {
		return;
	}

	if ( ! isset( $hook_extra['type'] ) || 'theme' !== $hook_extra['type'] ) {
		return;
	}

	if ( ! isset( $hook_extra['themes'] ) || ! is_array( $hook_extra['themes'] ) ) {
		return;
	}

	$current_theme = wp_get_theme();
	$themes        = [
		$current_theme->get_template(), // Parent theme.
		$current_theme->get_stylesheet(), // Child theme.
	];

	// Bail out if the current theme or its parent is not updating.
	if ( empty( array_intersect( $hook_extra['themes'], $themes ) ) ) {
		return;
	}

	wpr_clear_unused_css();
	
}
add_action( 'upgrader_process_complete', __NAMESPACE__ .'\wpr_rocket_clean_cache_theme_update', 10, 2 );  

