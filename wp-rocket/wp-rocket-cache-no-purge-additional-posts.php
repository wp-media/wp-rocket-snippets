<?php
/**
 * Plugin Name: WP Rocket | Remove additional URLs from post purge
 * Description: Removes additional URLs from WP Rocket’s automatic cache purging when a post is updated.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\no_purge_post_additional_urls;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude URLs WP Rocket’s automatic cache purging.
 *
 * @param  array  $urls    Array with URLs to be purged
 * @return array           Modified array with URLs to be purged
 */

function disable_cache_clearing_files( $urls ) {

    // only the 1st URL in the array
    $urls = array_slice( $urls, 0, 1 );
    
    // returns sliced array with the 1st post url only
    return $urls;
}
add_filter( 'rocket_post_purge_urls', __NAMESPACE__ . '\disable_cache_clearing_files');

// exclude taxonomies from the cleanup too
add_filter( 'rocket_exclude_post_taxonomy', function( $taxonomies ) {
    $taxonomies[] = 'product_cat';
    $taxonomies[] = 'category';
    $taxonomies[] = 'post_tag';
    return $taxonomies;
} );
