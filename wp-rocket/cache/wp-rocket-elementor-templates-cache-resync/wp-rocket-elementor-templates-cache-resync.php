<?php

/**
 * Plugin Name: WP Rocket | Clear cache and preload Elementor Library
 * Description: When URL with a query string for Elementor Library is saved, the cache is cleared and preloaded.
 * Author:      Jeroen van Beusekom
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Hooks into the 'after_rocket_clean_post' action to check if any purged URLs are related to Elementor library.
 *
 * If at least one purged URL contains the query string '?elementor_library', this callback:
 * - Cleans the WP Rocket cache directory.
 * - Cleans the domain cache.
 *
 * @param WP_Post $post        The post object that was cleaned.
 * @param array   $purge_urls  Array of URLs that were purged.
 * @param string  $lang        Language code associated with the purge.
 *
 * @see rocket_reset_preload
 * @see rocket_clean_cache_dir()
 * @see rocket_clean_domain()
 */
add_action( 'after_rocket_clean_post', function( $post, $purge_urls, $lang ) {

    /**
     * Checks if any of the URLs in the $purge_urls array contain the query string '?elementor_library'.
     *
     * Sets $is_elementor to true if at least one URL matches, otherwise false.
     *
     * @var bool $is_elementor Indicates presence of Elementor library URLs in the purge list.
     */
    $is_elementor = preg_grep('/\?elementor_library/', $purge_urls) ? true : false;

    /**
     * If Elementor is active, triggers cache and preload reset actions.
     *
     * - Cleans the WP Rocket cache directory using rocket_clean_cache_dir().
     * - Cleans the domain cache using rocket_clean_domain().
     *
     * @see rocket_clean_cache_dir()
     * @see rocket_clean_domain()
     */
    if ( $is_elementor ) {

        rocket_clean_domain();

    } 

}, 10, 3);

/**
 * Filters the URLs to be purged by WP Rocket, allowing only URLs without a query string
 * or URLs containing the 'elementor_library' query string.
 *
 * This filter modifies the array of URLs passed to 'rocket_post_purge_urls' by removing
 * any URLs that contain a query string, except those specifically containing 'elementor_library'.
 *
 * @param array $urls Array of URLs to be filtered for cache purging.
 * @return array Filtered array of URLs, including only those without a query string or with 'elementor_library'.
 */
add_filter( 'rocket_post_purge_urls', function($urls) {

    $links = array_filter($urls, function($url) {
        return strpos($url, '?') === false || strpos($url, '?elementor_library') !== false;
    });

    return $links;

}, 10, 1);
