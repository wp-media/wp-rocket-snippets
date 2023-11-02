<?php
// Prevents adding URL to the wpr_rocket_cache table if Preload is disabled
// using the filter rocket_preload_exclude_urls
function stop_adding_to_cache_table( array $regexes ) : array {

    $new_regex = $_SERVER['REQUEST_URI'];
    
    $options = get_option('wp_rocket_settings', []);

    //only if preload is disabled
    if( $options['manual_preload'] == 0) {

        // add the currently visited URL to the exclusions array
        $regexes[] = $new_regex;
    }

return $regexes;
}

add_filter( 'rocket_preload_exclude_urls', 'stop_adding_to_cache_table');