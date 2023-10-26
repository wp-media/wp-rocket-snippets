<?php

/**
 * Plugin Name: WP Rocket | Disable Cloudflare Auto Cache Purge
 * Description: Prevents WP Rocket from clearing Cloudflare cache as it normally does when WP Rocket's cache is cleared and the Official Cloudflare plugin is in use.
 * Plugin URI:  http://wp-rocket.me/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\compatibility\disable_auto_clearing_cloudflare_cache;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function disable_clearing_cloudflare_cache() {
  $container = apply_filters( 'rocket_container', null );
  $event_manager = $container->get( 'event_manager' );
  $cloudflare_plugin_subscriber = $container->get( 'cloudflare_plugin_subscriber' );

  $event_manager->remove_callback( 'after_rocket_clean_domain', [ $cloudflare_plugin_subscriber, 'purge_cloudflare' ] );
  $event_manager->remove_callback( 'after_rocket_clean_files', [ $cloudflare_plugin_subscriber, 'purge_cloudflare_partial' ] );
  $event_manager->remove_callback( 'rocket_rucss_complete_job_status', [ $cloudflare_plugin_subscriber, 'purge_cloudflare_after_usedcss' ] );
  $event_manager->remove_callback( 'rocket_rucss_after_clearing_usedcss', [ $cloudflare_plugin_subscriber, 'purge_cloudflare_after_usedcss' ] );
}
add_action( 'admin_init', __NAMESPACE__ . '\disable_clearing_cloudflare_cache', 99999999999 );