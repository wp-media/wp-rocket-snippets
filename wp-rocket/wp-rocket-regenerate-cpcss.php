?php 
// Load WordPress environment.
require 'wp-load.php';

//Code snippet to regenerate the CPCSS for the Load CSS asynchronously feature
//Requires admin activity for the regeneration to start

function wp_rocket_generate_cpcss() {
    $container = apply_filters( 'rocket_container', null );
    $container->get( 'critical_css' )->process_handler();
    echo "cpcss cleared";
}

// Call the function
wp_rocket_generate_cpcss();
