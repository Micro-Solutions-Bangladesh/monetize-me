<?php
/**
 * Deactivation handler.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Deactivator {

	/**
	 * Run on plugin deactivation.
	 *
	 * @return void
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
