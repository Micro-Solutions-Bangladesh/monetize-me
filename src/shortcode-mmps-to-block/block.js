/**
 * BLOCK: shortcode-mmps-to-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

import { getAdAlignmentValueLabelPairs } from '../helper';

//  Import CSS.
import './editor.scss';
import './style.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { Fragment } = wp.element;

// const {
// 	InspectorControls,
// } = wp.blockEditor;

const {
	PanelBody, SelectControl, ServerSideRender, TextControl, ToggleControl,
} = wp.components;

const { InspectorControls } = wp.editor;

/**
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'monetize-me/shortcode-mmps-to-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Monetize Me' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Monetize Me' ),
		__( 'Adsense' ),
		__( 'msbd' ),
	],

	attributes: {
		adAlignment: {
			type: 'string',
			default: 'center-align',
		},
		adCategory: { // Required
			type: 'string',
			default: '0',
		},
		adSponsor: {
			type: 'string',
			default: '0',
		},
		postSlug: {
			type: 'string',
			default: '',
		},
		limit: { // limit
			type: 'string',
			default: '1',
		},
		isWrapper: { // wrapper:
			type: 'string',
			default: 'true',
		},
	},

	/**
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: ( props ) => {
		const { setAttributes, attributes } = props;
		const { adAlignment, adCategory, adSponsor, limit, postSlug, isWrapper } = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody
						title={ __( 'Ad Settings' ) }
						initialOpen={ true }
					>
						<SelectControl
							label={ __( 'Ad Alignment' ) }
							value={ adAlignment }
							options={ getAdAlignmentValueLabelPairs() }
							onChange={ adAlign => setAttributes( { adAlignment: adAlign } ) }
						/>

						<SelectControl
							label={ __( 'Ad Category **' ) }
							value={ adCategory }
							options={ mmpConfigs.adCategoryValueLabelPairs }
							onChange={ adCat => setAttributes( { adCategory: adCat } ) }
						/>

						<SelectControl
							label={ __( 'Ad Sponsor' ) }
							value={ adSponsor }
							options={ mmpConfigs.adSponsorValueLabelPairs }
							onChange={ adSpon => setAttributes( { adSponsor: adSpon } ) }
						/>

						<TextControl
							label="Ad Slug"
							value={ postSlug }
							onChange={ ( pSlug ) => setAttributes( { postSlug: pSlug } ) }
						/>

						<TextControl
							label="Ad Limit **"
							value={ limit }
							onChange={ ( limitNo ) => setAttributes( { limit: limitNo } ) }
						/>

						<ToggleControl
							label="Fixed Background"
							help={ ( isWrapper === 'true' ) ? 'Use wrapper for Ad.' : 'No wrapper for Ad.' }
							checked={ ( isWrapper === 'true' ) }
							onChange={ ( wrapper ) => setAttributes( { isWrapper: ( ( wrapper ) ? 'true' : 'false' ) } ) }
						/>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="monetize-me/shortcode-mmps-to-block"
					attributes={ attributes }
				/>
			</Fragment>
		);
	},

	/**
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: () => {
		return null;
	},
} );
