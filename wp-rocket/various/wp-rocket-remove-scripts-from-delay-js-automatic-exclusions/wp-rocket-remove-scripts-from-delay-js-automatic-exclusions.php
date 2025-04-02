<?php
/**
 * Plugin Name: WP Rocket | Remove scripts from Delay JS Automatic Exclusions
 * Plugin URI: 
 * Description: Remove scripts from the Automatic Delay JS exclusion list so they can be delayed.
 * Version: 1.0
 * Author: WP Rocket Support Team
 * Author URI: https://wp-rocket.me
 * License:	GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright 2021 WP Media <support@wp-rocket.me>
 */


// Namespaces must be declared before any other declaration.
namespace WP_Rocket\Helpers\static_files\exclude\control_delay_js_exclusions;

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

function include_to_delay_js($exclusions)
{

    /**
        Add the script(s) you want to be removed from the Delay JavaScript Execution Automatic exclusions list.
        Uncomment the extra line and replace with the script you want to be delayed, or add them manually.
    **/

    $patterns = array(
        // START EDITING

        //'first-script',
        //'second-script',
        //'third-script',

        // STOP EDITING
    );

    $exclusions = array_diff($exclusions, $patterns);

    return $exclusions;
}

add_filter('rocket_delay_js_exclusions',  __NAMESPACE__ . '\include_to_delay_js');
