<?php

$docroot = $_SERVER['DOCUMENT_ROOT'];

require( $docroot . '/wp-load.php' );

// No need to go further if WP Rocket is not in use
if ( ! defined( 'WP_ROCKET_VERSION' ) ) {
  return;
}

// EDIT HERE: Add as many lines as you have files to be monitored for changes
$files_to_monitor = array(
  // Keep the $docroot part the same - only add paths to your files for monitoring
  // Paths are to be specified from the WordPress root location
  $docroot . '/wp-content/uploads/custom-css-js/32737.css',
);

$options = array(
  'purge_used_css' => true,   // true to purge Used CSS
  'purge_cache' => true,      // true to purge cache
  'purge_minified' => true,   // true to purge minified CSS and JS files
);
// STOP EDITING

$time_in_seconds = time();

function purge_if_needed( $files_to_monitor, $time_in_seconds, $interval_to_clear, $options ) {

  foreach ( $files_to_monitor as $file ) {
    
    if ( ! file_exists( $file ) ) {
      continue;
    }

    $last_modified = filemtime( $file );

    // If file was not updated within qualifying interval we skip to check the next file
    if ( ( $time_in_seconds - $last_modified ) >= $interval_to_clear ) {
      continue;
    }

    // At this point, file qualifies as edited within time to clear, so we purge
    if ( $options['purge_used_css'] ) {
      // access rocket's injection container
      $container = apply_filters( 'rocket_container', null );
      // get the rucss subscriber from the container
      $subscriber = $container->get( 'rucss_admin_subscriber' );
      // call the rucss truncate method.
      $subscriber->truncate_used_css();
    }

    if ( $options['purge_cache'] && function_exists( 'rocket_clean_domain' ) ) {
      // clear domain cache
      rocket_clean_domain();
    }

    if ( $options['purge_minified'] && function_exists( 'rocket_clean_minify' ) ) {
      // Clear minified CSS and JavaScript files.
      rocket_clean_minify();
    }

    // No need to continue checking more files
    break;
  }
}

// Case of the first time this file is run via cron and file does not exist with any record of time last cron run
if ( ! file_exists( __dir__ . '/time-last-cron-run.txt' ) ) {

  // Create file to track last cron run and set the value to current time
  fopen( __dir__ . '/time-last-cron-run.txt', 'c' );
  $handle = fopen( __dir__ . '/time-last-cron-run.txt', 'r+' );
  fwrite( $handle, $time_in_seconds );
  fclose( $handle );

  // We pass PHP_INT_MAX to guarantee purge the first time cron runs since we have no last cron run time to compare
  purge_if_needed( $files_to_monitor, $time_in_seconds, PHP_INT_MAX, $options );

// Case where file exists with record of when last successful cron run happened (each run after the first one)
} else {

  // Open the file that keeps track of last time cron run
  $handle = fopen( __dir__ . '/time-last-cron-run.txt', 'r+' );
  $last_cron_run = fgets( $handle );
  $interval_to_clear = $time_in_seconds - $last_cron_run;

  // Have record of last cron run so purge only if CSS file edited sometime after that last cron run
  purge_if_needed( $files_to_monitor, $time_in_seconds, $interval_to_clear, $options );
}

// Finish by updating last time cron was run
ftruncate( $handle, 0 );
fseek( $handle, 0 );
fwrite( $handle, $time_in_seconds );
fclose( $handle );