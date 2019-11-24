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
const { Fragment, createElement } = wp.element;

const {
	InspectorControls,
} = wp.blockEditor;

const {
	PanelBody, SelectControl, ServerSideRender,
} = wp.components;

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
			type: 'integer',
			default: 0,
		},
		// adWidth: { // width: depricated in favor of ad_category
		// 	type: 'string',
		// 	default: '',
		// },
		// adHeight: { // height: depricated in favor of ad_category
		// 	type: 'string',
		// 	default: '',
		// },
		// adType: { // type: default is mix in shortcode
		// 	type: 'string',
		// 	default: '',
		// },
		sponsorType: { // stype:
			type: 'string',
			default: 'adsense',
		},
		// postSlug: {
		// 	type: 'string',
		// },
		// limit: { // limit
		// 	type: 'string',
		// 	default: 1,
		// },
		// wrapper: { // wrapper:
		// 	type: 'string',
		// 	default: '1',
		// },
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
		const { className, setAttributes, attributes } = props;
		const { adAlignment, adCategory } = attributes;

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
					</PanelBody>
					<PanelBody title={ __( 'Ad Category' ) } initialOpen={ false }>
						<SelectControl
							label={ __( 'Ad Category' ) }
							value={ adCategory }
							options={ mmpConfigs.adCategoryValueLabelPairs }
							onChange={ adCat => setAttributes( { adCategory: adCat } ) }
						/>
					</PanelBody>
				</InspectorControls>

				<div className={ className }>
					<ServerSideRender
						block="monetize-me/shortcode-mmps-to-block"
						attributes={ attributes }
					/>
				</div>
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
	save: ( props ) => {
		return (
			<div className={ props.className }>
				<p>— Hello from the frontend.</p>
				<p>
					Monetize Me: <code>monetize-me</code> is a new Gutenberg block.
				</p>
				<p>
					It was created via{ ' ' }
					<code>
						<a href="https://github.com/ahmadawais/create-guten-block">
                            Monetize-Me
						</a>
					</code>.
				</p>
			</div>
		);
	},
} );
