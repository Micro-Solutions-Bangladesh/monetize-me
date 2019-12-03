<?php
/**
 * Plugin Name: Monetize Me
 * Plugin URI: https://mcqacademy.com/
 * Description: Monetize Me plugin will help webmaster to manage monetize scripts and display using shortcodes and widgets.
 * Author: microsolutions, shahalom
 * Author URI: https://MicroSolutionsBD.com/
 * Version: 1.0.1
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package monetize-me
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once('libs/msbd-helper-functions.php');
require_once('libs/widgets.php');

require_once('inc/widgets.php');
require_once('inc/shortcodes.php');

require_once('inc/custom-post-types/ad.php');
require_once('inc/custom-taxonomies/adcategory.php');
require_once('inc/custom-taxonomies/adsponsor.php');

require_once('inc/functions.php');


/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

// Activation Hook
require_once('inc/activation-hook.php');
register_activation_hook(__FILE__, array('Monetize_Me_Activation', 'plugin_activated'));

/* end of file main.php */
