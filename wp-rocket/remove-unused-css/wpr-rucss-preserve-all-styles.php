<?php

// Preserve all inline styles

add_filter('rocket_rucss_inline_content_exclusions', function ($inline_exclusions) { $inline_exclusions[] = '.'; return $inline_exclusions; });

// Preserve all stylesheets

add_filter('rocket_rucss_external_exclusions', function ($external_exclusions) { $external_exclusions[] = '/'; return $external_exclusions; });
