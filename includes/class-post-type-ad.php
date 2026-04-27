<?php
/**
 * Ad custom post type.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Post_Type_Ad {

	/**
	 * Post type slug.
	 */
	const POST_TYPE = 'ad';

	/**
	 * Register the post type.
	 *
	 * @return void
	 */
	public static function register() {
		add_filter( 'manage_edit-' . self::POST_TYPE . '_columns', array( __CLASS__, 'add_admin_columns' ) );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( __CLASS__, 'render_admin_column' ), 10, 2 );

		$labels = array(
			'name'                  => __( 'Ads', 'monetize-me' ),
			'singular_name'         => __( 'Ad', 'monetize-me' ),
			'menu_name'             => __( 'Ads', 'monetize-me' ),
			'name_admin_bar'        => __( 'Ad', 'monetize-me' ),
			'add_new'               => __( 'Add New', 'monetize-me' ),
			'add_new_item'          => __( 'Add New Ad', 'monetize-me' ),
			'edit_item'             => __( 'Edit Ad', 'monetize-me' ),
			'new_item'              => __( 'New Ad', 'monetize-me' ),
			'view_item'             => __( 'View Ad', 'monetize-me' ),
			'search_items'          => __( 'Search Ads', 'monetize-me' ),
			'not_found'             => __( 'No ads found.', 'monetize-me' ),
			'not_found_in_trash'    => __( 'No ads found in Trash.', 'monetize-me' ),
			'all_items'             => __( 'All Ads', 'monetize-me' ),
			'archives'              => __( 'Ad Archives', 'monetize-me' ),
			'attributes'            => __( 'Ad Attributes', 'monetize-me' ),
			'insert_into_item'      => __( 'Insert into ad', 'monetize-me' ),
			'uploaded_to_this_item' => __( 'Uploaded to this ad', 'monetize-me' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => false,
			// Always register the UI consistently; capabilities below hide it from non-admins.
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'hierarchical'        => false,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-megaphone',
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'taxonomies'          => array( 'adcategory', 'adsponsor' ),
			'has_archive'         => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'rewrite'             => false,
			'query_var'           => false,
			'can_export'          => true,
			'delete_with_user'    => false,
			'capability_type'     => array( 'monetize_ad', 'monetize_ads' ),
			'map_meta_cap'        => true,
			'capabilities'        => self::get_capabilities(),
		);

		register_post_type( self::POST_TYPE, $args );

		add_filter( 'user_can_richedit', array( __CLASS__, 'disable_rich_editor_for_ads' ) );
	}

	/**
	 * Return Ads CPT capabilities.
	 *
	 * Uses plugin-specific capabilities instead of reusing manage_options as
	 * post type primitives. Administrators receive these capabilities on
	 * activation/admin upgrade, keeping the Ads CPT admin-only without affecting
	 * unrelated admin pages.
	 *
	 * @return array<string, string>
	 */
	public static function get_capabilities() {
		return array(
			'edit_post'              => 'edit_monetize_ad',
			'read_post'              => 'read_monetize_ad',
			'delete_post'            => 'delete_monetize_ad',
			'edit_posts'             => 'edit_monetize_ads',
			'edit_others_posts'      => 'edit_others_monetize_ads',
			'delete_posts'           => 'delete_monetize_ads',
			'publish_posts'          => 'publish_monetize_ads',
			'read_private_posts'     => 'read_private_monetize_ads',
			'delete_private_posts'   => 'delete_private_monetize_ads',
			'delete_published_posts' => 'delete_published_monetize_ads',
			'delete_others_posts'    => 'delete_others_monetize_ads',
			'edit_private_posts'     => 'edit_private_monetize_ads',
			'edit_published_posts'   => 'edit_published_monetize_ads',
			'create_posts'           => 'edit_monetize_ads',
		);
	}

	/**
	 * Add custom admin columns for the ad list table.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public static function add_admin_columns( $columns ) {
		$updated_columns = array();

		foreach ( $columns as $key => $label ) {
			$updated_columns[ $key ] = $label;

			if ( 'title' === $key ) {
				$updated_columns['ad_slug'] = __( 'Slug', 'monetize-me' );
			}
		}

		if ( ! isset( $updated_columns['ad_slug'] ) ) {
			$updated_columns['ad_slug'] = __( 'Slug', 'monetize-me' );
		}

		return $updated_columns;
	}

	/**
	 * Render custom admin column values for the ad list table.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Post ID.
	 * @return void
	 */
	public static function render_admin_column( $column, $post_id ) {
		if ( 'ad_slug' !== $column ) {
			return;
		}

		$post = get_post( $post_id );

		if ( ! $post || empty( $post->post_name ) ) {
			echo '&#8212;';
			return;
		}

		echo '<code>' . esc_html( $post->post_name ) . '</code>';
	}

	/**
	 * Disable rich editor for ad post type only.
	 *
	 * @param bool $default Default result.
	 * @return bool
	 */
	public static function disable_rich_editor_for_ads( $default ) {
		if ( ! is_admin() || ! function_exists( 'get_current_screen' ) ) {
			return $default;
		}

		$screen = get_current_screen();

		if ( $screen && self::POST_TYPE === $screen->post_type ) {
			return false;
		}

		return $default;
	}
}
