<?php
/**
 * Ad Category taxonomy.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Taxonomy_Ad_Category {

	/**
	 * Taxonomy slug.
	 */
	const TAXONOMY = 'adcategory';

	/**
	 * Register taxonomy.
	 *
	 * @return void
	 */
	public static function register() {
		$labels = array(
			'name'                       => __( 'Ad Categories', 'monetize-me' ),
			'singular_name'              => __( 'Ad Category', 'monetize-me' ),
			'search_items'               => __( 'Search Ad Categories', 'monetize-me' ),
			'popular_items'              => __( 'Popular Ad Categories', 'monetize-me' ),
			'all_items'                  => __( 'All Ad Categories', 'monetize-me' ),
			'edit_item'                  => __( 'Edit Ad Category', 'monetize-me' ),
			'view_item'                  => __( 'View Ad Category', 'monetize-me' ),
			'update_item'                => __( 'Update Ad Category', 'monetize-me' ),
			'add_new_item'               => __( 'Add New Ad Category', 'monetize-me' ),
			'new_item_name'              => __( 'New Ad Category Name', 'monetize-me' ),
			'separate_items_with_commas' => __( 'Separate ad categories with commas', 'monetize-me' ),
			'add_or_remove_items'        => __( 'Add or remove ad categories', 'monetize-me' ),
			'choose_from_most_used'      => __( 'Choose from the most used ad categories', 'monetize-me' ),
			'menu_name'                  => __( 'Ad Categories', 'monetize-me' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => false,
			// Always register taxonomy UI consistently; capabilities below hide it from non-admins.
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => false,
			'query_var'         => true,
			'rewrite'           => false,
			'capabilities'      => array(
				'manage_terms' => 'manage_monetize_ad_terms',
				'edit_terms'   => 'manage_monetize_ad_terms',
				'delete_terms' => 'manage_monetize_ad_terms',
				'assign_terms' => 'assign_monetize_ad_terms',
			),
		);

		register_taxonomy( self::TAXONOMY, array( 'ad' ), $args );
	}
}
