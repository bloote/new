/**
 * Live preview for the Vertex Customizer.
 *
 * @package Vertex
 */
( function ( $ ) {
	'use strict';

	// Site title & description.
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-title a span, .site-title a' ).first().text( to );
		} );
	} );

	// Hero title.
	wp.customize( 'vertex_hero_title', function ( value ) {
		value.bind( function ( to ) {
			$( '.vx-hero__title' ).html( to );
		} );
	} );

	// Hero text.
	wp.customize( 'vertex_hero_text', function ( value ) {
		value.bind( function ( to ) {
			$( '.vx-hero__text' ).text( to );
		} );
	} );

	// Colors -> update CSS custom properties live.
	function setVar( name, val ) {
		document.documentElement.style.setProperty( name, val );
	}

	wp.customize( 'vertex_color_primary', function ( value ) {
		value.bind( function ( to ) {
			setVar( '--vx-primary', to );
		} );
	} );
	wp.customize( 'vertex_color_accent', function ( value ) {
		value.bind( function ( to ) {
			setVar( '--vx-accent', to );
		} );
	} );
	wp.customize( 'vertex_color_ink', function ( value ) {
		value.bind( function ( to ) {
			setVar( '--vx-ink', to );
		} );
	} );
} )( jQuery );
