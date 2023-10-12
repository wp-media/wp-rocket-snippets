<?php
/**
 * Plugin Name: WP Rocket | Purge Cloudflare APO via Cache Lifespan
 * Description: Clears cache files expired via Cache Lifespan on both WP Rocket and CLoudflare APO.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\compatibility\purge_cloudflare_apo_cache_lifespan;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function purge_cloudflare_apo_cache_lifespan( $deleted ) {

  if (! isset( $deleted[0]['files'] ) ) {
    return;
  }

  if ( defined( 'WP_ROCKET_VERSION' ) ) {

    // access rocket's injection container
    $container = apply_filters( 'rocket_container', null );

    // get the Cloudflare APO subscriber from the container
    $subscriber = $container->get( 'cloudflare_plugin_subscriber' );

    $urls = array();

    foreach ( $deleted[0]['files'] as $file ) {

      // Convert paths to URLs and account for trailing slash and non-trailing slash setups
      $urls[] = 'https://' . str_replace( WP_ROCKET_CACHE_PATH, '', $file );
    }

    // Convert URLs to post IDs
    $post_ids = array_filter( array_map( 'url_to_postid', $urls ) );

    // If $post_ids is empty, it means no pages or only home page was cached
    // purge_cloudflare_partial won't work for home page in that case, so we use purge_cloudflare instead
    if ( empty( $post_ids ) ) {
      $subscriber->purge_cloudflare();
      return;
    }

    // Otherwise we purge all expired cache pages
    $subscriber->purge_cloudflare_partial( $urls );
  }
}
add_action( 'rocket_after_automatic_cache_purge', __NAMESPACE__ . '\purge_cloudflare_apo_cache_lifespan' );