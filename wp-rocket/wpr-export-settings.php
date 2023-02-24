<?php
// Allows to export WP Rocket settings when the backend is not accessible 

// Load WordPress.
require( 'wp-load.php' );
 
$filename = sprintf( 'wp-rocket-settings-%s-%s.json', date( 'Y-m-d' ), uniqid() );
//$gz       = 'gz' . strrev( 'etalfed' );
$options  = wp_json_encode( get_option( 'wp_rocket_settings' ) ); // do not use get_rocket_option() here.
nocache_headers();
@header( 'Content-Type: application/json' );
@header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
@header( 'Content-Transfer-Encoding: binary' );
@header( 'Content-Length: ' . strlen( $options ) );
@header( 'Connection: close' );
echo $options;
exit();