<?php
/**
 * Plugin Name: WP Rocket | Clean product related translations (WPML with translated slugs)
 * Description: Clears the cache of product translations when updating the main language, to keep the translated posts in sync
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2023
 */

namespace WP_Rocket\Helpers\htaccess\wp_rocket_clean_product_related_translations;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

function rocket_clean_related_post_translations(  $urls_to_purge, $post  ) {
	
	$the_current_lang = apply_filters( 'wpml_current_language', NULL );

	if ( empty( $urls_to_purge ) || ! is_array( $urls_to_purge ) )
		return $urls_to_purge;
		 
		$post_id = $post->ID;
		
		$type = apply_filters( 'wpml_element_type', get_post_type( $post_id ) );
		$trid = apply_filters( 'wpml_element_trid', false, $post_id, $type );

		
		$translations = apply_filters( 'wpml_get_element_translations', array(), $trid, $type );
		
		foreach ( $translations as $lang => $translation ) {
		
			do_action( 'wpml_switch_language', $translation->language_code );
			$permalink = get_permalink($translation->element_id);	
			   
			   $urls_to_purge[] = $permalink;	    
		    
		}
		
		do_action( 'wpml_switch_language', $the_current_lang );

		return $urls_to_purge;

 }	
 
add_filter( 'rocket_post_purge_urls', __NAMESPACE__ . '\rocket_clean_related_post_translations', 10, 2 );
