<?php
/**
 * Northline — image generator.
 *
 * Draws every image the theme and its demo content need, in the blueprint
 * house style, straight to northline/assets/images/. Deterministic: the same
 * seed always produces the same picture, so re-running this never churns the
 * repository.
 *
 * Usage:  php tools/generate-images.php
 */

const OUT = __DIR__ . '/../northline/assets/images';

/* ---------------------------------------------------------------- palettes */

$PALETTES = array(
	// Deep blueprint — stands in for photography.
	'ink'   => array(
		'bg'   => array( 0x14, 0x1f, 0x2b ),
		'bg2'  => array( 0x22, 0x3a, 0x51 ),
		'mid'  => array( 0x35, 0x5b, 0x7d ),
		'line' => array( 0x8d, 0xb6, 0xdc ),
		'hi'   => array( 0xdf, 0xec, 0xfa ),
	),
	// Paper blueprint — stands in for interface screenshots.
	'paper' => array(
		'bg'   => array( 0xe6, 0xe9, 0xec ),
		'bg2'  => array( 0xd2, 0xdc, 0xe6 ),
		'mid'  => array( 0xa9, 0xbe, 0xd2 ),
		'line' => array( 0x4f, 0x74, 0x97 ),
		'hi'   => array( 0x1d, 0x2d, 0x3d ),
	),
	// Mid slate — used for the wider hero plates.
	'slate' => array(
		'bg'   => array( 0x27, 0x3b, 0x4e ),
		'bg2'  => array( 0x35, 0x51, 0x6c ),
		'mid'  => array( 0x4c, 0x73, 0x96 ),
		'line' => array( 0xa8, 0xc8, 0xe6 ),
		'hi'   => array( 0xee, 0xf6, 0xff ),
	),
);

/* ----------------------------------------------------------------- helpers */

function pal( $im, $palette, $key, $alpha = 0 ) {
	global $PALETTES;
	$c     = $PALETTES[ $palette ][ $key ];
	$alpha = max( 0, min( 127, (int) $alpha ) );
	return imagecolorallocatealpha( $im, $c[0], $c[1], $c[2], $alpha );
}

function mix( $im, $palette, $a, $b, $t, $alpha = 0 ) {
	global $PALETTES;
	$x = $PALETTES[ $palette ][ $a ];
	$y = $PALETTES[ $palette ][ $b ];
	$alpha = max( 0, min( 127, (int) $alpha ) );
	return imagecolorallocatealpha(
		$im,
		(int) round( $x[0] + ( $y[0] - $x[0] ) * $t ),
		(int) round( $x[1] + ( $y[1] - $x[1] ) * $t ),
		(int) round( $x[2] + ( $y[2] - $x[2] ) * $t ),
		$alpha
	);
}

function canvas( $w, $h, $palette ) {
	$im = imagecreatetruecolor( $w, $h );
	imagealphablending( $im, true );
	imageantialias( $im, true );
	// Vertical wash from bg2 down to bg.
	for ( $y = 0; $y < $h; $y++ ) {
		$t = $y / max( 1, $h - 1 );
		imageline( $im, 0, $y, $w, $y, mix( $im, $palette, 'bg2', 'bg', $t * 0.9 + 0.05 ) );
	}
	return $im;
}

/** Fine engineering grid across the whole plate. */
function grid( $im, $w, $h, $palette, $step = 34 ) {
	$fine  = pal( $im, $palette, 'line', 108 );
	$heavy = pal( $im, $palette, 'line', 92 );
	for ( $x = 0; $x <= $w; $x += $step ) {
		imageline( $im, $x, 0, $x, $h, ( 0 === ( $x / $step ) % 5 ) ? $heavy : $fine );
	}
	for ( $y = 0; $y <= $h; $y += $step ) {
		imageline( $im, 0, $y, $w, $y, ( 0 === ( $y / $step ) % 5 ) ? $heavy : $fine );
	}
}

