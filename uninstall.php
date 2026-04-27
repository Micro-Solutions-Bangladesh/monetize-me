<?php
/**
 * Uninstall handler.
 *
 * @package MonetizeMe
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'monetize_me_version' );
