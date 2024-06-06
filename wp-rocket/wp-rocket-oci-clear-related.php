<?php
/**
 * Plugin Name: WP Rocket | Clear the Optimized Critical Images of related posts
 * Description: Clears the Optimize Critical Images of related posts, after a post has been updated.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\oci_clear_related_posts;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

function wpr_clear_oci( $the_post ) {
	
	$the_post = rtrim($the_post,"/");
	 
	 error_log("\n Post: " . print_r($the_post, true), 3, ABSPATH . "/wp-content/wpr-logs/oci.txt");


	global $wpdb;
    $wpdb->delete($wpdb->prefix."wpr_above_the_fold", array( 'url' => $the_post ));
}

// clear the posts and the homepage
function clear_related_oci_posts( $purge_urls,  ) {
	$purge_urls[] = rocket_get_home_url();
	foreach ( $purge_urls as $purge_url ) {
		wpr_clear_oci($purge_url);
	}	
	return $purge_urls;
}

add_action( 'rocket_post_purge_urls', __NAMESPACE__.'\clear_related_oci_posts' );


// clear the terms
function clear_related_oci_terms( $urls ) {
	foreach ( $urls as $url ) {
		wpr_clear_oci($url);
	}		
	return $urls;
}

add_action( 'rocket_after_clean_terms', __NAMESPACE__.'\clear_related_oci_terms' );