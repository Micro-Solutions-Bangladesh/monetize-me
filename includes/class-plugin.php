<?php
/**
 * Main plugin bootstrap class.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize plugin.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		add_action( 'init', array( '\Monetize_Me\Post_Type_Ad', 'register' ) );
		add_action( 'init', array( '\Monetize_Me\Taxonomy_Ad_Category', 'register' ) );
		add_action( 'init', array( '\Monetize_Me\Taxonomy_Ad_Sponsor', 'register' ) );

		Shortcode::register();
		Widget_Ad::register();
		Block::register();
		if ( is_admin() && ! is_network_admin() ) {
			Admin::register();
		}

		if ( is_multisite() && is_network_admin() ) {
			Network_Admin::register();
		}

		add_action( 'save_post_' . Post_Type_Ad::POST_TYPE, array( $this, 'purge_ad_caches' ), 10, 3 );
		add_action( 'deleted_post', array( $this, 'purge_ad_caches_on_delete' ) );
		add_action( 'set_object_terms', array( $this, 'purge_ad_caches_on_terms' ), 10, 6 );
	}

	/**
	 * Load translations.
	 *
	 * @return void
	 */
	/**
	 * Purge ad caches when an ad is saved.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 * @param bool     $update  Whether this is an update.
	 * @return void
	 */
	public function purge_ad_caches( $post_id, $post, $update ) {
		unset( $post_id, $post, $update );
		Ad_Service::purge_all_caches();
	}

	/**
	 * Purge ad caches when an ad is deleted.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function purge_ad_caches_on_delete( $post_id ) {
		if ( Post_Type_Ad::POST_TYPE === get_post_type( $post_id ) ) {
			Ad_Service::purge_all_caches();
		}
	}

	/**
	 * Purge ad caches when ad taxonomies change.
	 *
	 * @param int    $object_id    Object ID.
	 * @param array  $terms        Terms.
	 * @param array  $tt_ids       Term taxonomy IDs.
	 * @param string $taxonomy     Taxonomy slug.
	 * @param bool   $append       Whether terms were appended.
	 * @param array  $old_tt_ids   Old term taxonomy IDs.
	 * @return void
	 */
	public function purge_ad_caches_on_terms( $object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids ) {
		unset( $terms, $tt_ids, $append, $old_tt_ids );

		if ( Post_Type_Ad::POST_TYPE !== get_post_type( $object_id ) ) {
			return;
		}

		if ( in_array( $taxonomy, array( Taxonomy_Ad_Category::TAXONOMY, Taxonomy_Ad_Sponsor::TAXONOMY ), true ) ) {
			Ad_Service::purge_all_caches();
		}
	}

	public function load_textdomain() {
		load_plugin_textdomain(
			'monetize-me',
			false,
			dirname( plugin_basename( MONETIZE_ME_FILE ) ) . '/languages'
		);
	}
}