/** Diagonal hatching inside a rectangle. */
function hatch( $im, $x1, $y1, $x2, $y2, $col, $gap = 7 ) {
	$span = ( $x2 - $x1 ) + ( $y2 - $y1 );
	for ( $i = -( $y2 - $y1 ); $i < $span; $i += $gap ) {
		$ax = $x1 + $i;
		$ay = $y1;
		$bx = $x1 + $i + ( $y2 - $y1 );
		$by = $y2;
		// Clip to the box.
		if ( $ax < $x1 ) {
			$ay += $x1 - $ax;
			$ax  = $x1;
		}
		if ( $bx > $x2 ) {
			$by -= $bx - $x2;
			$bx  = $x2;
		}
		if ( $ay > $y2 || $by < $y1 || $ax > $x2 || $bx < $x1 ) {
			continue;
		}
		imageline( $im, (int) $ax, (int) $ay, (int) $bx, (int) $by, $col );
	}
}

function rect( $im, $x1, $y1, $x2, $y2, $col ) {
	imagerectangle( $im, (int) $x1, (int) $y1, (int) $x2, (int) $y2, $col );
}

/** Dimension line with end ticks. */
function dimension( $im, $x1, $y1, $x2, $y2, $col ) {
	imageline( $im, $x1, $y1, $x2, $y2, $col );
	if ( $y1 === $y2 ) {
		imageline( $im, $x1, $y1 - 5, $x1, $y1 + 5, $col );
		imageline( $im, $x2, $y2 - 5, $x2, $y2 + 5, $col );
	} else {
		imageline( $im, $x1 - 5, $y1, $x1 + 5, $y1, $col );
		imageline( $im, $x2 - 5, $y2, $x2 + 5, $y2, $col );
	}
}

/** Small technical annotation, drawn with the built-in bitmap face. */
function label( $im, $x, $y, $text, $col, $size = 2 ) {
	imagestring( $im, $size, (int) $x, (int) $y, $text, $col );
}

/** Registration crosses in the four corners. */
function registration( $im, $w, $h, $palette ) {
	$c = pal( $im, $palette, 'line', 40 );
	$m = 26;
	$r = 9;
	$pts = array( array( $m, $m ), array( $w - $m, $m ), array( $m, $h - $m ), array( $w - $m, $h - $m ) );
	foreach ( $pts as $p ) {
		imageline( $im, $p[0] - $r, $p[1], $p[0] + $r, $p[1], $c );
		imageline( $im, $p[0], $p[1] - $r, $p[0], $p[1] + $r, $c );
	}
	rect( $im, $m, $m, $w - $m, $h - $m, pal( $im, $palette, 'line', 112 ) );
}

/** Very light halftone speckle, so flat fills read as printed. */
function halftone( $im, $w, $h, $palette, $step = 6 ) {
	$c = pal( $im, $palette, 'hi', 118 );
	for ( $y = 0; $y < $h; $y += $step ) {
		for ( $x = ( ( $y / $step ) % 2 ) * ( $step / 2 ); $x < $w; $x += $step ) {
			imagesetpixel( $im, (int) $x, (int) $y, $c );
		}
	}
}

/* ------------------------------------------------------------------ scenes */

/** Architectural plan: nested rooms, dimension runs, annotations. */
function scene_plan( $im, $w, $h, $palette ) {
	$line  = pal( $im, $palette, 'line' );
	$soft  = pal( $im, $palette, 'line', 70 );
	$fill  = pal( $im, $palette, 'mid', 96 );
	$hi    = pal( $im, $palette, 'hi' );
	$m     = (int) ( min( $w, $h ) * 0.12 );

	rect( $im, $m, $m, $w - $m, $h - $m, $line );
	rect( $im, $m + 6, $m + 6, $w - $m - 6, $h - $m - 6, $soft );

	$cols = 3;
	$rows = 3;
	$iw   = ( $w - 2 * $m );
	$ih   = ( $h - 2 * $m );
	$used = array();
	for ( $i = 0; $i < 7; $i++ ) {
		$cx = mt_rand( 0, $cols - 1 );
		$cy = mt_rand( 0, $rows - 1 );
		$cw = mt_rand( 1, $cols - $cx );
		$ch = mt_rand( 1, $rows - $cy );
		$key = "$cx-$cy-$cw-$ch";
		if ( isset( $used[ $key ] ) ) {
			continue;
		}
		$used[ $key ] = true;
		$x1 = (int) ( $m + $cx * $iw / $cols + 14 );
		$y1 = (int) ( $m + $cy * $ih / $rows + 14 );
		$x2 = (int) ( $m + ( $cx + $cw ) * $iw / $cols - 14 );
		$y2 = (int) ( $m + ( $cy + $ch ) * $ih / $rows - 14 );
		if ( $x2 - $x1 < 40 || $y2 - $y1 < 40 ) {
			continue;
		}
		imagefilledrectangle( $im, $x1, $y1, $x2, $y2, $fill );
		rect( $im, $x1, $y1, $x2, $y2, $line );
		if ( 0 === $i % 3 ) {
			hatch( $im, $x1 + 2, $y1 + 2, $x2 - 2, $y2 - 2, pal( $im, $palette, 'line', 104 ), 9 );
		}
		label( $im, $x1 + 8, $y1 + 6, sprintf( 'R.%02d', $i + 1 ), $soft, 1 );
	}

	dimension( $im, $m, (int) ( $m * 0.55 ), $w - $m, (int) ( $m * 0.55 ), $soft );
	dimension( $im, (int) ( $m * 0.55 ), $m, (int) ( $m * 0.55 ), $h - $m, $soft );
	label( $im, (int) ( $w / 2 - 30 ), (int) ( $m * 0.55 ) - 18, sprintf( '%d MM', $w * 4 ), $hi, 1 );
}

