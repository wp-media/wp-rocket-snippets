<?php
/**
 * Plugin Name: WP Rocket | Delay WooCommerce Product Gallery
 * Description: Overrides WooCommerce Product Gallery's exclusion from Delay JavaScript
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\static_files\exclude\delay_js;

// Standard plugin security, keep this line in place.
if ( ! defined( 'ABSPATH' ) ) exit; 


function exclude_files( $excluded_files = array() ) {

    $flipped = array_flip($excluded_files);
    unset($flipped['/jquery-?[0-9.]*(.min|.slim|.slim.min)?.js']);
    unset($flipped['/woocommerce/assets/js/zoom/jquery.zoom(.min)?.js']);
    unset($flipped['/woocommerce/assets/js/photoswipe/']);
    unset($flipped['/woocommerce/assets/js/flexslider/jquery.flexslider(.min)?.js']);
    unset($flipped['/woocommerce/assets/js/frontend/single-product(.min)?.js']);

    $excluded_files = array_flip($flipped);

    return $excluded_files;
}

add_filter( 'rocket_wc_product_gallery_delay_js_exclusions', __NAMESPACE__ . '\exclude_files', 1000 );