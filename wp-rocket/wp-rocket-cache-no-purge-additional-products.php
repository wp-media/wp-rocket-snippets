<?php
/**
 * Plugin Name: WP Rocket | Remove additional URLs from product purge
 * Description: Removes additional URLs from WP Rocket’s automatic cache purging when a product is updated.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/wp-rocket-cache-no-purge-additional-products/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\no_purge_product_urls;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude URLs WP Rocket’s automatic cache purging.
 *
 * @param  array  $urls    Array with URLs to be purged
 * @return array           Modified array with URLs to be purged
 */

function disable_cache_clearing_files( $urls ) {

    // get the post id
    $the_post_id = url_to_postid( $urls[0] );

    // if the post type is product
    if ( get_post_type( $the_post_id ) === 'product' ) {   
        // returns the first url in the list of urls to be purged
	    $urls = array_slice( $urls, 0, 1 );
    }

    // returns sliced array with the product post url only
	return $urls;
}
add_filter( 'rocket_post_purge_urls', __NAMESPACE__ . '\disable_cache_clearing_files');

// exclude taxonomies from the cleanup in the case of producy cats
add_filter( 'rocket_exclude_post_taxonomy', function( $taxonomies ) {
    $taxonomies[] = 'product_cat';
    return $taxonomies;
} );
