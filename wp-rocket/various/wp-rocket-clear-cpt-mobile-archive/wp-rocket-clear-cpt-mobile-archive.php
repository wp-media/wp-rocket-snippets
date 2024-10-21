<?php
/**
 * Plugin Name: WP Rocket | Clear CPT mobile archive
 * Description: Purges a custom set of URLs additional to WP Rocket’s automatic cache purging when a post is updated.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-cache-purge-urls/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\cache\filter_purge_urls_cpt;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


function purge_custom_post_urls($urls_to_purge, $post) {

    if (empty($urls_to_purge) || !is_array($urls_to_purge)) {
        return $urls_to_purge;
    }

    $new_urls = $urls_to_purge;

    foreach ($urls_to_purge as $url) {
        // Check for 'index-https.html' only (without '.html_gzip')
        if (strpos($url, 'index-https.html') !== false && strpos($url, '.html_gzip') === false) {
            // Get the base URL without 'index-https.html'
            $base_url = str_replace('index-https.html', '', $url);

            // Check if 'index-mobile-https.html' exists
            $mobile_html = $base_url . 'index-mobile-https.html';
            $mobile_gzip = $base_url . 'index-mobile-https.html_gzip';

            if (!in_array($mobile_html, $new_urls)) {
                // Add the 'index-mobile-https.html' if not found
                $new_urls[] = $mobile_html;
            }

            if (!in_array($mobile_gzip, $new_urls)) {
                // Add the 'index-mobile-https.html_gzip' if not found
                $new_urls[] = $mobile_gzip;
            }
        }
    }

    return $new_urls;
}

add_filter('rocket_post_purge_urls', __NAMESPACE__ . '\purge_custom_post_urls', 10, 2);