/** Isometric stack of volumes. */
function scene_iso( $im, $w, $h, $palette ) {
	$line = pal( $im, $palette, 'line' );
	$top  = pal( $im, $palette, 'mid', 40 );
	$left = pal( $im, $palette, 'mid', 88 );
	$rgt  = pal( $im, $palette, 'bg2', 30 );

	$u  = (int) ( min( $w, $h ) / 7 );
	$cx = (int) ( $w / 2 );
	$cy = (int) ( $h * 0.62 );

	$cells = array();
	for ( $i = 0; $i < 9; $i++ ) {
		$cells[] = array( mt_rand( -2, 2 ), mt_rand( -2, 2 ), mt_rand( 1, 3 ) );
	}
	usort(
		$cells,
		function ( $a, $b ) {
			return ( $a[0] + $a[1] ) <=> ( $b[0] + $b[1] );
		}
	);

	foreach ( $cells as $c ) {
		list( $gx, $gy, $gz ) = $c;
		$ox = $cx + ( $gx - $gy ) * $u;
		$oy = $cy + ( $gx + $gy ) * (int) ( $u / 2 ) - $gz * (int) ( $u * 0.55 );
		$hh = $gz * (int) ( $u * 0.55 );

		// Top face.
		$t = array( $ox, $oy - $u / 2, $ox + $u, $oy, $ox, $oy + $u / 2, $ox - $u, $oy );
		imagefilledpolygon( $im, array_map( 'intval', $t ), $top );
		imagepolygon( $im, array_map( 'intval', $t ), $line );
		// Left face.
		$l = array( $ox - $u, $oy, $ox, $oy + $u / 2, $ox, $oy + $u / 2 + $hh, $ox - $u, $oy + $hh );
		imagefilledpolygon( $im, array_map( 'intval', $l ), $left );
		imagepolygon( $im, array_map( 'intval', $l ), $line );
		// Right face.
		$r = array( $ox + $u, $oy, $ox, $oy + $u / 2, $ox, $oy + $u / 2 + $hh, $ox + $u, $oy + $hh );
		imagefilledpolygon( $im, array_map( 'intval', $r ), $rgt );
		imagepolygon( $im, array_map( 'intval', $r ), $line );
	}
}

