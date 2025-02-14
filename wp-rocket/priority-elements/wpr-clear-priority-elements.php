<?php
// Load WordPress - needed if using this snippet in a standalone PHP file.
require( 'wp-load.php' );

// Clear Priority Elements

if (defined('WP_ROCKET_VERSION')) {
  // access rocket's injection container
  $container = apply_filters('rocket_container', null);

  // Get the Performance Hints subscriber from the container
  $perfhints_subscriber = $container -> get('performance_hints_admin_subscriber');
  // call the Performance Hints truncate tables method.
  $perfhints_subscriber -> truncate_tables();

}

// Clear cache
if (function_exists('rocket_clean_domain')) {
  rocket_clean_domain();
}
