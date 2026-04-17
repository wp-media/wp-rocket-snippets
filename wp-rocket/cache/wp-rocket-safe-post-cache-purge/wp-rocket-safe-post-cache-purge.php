<?php
/**
 * Plugin Name: WP Rocket | Safe Post Cache Purge on Status Change
 * Description: Prevents fatal errors when pre_post_update is called with invalid arguments and safely purges cache.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me
 * License:     GPLv2 or later
 */

namespace WP_Rocket\Helpers\safe_post_update_purge;

defined( 'ABSPATH' ) || exit;

/**
 * OPTIONAL: Limit to specific post types.
 * Leave empty array [] to allow all.
 */
function get_allowed_post_types() {
	return [
		// Example:
		// 'jet-engine-cpt',
		// 'post',
	];
}

/**
 *  Remove WP Rocket unsafe hooks AFTER they are registered
 */
add_action( 'plugins_loaded', function() {

	remove_action(
		'pre_post_update',
		'rocket_clean_post_cache_on_status_change',
		10
	);

	remove_action(
		'pre_post_update',
		'rocket_clean_post_cache_on_slug_change',
		PHP_INT_MAX
	);

}, 999 );

/**
 *  Safe wrapper
 */
add_action( 'init', function() {

	add_action( 'pre_post_update', function( $post_id, $data = null ) {

		// Validate post ID
		if ( empty( $post_id ) || ! is_numeric( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return;
		}

		// Optional: filter by post type
		$allowed = get_allowed_post_types();
		if ( ! empty( $allowed ) && ! in_array( $post->post_type, $allowed, true ) ) {
			return;
		}

		// Normal case → use original logic safely
		if ( ! empty( $data ) && is_array( $data ) ) {

			rocket_clean_post_cache_on_status_change( $post_id, $data );
			rocket_clean_post_cache_on_slug_change( $post_id, $data );

			return;
		}

		// Fallback → purge anyway
		rocket_clean_post( $post_id );

	}, 10, 2 );

});