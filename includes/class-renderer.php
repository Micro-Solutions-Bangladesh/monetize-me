<?php
/**
 * Backward-compatible renderer proxy.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Renderer {

	/**
	 * Render ads.
	 *
	 * @param array $atts Normalized or raw arguments.
	 * @return string
	 */
	public static function render( $atts ) {
		return Ad_Service::render( $atts );
	}
}
