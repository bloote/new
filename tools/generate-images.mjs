/**
 * Northline — image generator.
 *
 * Every picture the theme and its demo content need is drawn here and written
 * to northline/assets/images/. Nothing is downloaded and nothing is licensed
 * from a stock library: each image is laid out in HTML and CSS, rendered by
 * headless Chromium at the exact size it is used, and saved as a JPEG.
 *
 * Rendering in a browser rather than in a drawing library is what makes real
 * typography, gradients, blend modes and shadows available, so the interface
 * mockups read as screenshots and the editorial plates read as artwork.
 *
 * Usage:  node tools/generate-images.mjs [name-fragment]
 *
 * Passing a fragment renders only the files whose names contain it, which is
 * how you iterate on one plate without rebuilding all forty-six.
 */

import { chromium } from 'playwright';
import { readFileSync, mkdirSync, existsSync, statSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { dirname, join } from 'node:path';

const ROOT = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const THEME = join( ROOT, 'northline' );
const OUT = join( THEME, 'assets/images' );

/* ------------------------------------------------------------------ colour */

/**
 * The theme's palette, plus the three alternative accents the original design
 * offered as options. Using them as secondary tones keeps the artwork varied
 * without going off-brand.
 */
const C = {
	ink: '#1d1f20',
	base: '#f2f2f3',
	surface: '#e9e9ea',
	accent: '#5980a6',
	accentDeep: '#416180',
	accentDark: '#1d2d3d',
	accentTint: '#eef6ff',
	night: '#111e2b',
	sage: '#6d7f57',
	clay: '#a05c3c',
	indigo: '#4a4f7a',
};

/* ------------------------------------------------------------------- fonts */

const fontFace = ( family, weight, file ) => {
	const path = join( THEME, 'assets/fonts', file );
	const data = readFileSync( path ).toString( 'base64' );
	return `@font-face{font-family:'${ family }';font-weight:${ weight };font-style:normal;font-display:block;src:url(data:font/woff2;base64,${ data }) format('woff2')}`;
};

const FONTS = [
	fontFace( 'Barlow', 400, 'barlow-400-latin.woff2' ),
	fontFace( 'Barlow', 500, 'barlow-500-latin.woff2' ),
	fontFace( 'Barlow', 700, 'barlow-700-latin.woff2' ),
	fontFace( 'Barlow Condensed', 400, 'barlow-condensed-400-latin.woff2' ),
	fontFace( 'Barlow Condensed', 600, 'barlow-condensed-600-latin.woff2' ),
	fontFace( 'Barlow Condensed', 700, 'barlow-condensed-700-latin.woff2' ),
].join( '' );

/* ------------------------------------------------------------- base styles */

const BASE = `
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{width:100%;height:100%;overflow:hidden}
body{font-family:'Barlow',system-ui,sans-serif;color:${ C.ink };
	-webkit-font-smoothing:antialiased;text-rendering:geometricPrecision}
.h{font-family:'Barlow Condensed',sans-serif;font-weight:600;letter-spacing:-.01em;line-height:1.04}
.stage{position:relative;width:100%;height:100%;overflow:hidden}

/* A fine paper grain, so flat fills never look like flat fills. */
.grain{position:absolute;inset:0;pointer-events:none;opacity:.35;mix-blend-mode:overlay;
	background-image:url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='160' height='160'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='3'/></filter><rect width='160' height='160' filter='url(%23n)' opacity='.5'/></svg>")}

/* A soft vignette that keeps the eye inside the plate. */
.vig{position:absolute;inset:0;pointer-events:none;
	background:radial-gradient(120% 90% at 50% 40%,transparent 40%,rgba(0,0,0,.30) 100%)}

/* Photographic stand-ins inside interface mockups: a lit gradient with a
   blurred highlight, never an outlined box with a cross through it. */
.ph{position:relative;overflow:hidden;background:linear-gradient(150deg,#2c4a66,#14232f 70%)}
.ph::after{content:'';position:absolute;width:70%;height:70%;left:8%;top:-14%;border-radius:50%;
	background:radial-gradient(circle,rgba(148,188,227,.55),transparent 65%);filter:blur(18px)}
.ph.light{background:linear-gradient(150deg,#c9d8e6,#98b4cb 70%)}
.ph.sage{background:linear-gradient(150deg,#7f9268,#3f4c33 70%)}
.ph.clay{background:linear-gradient(150deg,#b8714d,#5c3221 70%)}
.ph.indigo{background:linear-gradient(150deg,#5a5f8e,#292c48 70%)}

.row{display:flex}
.col{display:flex;flex-direction:column}
.fill{flex:1}
`;

/* -------------------------------------------------------------- primitives */

const px = ( n ) => `${ n }px`;

/** A rule of small caps used as a label throughout the artwork. */
const kicker = ( text, color = C.accent, size = 13 ) =>
	`<div class="h" style="font-size:${ px( size ) };letter-spacing:.18em;text-transform:uppercase;color:${ color };font-weight:600">${ text }</div>`;

/** A run of text lines standing in for body copy at small sizes. */
const lines = ( n, { w = 100, color = 'rgba(29,31,32,.16)', gap = 9, h = 7 } = {} ) =>
	Array.from( { length: n }, ( _, i ) => {
		const width = i === n - 1 ? w * 0.62 : w - i * 4;
		return `<div style="height:${ px( h ) };width:${ width }%;background:${ color };border-radius:${ px( h / 2 ) };margin-bottom:${ px( gap ) }"></div>`;
	} ).join( '' );

/** The browser window that frames every interface mockup. */
const browser = ( inner, { url = 'northline.co', tone = 'light' } = {} ) => {
	const bar = tone === 'light' ? '#e4e7ea' : '#1b2b3a';
	const dot = tone === 'light' ? '#c3cad1' : '#31465a';
	const pill = tone === 'light' ? '#f4f6f8' : '#22364a';
	const text = tone === 'light' ? 'rgba(29,31,32,.45)' : 'rgba(238,246,255,.5)';
	return `
	<div class="col" style="position:absolute;inset:3.2% 3.2% 0 3.2%;border-radius:10px 10px 0 0;overflow:hidden;
		box-shadow:0 40px 80px rgba(10,20,30,.30),0 4px 12px rgba(10,20,30,.14)">
		<div class="row" style="align-items:center;gap:8px;height:44px;flex:none;padding:0 16px;background:${ bar }">
			${ [ 0, 1, 2 ].map( () => `<span style="width:10px;height:10px;border-radius:50%;background:${ dot }"></span>` ).join( '' ) }
			<div class="row" style="align-items:center;justify-content:center;margin-left:14px;width:44%;height:24px;border-radius:12px;background:${ pill }">
				<span style="font-size:12px;color:${ text }">${ url }</span>
			</div>
		</div>
		<div class="fill" style="position:relative;overflow:hidden">${ inner }</div>
	</div>`;
};

/** The header inside a mocked-up site. */
const siteNav = ( { brand, items, cta, accent = C.accent, dark = false } ) => {
	const fg = dark ? '#eef6ff' : C.ink;
	const line = dark ? 'rgba(238,246,255,.14)' : 'rgba(29,31,32,.12)';
	return `
	<div class="row" style="align-items:center;gap:26px;padding:20px 34px;border-bottom:1px solid ${ line }">
		<div class="row" style="align-items:center;gap:9px;margin-right:auto">
			<span style="position:relative;width:18px;height:18px;border:1.5px solid ${ fg };display:block">
				<span style="position:absolute;inset:3px;background:${ accent };display:block"></span></span>
			<span class="h" style="font-size:17px;letter-spacing:.08em;text-transform:uppercase;color:${ fg }">${ brand }</span>
		</div>
		${ items.map( ( i ) => `<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:${ dark ? 'rgba(238,246,255,.72)' : 'rgba(29,31,32,.62)' }">${ i }</span>` ).join( '' ) }
		<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:#fff;background:${ accent };padding:9px 16px">${ cta }</span>
	</div>`;
};

/* ------------------------------------------------------------------ scenes */

/** The figures band and footer that close a mocked-up page. */
const siteTail = ( { brand, accent, dark, stats } ) => {
	const fg = dark ? '#eef6ff' : C.ink;
	const quiet = dark ? 'rgba(238,246,255,.5)' : 'rgba(29,31,32,.5)';
	const line = dark ? 'rgba(238,246,255,.12)' : 'rgba(29,31,32,.10)';
	return `
	<div class="fill"></div>
	<div class="row" style="padding:0 34px;border-top:1px solid ${ line }">
		${ stats.map( ( [ n, l ], i ) => `
			<div class="col fill" style="padding:22px 22px 22px ${ i ? '22px' : '0' };${ i ? `border-left:1px solid ${ line }` : '' }">
				<span class="h" style="font-size:28px;color:${ fg }">${ n }</span>
				<span class="h" style="font-size:10px;letter-spacing:.16em;text-transform:uppercase;color:${ quiet };margin-top:6px">${ l }</span>
			</div>` ).join( '' ) }
	</div>
	<div class="row" style="align-items:center;justify-content:space-between;padding:16px 34px;border-top:1px solid ${ line };
		background:${ dark ? 'rgba(238,246,255,.03)' : 'rgba(29,31,32,.03)' }">
		<span class="h" style="font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:${ quiet }">© ${ brand }</span>
		<div class="row" style="gap:18px">
			${ [ 'Privacy', 'Terms', 'Contact' ].map( ( t ) => `<span style="font-size:12px;color:${ quiet }">${ t }</span>` ).join( '' ) }
		</div>
		<span style="width:9px;height:9px;background:${ accent }"></span>
	</div>`;
};

/**
 * A believable marketing site, in one of six layouts. This is what stands in
 * for a theme screenshot, a client build or a documentation grab.
 */
function siteMock( cfg ) {
	const {
		variant = 'services',
		brand = 'Ledger',
		accent = C.accent,
		dark = false,
		title = 'Advice that holds up under scrutiny.',
		kick = 'Professional services',
		nav = [ 'Services', 'Work', 'About', 'Journal' ],
		cta = 'Enquire',
		phTone = '',
		url = 'ledger.example',
	} = cfg;

	const bg = dark ? '#16232f' : '#f7f8f9';
	const fg = dark ? '#eef6ff' : C.ink;
	const quiet = dark ? 'rgba(238,246,255,.55)' : 'rgba(29,31,32,.55)';
	const line = dark ? 'rgba(238,246,255,.12)' : 'rgba(29,31,32,.10)';
	const card = dark ? 'rgba(238,246,255,.05)' : '#fff';
	const lineColor = dark ? 'rgba(238,246,255,.18)' : 'rgba(29,31,32,.14)';

	const bodyByVariant = {
		services: `
			<div class="row" style="gap:44px;padding:52px 34px 34px;align-items:center">
				<div style="flex:1.15">
					${ kicker( kick, accent, 12 ) }
					<div class="h" style="font-size:52px;margin:16px 0 18px;color:${ fg };max-width:13ch">${ title }</div>
					<div style="max-width:34ch;margin-bottom:24px">${ lines( 3, { color: lineColor, h: 8 } ) }</div>
					<div class="row" style="gap:10px">
						<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:#fff;background:${ accent };padding:11px 20px">Book a call</span>
						<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:${ fg };border:1px solid ${ lineColor };padding:11px 20px">Our work</span>
					</div>
				</div>
				<div class="ph ${ phTone }" style="flex:.85;height:270px;border-radius:3px"></div>
			</div>
			<div class="row" style="gap:18px;padding:0 34px 40px">
				${ [ 'Strategy', 'Design', 'Delivery' ].map( ( t, i ) => `
					<div class="col fill" style="background:${ card };border:1px solid ${ line };padding:22px;gap:12px">
						<span class="h" style="font-size:11px;letter-spacing:.16em;color:${ accent }">0${ i + 1 }</span>
						<span class="h" style="font-size:21px;color:${ fg }">${ t }</span>
						<div>${ lines( 3, { color: lineColor, h: 6, gap: 7 } ) }</div>
					</div>` ).join( '' ) }
			</div>`,

		editorial: `
			<div style="padding:56px 34px 28px;max-width:78%">
				${ kicker( kick, accent, 12 ) }
				<div class="h" style="font-size:56px;line-height:1;margin:18px 0 20px;color:${ fg }">${ title }</div>
				<div class="row" style="gap:12px;align-items:center;margin-bottom:26px">
					<span style="width:34px;height:34px;border-radius:50%;background:linear-gradient(140deg,${ accent },${ C.accentDark })"></span>
					<span style="font-size:14px;color:${ quiet }">Maya Iyer &nbsp;·&nbsp; 14 January &nbsp;·&nbsp; 9 min read</span>
				</div>
			</div>
			<div class="ph ${ phTone }" style="height:190px;margin:0 34px 30px;border-radius:3px"></div>
			<div class="row" style="gap:40px;padding:0 34px">
				<div style="flex:2">${ lines( 7, { color: lineColor, h: 8, gap: 12 } ) }</div>
				<div style="flex:1;border-left:1px solid ${ line };padding-left:24px">
					${ kicker( 'Contents', quiet, 10 ) }
					<div style="margin-top:14px">${ lines( 5, { color: lineColor, h: 6, gap: 12, w: 86 } ) }</div>
				</div>
			</div>`,

		commerce: `
			<div class="row" style="align-items:flex-end;justify-content:space-between;padding:44px 34px 26px">
				<div>
					${ kicker( kick, accent, 12 ) }
					<div class="h" style="font-size:44px;margin-top:14px;color:${ fg }">${ title }</div>
				</div>
				<div class="row" style="gap:8px">
					${ [ 'All', 'New', 'Sale' ].map( ( t, i ) => `<span class="h" style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;padding:8px 14px;border:1px solid ${ lineColor };color:${ i === 0 ? '#fff' : fg };background:${ i === 0 ? accent : 'transparent' }">${ t }</span>` ).join( '' ) }
				</div>
			</div>
			<div class="row" style="gap:16px;padding:0 34px 40px">
				${ [ [ 'Roast no. 4', '£14' ], [ 'Everyday blend', '£12' ], [ 'Single origin', '£18' ], [ 'Subscription', '£38' ] ].map( ( [ t, p ], i ) => `
					<div class="col fill" style="gap:10px">
						<div class="ph ${ [ '', 'clay', 'light', 'sage' ][ i ] }" style="height:150px;border-radius:3px"></div>
						<span class="h" style="font-size:17px;color:${ fg }">${ t }</span>
						<span style="font-size:14px;color:${ quiet }">${ p }</span>
					</div>` ).join( '' ) }
			</div>`,

		onepage: `
			<div class="col" style="align-items:center;text-align:center;padding:60px 60px 34px">
				${ kicker( kick, accent, 12 ) }
				<div class="h" style="font-size:60px;line-height:.98;margin:18px 0 18px;color:${ fg };max-width:16ch">${ title }</div>
				<div style="width:44%;margin-bottom:26px">${ lines( 2, { color: lineColor, h: 8 } ) }</div>
				<div class="row" style="gap:10px">
					<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:#fff;background:${ accent };padding:12px 24px">Get started</span>
					<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:${ fg };border:1px solid ${ lineColor };padding:12px 24px">See pricing</span>
				</div>
			</div>
			<div class="row" style="gap:16px;padding:14px 60px 0;align-items:flex-end">
				${ [ [ 'Starter', '£19', 100 ], [ 'Studio', '£49', 130 ], [ 'Agency', '£99', 100 ] ].map( ( [ t, p, h ], i ) => `
					<div class="col fill" style="gap:10px;padding:22px;border:1px solid ${ i === 1 ? accent : line };background:${ i === 1 ? ( dark ? 'rgba(89,128,166,.14)' : C.accentTint ) : card };height:${ px( h + 60 ) }">
						<span class="h" style="font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:${ accent }">${ t }</span>
						<span class="h" style="font-size:32px;color:${ fg }">${ p }</span>
						<div>${ lines( 3, { color: lineColor, h: 6, gap: 7 } ) }</div>
					</div>` ).join( '' ) }
			</div>`,

		docs: `
			<div class="row fill" style="min-height:0">
				<div class="col" style="width:26%;border-right:1px solid ${ line };padding:30px 24px;gap:18px;background:${ dark ? 'rgba(238,246,255,.03)' : '#f1f3f5' }">
					${ kicker( 'Getting started', accent, 10 ) }
					${ [ 'Installation', 'Quick start', 'Patterns', 'Templates', 'Global styles', 'Child themes' ].map( ( t, i ) => `
						<span class="h" style="font-size:15px;font-weight:400;color:${ i === 2 ? accent : fg };opacity:${ i === 2 ? 1 : 0.72 }">${ t }</span>` ).join( '' ) }
					<div style="height:1px;background:${ line };margin:6px 0"></div>
					${ kicker( 'Reference', quiet, 10 ) }
					${ [ 'theme.json', 'Hooks', 'CLI' ].map( ( t ) => `<span class="h" style="font-size:15px;font-weight:400;color:${ fg };opacity:.72">${ t }</span>` ).join( '' ) }
				</div>
				<div class="col fill" style="padding:36px 34px">
					${ kicker( kick, accent, 11 ) }
					<div class="h" style="font-size:40px;margin:14px 0 20px;color:${ fg }">${ title }</div>
					<div style="max-width:52ch;margin-bottom:22px">${ lines( 4, { color: lineColor, h: 8, gap: 11 } ) }</div>
					<div style="font-family:ui-monospace,Menlo,monospace;font-size:13px;padding:16px 18px;border-radius:3px;
						background:${ dark ? '#0e1a25' : '#eceff2' };color:${ dark ? '#94bce3' : C.accentDeep };margin-bottom:22px">
						wp theme install ledger.zip --activate</div>
					<div style="max-width:52ch">${ lines( 3, { color: lineColor, h: 8, gap: 11 } ) }</div>
				</div>
			</div>`,

		multisite: `
			<div class="row" style="align-items:flex-end;justify-content:space-between;padding:44px 34px 26px">
				<div>
					${ kicker( kick, accent, 12 ) }
					<div class="h" style="font-size:44px;margin-top:14px;color:${ fg };max-width:16ch">${ title }</div>
				</div>
				<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:${ fg };border:1px solid ${ lineColor };padding:10px 18px">All locations</span>
			</div>
			<div class="row" style="gap:16px;padding:0 34px 20px">
				${ [ 'Bristol', 'Leeds', 'Glasgow' ].map( ( t, i ) => `
					<div class="col fill" style="border:1px solid ${ line };background:${ card }">
						<div class="ph ${ [ 'light', '', 'indigo' ][ i ] }" style="height:96px"></div>
						<div class="col" style="padding:18px;gap:8px">
							<span class="h" style="font-size:19px;color:${ fg }">${ t }</span>
							<div>${ lines( 2, { color: lineColor, h: 6, gap: 7 } ) }</div>
						</div>
					</div>` ).join( '' ) }
			</div>
			<div class="row" style="gap:0;padding:0 34px 34px;border-top:1px solid ${ line };margin:0 34px">
				${ [ [ '48', 'Sites' ], [ '12', 'Regions' ], [ '1', 'Pattern library' ], [ '6', 'Palettes' ] ].map( ( [ n, l ], i ) => `
					<div class="col fill" style="padding:20px 20px 0;${ i ? `border-left:1px solid ${ line }` : '' }">
						<span class="h" style="font-size:30px;color:${ fg }">${ n }</span>
						<span class="h" style="font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:${ quiet };margin-top:6px">${ l }</span>
					</div>` ).join( '' ) }
			</div>`,
	};

	const statsByVariant = {
		services: [ [ '61', 'Projects' ], [ '18', 'Years' ], [ '4.9', 'Client rating' ], [ '9', 'Specialists' ] ],
		editorial: [ [ '2,140', 'Essays' ], [ '31k', 'Readers' ], [ '12', 'Contributors' ], [ '9', 'Years' ] ],
		commerce: [ [ '240', 'Products' ], [ '4.8', 'Rating' ], [ '48h', 'Dispatch' ], [ '32', 'Countries' ] ],
		onepage: [ [ '12k', 'Teams' ], [ '99.9%', 'Uptime' ], [ '4.9', 'Rating' ], [ '24/7', 'Support' ] ],
		multisite: [ [ '4.9', 'Group rating' ], [ '320', 'Staff' ], [ '1994', 'Founded' ], [ '3', 'Countries' ] ],
	};

	const tail = 'docs' === variant
		? ''
		: siteTail( { brand, accent, dark, stats: statsByVariant[ variant ] } );

	return `
	<div class="stage" style="background:linear-gradient(160deg,${ dark ? '#0d1720' : '#dfe3e7' },${ dark ? '#16232f' : '#c8d0d8' })">
		${ browser(
			`<div class="col" style="height:100%;background:${ bg }">
				${ siteNav( { brand, items: nav, cta, accent, dark } ) }
				${ bodyByVariant[ variant ] }
				${ tail }
			</div>`,
			{ url, tone: dark ? 'dark' : 'light' }
		) }
		<div class="grain"></div>
	</div>`;
}

/**
 * A portrait study: flat shapes, warm ground, one accent arc. Deliberately
 * illustrative rather than photographic, so nobody is depicted who does not
 * exist.
 */
function portrait( { skin, shade, hair, beard = false, clothes, bg, arc, style = 'short' } ) {
	// Everything is positioned against one head: an ellipse at (200,178) with
	// radii 74 x 80. The hair is a slightly larger ellipse sitting 16px higher,
	// so the difference between the two reads as a hairline.
	const extras = {
		short: '',
		bun: '<circle cx="200" cy="74" r="27" fill="HAIR"/>',
		bob: `<rect x="118" y="150" width="30" height="118" rx="15" fill="HAIR"/>
			<rect x="252" y="150" width="30" height="118" rx="15" fill="HAIR"/>`,
		long: `<rect x="116" y="150" width="32" height="188" rx="16" fill="HAIR"/>
			<rect x="252" y="150" width="32" height="188" rx="16" fill="HAIR"/>`,
	}[ style ].replaceAll( 'HAIR', hair );

	return `
	<div class="stage" style="background:${ bg }">
		<svg viewBox="0 0 400 400" width="100%" height="100%">
			<defs>
				<clipPath id="face"><ellipse cx="200" cy="178" rx="74" ry="80"/></clipPath>
				<linearGradient id="cloth" x1="0" y1="0" x2="0" y2="1">
					<stop offset="0" stop-color="${ clothes }"/>
					<stop offset="1" stop-color="${ clothes }" stop-opacity=".78"/>
				</linearGradient>
			</defs>

			<circle cx="200" cy="176" r="150" fill="${ arc }" opacity=".55"/>
			<circle cx="200" cy="176" r="150" fill="none" stroke="${ arc }" stroke-width="2" opacity=".9"/>

			<!-- Neck, behind the head and mostly hidden by the shoulders. -->
			<rect x="176" y="228" width="48" height="76" rx="22" fill="${ shade }"/>

			<!-- Hair sits under the face, so the face edge draws the hairline. -->
			${ extras }
			<ellipse cx="200" cy="162" rx="80" ry="88" fill="${ hair }"/>

			<ellipse cx="126" cy="188" rx="11" ry="17" fill="${ shade }"/>
			<ellipse cx="274" cy="188" rx="11" ry="17" fill="${ shade }"/>
			<ellipse cx="200" cy="178" rx="74" ry="80" fill="${ skin }"/>

			${ beard ? `<g clip-path="url(#face)"><ellipse cx="200" cy="292" rx="84" ry="80" fill="${ hair }"/></g>` : '' }

			<g stroke="rgba(24,28,32,.62)" stroke-width="5" stroke-linecap="round">
				<path d="M170 186h22"/><path d="M208 186h22"/>
			</g>
			<path d="M198 200c0 8 3 12 7 12" fill="none" stroke="rgba(24,28,32,.18)" stroke-width="4" stroke-linecap="round"/>

			<!-- Shoulders, drawn last so they cover the base of the neck. -->
			<path d="M200 288c-74 0-116 44-124 112h248c-8-68-50-112-124-112z" fill="url(#cloth)"/>
		</svg>
		<div class="grain" style="opacity:.18"></div>
	</div>`;
}

/**
 * Editorial artwork for a journal post. Each motif is a considered composition
 * in a 1600 x 900 space, cropped to whatever the plate needs.
 */
function editorial( { motif, tone = '#1b3047', accent = '#5980a6', glow = '#94bce3', label = '' } ) {
	const motifs = {
		// A content model: three types, their fields, and the relationships
		// that let the site assemble itself.
		nodes: `
			<g stroke="${ glow }" stroke-width="1.5" opacity=".45" fill="none">
				<path d="M430 360 C 600 300 700 460 830 500"/>
				<path d="M830 500 C 980 470 1060 360 1180 320"/>
				<path d="M430 360 C 640 200 980 190 1180 320"/>
				<path d="M300 190 L430 360"/><path d="M232 520 L430 360"/><path d="M420 640 L430 360"/>
				<path d="M700 700 L830 500"/><path d="M990 660 L830 500"/>
				<path d="M1330 500 L1180 320"/><path d="M1290 160 L1180 320"/>
			</g>
			<g fill="${ accent }" opacity=".85">
				<circle cx="300" cy="190" r="17"/><circle cx="232" cy="520" r="13"/><circle cx="420" cy="640" r="15"/>
				<circle cx="700" cy="700" r="14"/><circle cx="990" cy="660" r="17"/>
				<circle cx="1330" cy="500" r="13"/><circle cx="1290" cy="160" r="16"/>
			</g>
			<circle cx="430" cy="360" r="52" fill="${ accent }" opacity=".9"/>
			<circle cx="830" cy="500" r="64" fill="${ glow }"/>
			<circle cx="1180" cy="320" r="46" fill="${ accent }" opacity=".9"/>
			<circle cx="830" cy="500" r="96" fill="none" stroke="${ glow }" stroke-width="1.5" opacity=".5"/>`,

		// A page-weight budget: the line comes down and stays under the cap.
		area: `
			<g stroke="${ glow }" stroke-width="1" opacity=".18">
				${ [ 220, 360, 500, 640 ].map( ( y ) => `<line x1="150" y1="${ y }" x2="1450" y2="${ y }"/>` ).join( '' ) }
			</g>
			<path d="M150 300 L310 250 L470 380 L630 330 L790 470 L950 430 L1110 560 L1270 530 L1450 610 L1450 760 L150 760 Z"
				fill="url(#fade)"/>
			<polyline points="150,300 310,250 470,380 630,330 790,470 950,430 1110,560 1270,530 1450,610"
				fill="none" stroke="${ glow }" stroke-width="5" stroke-linejoin="round" stroke-linecap="round"/>
			<line x1="150" y1="430" x2="1450" y2="430" stroke="#eef6ff" stroke-width="2.5" stroke-dasharray="12 10" opacity=".85"/>
			<g fill="#eef6ff">
				${ [ [ 310, 250 ], [ 630, 330 ], [ 950, 430 ], [ 1270, 530 ] ].map( ( [ x, y ] ) => `<circle cx="${ x }" cy="${ y }" r="9"/>` ).join( '' ) }
			</g>`,

		// A migration: many old URLs resolving into a few destinations.
		flow: `
			<g fill="none" stroke="${ glow }">
				${ Array.from( { length: 11 }, ( _, i ) => {
					const y = 120 + i * 66;
					const t = 250 + ( i % 3 ) * 200;
					return `<path d="M0 ${ y } C 520 ${ y } 700 ${ t } 1220 ${ t }" stroke-width="${ 1 + ( i % 3 ) }" opacity="${ 0.18 + ( i % 4 ) * 0.14 }"/>`;
				} ).join( '' ) }
			</g>
			<line x1="1220" y1="60" x2="1220" y2="840" stroke="#eef6ff" stroke-width="1.5" opacity=".35"/>
			<g fill="#eef6ff">
				<circle cx="1220" cy="250" r="13"/><circle cx="1220" cy="450" r="13"/><circle cx="1220" cy="650" r="13"/>
			</g>
			<g fill="${ accent }" opacity=".9">
				<rect x="1300" y="206" width="230" height="88" rx="4"/>
				<rect x="1300" y="406" width="230" height="88" rx="4"/>
				<rect x="1300" y="606" width="230" height="88" rx="4"/>
			</g>`,

		// A pattern library: a modular grid where a few cells carry the weight.
		modules: `
			${ [
				[ 150, 130, 380, 240, 0.22 ], [ 560, 130, 240, 240, 0.4 ], [ 830, 130, 240, 110, 0.16 ],
				[ 830, 270, 240, 100, 0.3 ], [ 1100, 130, 350, 240, 1 ],
				[ 150, 400, 240, 190, 0.3 ], [ 420, 400, 380, 190, 0.16 ], [ 830, 400, 240, 190, 0.5 ],
				[ 1100, 400, 350, 190, 0.22 ],
				[ 150, 620, 650, 150, 0.4 ], [ 830, 620, 240, 150, 0.16 ], [ 1100, 620, 350, 150, 0.3 ],
			].map( ( [ x, y, w, h, o ] ) => o === 1
				? `<rect x="${ x }" y="${ y }" width="${ w }" height="${ h }" rx="4" fill="${ glow }"/>`
				: `<rect x="${ x }" y="${ y }" width="${ w }" height="${ h }" rx="4" fill="${ accent }" opacity="${ o }"/>` ).join( '' ) }
			<rect x="1140" y="170" width="270" height="14" rx="7" fill="${ tone }" opacity=".55"/>
			<rect x="1140" y="206" width="180" height="14" rx="7" fill="${ tone }" opacity=".35"/>`,

		// The contract between tokens, patterns and templates.
		rings: `
			<g fill="none" stroke="${ glow }">
				<circle cx="800" cy="450" r="330" stroke-width="1" opacity=".28"/>
				<circle cx="800" cy="450" r="250" stroke-width="1.5" opacity=".5"/>
				<circle cx="800" cy="450" r="170" stroke-width="2" opacity=".75"/>
			</g>
			<path d="M800 450 L800 120 A330 330 0 0 1 1085 615 Z" fill="${ accent }" opacity=".45"/>
			<circle cx="800" cy="450" r="90" fill="${ glow }"/>
			<g stroke="${ glow }" stroke-width="2" opacity=".6">
				${ Array.from( { length: 36 }, ( _, i ) => {
					const a = ( i * 10 * Math.PI ) / 180;
					const r1 = i % 3 === 0 ? 344 : 352;
					return `<line x1="${ 800 + Math.cos( a ) * r1 }" y1="${ 450 + Math.sin( a ) * r1 }" x2="${ 800 + Math.cos( a ) * 368 }" y2="${ 450 + Math.sin( a ) * 368 }"/>`;
				} ).join( '' ) }
			</g>`,

		// Discovery: questions radiating out, one of them longer than the rest.
		spokes: `
			<g stroke="${ glow }" stroke-linecap="round">
				${ Array.from( { length: 9 }, ( _, i ) => {
					const a = ( -80 + i * 9 ) * Math.PI / 180;
					const len = [ 520, 620, 470, 700, 560, 880, 500, 640, 540 ][ i ];
					const x = 210 + Math.cos( a ) * len;
					const y = 760 + Math.sin( a ) * len;
					const hot = i === 5;
					return `<line x1="210" y1="760" x2="${ x }" y2="${ y }" stroke-width="${ hot ? 4 : 2 }" opacity="${ hot ? 1 : 0.35 }"/>
						<circle cx="${ x }" cy="${ y }" r="${ hot ? 16 : 9 }" fill="${ hot ? '#eef6ff' : accent }" opacity="${ hot ? 1 : 0.8 }"/>`;
				} ).join( '' ) }
			</g>
			<circle cx="210" cy="760" r="26" fill="${ glow }"/>`,

		// A type specimen with its metrics drawn in.
		type: `
			<g stroke="${ glow }" stroke-width="1.5" opacity=".38">
				<line x1="120" y1="240" x2="1480" y2="240"/>
				<line x1="120" y1="330" x2="1480" y2="330"/>
				<line x1="120" y1="660" x2="1480" y2="660"/>
				<line x1="120" y1="740" x2="1480" y2="740"/>
			</g>
			<text x="800" y="660" text-anchor="middle" font-family="Barlow Condensed" font-weight="700"
				font-size="600" fill="${ accent }" opacity=".95">Aa</text>
			<text x="800" y="660" text-anchor="middle" font-family="Barlow" font-weight="400"
				font-size="600" fill="${ glow }" opacity=".30">Aa</text>
			<g fill="${ glow }" font-family="Barlow Condensed" font-size="22" letter-spacing="3" opacity=".7">
				<text x="120" y="228">CAP</text><text x="120" y="318">X-HEIGHT</text>
				<text x="120" y="648">BASELINE</text><text x="120" y="728">DESCENDER</text>
			</g>`,

		// Editor training: four steps, each one landing higher than the last.
		steps: `
			<g stroke="${ glow }" stroke-width="1" opacity=".16">
				${ Array.from( { length: 7 }, ( _, i ) => `<line x1="${ 180 + i * 210 }" y1="120" x2="${ 180 + i * 210 }" y2="780"/>` ).join( '' ) }
			</g>
			<path d="M180 700 H390 V580 H600 V580 H810 V440 H1020 V440 H1230 V290 H1440"
				fill="none" stroke="${ glow }" stroke-width="5" stroke-linejoin="round"/>
			<path d="M180 700 H390 V580 H810 V440 H1230 V290 H1440 V780 H180 Z" fill="url(#fade)"/>
			<g fill="#eef6ff">
				${ [ [ 390, 580 ], [ 810, 440 ], [ 1230, 290 ] ].map( ( [ x, y ] ) => `<rect x="${ x - 12 }" y="${ y - 12 }" width="24" height="24" rx="3"/>` ).join( '' ) }
			</g>
			<circle cx="180" cy="700" r="14" fill="${ accent }"/>`,
	};

	return `
	<div class="stage" style="background:radial-gradient(110% 90% at 26% 8%,${ tone },#091220 92%)">
		<svg viewBox="0 0 1600 900" preserveAspectRatio="xMidYMid slice" width="100%" height="100%"
			style="position:absolute;inset:0">
			<defs>
				<linearGradient id="fade" x1="0" y1="0" x2="0" y2="1">
					<stop offset="0" stop-color="${ accent }" stop-opacity=".55"/>
					<stop offset="1" stop-color="${ accent }" stop-opacity="0"/>
				</linearGradient>
			</defs>
			${ motifs[ motif ] }
		</svg>
		${ label ? `<div style="position:absolute;left:44px;bottom:36px">${ kicker( label, 'rgba(238,246,255,.6)', 13 ) }</div>` : '' }
		<div class="grain"></div><div class="vig"></div>
	</div>`;
}

/**
 * A wide studio plate: overlapping planes, an accent arc and a horizon.
 */
function studioPlate( { label = '', tall = false } ) {
	return `
	<div class="stage" style="background:linear-gradient(165deg,#1c3247,#0c1721 70%)">
		<svg width="100%" height="100%" style="position:absolute;inset:0">
			<defs>
				<linearGradient id="g1" x1="0" y1="0" x2="1" y2="1">
					<stop offset="0" stop-color="#5980a6" stop-opacity=".9"/><stop offset="1" stop-color="#5980a6" stop-opacity=".15"/>
				</linearGradient>
				<linearGradient id="g2" x1="0" y1="1" x2="1" y2="0">
					<stop offset="0" stop-color="#94bce3" stop-opacity=".55"/><stop offset="1" stop-color="#94bce3" stop-opacity="0"/>
				</linearGradient>
			</defs>
			<circle cx="${ tall ? '62%' : '68%' }" cy="${ tall ? '30%' : '26%' }" r="${ tall ? '34%' : '30%' }" fill="url(#g1)"/>
			<rect x="${ tall ? '10%' : '8%' }" y="${ tall ? '40%' : '38%' }" width="${ tall ? '52%' : '40%' }" height="${ tall ? '34%' : '44%' }" fill="url(#g2)"/>
			<rect x="${ tall ? '30%' : '30%' }" y="${ tall ? '52%' : '50%' }" width="${ tall ? '56%' : '44%' }" height="${ tall ? '30%' : '38%' }" fill="#eef6ff" opacity=".10"/>
			<line x1="0" y1="${ tall ? '78%' : '76%' }" x2="100%" y2="${ tall ? '78%' : '76%' }" stroke="#94bce3" stroke-width="1" opacity=".45"/>
			<line x1="${ tall ? '30%' : '30%' }" y1="0" x2="${ tall ? '30%' : '30%' }" y2="100%" stroke="#94bce3" stroke-width="1" opacity=".2"/>
		</svg>
		${ label ? `<div style="position:absolute;left:40px;bottom:34px">${ kicker( label, 'rgba(238,246,255,.6)', 13 ) }</div>` : '' }
		<div class="grain"></div><div class="vig"></div>
	</div>`;
}

/** A phone against a coloured ground — the ticketing and commerce cases. */
function phoneMock( { accent = C.accent, title = 'Book a ticket', ground = '#16303f', rows = [] } ) {
	return `
	<div class="stage col" style="background:radial-gradient(90% 80% at 32% 8%,${ ground },#0a141d);align-items:center;justify-content:center">
		<div style="position:absolute;width:44%;height:74%;border-radius:26px;background:rgba(148,188,227,.10);
			transform:rotate(-7deg) translateX(-12%)"></div>
		<div class="col" style="width:34%;height:90%;border-radius:36px;background:#f6f7f8;padding:16px 16px 18px;
			box-shadow:0 50px 100px rgba(4,10,16,.6);position:relative;z-index:1">
			<div style="width:34%;height:5px;border-radius:3px;background:#d3d9de;margin:2px auto 16px"></div>

			<div class="row" style="align-items:center;gap:10px;margin-bottom:14px">
				<span style="width:22px;height:22px;border-radius:50%;background:#e6eaee"></span>
				<span class="h" style="font-size:20px;color:${ C.ink }">${ title }</span>
			</div>

			<div class="row" style="gap:8px;margin-bottom:16px">
				${ [ 'Today', '1 adult', 'Return' ].map( ( t ) => `
					<span class="h" style="flex:1;text-align:center;font-size:12px;letter-spacing:.06em;text-transform:uppercase;
						color:${ C.accentDeep };background:#eaeff4;padding:8px 0;border-radius:3px">${ t }</span>` ).join( '' ) }
			</div>

			<div class="col" style="gap:9px">
				${ rows.map( ( r, i ) => `
					<div class="col" style="padding:13px 14px;border:1px solid ${ i === 0 ? accent : 'rgba(29,31,32,.12)' };
						background:${ i === 0 ? C.accentTint : '#fff' };border-radius:3px;gap:6px">
						<div class="row" style="align-items:baseline;justify-content:space-between">
							<span class="h" style="font-size:17px;color:${ C.ink }">${ r[ 0 ] }</span>
							<span class="h" style="font-size:17px;color:${ i === 0 ? C.accentDeep : C.ink }">${ r[ 1 ] }</span>
						</div>
						<span style="font-size:12px;color:rgba(29,31,32,.5)">${ r[ 2 ] }</span>
					</div>` ).join( '' ) }
			</div>

			<div class="fill"></div>

			<div class="col" style="gap:8px;padding-top:14px;border-top:1px solid rgba(29,31,32,.12);margin-bottom:12px">
				${ [ [ 'Fare', '£14.20' ], [ 'Reservation', 'Free' ] ].map( ( [ a, b ] ) => `
					<div class="row" style="justify-content:space-between">
						<span style="font-size:13px;color:rgba(29,31,32,.55)">${ a }</span>
						<span style="font-size:13px;color:${ C.ink }">${ b }</span>
					</div>` ).join( '' ) }
				<div class="row" style="justify-content:space-between;margin-top:2px">
					<span class="h" style="font-size:16px;color:${ C.ink }">Total</span>
					<span class="h" style="font-size:22px;color:${ C.ink }">£14.20</span>
				</div>
			</div>

			<div class="h" style="font-size:13px;letter-spacing:.1em;text-transform:uppercase;color:#fff;background:${ accent };
				padding:15px;text-align:center;border-radius:3px">Continue to payment</div>
		</div>
		<div class="grain"></div><div class="vig"></div>
	</div>`;
}

/** A design-system plate: swatches, type scale and components. */
function systemPlate( { accent = C.accent } ) {
	const swatches = [ '#eef6ff', '#b5d9fd', '#5980a6', '#416180', '#1d2d3d', '#6d7f57', '#a05c3c', '#4a4f7a' ];
	return `
	<div class="stage" style="background:linear-gradient(160deg,#f4f5f6,#dfe4e8)">
		<div class="col" style="position:absolute;inset:9%;gap:26px">
			${ kicker( 'Design system · 41 components', C.accentDeep, 13 ) }
			<div class="row" style="gap:10px">
				${ swatches.map( ( s ) => `<div style="flex:1;height:64px;background:${ s };border-radius:2px"></div>` ).join( '' ) }
			</div>
			<div class="row" style="gap:26px;align-items:flex-end">
				${ [ 56, 40, 28, 20, 15 ].map( ( s ) => `<span class="h" style="font-size:${ px( s ) };color:${ C.ink }">Aa</span>` ).join( '' ) }
				<div class="fill"></div>
				<div class="row" style="gap:8px">
					<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:#fff;background:${ accent };padding:10px 18px">Primary</span>
					<span class="h" style="font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:${ C.ink };border:1px solid rgba(29,31,32,.18);padding:10px 18px">Secondary</span>
				</div>
			</div>
			<div class="row fill" style="gap:14px">
				${ [ 'Card', 'Table', 'Form', 'Nav' ].map( ( t ) => `
					<div class="col fill" style="background:#fff;border:1px solid rgba(29,31,32,.10);padding:18px;gap:10px">
						<span class="h" style="font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:${ C.accentDeep }">${ t }</span>
						${ lines( 4, { h: 6, gap: 8 } ) }
					</div>` ).join( '' ) }
			</div>
		</div>
		<div class="grain" style="opacity:.2"></div>
	</div>`;
}

/** A faceted archive — the heritage catalogue. */
function archivePlate() {
	return `
	<div class="stage" style="background:linear-gradient(160deg,#101d29,#0a131b)">
		<div class="row" style="position:absolute;inset:8%;gap:26px">
			<div class="col" style="width:26%;gap:14px">
				${ kicker( 'Facets', 'rgba(238,246,255,.5)', 11 ) }
				${ [ [ 'Period', 7 ], [ 'Place', 12 ], [ 'Material', 5 ], [ 'Maker', 9 ], [ 'Collection', 4 ] ].map( ( [ t, n ], i ) => `
					<div class="row" style="align-items:center;justify-content:space-between;padding:10px 12px;border:1px solid ${ i === 1 ? C.accent : 'rgba(238,246,255,.14)' };background:${ i === 1 ? 'rgba(89,128,166,.22)' : 'transparent' }">
						<span class="h" style="font-size:14px;font-weight:400;color:#eef6ff">${ t }</span>
						<span style="font-size:12px;color:rgba(238,246,255,.5)">${ n }</span>
					</div>` ).join( '' ) }
			</div>
			<div class="col fill" style="gap:12px">
				<div class="row" style="align-items:center;justify-content:space-between">
					${ kicker( '12,043 records · 180 ms', 'rgba(238,246,255,.5)', 11 ) }
				</div>
				<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;flex:1">
					${ Array.from( { length: 12 }, ( _, i ) => `
						<div class="col" style="border:1px solid rgba(238,246,255,.12);overflow:hidden">
							<div class="ph ${ [ '', 'light', 'clay', 'sage', 'indigo' ][ i % 5 ] }" style="flex:1"></div>
							<div style="padding:8px 9px">${ lines( 1, { h: 5, gap: 0, color: 'rgba(238,246,255,.22)', w: 78 } ) }</div>
						</div>` ).join( '' ) }
				</div>
			</div>
		</div>
		<div class="grain"></div><div class="vig"></div>
	</div>`;
}

/** A configurator — the Brayton case. */
function configuratorPlate() {
	return `
	<div class="stage" style="background:linear-gradient(160deg,#22333f,#0d161d)">
		<div class="row" style="position:absolute;inset:9%;gap:30px;align-items:stretch">
			<div class="col fill" style="justify-content:center;align-items:center;position:relative">
				<svg viewBox="0 0 400 240" width="100%">
					<g fill="none" stroke="#94bce3" stroke-width="3" stroke-linecap="round">
						<circle cx="96" cy="168" r="52" opacity=".9"/>
						<circle cx="304" cy="168" r="52" opacity=".9"/>
						<path d="M96 168 L168 78 L262 78 L304 168 L188 168 Z" opacity=".95"/>
						<path d="M168 78 L188 168" opacity=".95"/>
						<path d="M262 78 L246 44 L214 44" opacity=".8"/>
						<path d="M150 62 L186 62" opacity=".8"/>
					</g>
					<circle cx="96" cy="168" r="10" fill="#5980a6"/>
					<circle cx="304" cy="168" r="10" fill="#5980a6"/>
				</svg>
			</div>
			<div class="col" style="width:32%;gap:10px;justify-content:center">
				${ kicker( 'Configure', 'rgba(238,246,255,.55)', 11 ) }
				${ [ [ 'Frame', 'Steel 853' ], [ 'Gearing', '1×11' ], [ 'Wheels', '650b' ], [ 'Finish', 'Slate' ] ].map( ( [ a, b ], i ) => `
					<div class="row" style="align-items:center;justify-content:space-between;padding:11px 13px;border:1px solid ${ i === 3 ? C.accent : 'rgba(238,246,255,.14)' };background:${ i === 3 ? 'rgba(89,128,166,.2)' : 'transparent' }">
						<span class="h" style="font-size:14px;font-weight:400;color:rgba(238,246,255,.72)">${ a }</span>
						<span class="h" style="font-size:15px;color:#eef6ff">${ b }</span>
					</div>` ).join( '' ) }
				<div class="row" style="align-items:baseline;justify-content:space-between;margin-top:8px;padding-top:12px;border-top:1px solid rgba(238,246,255,.16)">
					<span class="h" style="font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:rgba(238,246,255,.5)">Estimate</span>
					<span class="h" style="font-size:30px;color:#eef6ff">£2,840</span>
				</div>
			</div>
		</div>
		<div class="grain"></div><div class="vig"></div>
	</div>`;
}

/** The social card. */

/* ------------------------------------------------------------------- specs */

const SPECS = [
	/* Hero and studio plates. */
	{ file: 'hero-studio.jpg', w: 1200, h: 1500, html: () => studioPlate( { label: 'Northline studio — Bristol', tall: true } ) },
	{ file: 'studio-room.jpg', w: 1400, h: 1120, html: () => studioPlate( { label: 'The studio' } ) },

	/* Case-study covers. */
	{ file: 'project-northgate-health.jpg', w: 1400, h: 1050, html: () => siteMock( { variant: 'services', brand: 'Northgate', kick: 'Private healthcare', title: 'Find the treatment you need.', nav: [ 'Treatments', 'Consultants', 'Locations' ], cta: 'Book', url: 'northgatehealth.example', accent: '#3f7d8c' } ) },
	{ file: 'project-fieldnote.jpg', w: 1400, h: 1050, html: () => siteMock( { variant: 'editorial', brand: 'Fieldnote', kick: 'Long read', title: 'The quiet economics of small publishers.', nav: [ 'Latest', 'Series', 'About' ], cta: 'Subscribe', dark: true, url: 'fieldnote.example' } ) },
	{ file: 'project-kelso-rail.jpg', w: 1400, h: 1050, html: () => phoneMock( { title: 'Bristol → Cardiff', ground: '#1b3446', rows: [ [ '09:42', '£14.20', 'Direct · 52 min · Platform 3' ], [ '10:08', '£11.60', '1 change at Newport · 1 h 04' ], [ '10:42', '£14.20', 'Direct · 52 min · Platform 5' ], [ '11:12', '£16.80', 'Direct · 49 min · Platform 3' ] ] } ) },
	{ file: 'project-halcyon.jpg', w: 1400, h: 1050, html: () => siteMock( { variant: 'onepage', brand: 'Halcyon', kick: 'Product launch', title: 'Ship your roadmap, not your backlog.', nav: [ 'Product', 'Pricing', 'Docs' ], cta: 'Try free', accent: C.indigo, url: 'halcyon.example' } ) },
	{ file: 'project-merrick-co.jpg', w: 1400, h: 1050, html: () => systemPlate( {} ) },
	{ file: 'project-sablefield.jpg', w: 1400, h: 1050, html: () => siteMock( { variant: 'commerce', brand: 'Sablefield', kick: 'Roastery', title: 'Coffee, every other Thursday.', nav: [ 'Shop', 'Subscribe', 'Roastery' ], cta: 'Basket', accent: C.clay, url: 'sablefield.example' } ) },
	{ file: 'project-ordnance-trust.jpg', w: 1400, h: 1050, html: () => archivePlate() },
	{ file: 'project-loom-analytics.jpg', w: 1400, h: 1050, html: () => siteMock( { variant: 'docs', brand: 'Loom', kick: 'Documentation', title: 'Querying the events API', nav: [ 'Product', 'Docs', 'Pricing' ], cta: 'Sign in', dark: true, url: 'docs.loom.example' } ) },
	{ file: 'project-brayton-cycles.jpg', w: 1400, h: 1050, html: () => configuratorPlate() },

	/* Wide case-study hero and inline details. */
	{ file: 'case-northgate-hero.jpg', w: 1920, h: 1080, html: () => siteMock( { variant: 'services', brand: 'Northgate', kick: 'Treatment', title: 'Cardiology, explained plainly.', nav: [ 'Treatments', 'Consultants', 'Locations' ], cta: 'Book', accent: '#3f7d8c', url: 'northgatehealth.example/treatments' } ) },
	{ file: 'case-detail-template.jpg', w: 1200, h: 900, html: () => siteMock( { variant: 'multisite', brand: 'Northgate', kick: 'Locations', title: 'Nine clinics, one content model.', nav: [ 'Treatments', 'Locations' ], cta: 'Book', accent: '#3f7d8c', url: 'northgatehealth.example/locations' } ) },
	{ file: 'case-detail-editor.jpg', w: 1200, h: 900, html: () => siteMock( { variant: 'docs', brand: 'Northgate', kick: 'Editor guide', title: 'Adding a treatment page', nav: [ 'Guide' ], cta: 'Publish', accent: '#3f7d8c', url: 'northgatehealth.example/wp-admin' } ) },

	/* Team portraits. */
	{ file: 'team-maya-iyer.jpg', w: 900, h: 900, html: () => portrait( { skin: '#c98d63', shade: '#b47a52', hair: '#241b17', clothes: C.sage, bg: '#e6ebe1', arc: '#d3ddc9', style: 'bun' } ) },
	{ file: 'team-daniel-okoro.jpg', w: 900, h: 900, html: () => portrait( { skin: '#8a5636', shade: '#77462a', hair: '#1a1512', beard: true, clothes: C.clay, bg: '#f0e5de', arc: '#e3cec2', style: 'short' } ) },
	{ file: 'team-sofia-lindqvist.jpg', w: 900, h: 900, html: () => portrait( { skin: '#e8bd9a', shade: '#d7a986', hair: '#c9a26a', clothes: C.indigo, bg: '#e4e7ef', arc: '#d2d7e6', style: 'bob' } ) },
	{ file: 'team-ben-trawick.jpg', w: 900, h: 900, html: () => portrait( { skin: '#dda882', shade: '#c9946f', hair: '#6b4a32', beard: true, clothes: C.accent, bg: '#e5ebf0', arc: '#cfdbe6', style: 'short' } ) },
	{ file: 'team-priya-raman.jpg', w: 900, h: 900, html: () => portrait( { skin: '#b97c50', shade: '#a56b41', hair: '#1e1714', clothes: C.accentDeep, bg: '#e9e6ee', arc: '#d8d3e3', style: 'long' } ) },
	{ file: 'team-iwan-petrov.jpg', w: 900, h: 900, html: () => portrait( { skin: '#c99a72', shade: '#b5865f', hair: '#2b2320', clothes: '#4b5a66', bg: '#e2e8ec', arc: '#ccd8e0', style: 'short' } ) },

	/* Journal covers. */
	{ file: 'post-content-models.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'nodes', label: 'Content models' } ) },
	{ file: 'post-performance-budget.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'area', label: 'Performance budget' } ) },
	{ file: 'post-migrating-400-pages.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'flow', label: 'Migration' } ) },
	{ file: 'post-twelve-patterns.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'modules', label: 'Twelve patterns' } ) },
	{ file: 'post-block-patterns-contract.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'rings', label: 'Design system contract' } ) },
	{ file: 'post-discovery-questions.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'spokes', tone: '#22344a', label: 'Discovery' } ) },
	{ file: 'post-web-fonts-layout-shift.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'type', label: 'Web fonts' } ) },
	{ file: 'post-editor-training.jpg', w: 1600, h: 900, html: () => editorial( { motif: 'steps', tone: '#1f3242', label: 'Editor training' } ) },
	{ file: 'post-content-models-wide.jpg', w: 1920, h: 823, html: () => editorial( { motif: 'nodes', label: 'One model, ninety pages' } ) },

	/* Theme screenshots. */
	{ file: 'theme-ledger.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'services', brand: 'Ledger', kick: 'Professional services', title: 'Advice that holds up under scrutiny.', url: 'ledger.example' } ) },
	{ file: 'theme-ledger-pro.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'services', brand: 'Ledger', kick: 'Professional services', title: 'Counsel for complex questions.', nav: [ 'Services', 'Team', 'Shop', 'Journal' ], cta: 'Enquire', accent: C.accentDeep, phTone: 'light', url: 'ledgerpro.example' } ) },
	{ file: 'theme-wharf.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'editorial', brand: 'Wharf', kick: 'Essay', title: 'What we lost when pages became feeds.', nav: [ 'Latest', 'Archive', 'About' ], cta: 'Subscribe', url: 'wharf.example' } ) },
	{ file: 'theme-kelpie.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'commerce', brand: 'Kelpie', kick: 'Storefront', title: 'A small shop, properly built.', nav: [ 'Shop', 'Collections', 'About' ], cta: 'Basket', accent: C.sage, url: 'kelpie.example' } ) },
	{ file: 'theme-wharf-pro.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'editorial', brand: 'Wharf', kick: 'Members', title: 'The paywall that readers forgive.', nav: [ 'Latest', 'Members', 'Archive' ], cta: 'Join', dark: true, url: 'wharfpro.example' } ) },
	{ file: 'theme-signal.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'onepage', brand: 'Signal', kick: 'Launching soon', title: 'One page. One thing to say.', nav: [ 'Features', 'Pricing', 'FAQ' ], cta: 'Get early access', url: 'signal.example' } ) },
	{ file: 'theme-kelpie-pro.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'commerce', brand: 'Kelpie', kick: 'Subscriptions', title: 'Sell the second order, not the first.', nav: [ 'Shop', 'Subscribe', 'Account' ], cta: 'Basket', accent: C.clay, dark: true, url: 'kelpiepro.example' } ) },
	{ file: 'theme-fieldbook.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'docs', brand: 'Fieldbook', kick: 'Documentation', title: 'Installing the theme', nav: [ 'Docs', 'API', 'Changelog' ], cta: 'GitHub', url: 'fieldbook.example' } ) },
	{ file: 'theme-atlas.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'multisite', brand: 'Atlas', kick: 'Group', title: 'Forty-eight sites, one system.', nav: [ 'Locations', 'Group', 'Careers' ], cta: 'Find us', accent: C.indigo, url: 'atlas.example' } ) },

	/* Product gallery. */
	{ file: 'product-ledger-pro-main.jpg', w: 1600, h: 900, html: () => siteMock( { variant: 'services', brand: 'Ledger', kick: 'Front page', title: 'Counsel for complex questions.', accent: C.accentDeep, url: 'ledgerpro.example' } ) },
	{ file: 'product-ledger-pro-01.jpg', w: 800, h: 600, html: () => siteMock( { variant: 'multisite', brand: 'Ledger', kick: 'Locations', title: 'Six offices.', nav: [ 'Services' ], cta: 'Enquire', accent: C.accentDeep, url: 'ledgerpro.example' } ) },
	{ file: 'product-ledger-pro-02.jpg', w: 800, h: 600, html: () => siteMock( { variant: 'commerce', brand: 'Ledger', kick: 'Shop', title: 'Templates.', nav: [ 'Shop' ], cta: 'Basket', accent: C.accentDeep, url: 'ledgerpro.example/shop' } ) },
	{ file: 'product-ledger-pro-03.jpg', w: 800, h: 600, html: () => siteMock( { variant: 'onepage', brand: 'Ledger', kick: 'Pricing', title: 'Three plans.', nav: [ 'Pricing' ], cta: 'Buy', accent: C.accentDeep, url: 'ledgerpro.example/pricing' } ) },
	{ file: 'product-ledger-pro-04.jpg', w: 800, h: 600, html: () => siteMock( { variant: 'editorial', brand: 'Ledger', kick: 'Journal', title: 'Notes.', nav: [ 'Journal' ], cta: 'Subscribe', accent: C.accentDeep, url: 'ledgerpro.example/journal' } ) },

	/* Documentation. */
	{ file: 'docs-site-editor.jpg', w: 1600, h: 1000, html: () => siteMock( { variant: 'docs', brand: 'Northline', kick: 'Site Editor', title: 'Editing a template part', nav: [ 'Docs', 'Patterns' ], cta: 'Save', url: 'northline.co/wp-admin/site-editor.php' } ) },
	{ file: 'docs-walkthrough.jpg', w: 1600, h: 900, html: () => siteMock( { variant: 'onepage', brand: 'Northline', kick: 'Walkthrough · part 1', title: 'Building a page from patterns.', nav: [ 'Docs', 'Video' ], cta: 'Watch', dark: true, url: 'northline.co/docs/video' } ) },

	/* Social card and theme screenshot. */
	{
		file: 'og-default.jpg',
		w: 1200,
		h: 630,
		html: () => `
		<div class="stage col" style="background:linear-gradient(150deg,#1d3348,#0b1520);justify-content:center;padding:0 74px">
			<div class="row" style="align-items:center;gap:14px;margin-bottom:26px">
				<span style="position:relative;width:26px;height:26px;border:2px solid #eef6ff;display:block">
					<span style="position:absolute;inset:5px;background:${ C.accent };display:block"></span></span>
				<span class="h" style="font-size:24px;letter-spacing:.1em;text-transform:uppercase;color:#eef6ff">Northline</span>
			</div>
			<div class="h" style="font-size:74px;line-height:.98;color:#eef6ff;max-width:17ch">Websites that work as hard as your team.</div>
			<div style="font-size:22px;color:rgba(238,246,255,.6);margin-top:22px">Web design &amp; development studio · Bristol</div>
			<div class="grain"></div>
		</div>`,
	},
	{ file: '../../screenshot.png', w: 1200, h: 900, type: 'png', html: () => siteMock( { variant: 'services', brand: 'Northline', kick: 'Web design & development studio', title: 'Websites that work as hard as your team.', nav: [ 'Work', 'Services', 'Studio', 'Journal' ], cta: 'Book a call', url: 'northline.co' } ) },
];

/* ------------------------------------------------------------------ render */

const filter = process.argv[ 2 ] || '';
const jobs = SPECS.filter( ( s ) => ! filter || s.file.includes( filter ) );

if ( ! existsSync( OUT ) ) {
	mkdirSync( OUT, { recursive: true } );
}

const browserInstance = await chromium.launch( { executablePath: '/opt/pw-browsers/chromium' } );
const page = await browserInstance.newPage( { deviceScaleFactor: 1 } );

let total = 0;

for ( const spec of jobs ) {
	await page.setViewportSize( { width: spec.w, height: spec.h } );
	await page.setContent(
		`<!doctype html><html><head><meta charset="utf-8"><style>${ FONTS }${ BASE }</style></head><body>${ spec.html() }</body></html>`,
		{ waitUntil: 'load' }
	);
	await page.evaluate( () => document.fonts.ready );

	const path = join( OUT, spec.file );
	await page.screenshot(
		spec.type === 'png'
			? { path, type: 'png' }
			: { path, type: 'jpeg', quality: 84 }
	);

	const size = statSync( path ).size;
	total += size;
	console.log( `${ spec.file.padEnd( 34 ) } ${ String( spec.w ).padStart( 5 ) } x ${ String( spec.h ).padEnd( 5 ) } ${ String( size ).padStart( 8 ) } bytes` );
}

await browserInstance.close();
console.log( `\n${ jobs.length } images, ${ ( total / 1024 / 1024 ).toFixed( 1 ) } MB total.` );
