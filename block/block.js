/**
 * Windspeed Converter block - editor script.
 *
 * Written as plain ES5 on purpose: the plugin ships without a build step,
 * so this file is loaded directly by the block editor.
 */
( function ( wp ) {
	'use strict';

	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var __ = wp.i18n.__;
	var registerBlockType = wp.blocks.registerBlockType;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var PanelBody = wp.components.PanelBody;
	var ToggleControl = wp.components.ToggleControl;
	var ServerSideRender = wp.serverSideRender;

	var FIELDS = [
		{ key: 'kmh', label: __( 'Km/h', 'wind-speed-converter' ) },
		{ key: 'mph', label: __( 'Mph', 'wind-speed-converter' ) },
		{ key: 'beaufort', label: __( 'Beaufort', 'wind-speed-converter' ) },
		{ key: 'ms', label: __( 'M/s', 'wind-speed-converter' ) },
		{ key: 'knots', label: __( 'Knots', 'wind-speed-converter' ) },
		{ key: 'link', label: __( 'Show backlink', 'wind-speed-converter' ) }
	];

	registerBlockType( 'wind-speed-converter/converter', {
		edit: function ( props ) {
			var blockProps = useBlockProps();

			var toggles = FIELDS.map( function ( field ) {
				return el( ToggleControl, {
					key: field.key,
					label: field.label,
					checked: !! props.attributes[ field.key ],
					__nextHasNoMarginBottom: true,
					onChange: function ( value ) {
						var update = {};
						update[ field.key ] = value;
						props.setAttributes( update );
					}
				} );
			} );

			return el(
				Fragment,
				null,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Fields', 'wind-speed-converter' ), initialOpen: true },
						toggles
					)
				),
				el(
					'div',
					blockProps,
					// Pointer events are disabled so clicking the preview
					// selects the block instead of focusing the form inputs.
					el(
						'div',
						{ style: { pointerEvents: 'none' } },
						el( ServerSideRender, {
							block: 'wind-speed-converter/converter',
							attributes: props.attributes
						} )
					)
				)
			);
		},
		save: function () {
			// Dynamic block - markup is rendered in PHP.
			return null;
		}
	} );
} )( window.wp );
