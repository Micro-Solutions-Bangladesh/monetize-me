<?php
/**
 * Network admin tools for multisite installs.
 *
 * @package MonetizeMe
 */

namespace Monetize_Me;

defined( 'ABSPATH' ) || exit;

/**
 * Adds network-level tools for Monetize Me.
 */
class Network_Admin {

	/**
	 * Network admin page slug.
	 */
	const PAGE_SLUG = 'monetize-me-network';

	/**
	 * Action nonce name.
	 */
	const NONCE_ACTION = 'monetize_me_copy_taxonomy_terms';

	/**
	 * Action nonce field.
	 */
	const NONCE_FIELD = 'monetize_me_copy_terms_nonce';

	/**
	 * Register network admin hooks.
	 *
	 * @return void
	 */
	public static function register() {
		if ( ! is_multisite() ) {
			return;
		}

		add_action( 'network_admin_menu', array( __CLASS__, 'add_network_menu_page' ) );
		add_action( 'network_admin_edit_monetize_me_copy_terms', array( __CLASS__, 'handle_copy_terms' ) );
	}

	/**
	 * Add the Network Admin settings page.
	 *
	 * @return void
	 */
	public static function add_network_menu_page() {
		add_submenu_page(
			'settings.php',
			esc_html__( 'Monetize Me', 'monetize-me' ),
			esc_html__( 'Monetize Me', 'monetize-me' ),
			'manage_network_options',
			self::PAGE_SLUG,
			array( __CLASS__, 'render_network_page' )
		);
	}

	/**
	 * Render the Network Admin settings page.
	 *
	 * @return void
	 */
	public static function render_network_page() {
		if ( ! current_user_can( 'manage_network_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to access this page.', 'monetize-me' ) );
		}

		$sites      = get_sites(
			array(
				'number'   => 0,
				'archived' => 0,
				'deleted'  => 0,
				'spam'     => 0,
			)
		);
		$source_id  = get_main_site_id();
		$notice_key = isset( $_GET['monetize_me_notice'] ) ? sanitize_key( wp_unslash( $_GET['monetize_me_notice'] ) ) : '';
		$message    = isset( $_GET['message'] ) ? sanitize_text_field( wp_unslash( $_GET['message'] ) ) : '';
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Monetize Me Network Settings', 'monetize-me' ); ?></h1>

