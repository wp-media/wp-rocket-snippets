<?php

if ( function_exists( 'rocket_clean_domain' ) ) {
  // Clear cache when a plugin update completes
  add_action( 'upgrader_process_complete', function() {
    rocket_clean_domain();
  });

  // Clear cache when update to WP Core completes
  add_action( '_core_updated_successfully', function() {
    rocket_clean_domain();
  });
}