/** Topographic contours. */
function scene_contour( $im, $w, $h, $palette ) {
	$cx    = $w * ( 0.35 + mt_rand( 0, 30 ) / 100 );
	$cy    = $h * ( 0.35 + mt_rand( 0, 30 ) / 100 );
	$phase = array();
	for ( $k = 0; $k < 5; $k++ ) {
		$phase[ $k ] = mt_rand( 0, 628 ) / 100;
	}
	$rings = 13;
	for ( $r = $rings; $r >= 1; $r-- ) {
		$base = ( min( $w, $h ) * 0.06 ) * $r;
		$col  = ( 0 === $r % 4 )
			? pal( $im, $palette, 'hi', 40 )
			: pal( $im, $palette, 'line', 74 );
		$pts = array();
		for ( $a = 0; $a < 360; $a += 4 ) {
			$rad = deg2rad( $a );
			$n   = 1
				+ 0.16 * sin( 3 * $rad + $phase[0] )
				+ 0.10 * sin( 5 * $rad + $phase[1] )
				+ 0.06 * sin( 8 * $rad + $phase[2] );
			$pts[] = (int) ( $cx + cos( $rad ) * $base * $n * 1.15 );
			$pts[] = (int) ( $cy + sin( $rad ) * $base * $n * 0.9 );
		}
		imagepolygon( $im, $pts, $col );
	}
	imageline( $im, 0, (int) $cy, $w, (int) $cy, pal( $im, $palette, 'line', 100 ) );
	imageline( $im, (int) $cx, 0, (int) $cx, $h, pal( $im, $palette, 'line', 100 ) );
}

/** Interface wireframe — the stand-in for a screenshot. */
function scene_wireui( $im, $w, $h, $palette ) {
	$line = pal( $im, $palette, 'line' );
	$soft = pal( $im, $palette, 'line', 96 );
	$fill = pal( $im, $palette, 'mid', 92 );
	$hi   = pal( $im, $palette, 'hi', 30 );
	$m    = (int) ( $w * 0.055 );
	$bar  = (int) ( $h * 0.085 );

	imagefilledrectangle( $im, $m, $m, $w - $m, $h - $m, pal( $im, $palette, 'bg', 60 ) );
	rect( $im, $m, $m, $w - $m, $h - $m, $line );

	// Chrome bar.
	imagefilledrectangle( $im, $m, $m, $w - $m, $m + $bar, $fill );
	rect( $im, $m, $m, $w - $m, $m + $bar, $line );
	for ( $i = 0; $i < 3; $i++ ) {
		imagefilledellipse( $im, $m + 22 + $i * 18, $m + (int) ( $bar / 2 ), 9, 9, $soft );
	}
	imagefilledrectangle( $im, $m + 92, $m + (int) ( $bar / 2 ) - 5, $m + 250, $m + (int) ( $bar / 2 ) + 5, pal( $im, $palette, 'line', 104 ) );
	for ( $i = 0; $i < 4; $i++ ) {
		$x = $w - $m - 40 - $i * 62;
		imagefilledrectangle( $im, $x - 40, $m + (int) ( $bar / 2 ) - 4, $x, $m + (int) ( $bar / 2 ) + 4, pal( $im, $palette, 'line', 96 ) );
	}

	// Hero band.
	$top = $m + $bar + (int) ( $h * 0.05 );
	$hb  = (int) ( $h * 0.30 );
	imagefilledrectangle( $im, $m + 30, $top, (int) ( $w * 0.55 ), $top + 16, $hi );
	imagefilledrectangle( $im, $m + 30, $top + 34, (int) ( $w * 0.44 ), $top + 46, pal( $im, $palette, 'line', 70 ) );
	for ( $i = 0; $i < 3; $i++ ) {
		imagefilledrectangle( $im, $m + 30, $top + 74 + $i * 18, (int) ( $w * ( 0.42 - $i * 0.05 ) ), $top + 82 + $i * 18, pal( $im, $palette, 'line', 128 ) );
	}
	imagefilledrectangle( $im, $m + 30, $top + 142, $m + 168, $top + 178, pal( $im, $palette, 'line', 40 ) );
	rect( $im, $m + 186, $top + 142, $m + 320, $top + 178, $soft );

	// Plate on the right.
	$px1 = (int) ( $w * 0.60 );
	$px2 = $w - $m - 30;
	imagefilledrectangle( $im, $px1, $top, $px2, $top + $hb, $fill );
	rect( $im, $px1, $top, $px2, $top + $hb, $line );
	imageline( $im, $px1, $top, $px2, $top + $hb, $soft );
	imageline( $im, $px2, $top, $px1, $top + $hb, $soft );

	// Card row.
	$cy1 = $top + $hb + (int) ( $h * 0.07 );
	$cy2 = $h - $m - 30;
	if ( $cy2 - $cy1 > 40 ) {
		$gap = 22;
		$cw  = (int) ( ( $w - 2 * $m - 60 - 2 * $gap ) / 3 );
		for ( $i = 0; $i < 3; $i++ ) {
			$x1 = $m + 30 + $i * ( $cw + $gap );
			rect( $im, $x1, $cy1, $x1 + $cw, $cy2, $line );
			imagefilledrectangle( $im, $x1 + 14, $cy1 + 16, $x1 + 54, $cy1 + 24, pal( $im, $palette, 'line', 60 ) );
			imagefilledrectangle( $im, $x1 + 14, $cy1 + 40, $x1 + $cw - 40, $cy1 + 52, $hi );
			for ( $k = 0; $k < 3; $k++ ) {
				imagefilledrectangle( $im, $x1 + 14, $cy1 + 70 + $k * 16, $x1 + $cw - 20 - $k * 18, $cy1 + 77 + $k * 16, pal( $im, $palette, 'line', 132 ) );
			}
		}
	}
}

