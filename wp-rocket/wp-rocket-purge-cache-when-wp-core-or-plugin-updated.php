<?php
/**
 * Plugin Name: WP Rocket | Purge Cache when WP Core or Plugin Updated
 * Description: Purges WP Rocket’s cache when WP core or a plugin is updated.
 * Plugin URI:  
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\cache\purge_cache_on_core_plugin_update;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

// Clear cache when a plugin update completes
add_action( 'upgrader_process_complete', function() {
  rocket_clean_domain();
});

// Clear cache when update to WP Core completes
add_action( '_core_updated_successfully', function() {
  rocket_clean_domain();
});