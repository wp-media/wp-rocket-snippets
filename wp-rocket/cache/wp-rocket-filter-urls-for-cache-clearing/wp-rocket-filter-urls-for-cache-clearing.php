<?php

/**
 * Plugin Name: WP Rocket | Filter URLs for Cache Clearing
 * Description: Allows filtering the domain names sent to rocket_clean_domain() using the filter rocket_clean_domain_urls.
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2026
 */

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

add_filter( 'rocket_clean_domain_urls', function( $urls, $lang ) {
    $updated_urls = [];
    
    foreach ( $urls as $url ) {
        $updated_url = str_replace( 
            'https://addyoursitehere.com/wp', // Add the Original domain you want to replace
            'https://addyoursitehere.com',    //Add the New domain you want to use
            $url 
        );
        $updated_urls[] = $updated_url;
    }
    
    return $updated_urls;
}, 10, 2 );