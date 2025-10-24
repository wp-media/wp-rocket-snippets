<?php
/**
 * Plugin Name: WP Rocket | Prevent Recursive Folder Cleanup
 * Description:  Prevents WP Rocket from recursively deleting cache inside language folders like /fr/, and only deletes index files.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2025
 */


defined( 'ABSPATH' ) || exit;

/**
 * List of language (or folder) URLs to protect from recursive purge.
 */
function rocket_fix_get_protected_urls() {
    
    $home_url = get_home_url();
    
	return [
		$home_url.'/fr/',
		// Add more here if needed
		// $home_url.'/es/',
		// $home_url.'/blog/',
	];
}

/**
 * 1 Filter purge URLs to remove protected language URLs.
 */
add_filter( 'rocket_post_purge_urls', function( $purge_urls, $post ) {
    

	$protected_urls = rocket_fix_get_protected_urls();
	


	foreach ( $protected_urls as $protected_url ) {
		foreach ( $purge_urls as $key => $url ) {
		    
			if ( untrailingslashit( $url ) === untrailingslashit( $protected_url ) ) {

				// Remove it from purge list to prevent WP Rocket recursive delete
				unset( $purge_urls[ $key ] );

				// Delete only index files manually
				rocket_fix_delete_first_level_index_files( $protected_url );

				// Update DB cache status
				rocket_fix_mark_cache_entry_pending( $protected_url );
			}
		}
	}

	return $purge_urls;
}, 10, 2 );


/**
 * 2 Delete only .html and .html_gzip files at first level of cache folder.
 */
function rocket_fix_delete_first_level_index_files( $url ) {
	$parsed = wp_parse_url( $url );
	if ( empty( $parsed['host'] ) ) {
		return;
	}

	// WP Rocket cache folder
	$cache_path = WP_CONTENT_DIR . '/cache/wp-rocket/' . $parsed['host'] . $parsed['path'];

	if ( ! is_dir( $cache_path ) ) {
		return;
	}

	$files = glob( trailingslashit( $cache_path ) . 'index*.{html,html_gzip}', GLOB_BRACE );

	if ( empty( $files ) ) {
		return;
	}

	foreach ( $files as $file ) {
		if ( is_file( $file ) ) {
			unlink( $file );
		}
	}
}


/**
 * 3 Mark this URL as pending in WP Rocket cache table.
 */
function rocket_fix_mark_cache_entry_pending( $url ) {
	global $wpdb;
	$table = $wpdb->prefix . 'wpr_rocket_cache';

	if ( ! $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table ) ) ) {
		return;
	}

	// Normalize URL without trailing slash
	$normalized = untrailingslashit( $url );

	$wpdb->update(
		$table,
		[ 'status' => 'pending' ],
		[ 'url' => $normalized ],
		[ '%s' ],
		[ '%s' ]
	);

}
