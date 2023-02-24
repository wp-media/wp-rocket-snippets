// Add a comment in the source code of a page to tell if it was preloaded or cached by a visit

add_filter( 'rocket_buffer', function($html){
 preg_match( '@WP Rocket/(Homepage_Preload_After_Purge_Cache|Homepage\sPreload|Preload){1}@i', $_SERVER['HTTP_USER_AGENT'] ) ?
	 $html .= '<!-- Cached by Preload -->':
 $html .= '<!-- Cached by ' . $_SERVER['HTTP_USER_AGENT'] . ' -->';
  return $html;
}, PHP_INT_MAX );