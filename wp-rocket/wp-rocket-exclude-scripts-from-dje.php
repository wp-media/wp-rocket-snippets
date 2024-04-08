<?php 
/**
 * Plugin Name: WP Rocket | Programmatically Exclude JS scripts from Delay JS
 * Description: Exclude JavaScript files from Delay JS programmatically instead of using the UI textarea
 * Version: 1.0
 * Author: WP Rocket Support Team
 * Author URI: https://wp-rocket.me
 * License:	GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright 2024 WP Media <support@wp-rocket.me>
 */
 

 // Namespaces must be declared before any other declaration.
 namespace WP_Rocket\Helpers\static_files\exclude\programmatic_delay_js_exclusions;
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 
 
function exclude_from_delay( $exclusions ) {
   
      
        // DELAY THESE SCRIPTS

        $exclusions[] = 'example-script.js';
                   
        // Duplicate the above line to add more scripts
        //$exclusions[] = 'script2.js';
        //$exclusions[] = 'anotherInline';     
  
    return $exclusions;

}

add_filter( 'rocket_delay_js_exclusions',  __NAMESPACE__ . '\exclude_from_delay' );