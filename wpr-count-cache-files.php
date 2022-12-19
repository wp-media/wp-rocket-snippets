<?php
// Counts the number of cached files inside the wp-content/cache/wp-rocket/ folder

$d = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$s = $_SERVER['SERVER_NAME'];	

$dir = new RecursiveDirectoryIterator( "wp-content/cache/wp-rocket/{$s}/");
$flat = new RecursiveIteratorIterator($dir);

$files = new RegexIterator($flat, '/^.+\.html_gzip$/i');
$filecount = count(iterator_to_array($files));


echo "<pre>[{$d}] Found {$filecount} .html_gzip cache files for {$s}:\n\n";
foreach($files as $file) {
        echo $file . "\n";
}
echo "</pre>";
