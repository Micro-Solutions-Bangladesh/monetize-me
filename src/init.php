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

/**
 * 
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
 * 
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
            'adCategoryValueLabelPairs' => monetize_me_ad_category_pairs(),
            'adSponsorValueLabelPairs' => monetize_me_ad_sponsor_pairs(),
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
            'render_callback' => 'monetize_me_gutenberg_serverside_handler',
            'attributes' => array(
                'className' => array(
                    'default' => '',
                    'type' => 'string',
                ),
                'adAlignment' => array(
                    'default' => 'center-align',
                    'type' => 'string',
                ),
                'adCategory' => array(
                    'default' => '0',
                    'type' => 'string',
                ),
                'adSponsor' => array(
                    'default' => '0',
                    'type' => 'string',
                ),
                'postSlug' => array(
                    'default' => '',
                    'type' => 'string',
                ),
                'limit' => array(
                    'default' => '1',
                    'type' => 'string',
                ),
                'isWrapper' => array(
                    'default' => 'true',
                    'type' => 'string',
                ),
            ),
        )
    );
}

// Hook: Block assets.
add_action( 'init', 'monetize_me_register_block_type' );
