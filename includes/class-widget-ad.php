<?php
/**
 * Classic widget for displaying ads.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

class Widget_Ad extends \WP_Widget {

	/**
	 * Register widget.
	 *
	 * @return void
	 */
	public static function register() {
		add_action(
			'widgets_init',
			function() {
				register_widget( __CLASS__ );
			}
		);
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'monetize_me_widget_ad',
			__( 'Show Advertisement', 'monetize-me' ),
			array(
				'description' => __( 'Display ads by slug or category.', 'monetize-me' ),
			)
		);
	}

	/**
	 * Frontend output.
	 *
	 * @param array $args     Widget args.
	 * @param array $instance Widget values.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$title       = isset( $instance['title'] ) ? $instance['title'] : '';
		$post_slug   = isset( $instance['postSlug'] ) ? $instance['postSlug'] : '';
		$ad_category = isset( $instance['adCategory'] ) ? sanitize_text_field( $instance['adCategory'] ) : '';
		$ad_limit    = isset( $instance['adLimit'] ) ? max( 1, absint( $instance['adLimit'] ) ) : 1;
		$is_wrapper  = ! empty( $instance['isWrapper'] );
		$alignment   = isset( $instance['adAlignment'] ) ? $instance['adAlignment'] : 'center-align';

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( '' !== $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo Renderer::render( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				'postSlug'    => sanitize_title( $post_slug ),
				'adCategory'  => monetize_me_parse_ad_category_selector( $ad_category ),
				'adSponsor'   => array(),
				'limit'       => $ad_limit,
				'isWrapper'   => $is_wrapper,
				'adAlignment' => sanitize_text_field( $alignment ),
				'className'   => '',
			)
		);

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Save widget settings.
	 *
	 * @param array $new_instance New values.
	 * @param array $old_instance Old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title'       => sanitize_text_field( $new_instance['title'] ?? '' ),
			'postSlug'    => sanitize_title( $new_instance['postSlug'] ?? '' ),
			'adCategory'  => sanitize_text_field( $new_instance['adCategory'] ?? '' ),
			'adLimit'     => max( 1, absint( $new_instance['adLimit'] ?? 1 ) ),
			'isWrapper'   => ! empty( $new_instance['isWrapper'] ) ? 1 : 0,
			'adAlignment' => sanitize_text_field( $new_instance['adAlignment'] ?? 'center-align' ),
		);
	}

	/**
	 * Admin form.
	 *
	 * @param array $instance Widget values.
	 * @return void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'       => '',
			'postSlug'    => '',
			'adCategory'  => '',
			'adLimit'     => 1,
			'isWrapper'   => 1,
			'adAlignment' => 'center-align',
		);

		$instance   = wp_parse_args( (array) $instance, $defaults );
		$categories = monetize_me_ad_category_pairs();

		include MONETIZE_ME_PATH . 'views/widget-form.php';
	}
}
