<?php
/**
 * Plugin Name: WP Rocket | Disable Optimize Critical Images for WooCommerce Products
 * Description: Disables Optimize Critical Images on WooCommerce products pages
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

function no_atf_for_products() {

	// Make sure is_product is present.
	if (! function_exists( 'is_product' )) {
		return false;
	}

/**
 * Disable OCI optimization on:
 * - single product pages
 */
if( is_product() ) {
	
	add_filter( 'rocket_above_the_fold_optimization', '__return_false' );
	}
}
add_filter( 'wp',  __NAMESPACE__ .'\no_atf_for_products' );