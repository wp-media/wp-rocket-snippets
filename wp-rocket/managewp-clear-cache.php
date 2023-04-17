<?php

// ManageWP PHP Snippet, will clear the cache and trigger a preload. 
// related doc: https://docs.wp-rocket.me/article/1320-managewp-how-to-clear-wp-rocket-cache
// Load WordPress environment.
require 'wp-load.php';

// Define some constants.
if ( ! defined( 'COOKIEHASH' ) ) {
	$siteurl = get_site_option( 'siteurl' );
	if ( $siteurl ) {
		define( 'COOKIEHASH', md5( $siteurl ) );
	} else {
		define( 'COOKIEHASH', '' );
	}
}
if ( ! defined( 'LOGGED_IN_COOKIE' ) ) {
	define( 'LOGGED_IN_COOKIE', 'wordpress_logged_in_' . COOKIEHASH );
}

// Instatiate the WP_Rewrite class and store it in $wp_rewrite.
$GLOBALS['wp_rewrite'] = new WP_Rewrite();


// Load WP Rocket environment.
require 'wp-content/plugins/wp-rocket/wp-rocket.php';
require 'wp-content/plugins/wp-rocket/inc/functions/i18n.php';
require 'wp-content/plugins/wp-rocket/inc/functions/formatting.php';
require 'wp-content/plugins/wp-rocket/inc/functions/options.php';
require 'wp-content/plugins/wp-rocket/inc/3rd-party/3rd-party.php';

// Clear the cache.
if ( function_exists( 'rocket_clean_domain' ) ) {
	
	// clear the files
	rocket_clean_domain();
	
	// set the jobs to pending in the wpr_rocket_cache table
	$GLOBALS['wpdb']->query( "UPDATE {$GLOBALS['wpdb']->prefix}wpr_rocket_cache SET status = 'pending' WHERE status = 'completed'");

	echo 'Cache cleared and preload started';
}