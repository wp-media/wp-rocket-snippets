<?php
/**
 * Plugin Name: WP Rocket | Disable Preload for products out of stock
 * Description: Disables WP Rocket’s Preload for products out of stock
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\no_preload_for_out_of_stock_products;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude specific posts from Preload
 * 
 * @author WP Rocket support team
 */
function no_preload_for_out_of_stock_products( array $regexes ) : array {
    
    // Get the current slug
    $new_regex =  $_SERVER['REQUEST_URI'];
    
    // Stop if is not a product
    if(!is_singular('product')) {
        return $regexes;
    }
    
    // Stop if the product has stock
    global $post;
    $product = wc_get_product($post->ID);
    
    if ($product->is_in_stock()) {
        return $regexes;
    }
    
    // add it to the Preload exclusion
    $regexes[] = $new_regex;
    
    return $regexes;

} 

add_filter( 'rocket_preload_exclude_urls', __NAMESPACE__ . '\no_preload_for_sold_out_products');