/** Blueprint portrait — a head study in construction lines. */
function scene_portrait( $im, $w, $h, $palette ) {
	$line = pal( $im, $palette, 'line' );
	$soft = pal( $im, $palette, 'line', 96 );
	$faint = pal( $im, $palette, 'line', 116 );
	$hi   = pal( $im, $palette, 'hi', 40 );

	$cx = (int) ( $w * 0.5 );
	$cy = (int) ( $h * 0.40 );
	$hw = (int) ( $w * 0.17 );          // Half head width.
	$hh = (int) ( $h * 0.21 );          // Half head height.

	// Shoulders: a trapezoid rather than a bubble, hatched.
	$sy = (int) ( $h * 0.74 );
	$s1 = (int) ( $cx - $w * 0.40 );
	$s2 = (int) ( $cx + $w * 0.40 );
	$n1 = (int) ( $cx - $w * 0.13 );
	$n2 = (int) ( $cx + $w * 0.13 );
	$shoulders = array( $n1, (int) ( $sy - $h * 0.06 ), $n2, (int) ( $sy - $h * 0.06 ), $s2, $sy, $s2, $h, $s1, $h, $s1, $sy );
	imagefilledpolygon( $im, $shoulders, pal( $im, $palette, 'mid', 92 ) );
	hatch( $im, $s1, $sy, $s2, $h - 1, $faint, 10 );
	imagepolygon( $im, $shoulders, $line );

	// Head: ellipse cranium narrowing to a jaw.
	$head = array();
	for ( $a = 180; $a <= 360; $a += 6 ) {
		$r = deg2rad( $a );
		$head[] = (int) ( $cx + cos( $r ) * $hw );
		$head[] = (int) ( $cy + sin( $r ) * $hh );
	}
	$head[] = (int) ( $cx + $hw * 0.82 );
	$head[] = (int) ( $cy + $hh * 0.55 );
	$head[] = (int) ( $cx + $hw * 0.34 );
	$head[] = (int) ( $cy + $hh * 1.12 );
	$head[] = (int) ( $cx - $hw * 0.34 );
	$head[] = (int) ( $cy + $hh * 1.12 );
	$head[] = (int) ( $cx - $hw * 0.82 );
	$head[] = (int) ( $cy + $hh * 0.55 );
	imagefilledpolygon( $im, $head, pal( $im, $palette, 'mid', 44 ) );
	imagepolygon( $im, $head, $line );

	// Horizontal sections across the head, like a contour survey.
	for ( $i = -3; $i <= 4; $i++ ) {
		$y = (int) ( $cy + $i * $hh * 0.27 );
		$t = abs( $i ) / 4.2;
		$half = (int) ( $hw * sqrt( max( 0.04, 1 - $t * $t ) ) * ( $i > 1 ? 0.78 : 1 ) );
		imageline( $im, $cx - $half, $y, $cx + $half, $y, ( 0 === $i ) ? $soft : $faint );
	}

	// Construction lines and setting-out circle.
	imageline( $im, $cx, 0, $cx, $h, $faint );
	imageellipse( $im, $cx, $cy, (int) ( $hw * 2.7 ), (int) ( $hw * 2.7 ), $faint );
	dimension( $im, $cx - $hw, (int) ( $cy - $hh * 1.42 ), $cx + $hw, (int) ( $cy - $hh * 1.42 ), $soft );
	dimension( $im, (int) ( $cx + $hw * 1.9 ), $cy - $hh, (int) ( $cx + $hw * 1.9 ), (int) ( $cy + $hh * 1.12 ), $soft );

	// Eye line and brow marks.
	$ey = (int) ( $cy + $hh * 0.08 );
	imageline( $im, (int) ( $cx - $hw * 0.62 ), $ey, (int) ( $cx - $hw * 0.24 ), $ey, $hi );
	imageline( $im, (int) ( $cx + $hw * 0.24 ), $ey, (int) ( $cx + $hw * 0.62 ), $ey, $hi );

	label( $im, (int) ( $cx - $hw ), (int) ( $cy - $hh * 1.42 ) - 20, 'PORTRAIT STUDY', $soft, 1 );
}

