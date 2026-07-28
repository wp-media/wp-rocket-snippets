<?php
/**
 * Plugin Name: WP Rocket | Reset CTA
 * Description: Removes the RocketCDN CTA hidden flag for all users. Activate once, reload WP Admin, and then remove this plugin.
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2026
 */

add_action( 'admin_init', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Prevent running more than once.
	if ( get_option( 'rocketcdn_cta_reset_done' ) ) {
		return;
	}

	global $wpdb;

	$deleted = $wpdb->delete(
		$wpdb->usermeta,
		[
			'meta_key' => 'rocket_rocketcdn_cta_hidden',
		],
		[ '%s' ]
	);

	update_option( 'rocketcdn_cta_reset_done', true );
	set_transient( 'rocketcdn_cta_reset_notice', (int) $deleted, MINUTE_IN_SECONDS );
} );

add_action( 'admin_notices', function () {
	$deleted = get_transient( 'rocketcdn_cta_reset_notice' );

	if ( false === $deleted ) {
		return;
	}

	delete_transient( 'rocketcdn_cta_reset_notice' );

	?>
	<div class="notice notice-success is-dismissible">
		<p>
			<?php
			printf(
				'RocketCDN CTA reset completed. Removed %d user meta entr%s.',
				$deleted,
				1 === $deleted ? 'y' : 'ies'
			);
			?>
		</p>
	</div>
	<?php
} );