<?php
/**
 * Central ad query and render service.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Ad_Service {

	/**
	 * Cache group.
	 *
	 * @var string
	 */
	const CACHE_GROUP = 'monetize_me';

	/**
	 * Cache salt option name.
	 *
	 * @var string
	 */
	const CACHE_SALT_OPTION = 'monetize_me_cache_salt';

	/**
	 * Normalize render/query arguments.
	 *
	 * @param array $args Raw arguments.
	 * @return array
	 */
	public static function normalize_args( $args ) {
		$args = wp_parse_args(
			(array) $args,
			array(
				'postSlug'    => '',
				'adCategory'  => array( 'field' => 'term_id', 'terms' => array() ),
				'adSponsor'   => array(),
				'limit'       => 1,
				'isWrapper'   => true,
				'adAlignment' => 'center-align',
				'className'   => '',
			)
		);

		$args['postSlug']    = sanitize_title( $args['postSlug'] );
		$args['adCategory']  = monetize_me_parse_ad_category_selector( $args['adCategory'] );
		$args['adSponsor']   = monetize_me_parse_csv_ids( $args['adSponsor'] );
		$args['limit']       = max( 1, absint( $args['limit'] ) );
		$args['isWrapper']   = monetize_me_to_bool( $args['isWrapper'] );
		$args['adAlignment'] = monetize_me_get_alignment_class( $args['adAlignment'] );
		$args['className']   = monetize_me_sanitize_classes( $args['className'] );

		/**
		 * Filter normalized ad service args.
		 *
		 * @param array $args Normalized args.
		 */
		return apply_filters( 'monetize_me/service/normalized_args', $args );
	}

	/**
	 * Get one ad post by slug.
	 *
	 * @param string $slug Ad post slug.
	 * @return \WP_Post|null
	 */
	public static function get_ad_by_slug( $slug ) {
		$posts = self::get_ads(
			array(
				'postSlug' => $slug,
				'limit'    => 1,
			)
		);

		return ! empty( $posts ) ? $posts[0] : null;
	}

	/**
	 * Get ads matching service arguments.
	 *
	 * @param array $args Service args.
	 * @return array<int, \WP_Post>
	 */
	public static function get_ads( $args = array() ) {
		$args      = self::normalize_args( $args );
		$cache_key = self::get_cache_key( 'ads', $args );
		$cached    = wp_cache_get( $cache_key, self::CACHE_GROUP );

		if ( false !== $cached && is_array( $cached ) ) {
			return self::hydrate_posts_from_ids( $cached );
		}

		$transient_key = self::get_transient_key( $cache_key );
		$cached        = get_transient( $transient_key );

		if ( is_array( $cached ) ) {
			wp_cache_set( $cache_key, $cached, self::CACHE_GROUP, 300 );
			return self::hydrate_posts_from_ids( $cached );
		}

		$query = new \WP_Query( self::build_query_args( $args ) );
		$ids   = array_map( 'intval', (array) $query->posts );

		wp_cache_set( $cache_key, $ids, self::CACHE_GROUP, 300 );
		set_transient( $transient_key, $ids, 5 * MINUTE_IN_SECONDS );

		return self::hydrate_posts_from_ids( $ids );
	}

	/**
	 * Render ads using unified service logic.
	 *
	 * @param array $args Service args.
	 * @return string
	 */
	public static function render( $args = array() ) {
		$args   = self::normalize_args( $args );
		$posts  = self::get_ads( $args );
		$output = array();

		foreach ( $posts as $post ) {
			$content = apply_filters( 'the_content', $post->post_content );

			if ( $args['isWrapper'] ) {
				$content = '<div class="ad-wrapper">' . $content . '</div>';
			}

			/**
			 * Filter a single rendered ad markup.
			 *
			 * @param string  $content Ad markup.
			 * @param \WP_Post $post   Ad post object.
			 * @param array   $args    Normalized render args.
			 */
			$output[] = apply_filters( 'monetize_me/service/rendered_ad', $content, $post, $args );
		}

		$classes = trim(
			implode(
				' ',
				array_filter(
					array(
						'monetize-me',
						$args['adAlignment'],
						$args['className'],
					)
				)
			)
		);

		if ( empty( $output ) ) {
			$html = '<div class="' . esc_attr( $classes ) . '">' . esc_html__( 'No ad found.', 'monetize-me' ) . '</div>';
		} else {
			$html = '<div class="' . esc_attr( $classes ) . '">' . implode( '', $output ) . '</div>';
		}

		do_action( 'monetize_me/service/rendered', $args, $posts, $html );

		/**
		 * Filter full rendered output.
		 *
		 * @param string $html  Final HTML.
		 * @param array  $args  Normalized render args.
		 * @param array  $posts Matched ad posts.
		 */
		return apply_filters( 'monetize_me/service/output', $html, $args, $posts );
	}

	/**
	 * Purge service caches by rotating the cache salt.
	 *
	 * @return void
	 */
	public static function purge_all_caches() {
		update_option( self::CACHE_SALT_OPTION, (string) microtime( true ), false );
	}

	/**
	 * Build WP_Query arguments.
	 *
	 * @param array $args Normalized args.
	 * @return array
	 */
	protected static function build_query_args( $args ) {
		$query_args = array(
			'post_type'              => Post_Type_Ad::POST_TYPE,
			'post_status'            => 'publish',
			'posts_per_page'         => $args['limit'],
			'orderby'                => 'rand',
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'cache_results'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => true,
			'fields'                 => 'ids',
		);

		if ( ! empty( $args['postSlug'] ) ) {
			$query_args['name']    = $args['postSlug'];
			$query_args['orderby'] = 'date';
			return $query_args;
		}

		$tax_query = array();

		if ( ! empty( $args['adCategory']['terms'] ) ) {
			$tax_query[] = array(
				'taxonomy' => Taxonomy_Ad_Category::TAXONOMY,
				'field'    => in_array( $args['adCategory']['field'], array( 'term_id', 'slug' ), true ) ? $args['adCategory']['field'] : 'term_id',
				'terms'    => $args['adCategory']['terms'],
			);
		}

		if ( ! empty( $args['adSponsor'] ) ) {
			$tax_query[] = array(
				'taxonomy' => Taxonomy_Ad_Sponsor::TAXONOMY,
				'field'    => 'term_id',
				'terms'    => $args['adSponsor'],
			);
		}

		if ( ! empty( $tax_query ) ) {
			if ( count( $tax_query ) > 1 ) {
				$tax_query['relation'] = 'AND';
			}

			$query_args['tax_query'] = $tax_query;
		}

		/**
		 * Filter internal WP_Query arguments.
		 *
		 * @param array $query_args Built WP_Query arguments.
		 * @param array $args       Normalized service args.
		 */
		return apply_filters( 'monetize_me/service/query_args', $query_args, $args );
	}

	/**
	 * Hydrate posts from a list of IDs while preserving order.
	 *
	 * @param array<int, int> $ids Post IDs.
	 * @return array<int, \WP_Post>
	 */
	protected static function hydrate_posts_from_ids( $ids ) {
		$posts = array();

		foreach ( (array) $ids as $post_id ) {
			$post = get_post( (int) $post_id );

			if ( $post instanceof \WP_Post && Post_Type_Ad::POST_TYPE === $post->post_type && 'publish' === $post->post_status ) {
				$posts[] = $post;
			}
		}

		return $posts;
	}

	/**
	 * Build a stable cache key.
	 *
	 * @param string $prefix Key prefix.
	 * @param array  $args   Normalized args.
	 * @return string
	 */
	protected static function get_cache_key( $prefix, $args ) {
		$salt = (string) get_option( self::CACHE_SALT_OPTION, '1' );
		return $prefix . ':' . md5( wp_json_encode( array( 'salt' => $salt, 'args' => $args ) ) );
	}

	/**
	 * Build transient key.
	 *
	 * @param string $cache_key Object cache key.
	 * @return string
	 */
	protected static function get_transient_key( $cache_key ) {
		return 'mm_' . md5( $cache_key );
	}
}