/** Chart plate — axes, bars, trend line. */
function scene_bars( $im, $w, $h, $palette ) {
	$line = pal( $im, $palette, 'line' );
	$soft = pal( $im, $palette, 'line', 96 );
	$fill = pal( $im, $palette, 'mid', 50 );
	$hi   = pal( $im, $palette, 'hi', 30 );

	$m  = (int) ( min( $w, $h ) * 0.16 );
	$x0 = $m;
	$y0 = $h - $m;
	$x1 = $w - $m;
	$y1 = $m;

	imageline( $im, $x0, $y0, $x1, $y0, $line );
	imageline( $im, $x0, $y0, $x0, $y1, $line );
	for ( $i = 1; $i <= 4; $i++ ) {
		$y = (int) ( $y0 - ( $y0 - $y1 ) * $i / 4 );
		imageline( $im, $x0, $y, $x1, $y, pal( $im, $palette, 'line', 120 ) );
	}

	$n   = 9;
	$bw  = (int) ( ( $x1 - $x0 ) / $n * 0.56 );
	$pts = array();
	for ( $i = 0; $i < $n; $i++ ) {
		$cx = (int) ( $x0 + ( $x1 - $x0 ) * ( $i + 0.5 ) / $n );
		$v  = mt_rand( 22, 96 ) / 100;
		$by = (int) ( $y0 - ( $y0 - $y1 ) * $v );
		imagefilledrectangle( $im, $cx - (int) ( $bw / 2 ), $by, $cx + (int) ( $bw / 2 ), $y0 - 1, $fill );
		rect( $im, $cx - (int) ( $bw / 2 ), $by, $cx + (int) ( $bw / 2 ), $y0 - 1, $line );
		$pts[] = array( $cx, (int) ( $by - 18 - mt_rand( 0, 26 ) ) );
	}
	for ( $i = 1; $i < count( $pts ); $i++ ) {
		imageline( $im, $pts[ $i - 1 ][0], $pts[ $i - 1 ][1], $pts[ $i ][0], $pts[ $i ][1], $hi );
	}
	foreach ( $pts as $p ) {
		imagefilledellipse( $im, $p[0], $p[1], 7, 7, $hi );
	}
	label( $im, $x0, $y1 - 22, 'FIG. 01 — SESSIONS / WEEK', $soft, 2 );
}

/** Concentric radial diagram. */
function scene_radial( $im, $w, $h, $palette ) {
	$line = pal( $im, $palette, 'line' );
	$soft = pal( $im, $palette, 'line', 104 );
	$cx   = (int) ( $w / 2 );
	$cy   = (int) ( $h / 2 );
	$max  = (int) ( min( $w, $h ) * 0.42 );

	for ( $i = 1; $i <= 6; $i++ ) {
		$d = (int) ( $max * 2 * $i / 6 );
		imageellipse( $im, $cx, $cy, $d, $d, ( 0 === $i % 3 ) ? $line : $soft );
	}
	for ( $a = 0; $a < 360; $a += 15 ) {
		$rad = deg2rad( $a );
		$r1  = ( 0 === $a % 45 ) ? 0 : $max * 0.86;
		imageline(
			$im,
			(int) ( $cx + cos( $rad ) * $r1 ),
			(int) ( $cy + sin( $rad ) * $r1 ),
			(int) ( $cx + cos( $rad ) * $max ),
			(int) ( $cy + sin( $rad ) * $max ),
			$soft
		);
	}
	$start = mt_rand( 0, 300 );
	imagefilledarc( $im, $cx, $cy, (int) ( $max * 1.3 ), (int) ( $max * 1.3 ), $start, $start + mt_rand( 40, 110 ), pal( $im, $palette, 'mid', 84 ), IMG_ARC_PIE );
	imagefilledellipse( $im, $cx, $cy, 11, 11, pal( $im, $palette, 'hi', 20 ) );
}

