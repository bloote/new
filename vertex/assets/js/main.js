/**
 * Vertex theme front-end scripts.
 *
 * @package Vertex
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileMenu();
		initHeaderScroll();
		initSearchPanel();
		initReveal();
		initBackToTop();
		initSmoothAnchors();
		initSubmenuAccessibility();
	} );

	/**
	 * Mobile navigation toggle.
	 */
	function initMobileMenu() {
		var toggle = document.querySelector( '.menu-toggle' );
		var nav = document.getElementById( 'site-navigation' );
		if ( ! toggle || ! nav ) {
			return;
		}
		toggle.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			document.body.style.overflow = open ? 'hidden' : '';
		} );

		// Close when a link is clicked.
		nav.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', function () {
				if ( window.innerWidth <= 782 && link.getAttribute( 'href' ) && link.getAttribute( 'href' ).indexOf( '#' ) !== 0 ) {
					nav.classList.remove( 'is-open' );
					toggle.setAttribute( 'aria-expanded', 'false' );
					document.body.style.overflow = '';
				}
			} );
		} );
	}

	/**
	 * Add a shadow to the header on scroll.
	 */
	function initHeaderScroll() {
		var header = document.querySelector( '[data-header]' );
		if ( ! header ) {
			return;
		}
		var onScroll = function () {
			header.classList.toggle( 'is-scrolled', window.scrollY > 12 );
		};
		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	/**
	 * Toggle the header search panel.
	 */
	function initSearchPanel() {
		var btn = document.querySelector( '[data-search-toggle]' );
		var panel = document.querySelector( '[data-search-panel]' );
		if ( ! btn || ! panel ) {
			return;
		}
		btn.addEventListener( 'click', function () {
			var hidden = panel.hasAttribute( 'hidden' );
			if ( hidden ) {
				panel.removeAttribute( 'hidden' );
				var field = panel.querySelector( 'input[type="search"]' );
				if ( field ) {
					field.focus();
				}
			} else {
				panel.setAttribute( 'hidden', '' );
			}
		} );
	}

	/**
	 * Reveal elements on scroll using IntersectionObserver.
	 */
	function initReveal() {
		var els = document.querySelectorAll( '.vx-reveal' );
		if ( ! els.length ) {
			return;
		}
		if ( ! ( 'IntersectionObserver' in window ) ) {
			els.forEach( function ( el ) {
				el.classList.add( 'is-visible' );
			} );
			return;
		}
		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
		);
		els.forEach( function ( el ) {
			observer.observe( el );
		} );
	}

	/**
	 * Back-to-top button.
	 */
	function initBackToTop() {
		var btn = document.querySelector( '[data-to-top]' );
		if ( ! btn ) {
			return;
		}
		var onScroll = function () {
			btn.classList.toggle( 'is-visible', window.scrollY > 600 );
		};
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		btn.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
		onScroll();
	}

	/**
	 * Smooth scrolling for in-page anchors.
	 */
	function initSmoothAnchors() {
		document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( anchor ) {
			anchor.addEventListener( 'click', function ( e ) {
				var id = anchor.getAttribute( 'href' );
				if ( id.length < 2 ) {
					return;
				}
				var target = document.querySelector( id );
				if ( target ) {
					e.preventDefault();
					var top = target.getBoundingClientRect().top + window.scrollY - 90;
					window.scrollTo( { top: top, behavior: 'smooth' } );
				}
			} );
		} );
	}

	/**
	 * Keyboard support for dropdown menus.
	 */
	function initSubmenuAccessibility() {
		document.querySelectorAll( '.main-navigation .menu-item-has-children' ).forEach( function ( item ) {
			var link = item.querySelector( 'a' );
			if ( ! link ) {
				return;
			}
			link.addEventListener( 'focus', function () {
				item.classList.add( 'is-focused' );
			} );
			item.addEventListener( 'focusout', function ( e ) {
				if ( ! item.contains( e.relatedTarget ) ) {
					item.classList.remove( 'is-focused' );
				}
			} );
		} );
	}
} )();
