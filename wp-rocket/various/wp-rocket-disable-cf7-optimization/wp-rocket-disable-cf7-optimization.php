<?php

/**
 * Plugin Name: WP Rocket | Disable Contact form 7 optimization
 * Description: Disables the optimizations WP Rocket applies for Contact form 7
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright WP MEDIA 2024
 */

namespace WP_Rocket\Helpers\cache\rocket_remove_url_exclusions;

// Standard plugin security, keep this line in place.
defined('ABSPATH') or die();

add_filter(
    'rocket_thirdparty_load',
    function ($status, $thirdparty) {
        if ('contact-form-7' !== $thirdparty) {
            return $status;
        }
        return false;
    },
    10,
    2
);
