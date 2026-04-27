<?php
/**
 * Ad Sponsor taxonomy.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Taxonomy_Ad_Sponsor {

	/**
	 * Taxonomy slug.
	 */
	const TAXONOMY = 'adsponsor';

	/**
	 * Register taxonomy.
	 *
	 * @return void
	 */
	public static function register() {
		$labels = array(
			'name'                       => __( 'Ad Sponsors', 'monetize-me' ),
			'singular_name'              => __( 'Ad Sponsor', 'monetize-me' ),
			'search_items'               => __( 'Search Ad Sponsors', 'monetize-me' ),
			'popular_items'              => __( 'Popular Ad Sponsors', 'monetize-me' ),
			'all_items'                  => __( 'All Ad Sponsors', 'monetize-me' ),
			'edit_item'                  => __( 'Edit Ad Sponsor', 'monetize-me' ),
			'view_item'                  => __( 'View Ad Sponsor', 'monetize-me' ),
			'update_item'                => __( 'Update Ad Sponsor', 'monetize-me' ),
			'add_new_item'               => __( 'Add New Ad Sponsor', 'monetize-me' ),
			'new_item_name'              => __( 'New Ad Sponsor Name', 'monetize-me' ),
			'separate_items_with_commas' => __( 'Separate ad sponsors with commas', 'monetize-me' ),
			'add_or_remove_items'        => __( 'Add or remove ad sponsors', 'monetize-me' ),
			'choose_from_most_used'      => __( 'Choose from the most used ad sponsors', 'monetize-me' ),
			'menu_name'                  => __( 'Ad Sponsors', 'monetize-me' ),
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
