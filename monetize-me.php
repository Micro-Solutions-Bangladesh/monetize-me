<?php
/**
 * Plugin Name: Monetize Me
 * Plugin URI: https://microsolutionsbd.com/wp-plugin-msbd-logs/2026/
 * Description: Manage advertisement scripts as Ads and display them via shortcode, widget, or block.
 * Version:     2.0.1
 * Requires PHP: 7.4
 * Author: Micro Solutions BD
 * Author URI: https://microsolutionsbd.com/
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: monetize-me
 * Domain Path: /languages
 *
 * @package MonetizeMe
 */

defined( 'ABSPATH' ) || exit;

define( 'MONETIZE_ME_VERSION', '2.0.1' );
define( 'MONETIZE_ME_FILE', __FILE__ );
define( 'MONETIZE_ME_PATH', plugin_dir_path( __FILE__ ) );
define( 'MONETIZE_ME_URL', plugin_dir_url( __FILE__ ) );

require_once MONETIZE_ME_PATH . 'includes/helper-functions.php';
require_once MONETIZE_ME_PATH . 'includes/class-plugin.php';
require_once MONETIZE_ME_PATH . 'includes/class-activator.php';
require_once MONETIZE_ME_PATH . 'includes/class-deactivator.php';
require_once MONETIZE_ME_PATH . 'includes/class-post-type-ad.php';
require_once MONETIZE_ME_PATH . 'includes/class-taxonomy-ad-category.php';
require_once MONETIZE_ME_PATH . 'includes/class-taxonomy-ad-sponsor.php';
require_once MONETIZE_ME_PATH . 'includes/class-ad-service.php';
require_once MONETIZE_ME_PATH . 'includes/class-renderer.php';
require_once MONETIZE_ME_PATH . 'includes/class-shortcode.php';
require_once MONETIZE_ME_PATH . 'includes/class-widget-ad.php';
require_once MONETIZE_ME_PATH . 'includes/class-block.php';
require_once MONETIZE_ME_PATH . 'includes/class-admin.php';
require_once MONETIZE_ME_PATH . 'includes/class-network-admin.php';

register_activation_hook( __FILE__, array( '\Monetize_Me\Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( '\Monetize_Me\Deactivator', 'deactivate' ) );

/**
 * Get plugin instance.
 *
 * @return \Monetize_Me\Plugin
 */
function monetize_me() {
	return \Monetize_Me\Plugin::instance();
}

monetize_me()->init();
