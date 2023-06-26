<?php
/**
 * Plugin Name: WP Rocket | Exclude inline CSS using attributes from Remove Unused CSS
 * Description: Exclude inline css using attributes (id or class) from being removed by WP Rocket’s Remove Unused CSS optimizations.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2022
 */

namespace WP_Rocket\Helpers\rucss\rucss_attr_style_exclusions;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude inline styles per attr (id or class) from being removed by WP Rocket’s Remove Unused CSS optimization.
 */
function attr_exclusions( $inline_atts_exclusions = array() ) {

    /**
     * EDIT THIS:
     * Edit below line as needed to exclude files.
     * To exclude multiple style declarations, copy the entire line into a new line for each style declaration you want you exclude.
     */
    $inline_atts_exclusions[] = 'et-divi-customizer-global-cached-inline-styles';
    
    // STOP EDITING

    return $inline_atts_exclusions;
}
add_filter( 'rocket_rucss_inline_atts_exclusions', __NAMESPACE__ . '\attr_exclusions' );