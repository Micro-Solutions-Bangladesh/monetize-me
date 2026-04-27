<?php
/**
 * Shortcode handler.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Shortcode {

	/**
	 * Register shortcode.
	 *
	 * @return void
	 */
	public static function register() {
		add_shortcode( 'mmps', array( __CLASS__, 'render_shortcode' ) );
	}

	/**
	 * Render shortcode.
	 *
	 * Supported:
	 * [mmps id="homepage-ad"]
	 * [mmps postSlug="homepage-ad"]
	 * [mmps adcategory="12"]
	 * [mmps adCategory="homepage-top"]
	 * [mmps adsponsor="3" limit="2"]
	 *
	 * Backward-compatible aliases are normalized to canonical camelCase keys.
	 * Canonical keys take priority when both canonical and alias values exist.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'id'          => '',
				'postSlug'    => '',
				'adCategory'  => '',
				'adSponsor'   => '',
				'limit'       => 1,
				'wrapper'     => 1,
				'isWrapper'   => '',
				'adAlignment' => '',
				'className'   => '',
			),
			self::normalize_shortcode_atts( (array) $atts ),
			'mmps'
		);

		$post_slug = ! empty( $atts['id'] ) ? $atts['id'] : $atts['postSlug'];

		$is_wrapper = '' !== $atts['isWrapper']
			? monetize_me_to_bool( $atts['isWrapper'] )
			: monetize_me_to_bool( $atts['wrapper'] );

		return Renderer::render(
			array(
				'postSlug'    => sanitize_title( $post_slug ),
				'adCategory'  => monetize_me_parse_ad_category_selector( $atts['adCategory'] ),
				'adSponsor'   => monetize_me_parse_csv_ids( $atts['adSponsor'] ),
				'limit'       => max( 1, absint( $atts['limit'] ) ),
				'isWrapper'   => $is_wrapper,
				'adAlignment' => sanitize_text_field( $atts['adAlignment'] ),
				'className'   => sanitize_text_field( $atts['className'] ),
			)
		);
	}

	/**
	 * Normalize shortcode aliases to canonical attribute keys.
	 *
	 * WordPress lowercases shortcode attribute names in many contexts, while
	 * block/widget/service code uses camelCase. This method keeps old shortcode
	 * aliases working without carrying duplicate keys through render logic.
	 *
	 * @param array $atts Raw shortcode attributes.
	 * @return array
	 */
	private static function normalize_shortcode_atts( array $atts ) {
		$aliases = array(
			'postslug'    => 'postSlug',
			'adcategory'  => 'adCategory',
			'adsponsor'   => 'adSponsor',
			'iswrapper'   => 'isWrapper',
			'adalignment' => 'adAlignment',
			'classname'   => 'className',
			'class'       => 'adAlignment',
		);

		foreach ( $aliases as $alias => $canonical ) {
			if ( ! array_key_exists( $alias, $atts ) || '' === $atts[ $alias ] ) {
				continue;
			}

			if ( ! array_key_exists( $canonical, $atts ) || '' === $atts[ $canonical ] ) {
				$atts[ $canonical ] = $atts[ $alias ];
			}

			unset( $atts[ $alias ] );
		}

		return $atts;
	}
}
