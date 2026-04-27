<?php
/**
 * Widget form template.
 *
 * Available variables:
 * - $instance
 * - $categories
 *
 * @package MonetizeMe
 */

defined( 'ABSPATH' ) || exit;
?>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php esc_html_e( 'Title:', 'monetize-me' ); ?>
	</label>
	<input
		class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
		type="text"
		value="<?php echo esc_attr( $instance['title'] ); ?>"
	/>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'adCategory' ) ); ?>">
		<?php esc_html_e( 'Ad Category:', 'monetize-me' ); ?>
	</label>
	<select
		class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'adCategory' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'adCategory' ) ); ?>"
	>
		<?php foreach ( $categories as $item ) : ?>
			<option value="<?php echo esc_attr( $item['value'] ); ?>" <?php selected( (string) $instance['adCategory'], (string) $item['value'] ); ?>>
				<?php echo esc_html( $item['label'] ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'adLimit' ) ); ?>">
		<?php esc_html_e( 'Number of ads:', 'monetize-me' ); ?>
	</label>
	<input
		class="small-text"
		id="<?php echo esc_attr( $this->get_field_id( 'adLimit' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'adLimit' ) ); ?>"
		type="number"
		min="1"
		value="<?php echo esc_attr( $instance['adLimit'] ); ?>"
	/>
</p>

<p><strong><?php esc_html_e( 'Or display one specific ad by slug:', 'monetize-me' ); ?></strong></p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'postSlug' ) ); ?>">
		<?php esc_html_e( 'Ad Slug:', 'monetize-me' ); ?>
	</label>
	<input
		class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'postSlug' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'postSlug' ) ); ?>"
		type="text"
		value="<?php echo esc_attr( $instance['postSlug'] ); ?>"
	/>
</p>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'adAlignment' ) ); ?>">
		<?php esc_html_e( 'Alignment class:', 'monetize-me' ); ?>
	</label>
	<input
		class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'adAlignment' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'adAlignment' ) ); ?>"
		type="text"
		value="<?php echo esc_attr( $instance['adAlignment'] ); ?>"
	/>
</p>

<p>
	<input
		type="checkbox"
		id="<?php echo esc_attr( $this->get_field_id( 'isWrapper' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'isWrapper' ) ); ?>"
		value="1"
		<?php checked( ! empty( $instance['isWrapper'] ) ); ?>
	/>
	<label for="<?php echo esc_attr( $this->get_field_id( 'isWrapper' ) ); ?>">
		<?php esc_html_e( 'Wrap each ad in .ad-wrapper', 'monetize-me' ); ?>
	</label>
</p>
