<?php
/**
 * Plugin Name: WP Rocket | Prevent Query Root Purge
 * Description: Prevents query-string root URLs from being included in WP Rocket's automatic post cache purges.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/
 * Version:     1.0.0
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2026
 */

namespace WP_Rocket\Helpers\cache\prevent_query_root_purge;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) || die();

/**
 * Remove query-string root URLs from WP Rocket's automatic post purge list.
 *
 * A URL such as https://example.com/?example=value has a root path. If it is
 * passed to rocket_clean_files(), the query string is not part of the cache
 * filesystem path and the URL can resolve to the domain's cache directory.
 *
 * Query-string URLs with a non-root path are preserved.
 *
 * @param array $urls Array of URLs to be purged.
 *
 * @return array Modified array of URLs to be purged.
 */
function prevent_query_root_purge( $urls ) {
	return array_values(
		array_filter(
			(array) $urls,
			static function ( $url ) {
				if ( ! is_string( $url ) || '' === $url ) {
					return false;
				}

				// Keep URLs that do not contain a query string.
				if ( false === strpos( $url, '?' ) ) {
					return true;
				}

				$path = wp_parse_url( $url, PHP_URL_PATH );

				// Remove query-string URLs whose path is empty or the domain root.
				return null !== $path && false !== $path && '' !== $path && '/' !== $path;
			}
		)
	);
}

add_filter(
	'rocket_post_purge_urls',
	__NAMESPACE__ . '\\prevent_query_root_purge',
	PHP_INT_MAX
);
