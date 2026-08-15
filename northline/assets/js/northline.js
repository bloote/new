/**
 * Northline — front-end behaviour.
 *
 * Everything here is progressive: with JavaScript off, tabs and accordions
 * render open, filters show the whole set, and counters print their final
 * value. Nothing is hidden that cannot be un-hidden.
 *
 * Components are found by class, so patterns stay ordinary core blocks:
 *
 *   .nl-tabs        .nl-tab-btn / .nl-tab-panel   paired by document order
 *   .nl-accordion   .nl-accordion-head / -body / -mark
 *   .nl-filter-group  .nl-filter[data-filter]     filters .wp-block-post
 *   .nl-carousel    .nl-carousel-track/-slide/-prev/-next/-dot
 *   .nl-switch      .nl-switch-opt / .nl-switch-a / .nl-switch-b
 *   .nl-choice      .nl-choice-opt / .nl-choice-view
 *   .nl-count-<n>   animates 0 → n   ("x" stands in for a decimal point)
 *   .nl-reveal      fades in on first scroll into view
 */
( function () {
	'use strict';

	var reduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	function each( root, selector, fn ) {
		Array.prototype.forEach.call( ( root || document ).querySelectorAll( selector ), fn );
	}

	/* ------------------------------------------------------------- tabs --- */

	function initTabs( root ) {
		each( root, '.nl-tabs', function ( group ) {
			if ( group.dataset.nlInit ) {
				return;
			}
			group.dataset.nlInit = '1';

			var buttons = Array.prototype.slice.call( group.querySelectorAll( '.nl-tab-btn' ) );
			var panels = Array.prototype.slice.call( group.querySelectorAll( '.nl-tab-panel' ) );

			if ( ! buttons.length || ! panels.length ) {
				return;
			}

			buttons.forEach( function ( button, index ) {
				var control = button.querySelector( 'a, button' ) || button;
				control.setAttribute( 'role', 'tab' );
				control.setAttribute( 'aria-selected', index === 0 ? 'true' : 'false' );
				if ( 'A' === control.tagName ) {
					control.setAttribute( 'href', '#' );
				}
				control.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					select( index );
				} );
				control.addEventListener( 'keydown', function ( event ) {
					var next = null;
					if ( 'ArrowRight' === event.key || 'ArrowDown' === event.key ) {
						next = ( index + 1 ) % buttons.length;
					} else if ( 'ArrowLeft' === event.key || 'ArrowUp' === event.key ) {
						next = ( index - 1 + buttons.length ) % buttons.length;
					}
					if ( null !== next ) {
						event.preventDefault();
						select( next );
						( buttons[ next ].querySelector( 'a, button' ) || buttons[ next ] ).focus();
					}
				} );
			} );

			function select( index ) {
				buttons.forEach( function ( button, i ) {
					var on = i === index;
					button.classList.toggle( 'is-active', on );
					var control = button.querySelector( 'a, button' ) || button;
					control.setAttribute( 'aria-selected', on ? 'true' : 'false' );
					var link = button.querySelector( '.wp-block-button__link' );
					if ( link ) {
						link.classList.toggle( 'is-selected-tab', on );
					}
				} );
				panels.forEach( function ( panel, i ) {
					if ( i === index ) {
						panel.removeAttribute( 'hidden' );
					} else {
						panel.setAttribute( 'hidden', '' );
					}
				} );
			}

			select( 0 );
		} );
	}

	/* -------------------------------------------------------- accordion --- */

	function initAccordions( root ) {
		each( root, '.nl-accordion', function ( item ) {
			if ( item.dataset.nlInit ) {
				return;
			}
			item.dataset.nlInit = '1';

			var head = item.querySelector( '.nl-accordion-head' );
			var body = item.querySelector( '.nl-accordion-body' );

			if ( ! head || ! body ) {
				return;
			}

			var open = item.classList.contains( 'is-open' );
			var trigger = head.querySelector( 'h2, h3, h4, .nl-accordion-title' ) || head;

			head.setAttribute( 'tabindex', '0' );
			head.setAttribute( 'role', 'button' );
			head.setAttribute( 'aria-expanded', open ? 'true' : 'false' );

			function paint( animate ) {
				item.classList.toggle( 'is-open', open );
				head.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
				body.style.maxHeight = open ? body.scrollHeight + 40 + 'px' : '0px';
				body.style.opacity = open ? '1' : '0';
				if ( ! animate ) {
					body.style.transition = 'none';
					window.requestAnimationFrame( function () {
						body.style.transition = '';
					} );
				}
			}

			function toggle() {
				open = ! open;
				paint( true );
			}

			head.addEventListener( 'click', toggle );
			head.addEventListener( 'keydown', function ( event ) {
				if ( 'Enter' === event.key || ' ' === event.key ) {
					event.preventDefault();
					toggle();
				}
			} );

			// Re-measure when fonts land or the viewport changes.
			window.addEventListener( 'resize', function () {
				if ( open ) {
					body.style.maxHeight = body.scrollHeight + 40 + 'px';
				}
			} );

			paint( false );
			if ( trigger !== head ) {
				trigger.style.cursor = 'pointer';
			}
		} );
	}

	/* ----------------------------------------------------------- filters --- */

	function initFilters( root ) {
		each( root, '.nl-filter-group', function ( group ) {
			if ( group.dataset.nlInit ) {
				return;
			}
			group.dataset.nlInit = '1';

			var buttons = Array.prototype.slice.call( group.querySelectorAll( '.nl-filter' ) );
			var items = Array.prototype.slice.call(
				group.querySelectorAll( '.wp-block-post, .nl-filterable' )
			);

			if ( ! buttons.length || ! items.length ) {
				return;
			}

			buttons.forEach( function ( button ) {
				var control = button.querySelector( 'a, button' ) || button;
				if ( 'A' === control.tagName ) {
					control.setAttribute( 'href', '#' );
				}
				control.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					apply( button );
				} );
			} );

			function apply( active ) {
				var key = keyFor( active );

				buttons.forEach( function ( button ) {
					var on = button === active;
					button.classList.toggle( 'is-active', on );
					var control = button.querySelector( 'a, button' ) || button;
					control.setAttribute( 'aria-pressed', on ? 'true' : 'false' );
				} );

				var shown = 0;
				items.forEach( function ( item ) {
					var on = ! key || 'all' === key || item.classList.contains( key );
					item.classList.toggle( 'nl-filter-hidden', ! on );
					if ( on ) {
						shown++;
					}
				} );

				var empty = group.querySelector( '.nl-filter-empty' );
				if ( empty ) {
					empty.hidden = shown > 0;
				}
			}

			function keyFor( button ) {
				var match = ( button.className || '' ).match( /nl-filter-key-([\w-]+)/ );
				return match ? match[ 1 ] : 'all';
			}

			apply( buttons[ 0 ] );
		} );
	}

	/* ---------------------------------------------------------- carousel --- */

	function initCarousels( root ) {
		each( root, '.nl-carousel', function ( group ) {
			if ( group.dataset.nlInit ) {
				return;
			}
			group.dataset.nlInit = '1';

			var track = group.querySelector( '.nl-carousel-track' );

			if ( ! track || ! track.children.length ) {
				return;
			}

			var slides = Array.prototype.slice.call( track.children );
			var dots = Array.prototype.slice.call( group.querySelectorAll( '.nl-carousel-dot' ) );
			var index = 0;

			function paint() {
				track.style.transform = 'translateX(' + ( -index * 100 ) + '%)';
				slides.forEach( function ( slide, i ) {
					slide.setAttribute( 'aria-hidden', i === index ? 'false' : 'true' );
				} );
				dots.forEach( function ( dot, i ) {
					dot.setAttribute( 'aria-selected', i === index ? 'true' : 'false' );
				} );
			}

			function go( delta ) {
				index = ( index + delta + slides.length ) % slides.length;
				paint();
			}

			each( group, '.nl-carousel-prev', function ( button ) {
				button.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					go( -1 );
				} );
			} );
			each( group, '.nl-carousel-next', function ( button ) {
				button.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					go( 1 );
				} );
			} );
			dots.forEach( function ( dot, i ) {
				dot.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					index = i;
					paint();
				} );
			} );

			paint();
		} );
	}

	/* ------------------------------------------------------------ switch --- */

	function initSwitches( root ) {
		each( root, '.nl-switch', function ( group ) {
			if ( group.dataset.nlInit ) {
				return;
			}
			group.dataset.nlInit = '1';

			var options = Array.prototype.slice.call( group.querySelectorAll( '.nl-switch-opt' ) );

			options.forEach( function ( option, index ) {
				var control = option.querySelector( 'a, button' ) || option;
				if ( 'A' === control.tagName ) {
					control.setAttribute( 'href', '#' );
				}
				control.addEventListener( 'click', function ( event ) {
					event.preventDefault();
					group.classList.toggle( 'is-b', 1 === index );
					options.forEach( function ( other, i ) {
						other.classList.toggle( 'is-active', i === index );
						var otherControl = other.querySelector( 'a, button' ) || other;
						otherControl.setAttribute( 'aria-pressed', i === index ? 'true' : 'false' );
					} );
				} );
			} );

			if ( options.length ) {
				options[ 0 ].classList.add( 'is-active' );
			}
		} );
	}

	/* ------------------------------------------------------------ choice --- */

	function initChoices( root ) {
		each( root, '.nl-choice', function ( group ) {
			if ( group.dataset.nlInit ) {
				return;
			}
			group.dataset.nlInit = '1';

			var options = Array.prototype.slice.call( group.querySelectorAll( '.nl-choice-opt' ) );
			var views = Array.prototype.slice.call( group.querySelectorAll( '.nl-choice-view' ) );

			function select( index ) {
				options.forEach( function ( option, i ) {
					option.setAttribute( 'aria-pressed', i === index ? 'true' : 'false' );
				} );
				views.forEach( function ( view, i ) {
					view.classList.toggle( 'is-active', i === index );
				} );
			}

			options.forEach( function ( option, index ) {
				option.setAttribute( 'type', 'button' );
				option.addEventListener( 'click', function () {
					select( index );
				} );
			} );

			if ( options.length ) {
				select( 0 );
			}
		} );
	}

	/* ---------------------------------------------------------- counters --- */

	function initCounters( root ) {
		each( root, '[class*="nl-count-"]', function ( element ) {
			if ( element.dataset.nlInit ) {
				return;
			}

			var match = ( element.className || '' ).match( /nl-count-([\dx]+)/ );

			if ( ! match ) {
				return;
			}

			element.dataset.nlInit = '1';

			var target = parseFloat( match[ 1 ].replace( 'x', '.' ) );
			var decimals = match[ 1 ].indexOf( 'x' ) > -1 ? match[ 1 ].split( 'x' )[ 1 ].length : 0;
			var final = element.textContent;

			if ( reduced || isNaN( target ) ) {
				return;
			}

			watch( element, function () {
				var started = Date.now();
				var duration = 1300;
				var tick = setInterval( function () {
					var progress = Math.min( 1, ( Date.now() - started ) / duration );
					var eased = 1 - Math.pow( 1 - progress, 3 );
					element.textContent = ( target * eased ).toFixed( decimals );
					if ( progress >= 1 ) {
						clearInterval( tick );
						element.textContent = final;
					}
				}, 32 );
			} );

			element.textContent = ( 0 ).toFixed( decimals );
		} );
	}

	/* ------------------------------------------------------------ reveal --- */

	function initReveals( root ) {
		each( root, '.nl-reveal', function ( element ) {
			if ( element.dataset.nlInit ) {
				return;
			}
			element.dataset.nlInit = '1';

			if ( reduced ) {
				element.classList.add( 'is-in' );
				return;
			}

			watch( element, function () {
				element.classList.add( 'is-in' );
			} );
		} );
	}

	/* ------------------------------------------------------- view watcher --- */

	var pending = [];
	var watching = false;

	function inView( element ) {
		var box = element.getBoundingClientRect();
		var height = window.innerHeight || document.documentElement.clientHeight;
		return box.top < height - 40 && box.bottom > 0;
	}

	function pump() {
		for ( var i = pending.length - 1; i >= 0; i-- ) {
			if ( inView( pending[ i ].element ) ) {
				pending[ i ].run();
				pending.splice( i, 1 );
			}
		}
	}

	function watch( element, run ) {
		pending.push( { element: element, run: run } );

		if ( ! watching ) {
			watching = true;
			window.addEventListener( 'scroll', pump, { passive: true } );
			window.addEventListener( 'resize', pump, { passive: true } );
		}

		// Anything already on screen resolves on the next frame.
		window.requestAnimationFrame( pump );
	}

	/* -------------------------------------------------------------- boot --- */

	function boot( root ) {
		initTabs( root );
		initAccordions( root );
		initFilters( root );
		initCarousels( root );
		initSwitches( root );
		initChoices( root );
		initCounters( root );
		initReveals( root );
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', function () {
			boot( document );
		} );
	} else {
		boot( document );
	}

	// Re-scan after web fonts settle, so accordion heights are measured right.
	if ( document.fonts && document.fonts.ready ) {
		document.fonts.ready.then( function () {
			each( document, '.nl-accordion.is-open .nl-accordion-body', function ( body ) {
				body.style.maxHeight = body.scrollHeight + 40 + 'px';
			} );
		} );
	}

	window.northline = { boot: boot };
} )();