/** Layered strata — good for wide banner plates. */
function scene_strata( $im, $w, $h, $palette ) {
	$layers = 7;
	$y      = (int) ( $h * 0.18 );
	for ( $i = 0; $i < $layers; $i++ ) {
		$next = $y + (int) ( ( $h - $y ) / ( $layers - $i ) ) + mt_rand( -14, 14 );
		$next = min( $next, $h );
		$pts  = array();
		$pts[] = 0;
		$pts[] = $y;
		for ( $x = 0; $x <= $w; $x += 40 ) {
			$pts[] = $x;
			$pts[] = (int) ( $y + sin( $x / $w * M_PI * ( 1.5 + $i * 0.4 ) + $i ) * ( 16 + $i * 3 ) );
		}
		$pts[] = $w;
		$pts[] = $next;
		$pts[] = $w;
		$pts[] = $h;
		$pts[] = 0;
		$pts[] = $h;
		imagefilledpolygon( $im, $pts, pal( $im, $palette, 'mid', 118 - $i * 10 ) );
		if ( 0 === $i % 2 ) {
			hatch( $im, 0, $y, $w, min( $next, $h ), pal( $im, $palette, 'line', 118 ), 11 );
		}
		$y = $next;
	}
	imageline( $im, 0, (int) ( $h * 0.18 ), $w, (int) ( $h * 0.18 ), pal( $im, $palette, 'hi', 40 ) );
}

/* ------------------------------------------------------------------ driver */

function make( $file, $w, $h, $scene, $palette, $seed, $opts = array() ) {
	mt_srand( $seed );
	$im = canvas( $w, $h, $palette );

	if ( ! empty( $opts['grid'] ) ) {
		grid( $im, $w, $h, $palette, $opts['grid'] );
	}

	$fn = 'scene_' . $scene;
	$fn( $im, $w, $h, $palette );

	if ( empty( $opts['no_registration'] ) ) {
		registration( $im, $w, $h, $palette );
	}
	halftone( $im, $w, $h, $palette, 12 );

	if ( ! empty( $opts['caption'] ) ) {
		$c = pal( $im, $palette, 'hi', 42 );
		label( $im, 34, $h - 42, strtoupper( $opts['caption'] ), $c, 2 );
	}

	$path = OUT . '/' . $file;
	if ( str_ends_with( $file, '.png' ) ) {
		imagepng( $im, $path, 8 );
	} else {
		imagejpeg( $im, $path, 68 );
	}
	imagedestroy( $im );
	printf( "%-34s %5d x %-5d %8d bytes\n", $file, $w, $h, filesize( $path ) );
}

if ( ! is_dir( OUT ) ) {
	mkdir( OUT, 0755, true );
}

/* Hero and studio plates. */
make( 'hero-studio.jpg', 1200, 1500, 'plan', 'ink', 1001, array( 'grid' => 40, 'caption' => 'Northline studio — Bristol' ) );
make( 'studio-room.jpg', 1400, 1120, 'iso', 'slate', 1002, array( 'grid' => 40, 'caption' => 'Studio' ) );

/* Case-study / project covers. */
$projects = array(
	array( 'northgate-health', 'wireui', 'paper', 'Northgate Health' ),
	array( 'fieldnote', 'contour', 'ink', 'Fieldnote' ),
	array( 'kelso-rail', 'iso', 'slate', 'Kelso Rail' ),
	array( 'halcyon', 'wireui', 'paper', 'Halcyon' ),
	array( 'merrick-co', 'radial', 'ink', 'Merrick & Co' ),
	array( 'sablefield', 'plan', 'slate', 'Sablefield' ),
	array( 'ordnance-trust', 'contour', 'paper', 'Ordnance Trust' ),
	array( 'loom-analytics', 'bars', 'ink', 'Loom Analytics' ),
	array( 'brayton-cycles', 'iso', 'paper', 'Brayton Cycles' ),
);
$i = 0;
foreach ( $projects as $p ) {
	$i++;
	make( "project-{$p[0]}.jpg", 1400, 1050, $p[1], $p[2], 2000 + $i, array( 'grid' => 34, 'caption' => $p[3] ) );
}

