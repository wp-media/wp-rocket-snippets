<?php
/**
 * Plugin Name: WP Rocket | Reset cache tables after Multisite cache cleanup
 * Description: Will reset all cache rows to pending on a multisite install, after WP Rocket's cache cleanup to trigger a preload.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\multisite_reset_cache_status;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();


// this is a patch for https://github.com/wp-media/wp-rocket/issues/2746
function reset_cache_tables() {
    
   if ( is_multisite()) {
  $sites = get_sites();	
  
  foreach ($sites as $site ) {
    $site_url = get_site_url($site->blog_id);			
    switch_to_blog( $site->blog_id );
    global $wpdb;
      $table_name = $wpdb->prefix . 'wpr_rocket_cache';
    //$wpdb->query("TRUNCATE TABLE $table_name");
    $wpdb->query("UPDATE `$table_name` SET `status` = 'pending' WHERE `status` != 'pending'");
    
    }			
  }	

}

add_action('after_rocket_clean_domain', __NAMESPACE__ .'\reset_cache_tables');

