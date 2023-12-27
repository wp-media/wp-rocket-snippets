<?php
/**
 * Plugin Name: WP Rocket | Reset Cache Table
 * Description: Reset the cache table to its original state
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\reset_cache_table;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();



// Upon activation, clear the cache and deactivate/reactivate Preload
register_activation_hook(__FILE__, __NAMESPACE__ .'\prepare_things_upon_activation');

function prepare_things_upon_activation()
{

    // 1 - truncate cache table upon plugin activation
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpr_rocket_cache';
    $wpdb->query("TRUNCATE TABLE $table_name");


    // 2 clear the cache
    if (function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }


    // 2 - Disable and reenable preload, so the sitemap gets imported immediately
    $options = get_option('wp_rocket_settings', []);

    // disable preload
    $options['manual_preload'] = 0;
    update_option('wp_rocket_settings', $options);

    // enable preload
    $options['manual_preload'] = 1;
    update_option('wp_rocket_settings', $options);
}
