<?php
/**
 * Admin upgrade routines.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Admin {

	/**
	 * Register admin hooks.
	 *
	 * @return void
	 */
	public static function register() {
		add_action( 'admin_init', array( __CLASS__, 'maybe_run_upgrade' ) );
	}

	/**
	 * Run one-time upgrade routines.
	 *
	 * @return void
	 */
	public static function maybe_run_upgrade() {
		Activator::add_admin_capabilities();

		$installed_version = get_option( 'monetize_me_version', '0.0.0' );

		if ( version_compare( $installed_version, '2.0.0', '<' ) ) {
			Ad_Service::purge_all_caches();
		}

		if ( version_compare( $installed_version, MONETIZE_ME_VERSION, '<' ) ) {
			update_option( 'monetize_me_version', MONETIZE_ME_VERSION );
		}
	}
}
