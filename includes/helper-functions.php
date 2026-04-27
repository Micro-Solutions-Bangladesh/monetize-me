<?php
/**
 * Helper functions for Monetize Me.
 *
 * @package MonetizeMe
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'monetize_me_taxonomy_name_id_pairs' ) ) {
	/**
	 * Return taxonomy terms as label/value pairs.
	 *
	 * @param string $taxonomy             Taxonomy slug.
	 * @param bool   $include_empty_option Whether to include a default empty option.
	 * @return array<int, array<string, mixed>>
	 */
	function monetize_me_taxonomy_name_id_pairs( $taxonomy, $include_empty_option = true ) {
		$result = array();

		if ( $include_empty_option ) {
			$result[] = array(
				'label' => __( '-- Select --', 'monetize-me' ),
				'value' => 0,
			);
		}

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return $result;
		}

		foreach ( $terms as $term ) {
			$result[] = array(
				'label' => $term->name,
				'value' => (int) $term->term_id,
			);
		}

		return $result;
	}
}

if ( ! function_exists( 'monetize_me_ad_category_pairs' ) ) {
	/**
	 * Return Ad Category options.
	 *
	 * @param bool $include_empty_option Whether to include empty option.
	 * @return array<int, array<string, mixed>>
	 */
	function monetize_me_ad_category_pairs( $include_empty_option = true ) {
		return monetize_me_taxonomy_name_id_pairs( 'adcategory', $include_empty_option );
	}
}

if ( ! function_exists( 'monetize_me_ad_sponsor_pairs' ) ) {
	/**
	 * Return Ad Sponsor options.
	 *
	 * @param bool $include_empty_option Whether to include empty option.
	 * @return array<int, array<string, mixed>>
	 */
	function monetize_me_ad_sponsor_pairs( $include_empty_option = true ) {
		return monetize_me_taxonomy_name_id_pairs( 'adsponsor', $include_empty_option );
	}
}

if ( ! function_exists( 'monetize_me_parse_csv_ids' ) ) {
	/**
	 * Parse comma-separated IDs into an array of integers.
	 *
	 * @param mixed $value Raw value.
	 * @return array<int, int>
	 */
	function monetize_me_parse_csv_ids( $value ) {
		if ( is_array( $value ) ) {
			$ids = array_map( 'absint', $value );
			$ids = array_filter( $ids );

			return array_values( array_unique( $ids ) );
		}

		$parts = array_map( 'trim', explode( ',', (string) $value ) );
		$ids   = array_map( 'absint', $parts );
		$ids   = array_filter( $ids );

		return array_values( array_unique( $ids ) );
	}
}


if ( ! function_exists( 'monetize_me_parse_ad_category_selector' ) ) {
	/**
	 * Parse ad category selector.
	 *
	 * Supports either:
	 * - comma-separated category term IDs, or
	 * - a single category slug.
	 *
	 * @param mixed $value Raw category selector value.
	 * @return array<string, mixed>
	 */
	function monetize_me_parse_ad_category_selector( $value ) {
		if ( is_array( $value ) ) {
			if ( isset( $value['field'], $value['terms'] ) ) {
				$field = in_array( $value['field'], array( 'term_id', 'slug' ), true ) ? $value['field'] : 'term_id';
				$terms = 'slug' === $field
					? array_values( array_filter( array_map( 'sanitize_title', (array) $value['terms'] ) ) )
					: monetize_me_parse_csv_ids( $value['terms'] );

				return array(
					'field' => $field,
					'terms' => $terms,
				);
			}

			$ids = monetize_me_parse_csv_ids( $value );

			return array(
				'field' => 'term_id',
				'terms' => $ids,
			);
		}

		$value = trim( (string) $value );

		if ( '' === $value ) {
			return array(
				'field' => 'term_id',
				'terms' => array(),
			);
		}

		if ( false !== strpos( $value, ',' ) ) {
			return array(
				'field' => 'term_id',
				'terms' => monetize_me_parse_csv_ids( $value ),
			);
		}

		if ( ctype_digit( $value ) ) {
			return array(
				'field' => 'term_id',
				'terms' => monetize_me_parse_csv_ids( $value ),
			);
		}

		$slug = sanitize_title( $value );

		return array(
			'field' => 'slug',
			'terms' => '' !== $slug ? array( $slug ) : array(),
		);
	}
}