			<?php if ( 'copied' === $notice_key ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo esc_html( $message ? $message : __( 'Taxonomy terms copied successfully.', 'monetize-me' ) ); ?></p>
				</div>
			<?php elseif ( 'error' === $notice_key ) : ?>
				<div class="notice notice-error is-dismissible">
					<p><?php echo esc_html( $message ? $message : __( 'Unable to copy taxonomy terms.', 'monetize-me' ) ); ?></p>
				</div>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( network_admin_url( 'edit.php?action=monetize_me_copy_terms' ) ); ?>">
				<?php wp_nonce_field( self::NONCE_ACTION, self::NONCE_FIELD ); ?>

				<h2><?php esc_html_e( 'Copy Ad Taxonomy Terms', 'monetize-me' ); ?></h2>
				<p><?php esc_html_e( 'Copy all Ad Sponsors and Ad Categories from one site to a selected subsite. Existing destination terms with the same slug are skipped.', 'monetize-me' ); ?></p>

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row">
								<label for="monetize-me-source-site"><?php esc_html_e( 'Source site', 'monetize-me' ); ?></label>
							</th>
							<td>
								<select id="monetize-me-source-site" name="source_blog_id" required>
									<?php foreach ( $sites as $site ) : ?>
										<option value="<?php echo esc_attr( (string) $site->blog_id ); ?>" <?php selected( (int) $site->blog_id, (int) $source_id ); ?>>
											<?php echo esc_html( self::get_site_option_label( $site ) ); ?>
										</option>
									<?php endforeach; ?>
								</select>
								<p class="description"><?php esc_html_e( 'The main site is selected by default.', 'monetize-me' ); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="monetize-me-destination-site"><?php esc_html_e( 'Destination subsite', 'monetize-me' ); ?></label>
							</th>
							<td>
								<select id="monetize-me-destination-site" name="destination_blog_id" required>
									<option value=""><?php esc_html_e( 'Select a subsite', 'monetize-me' ); ?></option>
									<?php foreach ( $sites as $site ) : ?>
										<option value="<?php echo esc_attr( (string) $site->blog_id ); ?>">
											<?php echo esc_html( self::get_site_option_label( $site ) ); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<?php submit_button( __( 'Copy Terms to Selected Subsite', 'monetize-me' ) ); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Handle taxonomy term copy request from Network Admin.
	 *
	 * @return void
	 */
	public static function handle_copy_terms() {
		if ( ! current_user_can( 'manage_network_options' ) ) {
			wp_die( esc_html__( 'Sorry, you are not allowed to perform this action.', 'monetize-me' ) );
		}

		check_admin_referer( self::NONCE_ACTION, self::NONCE_FIELD );

		$source_blog_id      = isset( $_POST['source_blog_id'] ) ? absint( $_POST['source_blog_id'] ) : 0;
		$destination_blog_id = isset( $_POST['destination_blog_id'] ) ? absint( $_POST['destination_blog_id'] ) : 0;

		if ( ! $source_blog_id || ! $destination_blog_id ) {
			self::redirect_with_notice( 'error', __( 'Please select both source and destination sites.', 'monetize-me' ) );
		}

		if ( $source_blog_id === $destination_blog_id ) {
			self::redirect_with_notice( 'error', __( 'Source and destination sites must be different.', 'monetize-me' ) );
		}

		if ( ! get_site( $source_blog_id ) || ! get_site( $destination_blog_id ) ) {
			self::redirect_with_notice( 'error', __( 'Selected site was not found.', 'monetize-me' ) );
		}

		$taxonomies = array(
			Taxonomy_Ad_Sponsor::TAXONOMY,
			Taxonomy_Ad_Category::TAXONOMY,
		);

		$summary = array(
			'copied'  => 0,
			'skipped' => 0,
			'failed'  => 0,
		);

		foreach ( $taxonomies as $taxonomy ) {
			$result             = self::copy_taxonomy_terms( $taxonomy, $source_blog_id, $destination_blog_id );
			$summary['copied']  += $result['copied'];
			$summary['skipped'] += $result['skipped'];
			$summary['failed']  += $result['failed'];
		}

		$message = sprintf(
			/* translators: 1: copied count, 2: skipped count, 3: failed count. */
			__( 'Copy complete. Copied: %1$d. Skipped existing slugs: %2$d. Failed: %3$d.', 'monetize-me' ),
			$summary['copied'],
			$summary['skipped'],
			$summary['failed']
		);

		self::redirect_with_notice( 'copied', $message );
	}

	/**
	 * Copy all terms from one blog taxonomy to another blog taxonomy.
	 *
	 * @param string $taxonomy            Taxonomy slug.
	 * @param int    $source_blog_id      Source blog ID.
	 * @param int    $destination_blog_id Destination blog ID.
	 * @return array{copied:int,skipped:int,failed:int}
	 */
	private static function copy_taxonomy_terms( $taxonomy, $source_blog_id, $destination_blog_id ) {
		$result = array(
			'copied'  => 0,
			'skipped' => 0,
			'failed'  => 0,
		);

		switch_to_blog( $source_blog_id );
		self::ensure_taxonomies_registered();

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);
		restore_current_blog();

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return $result;
		}

		foreach ( $terms as $term ) {
			switch_to_blog( $destination_blog_id );
			self::ensure_taxonomies_registered();

			$existing_term = get_term_by( 'slug', $term->slug, $taxonomy );

			if ( $existing_term ) {
				$result['skipped']++;
				restore_current_blog();
				continue;
			}

			$inserted = wp_insert_term(
				$term->name,
				$taxonomy,
				array(
					'slug'        => $term->slug,
					'description' => $term->description,
				)
			);

			if ( is_wp_error( $inserted ) ) {
				$result['failed']++;
			} else {
				$result['copied']++;
			}

			restore_current_blog();
		}

		return $result;
	}

	/**
	 * Ensure plugin taxonomies exist after switch_to_blog().
	 *
	 * @return void
	 */
	private static function ensure_taxonomies_registered() {
		if ( ! taxonomy_exists( Taxonomy_Ad_Category::TAXONOMY ) ) {
			Taxonomy_Ad_Category::register();
		}

		if ( ! taxonomy_exists( Taxonomy_Ad_Sponsor::TAXONOMY ) ) {
			Taxonomy_Ad_Sponsor::register();
		}
	}

	/**
	 * Build a readable site option label.
	 *
	 * @param \WP_Site $site Site object.
	 * @return string
	 */
	private static function get_site_option_label( $site ) {
		$details = get_blog_details( $site->blog_id );
		$name    = $details && ! empty( $details->blogname ) ? $details->blogname : sprintf( __( 'Site #%d', 'monetize-me' ), $site->blog_id );
		$url     = $details && ! empty( $details->siteurl ) ? $details->siteurl : get_site_url( $site->blog_id );

		return sprintf( '%1$s — %2$s', $name, $url );
	}

	/**
	 * Redirect back to the settings page with an admin notice.
	 *
	 * @param string $notice  Notice key.
	 * @param string $message Notice message.
	 * @return void
	 */
	private static function redirect_with_notice( $notice, $message ) {
		wp_safe_redirect(
			add_query_arg(
				array(
					'page'               => self::PAGE_SLUG,
					'monetize_me_notice' => sanitize_key( $notice ),
					'message'            => $message,
				),
				network_admin_url( 'settings.php' )
			)
		);
		exit;
	}
}
