<?php
/**
 * Plugin Name: WP Rocket | Enable Page Caching For Specific Pages or Posts only for logged in users
 * Description: Enables WP Rocket’s page cache file generation only on specific pages.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-snippets/blob/main/wp-rocket/wp-rocket-cache-only-specific-pages-logged-in-users.php
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\only_cache_for_page;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

    

function disable_cache_for_logged_in_user_with_exceptions() {
    
    $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    
    // the URLs from this list will be cached and optimized
    // all the other URLs will have the cache disabled, but the page optimizations active.
    // note this only applies to logged in users
    
    // You can add more URLs to this array as needed
    $excluded_url[] = 'example.com/first-url/';   // Replace the URL on this line.
    $excluded_url[] = 'example.com/second-url/';   // Replace the URL on this line.

    if ( is_user_logged_in() ) {
       if ( ! in_array($url, $excluded_url)){
           add_filter( 'do_rocket_generate_caching_files', '__return_false' );
       }           
    }
}

add_action( 'init', __NAMESPACE__ . '\disable_cache_for_logged_in_user_with_exceptions' );
  

/**
 * Cleans entire cache folder on activation.
 *
 * @author Arun Basil Lal
 */
function clean_wp_rocket_cache() {

    if ( ! function_exists( 'rocket_clean_domain' ) ) {
        return false;
    }

    // Purge entire WP Rocket cache.
    rocket_clean_domain();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\clean_wp_rocket_cache' );