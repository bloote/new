/**
 * Editor registration for the theme's two dynamic blocks.
 *
 * Written against the packages WordPress already ships, so the theme needs no
 * build step: drop it in, and the blocks appear in the inserter.
 */
( function ( blocks, element, blockEditor, components, serverSideRender, i18n ) {
	'use strict';

	var el = element.createElement;
	var __ = i18n.__;
	var useBlockProps = blockEditor.useBlockProps;
	var InspectorControls = blockEditor.InspectorControls;
	var ServerSideRender = serverSideRender;

	blocks.registerBlockType( 'northline/meta-line', {
		edit: function ( props ) {
			return el(
				'div',
				useBlockProps(),
				el(
					InspectorControls,
					null,
					el(
						components.PanelBody,
						{ title: __( 'Meta line', 'northline' ), initialOpen: true },
						el( components.TextControl, {
							label: __( 'Custom fields', 'northline' ),
							help: __( 'Comma-separated meta keys, in the order they should read.', 'northline' ),
							value: props.attributes.fields,
							onChange: function ( value ) {
								props.setAttributes( { fields: value } );
							},
						} ),
						el( components.TextControl, {
							label: __( 'Separator', 'northline' ),
							value: props.attributes.separator,
							onChange: function ( value ) {
								props.setAttributes( { separator: value } );
							},
						} ),
						el( components.TextControl, {
							label: __( 'Prefix', 'northline' ),
							value: props.attributes.prefix,
							onChange: function ( value ) {
								props.setAttributes( { prefix: value } );
							},
						} ),
						el( components.TextControl, {
							label: __( 'Fallback text', 'northline' ),
							help: __( 'Shown when none of those fields have a value.', 'northline' ),
							value: props.attributes.fallback,
							onChange: function ( value ) {
								props.setAttributes( { fallback: value } );
							},
						} )
					)
				),
				el( ServerSideRender, {
					block: 'northline/meta-line',
					attributes: props.attributes,
					EmptyResponsePlaceholder: function () {
						return el(
							components.Placeholder,
							{ label: __( 'Meta line', 'northline' ) },
							__( 'Nothing to show — this post has no value for those fields.', 'northline' )
						);
					},
				} )
			);
		},
		save: function () {
			return null;
		},
	} );

	blocks.registerBlockType( 'northline/form', {
		edit: function ( props ) {
			return el(
				'div',
				useBlockProps(),
				el(
					InspectorControls,
					null,
					el(
						components.PanelBody,
						{ title: __( 'Form', 'northline' ), initialOpen: true },
						el( components.SelectControl, {
							label: __( 'Which form', 'northline' ),
							value: props.attributes.variant,
							options: [
								{ label: __( 'Project enquiry', 'northline' ), value: 'contact' },
								{ label: __( 'Custom order', 'northline' ), value: 'order' },
								{ label: __( 'Journal subscription', 'northline' ), value: 'newsletter' },
							],
							onChange: function ( value ) {
								props.setAttributes( { variant: value } );
							},
						} )
					)
				),
				el(
					'div',
					{ style: { pointerEvents: 'none' } },
					el( ServerSideRender, {
						block: 'northline/form',
						attributes: props.attributes,
					} )
				)
			);
		},
		save: function () {
			return null;
		},
	} );
} )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components, window.wp.serverSideRender, window.wp.i18n );
