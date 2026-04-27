(function (blocks, blockEditor, components, element, i18n) {
	var registerBlockType = blocks.registerBlockType;
	var InspectorControls = blockEditor.InspectorControls;
	var useBlockProps = blockEditor.useBlockProps;
	var PanelBody = components.PanelBody;
	var TextControl = components.TextControl;
	var ToggleControl = components.ToggleControl;
	var RangeControl = components.RangeControl;
	var Notice = components.Notice;
	var Fragment = element.Fragment;
	var createElement = element.createElement;
	var __ = i18n.__;

	registerBlockType('monetize-me/ad', {
		apiVersion: 3,
		title: __('Advertisement', 'monetize-me'),
		category: 'widgets',
		icon: 'megaphone',
		description: __('Display an advertisement by slug or taxonomy filters.', 'monetize-me'),
		attributes: {
			postSlug: { type: 'string', default: '' },
			adCategory: { type: 'string', default: '' },
			adSponsor: { type: 'string', default: '' },
			limit: { type: 'number', default: 1 },
			isWrapper: { type: 'boolean', default: true },
			adAlignment: { type: 'string', default: 'center-align' },
			className: { type: 'string', default: '' }
		},
		supports: { html: false },
		edit: function (props) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps = useBlockProps({ className: 'monetize-me-block-editor-preview' });

			return createElement(
				Fragment,
				null,
				createElement(
					InspectorControls,
					null,
					createElement(
						PanelBody,
						{ title: __('Advertisement Settings', 'monetize-me'), initialOpen: true },
						createElement(TextControl, {
							label: __('Ad Slug', 'monetize-me'),
							help: __('Display one specific ad by its post slug.', 'monetize-me'),
							value: attributes.postSlug,
							onChange: function (value) { setAttributes({ postSlug: value }); }
						}),
						createElement(TextControl, {
							label: __('Ad Category IDs', 'monetize-me'),
							help: __('Comma-separated term IDs. Used when Ad Slug is empty.', 'monetize-me'),
							value: attributes.adCategory,
							onChange: function (value) { setAttributes({ adCategory: value }); }
						}),
						createElement(TextControl, {
							label: __('Ad Sponsor IDs', 'monetize-me'),
							help: __('Optional comma-separated sponsor term IDs.', 'monetize-me'),
							value: attributes.adSponsor,
							onChange: function (value) { setAttributes({ adSponsor: value }); }
						}),
						createElement(RangeControl, {
							label: __('Number of Ads', 'monetize-me'),
							value: attributes.limit,
							onChange: function (value) { setAttributes({ limit: value || 1 }); },
							min: 1,
							max: 10
						}),
						createElement(ToggleControl, {
							label: __('Wrap each ad in .ad-wrapper', 'monetize-me'),
							checked: !!attributes.isWrapper,
							onChange: function (value) { setAttributes({ isWrapper: value }); }
						}),
						createElement(TextControl, {
							label: __('Alignment Class', 'monetize-me'),
							help: __('Example: center-align, left-align, right-align', 'monetize-me'),
							value: attributes.adAlignment,
							onChange: function (value) { setAttributes({ adAlignment: value }); }
						}),
						createElement(TextControl, {
							label: __('Extra CSS Class', 'monetize-me'),
							value: attributes.className,
							onChange: function (value) { setAttributes({ className: value }); }
						})
					)
				),
				createElement(
					'div',
					blockProps,
					createElement('strong', null, __('Monetize Me: Advertisement', 'monetize-me')),
					attributes.postSlug
						? createElement('p', null, __('Displaying ad by slug:', 'monetize-me'), ' ', createElement('code', null, attributes.postSlug))
						: createElement('p', null, __('Displaying ads by filters.', 'monetize-me')),
					createElement(
						'ul',
						null,
						createElement('li', null, createElement('strong', null, __('Category IDs:', 'monetize-me')), ' ', attributes.adCategory || __('None', 'monetize-me')),
						createElement('li', null, createElement('strong', null, __('Sponsor IDs:', 'monetize-me')), ' ', attributes.adSponsor || __('None', 'monetize-me')),
						createElement('li', null, createElement('strong', null, __('Limit:', 'monetize-me')), ' ', String(attributes.limit || 1)),
						createElement('li', null, createElement('strong', null, __('Wrapper:', 'monetize-me')), ' ', attributes.isWrapper ? __('Enabled', 'monetize-me') : __('Disabled', 'monetize-me')),
						createElement('li', null, createElement('strong', null, __('Alignment Class:', 'monetize-me')), ' ', attributes.adAlignment || __('None', 'monetize-me')),
						createElement('li', null, createElement('strong', null, __('Extra Class:', 'monetize-me')), ' ', attributes.className || __('None', 'monetize-me'))
					),
					createElement(
						Notice,
						{ status: 'info', isDismissible: false },
						__('This is an editor preview panel. Frontend output is rendered on the server.', 'monetize-me')
					)
				)
			);
		},
		save: function () {
			return null;
		}
	});
})(window.wp.blocks, window.wp.blockEditor, window.wp.components, window.wp.element, window.wp.i18n);
