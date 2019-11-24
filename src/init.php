<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package monetize-me
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function monetize_me_render_serverside_handler($atts) {
    return "<p>adCategory:  == sponsorType:  == postSlug: </p>";
}


/**
 * Enqueue Gutenberg block assets for frontend.
 *
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function monetize_me_frontent_assets() { // phpcs:ignore
	// Register block styles for frontend.
	wp_register_style(
		'monetize-me-block-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array( 'wp-editor' ),
		null
	);

    wp_enqueue_style( 'monetize-me-block-css' );
}
// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'monetize_me_frontent_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function monetize_me_editor_assets() { // phpcs:ignore
	// Register block editor styles for backend.
	wp_register_style(
		'monetize-me-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		null
    );
    
    wp_enqueue_style( 'monetize-me-block-editor-css' );

    // Register block editor script for backend.
	wp_register_script(
		'monetize-me-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ),
		null,
		true
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `mmpConfigs` object.
	wp_localize_script(
		'monetize-me-block-js',
		'mmpConfigs',
		[
            'siteTitle' => get_bloginfo("name"),
            'siteTagline' => get_bloginfo("description"),
            'siteUrl' => esc_url( get_site_url() ),
            'adCategoryValueLabelPairs' => get_ad_category_value_label_pairs(),
			// 'pluginDirPath' => plugin_dir_path( __DIR__ ),
			// 'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
		]
    );
    
    wp_enqueue_script('monetize-me-block-js');
}
// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'monetize_me_editor_assets' );

/**
 * 
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function monetize_me_register_block_type() { // phpcs:ignore
    register_block_type(
        'monetize-me/shortcode-mmps-to-block', array(
            'render_callback' => 'monetize_me_render_serberside_handler',
            'attributes' => array(
                'adCategory' => array(
                    'default' => 23,
                    'type' => 'integer',
                ),
                'sponsorType' => array(
                    'default' => 5,
                    'type' => 'integer',
                ),
                'postSlug' => array(
                    'default' => 'post-slug',
                    'type' => 'string',
                ),
            ),
        )
    );
}

// Hook: Block assets.
add_action( 'init', 'monetize_me_register_block_type' );
