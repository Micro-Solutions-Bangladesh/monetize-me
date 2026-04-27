<?php
/**
 * Block registration and render callback.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Block {

	/**
	 * Register block hooks.
	 *
	 * @return void
	 */
	public static function register() {
		add_action( 'init', array( __CLASS__, 'register_block' ) );
	}

	/**
	 * Register block type from block.json.
	 *
	 * @return void
	 */
	public static function register_block() {
		$build_block_json = MONETIZE_ME_PATH . 'build/block.json';
		$src_block_json   = MONETIZE_ME_PATH . 'src/block/block.json';

		if ( file_exists( $build_block_json ) ) {
			register_block_type(
				$build_block_json,
				array(
					'render_callback' => array( __CLASS__, 'render' ),
				)
			);
			return;
		}

		if ( file_exists( $src_block_json ) ) {
			register_block_type(
				$src_block_json,
				array(
					'render_callback' => array( __CLASS__, 'render' ),
				)
			);
		}
	}

	/**
	 * Server-side render callback.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content    Saved block content.
	 * @return string
	 */
	public static function render( $attributes, $content = '' ) {
		unset( $content );

		return Renderer::render(
			array(
				'postSlug'    => sanitize_title( $attributes['postSlug'] ?? '' ),
				'adCategory'  => monetize_me_parse_ad_category_selector( $attributes['adCategory'] ?? '' ),
				'adSponsor'   => monetize_me_parse_csv_ids( $attributes['adSponsor'] ?? '' ),
				'limit'       => max( 1, absint( $attributes['limit'] ?? 1 ) ),
				'isWrapper'   => monetize_me_to_bool( $attributes['isWrapper'] ?? true ),
				'adAlignment' => sanitize_text_field( $attributes['adAlignment'] ?? 'center-align' ),
				'className'   => sanitize_text_field( $attributes['className'] ?? '' ),
			)
		);
	}
}