/* Wide case-study heroes and inline details. */
make( 'case-northgate-hero.jpg', 1920, 1080, 'wireui', 'paper', 2101, array( 'grid' => 40, 'caption' => 'Treatment template' ) );
make( 'case-detail-template.jpg', 1200, 900, 'plan', 'paper', 2102, array( 'grid' => 30, 'caption' => 'Template detail' ) );
make( 'case-detail-editor.jpg', 1200, 900, 'wireui', 'slate', 2103, array( 'grid' => 30, 'caption' => 'Editor view' ) );

/* Team portraits. */
$team = array( 'maya-iyer', 'daniel-okoro', 'sofia-lindqvist', 'ben-trawick', 'priya-raman', 'iwan-petrov' );
$i    = 0;
foreach ( $team as $t ) {
	$i++;
	make( "team-{$t}.jpg", 900, 900, 'portrait', ( 0 === $i % 2 ) ? 'slate' : 'ink', 3000 + $i, array( 'grid' => 30 ) );
}

/* Journal post covers. */
$posts = array(
	array( 'content-models', 'plan', 'paper' ),
	array( 'performance-budget', 'bars', 'ink' ),
	array( 'migrating-400-pages', 'contour', 'slate' ),
	array( 'twelve-patterns', 'wireui', 'paper' ),
	array( 'block-patterns-contract', 'iso', 'ink' ),
	array( 'discovery-questions', 'radial', 'slate' ),
	array( 'web-fonts-layout-shift', 'strata', 'paper' ),
	array( 'editor-training', 'wireui', 'ink' ),
);
$i = 0;
foreach ( $posts as $p ) {
	$i++;
	make( "post-{$p[0]}.jpg", 1600, 900, $p[1], $p[2], 4000 + $i, array( 'grid' => 34 ) );
}
make( 'post-content-models-wide.jpg', 1920, 823, 'strata', 'ink', 4101, array( 'grid' => 40, 'caption' => 'Fig. 4 — one model, ninety pages' ) );

/* Theme screenshots for the downloads catalogue. */
$themes = array( 'ledger', 'ledger-pro', 'wharf', 'kelpie', 'wharf-pro', 'signal', 'kelpie-pro', 'fieldbook', 'atlas' );
$i      = 0;
foreach ( $themes as $t ) {
	$i++;
	make( "theme-{$t}.jpg", 1600, 1000, 'wireui', ( 0 === $i % 3 ) ? 'slate' : 'paper', 5000 + $i, array( 'grid' => 32, 'caption' => $t ) );
}

/* Product page gallery. */
make( 'product-ledger-pro-main.jpg', 1600, 900, 'wireui', 'paper', 5101, array( 'grid' => 32, 'caption' => 'Front page template' ) );
for ( $i = 1; $i <= 4; $i++ ) {
	$scenes = array( 'plan', 'wireui', 'radial', 'iso' );
	make( "product-ledger-pro-0{$i}.jpg", 800, 600, $scenes[ $i - 1 ], ( 0 === $i % 2 ) ? 'slate' : 'paper', 5110 + $i, array( 'grid' => 26 ) );
}

/* Docs. */
make( 'docs-site-editor.jpg', 1600, 1000, 'wireui', 'paper', 6001, array( 'grid' => 32, 'caption' => 'Site editor' ) );
make( 'docs-walkthrough.jpg', 1600, 900, 'wireui', 'slate', 6002, array( 'grid' => 32, 'caption' => 'Walkthrough · part 1' ) );

/* Social card + theme screenshot. */
make( 'og-default.jpg', 1200, 630, 'strata', 'ink', 7001, array( 'grid' => 34, 'caption' => 'Northline — web design & development studio' ) );
make( '../../screenshot.png', 1200, 900, 'wireui', 'paper', 7002, array( 'grid' => 32, 'caption' => 'Northline' ) );

echo "\nDone.\n";
