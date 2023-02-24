// Function to disable Delay JS Execution feature on specific device (mobile/desktop).
// Uncomment line 9 or 10, depending on what you want to achieve
// Add this snippet to your theme's functions.php
// Make sure to have Separate Mobile Cache feature active, Delay JS Execution feature active and to clear the cache

add_filter( 'pre_get_rocket_option_delay_js', function ( $option_value ) {
    if ( is_admin() ) {
        return $option_value;
    }

    // return ! wp_is_mobile(); // Disable Delay JS Execution for Mobile
    // return wp_is_mobile(); // Disable Delay JS Execution for Desktop 
} );
