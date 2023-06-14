<?php
/**
 * Plugin Name: WP Rocket | Disable Preload for products under a category
 * Description: Disables WP Rocket’s Preload for products using the sold-out category
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\no_preload_for_sold_out_products;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude specific posts from Preload
 * 
 * @author WP Rocket support team
 */
function no_preload_for_sold_out_products( array $regexes ) : array {
    
    // Categories to be excluded from Preload
    $excluded_categories  = array( 
        'sold-out', 
    );
    
    // Get the current slug
    $new_regex =  $_SERVER['REQUEST_URI'];
    
    // Stop if is not a product
    if(!is_singular('product')) {
        return $regexes;
    }
    
    // only if the product has the specified term under the product_cat taxonomy
    if ( ( !has_term( $excluded_categories, 'product_cat' ) )  )  {
        
        return $regexes;
    } 
    
    // add it to the Preload exclusion
    $regexes[] = $new_regex;
    
    return $regexes;

} 

add_filter( 'rocket_preload_exclude_urls', __NAMESPACE__ . '\no_preload_for_sold_out_products');
