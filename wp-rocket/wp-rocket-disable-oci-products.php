<?php
/**
 * Plugin Name: WP Rocket | Disable Optimize Critical Images for specific post types
 * Description: Disables Optimize Critical Images on specific post types
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\compat\wc_products_no_oci;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

add_filter( 'rocket_above_the_fold_optimization', function( $enabled ) {
	
	// Disable Optimize Critical Images on a specific post type, using is_singular()
	// https://developer.wordpress.org/reference/functions/is_singular/
	//
	// Examples: 
	// is_singular('page'); for pages
	// is_singular('post'); por posts
	 // is_singular('product'); por WooCommerce products
	 // is_singular('book'); for a custom post type called book
	 // is_singular( array( 'product', 'post' ) ); for both, products and posts
	 
	return $enabled && ! is_singular( 'product' );
	
} );