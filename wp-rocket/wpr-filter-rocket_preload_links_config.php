<?php 

// filter URLs from being preloaded
//duplicate $config['excludeUris'] as many times as needed  

function rocket_exclude_preload_links( $config ) { 
	$config['excludeUris'] = 'https://www.example.com/this-is-the-slug-2';
	return $config;
}


add_filter( 'rocket_preload_links_config', 'rocket_exclude_preload_links');