if ( ! function_exists( 'monetize_me_to_bool' ) ) {
	/**
	 * Convert mixed value to boolean.
	 *
	 * @param mixed $value Raw value.
	 * @return bool
	 */
	function monetize_me_to_bool( $value ) {
		if ( is_bool( $value ) ) {
			return $value;
		}

		return in_array( $value, array( 1, '1', true, 'true', 'yes', 'on' ), true );
	}
}

if ( ! function_exists( 'monetize_me_sanitize_classes' ) ) {
	/**
	 * Sanitize a list of CSS classes.
	 *
	 * @param string $classes Raw class string.
	 * @return string
	 */
	function monetize_me_sanitize_classes( $classes ) {
		$list = preg_split( '/\s+/', (string) $classes );
		$list = array_filter( array_map( 'sanitize_html_class', $list ) );

		return implode( ' ', array_unique( $list ) );
	}
}

if ( ! function_exists( 'monetize_me_get_alignment_class' ) ) {
	/**
	 * Normalize alignment class.
	 *
	 * @param string $value Raw alignment class.
	 * @return string
	 */
	function monetize_me_get_alignment_class( $value ) {
		$value = sanitize_text_field( (string) $value );

		if ( '' === $value ) {
			return 'center-align';
		}

		return $value;
	}
}


if ( ! function_exists( 'monetize_me_get_ad' ) ) {
	/**
	 * Get one published ad post by slug.
	 *
	 * @param string $slug Ad slug.
	 * @return \WP_Post|null
	 */
	function monetize_me_get_ad( $slug ) {
		if ( ! class_exists( '\Monetize_Me\Ad_Service' ) ) {
			return null;
		}

		return \Monetize_Me\Ad_Service::get_ad_by_slug( $slug );
	}
}

if ( ! function_exists( 'monetize_me_get_random_ads' ) ) {
	/**
	 * Get published ads using the unified ad service query rules.
	 *
	 * @param array $args Query arguments.
	 * @return array<int, \WP_Post>
	 */
	function monetize_me_get_random_ads( $args = array() ) {
		if ( ! class_exists( '\Monetize_Me\Ad_Service' ) ) {
			return array();
		}

		return \Monetize_Me\Ad_Service::get_ads( $args );
	}
}

if ( ! function_exists( 'monetize_me_render_ad' ) ) {
	/**
	 * Render ads using the unified ad service.
	 *
	 * @param array $args Render arguments.
	 * @return string
	 */
	function monetize_me_render_ad( $args = array() ) {
		if ( ! class_exists( '\Monetize_Me\Ad_Service' ) ) {
			return '';
		}

		return \Monetize_Me\Ad_Service::render( $args );
	}
}

if ( ! function_exists( 'mm_get_ad' ) ) {
	/**
	 * Short alias for monetize_me_get_ad().
	 *
	 * @param string $slug Ad slug.
	 * @return \WP_Post|null
	 */
	function mm_get_ad( $slug ) {
		return monetize_me_get_ad( $slug );
	}
}

if ( ! function_exists( 'mm_get_random_ad' ) ) {
	/**
	 * Short alias for returning matched ads.
	 *
	 * @param array $args Query arguments.
	 * @return array<int, \WP_Post>
	 */
	function mm_get_random_ad( $args = array() ) {
		return monetize_me_get_random_ads( $args );
	}
}

if ( ! function_exists( 'mm_render_ad' ) ) {
	/**
	 * Short alias for monetize_me_render_ad().
	 *
	 * @param array $args Render arguments.
	 * @return string
	 */
	function mm_render_ad( $args = array() ) {
		return monetize_me_render_ad( $args );
	}
}
