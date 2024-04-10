<?php 

//Custom snippet for WP Rocket and the TotalPoll plugin.
//This function clears the cache files of a post and two specific URLs after a new vote is casted.

function rocket_clean_url_with_home_cleaning( $post_url ) {
	$urls_list = array(
        $post_url, // clean the post URL
		"https://website.com", // additional URLs
		"https://website.com/top-voted",
	);

		rocket_clean_files( $urls_list );
	
}
add_action( 'after_poll_cast_vote', 'rocket_clean_url_with_home_cleaning' );
