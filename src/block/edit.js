import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	ToggleControl,
	RangeControl,
	Notice,
} from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { postSlug, adCategory, adSponsor, limit, isWrapper, adAlignment, className } = attributes;

	const blockProps = useBlockProps( {
		className: 'monetize-me-block-editor-preview',
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Advertisement Settings', 'monetize-me' ) } initialOpen={ true }>
					<TextControl
						label={ __( 'Ad Slug', 'monetize-me' ) }
						help={ __( 'Display one specific ad by its post slug.', 'monetize-me' ) }
						value={ postSlug }
						onChange={ ( value ) => setAttributes( { postSlug: value } ) }
					/>

					<TextControl
						label={ __( 'Ad Category IDs', 'monetize-me' ) }
						help={ __( 'Comma-separated term IDs. Used when Ad Slug is empty.', 'monetize-me' ) }
						value={ adCategory }
						onChange={ ( value ) => setAttributes( { adCategory: value } ) }
					/>

					<TextControl
						label={ __( 'Ad Sponsor IDs', 'monetize-me' ) }
						help={ __( 'Optional comma-separated sponsor term IDs.', 'monetize-me' ) }
						value={ adSponsor }
						onChange={ ( value ) => setAttributes( { adSponsor: value } ) }
					/>

					<RangeControl
						label={ __( 'Number of Ads', 'monetize-me' ) }
						value={ limit }
						onChange={ ( value ) => setAttributes( { limit: value } ) }
						min={ 1 }
						max={ 10 }
					/>

					<ToggleControl
						label={ __( 'Wrap each ad in .ad-wrapper', 'monetize-me' ) }
						checked={ isWrapper }
						onChange={ ( value ) => setAttributes( { isWrapper: value } ) }
					/>

					<TextControl
						label={ __( 'Alignment Class', 'monetize-me' ) }
						help={ __( 'Example: center-align, left-align, right-align', 'monetize-me' ) }
						value={ adAlignment }
						onChange={ ( value ) => setAttributes( { adAlignment: value } ) }
					/>

					<TextControl
						label={ __( 'Extra CSS Class', 'monetize-me' ) }
						value={ className }
						onChange={ ( value ) => setAttributes( { className: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<strong>{ __( 'Monetize Me: Advertisement', 'monetize-me' ) }</strong>

				{ postSlug ? (
					<p>
						{ __( 'Displaying ad by slug:', 'monetize-me' ) } <code>{ postSlug }</code>
					</p>
				) : (
					<p>{ __( 'Displaying ads by filters.', 'monetize-me' ) }</p>
				) }

				<ul>
					<li>
						<strong>{ __( 'Category IDs:', 'monetize-me' ) }</strong>{ ' ' }
						{ adCategory || __( 'None', 'monetize-me' ) }
					</li>
					<li>
						<strong>{ __( 'Sponsor IDs:', 'monetize-me' ) }</strong>{ ' ' }
						{ adSponsor || __( 'None', 'monetize-me' ) }
					</li>
					<li>
						<strong>{ __( 'Limit:', 'monetize-me' ) }</strong> { limit }
					</li>
					<li>
						<strong>{ __( 'Wrapper:', 'monetize-me' ) }</strong>{ ' ' }
						{ isWrapper ? __( 'Enabled', 'monetize-me' ) : __( 'Disabled', 'monetize-me' ) }
					</li>
					<li>
						<strong>{ __( 'Alignment Class:', 'monetize-me' ) }</strong>{ ' ' }
						{ adAlignment || __( 'None', 'monetize-me' ) }
					</li>
					<li>
						<strong>{ __( 'Extra Class:', 'monetize-me' ) }</strong>{ ' ' }
						{ className || __( 'None', 'monetize-me' ) }
					</li>
				</ul>

				<Notice status="info" isDismissible={ false }>
					{ __(
						'This is an editor preview panel. Frontend output is rendered on the server.',
						'monetize-me'
					) }
				</Notice>
			</div>
		</>
	);
}
