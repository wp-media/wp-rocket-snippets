<?php

// Load WordPress
require( 'wp-load.php' );

// Clear Critical Images Optimization data
if ( defined( 'WP_ROCKET_VERSION' ) ) {
  // access rocket's injection container
  $container = apply_filters( 'rocket_container', null );
  // Get the rucss subscriber from the container
  $atf_subscriber = $container->get( 'atf_admin_subscriber' );
  // call the atf truncate method.
  $atf_subscriber->truncate_atf();
}
