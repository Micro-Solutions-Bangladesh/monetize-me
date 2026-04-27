<?php
/**
 * Activation handler.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Activator {

	/**
	 * Run on plugin activation.
	 *
	 * @return void
	 */
	public static function activate() {
			self::add_admin_capabilities();

		Post_Type_Ad::register();
		Taxonomy_Ad_Category::register();
		Taxonomy_Ad_Sponsor::register();

		update_option( 'monetize_me_version', MONETIZE_ME_VERSION );

		flush_rewrite_rules();
	}

	/**
	 * Add Ads management capabilities to administrators only.
	 *
	 * @return void
	 */
	public static function add_admin_capabilities() {
		$role = get_role( 'administrator' );

		if ( ! $role ) {
			return;
		}

		$caps = array_values( Post_Type_Ad::get_capabilities() );
		$caps[] = 'manage_monetize_ad_terms';
		$caps[] = 'assign_monetize_ad_terms';

		foreach ( array_unique( $caps ) as $cap ) {
			$role->add_cap( $cap );
		}
	}
}
