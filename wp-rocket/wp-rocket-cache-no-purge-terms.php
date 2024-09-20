<?php
/**
 * Plugin Name: WP Rocket | Disable Cache Clearing for terms
 * Description: Disables all of WP Rocket’s automatic cache clearing when terms are created
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/cache/wp-rocket-no-cache-auto-purge/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\cache\no_cache_auto_purge_terms;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Remove all of WP Rocket's cache purging actions.
 *
 * @author Caspar Hübinger
 */
function remove_purge_hooks() {

    // WP core action hooks rocket_clean_domain() gets hooked into.
    $clean_domain_hooks = array(
         // When a term is created 
        'create_term',
        // When a term is updated 
        'edited_terms',
        // When a term is deleted 
        'delete_term',
     );

       // Remove rocket_clean_domain() from core action hooks.
    foreach ( $clean_domain_hooks as $key => $handle ) {
        remove_action( $handle, 'rocket_clean_domain' );
    }
    
}
add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\remove_purge_hooks' );

/**
 * Disable cache clearing when term is created/updated/deleted for WP Rocket 3.5.5 or later.
 * Disable user cache purging for WP Rocket 3.5 or later.
 *
 *	@author Vasilis Manthos
 * 	@author Piotr Bak
 */
function wp_rocket_disable_user_cache_purging(){
    
    $container = apply_filters( 'rocket_container', '');
    // After term is created.
    $container->get('event_manager')->remove_callback( 'create_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );
    // After term is edited.
    $container->get('event_manager')->remove_callback( 'edit_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );
    // After term is removed.
    $container->get('event_manager')->remove_callback( 'delete_term' , [ $container->get('purge_actions_subscriber'), 'maybe_purge_cache_on_term_change'] );

}

add_action( 'wp_rocket_loaded', __NAMESPACE__ . '\wp_rocket_disable_user_cache_purging' );
