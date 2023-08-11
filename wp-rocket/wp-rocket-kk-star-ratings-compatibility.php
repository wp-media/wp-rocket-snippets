<?php 
// WP Rocket and KK Star Ratings compatibility snippet.
// Clears the post cache after submitting a vote using KK Star Ratings 

function custom_rocket_clean_post($outOf5, $outOfTotal, $id, $legacySlug, $fingerprint) {
	rocket_clean_post($id);
}

add_action('kksr_vote', 'custom_rocket_clean_post', 10, 5);