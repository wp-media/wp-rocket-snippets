<?php

// Add the snippet below to either functions.php file or via a code snippet plugin and refresh any WP Admin page to run it
// Will delete any cache files older than the time passed to purge_expired_files() - 30 seconds is set below by default
add_action( 'admin_init', function() {
	$faux_cache_lifespan_obj = new WP_Rocket\Engine\Cache\PurgeExpired\PurgeExpiredCache( WP_ROCKET_CACHE_PATH );
	$faux_cache_lifespan_obj->purge_expired_files( 30 ); // Pass custom Cache Lifespan time in seconds
} );

// This is not necessary, but will create log of pages cleared in the WP root directory
add_action( 'rocket_after_automatic_cache_purge_dir', function( $url_deleted, $args ) {
	// Added by WP Rocket Support
	error_log( "_______"
	. "LOG"
	. "_______\n"
	. "TIME: " . date("Y-m-d H:i:s", $_SERVER["REQUEST_TIME"] ) . "\n"
	. "URL_DELETED: " . print_r( $url_deleted, true ) . "\n\n"
	. "ARGS: " . print_r( $args, true ) . "\n\n"
	, 3, ABSPATH . "/cache-lifespan-purged-pages.log" );
}, 9999, 2 );