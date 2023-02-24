// Clear the cache for additional/parked domains

add_filter ( 'rocket_clean_domain_urls', function( $urls ){
	$urls[] = "https://parked-domain.com";
	return $urls;
}, 10, 1);