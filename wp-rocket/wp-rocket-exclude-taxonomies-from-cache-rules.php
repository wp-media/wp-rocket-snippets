<?php
// This code snippet modifies caching and optimization rules for taxonomies that are not cached by default.
add_action( 'wp_rocket_loaded', function() {
    $container = apply_filters( 'rocket_container', null );

    if ( ! $container ) {
        return;
    }

    // Get the actual instance of TaxonomySubscriber
    $taxonomy_subscriber = $container->get( 'taxonomy_subscriber' );

    if ( ! $taxonomy_subscriber ) {
        return;
    }

    // Get subscribed events (for debugging)
    $subscribed_events = $taxonomy_subscriber->get_subscribed_events();

    // Remove filter from 'rocket_buffer'
    remove_filter( 'rocket_buffer', [ $taxonomy_subscriber, 'stop_optimizations_for_not_valid_taxonomy_pages' ], 1 );

    // Remove action from 'do_rocket_generate_caching_files'
    remove_action( 'do_rocket_generate_caching_files', [ $taxonomy_subscriber, 'disable_cache_on_not_valid_taxonomy_pages' ] );


}, PHP_INT_MAX );