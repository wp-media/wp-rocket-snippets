<?php
/**
 * Plugin Name: WP Rocket | Exclude Attachment URLs from Preload
 * Description: Disables WP Rocket’s Preload for attachment URLs
 * Author:      WP Rocket Support Team
 * Author URI:  https://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\cache\no_preload_for_attachments;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Exclude specific posts from Preload
 * 
 * @author WP Rocket support team
 */
function no_preload_for_attachments( array $regexes ) : array {
    
    // Get the current slug
    $new_regex =  $_SERVER['REQUEST_URI'];
    
    // Stop if is a WordPress attachment
    if (is_attachment()) {
        $regexes[] = $new_regex;
        return $regexes;
    }
    
    // Add it to the Preload exclusion
    $regexes[] = $new_regex;
    
    return $regexes;

} 

add_filter( 'rocket_preload_exclude_urls', __NAMESPACE__ . '\no_preload_for_attachments');
