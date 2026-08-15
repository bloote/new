<?php
/**
 * Helpers the patterns lean on, so forty section files stay readable.
 *
 * Each one returns block markup as a string. Nothing here is required at
 * runtime once a pattern has been inserted — the result is ordinary core
 * blocks in the page.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL of an image shipped with the theme.
 *
 * @param string $file File name inside assets/images.
 * @return string
 */
function northline_img( $file ) {
	return NORTHLINE_URI . '/assets/images/' . ltrim( $file, '/' );
}

/**
 * The media library ID for a theme image, once the demo import has copied it in.
 *
 * @param string $file File name inside assets/images.
 * @return int Attachment ID, or 0 when the image has not been imported.
 */
function northline_attachment_id( $file ) {
	$map = northline_attachment_map();
	return isset( $map[ $file ] ) ? (int) $map[ $file ] : 0;
}

/**
 * File name to attachment ID for everything the demo import has copied in.
 *
 * @param bool $flush Rebuild the map on the next call. The importer flushes it
 *                    after copying media, so patterns rendered afterwards point
 *                    at library images rather than the bundled files.
 * @return array
 */
function northline_attachment_map( $flush = false ) {
	static $map = null;

	if ( $flush ) {
		$map = null;
		return array();
	}

	if ( null === $map ) {
		$map     = array();
		$results = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => 300,
				'meta_key'       => '_northline_source', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'fields'         => 'ids',
			)
		);
		foreach ( $results as $id ) {
			$source = get_post_meta( $id, '_northline_source', true );
			if ( $source ) {
				$map[ $source ] = $id;
			}
		}
	}

	return $map;
}

/**
 * Permalink for one of the demo pages, by slug, with a sensible fallback.
 *
 * @param string $slug Page slug.
 * @return string
 */
function northline_page_url( $slug ) {
	static $cache = array();

	if ( '__flush__' === $slug ) {
		$cache = array();
		return '';
	}

	if ( isset( $cache[ $slug ] ) ) {
		return $cache[ $slug ];
	}

	$page = get_page_by_path( $slug );

	if ( $page ) {
		$cache[ $slug ] = get_permalink( $page );
	} else {
		$cache[ $slug ] = home_url( '/' . $slug . '/' );
	}

	return $cache[ $slug ];
}

/**
 * Archive URL for one of the custom types, falling back to a sane path.
 *
 * @param string $post_type Post type name.
 * @return string
 */
function northline_archive_url( $post_type ) {
	$url = get_post_type_archive_link( $post_type );
	return $url ? $url : home_url( '/' . $post_type . '/' );
}

/**
 * Term ID for a slug, used to point query loops at a taxonomy without
 * hard-coding numbers that differ between installs.
 *
 * @param string $taxonomy Taxonomy name.
 * @param string $slug     Term slug.
 * @return int
 */
function northline_term_id( $taxonomy, $slug ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );
	return $term && ! is_wp_error( $term ) ? (int) $term->term_id : 0;
}

/**
 * Term archive URL, falling back to the parent archive.
 *
 * @param string $taxonomy Taxonomy name.
 * @param string $slug     Term slug.
 * @param string $fallback Fallback URL.
 * @return string
 */
function northline_term_url( $taxonomy, $slug, $fallback = '' ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );

	if ( $term && ! is_wp_error( $term ) ) {
		$link = get_term_link( $term );
		if ( ! is_wp_error( $link ) ) {
			return $link;
		}
	}

	return $fallback ? $fallback : home_url( '/' );
}

/**
 * An image block, wired to the media library when the demo import has run and
 * to the bundled file when it has not.
 *
 * @param string $file File name inside assets/images.
 * @param array  $args ratio, alt, class, align.
 * @return string
 */
function northline_image_block( $file, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'ratio' => '4/3',
			'alt'   => '',
			'class' => 'nl-blueprint',
			'align' => '',
		)
	);

	$id  = northline_attachment_id( $file );
	$url = $id ? wp_get_attachment_image_url( $id, 'full' ) : northline_img( $file );

	$attributes = array(
		'aspectRatio' => $args['ratio'],
		'scale'       => 'cover',
		'sizeSlug'    => 'full',
		'className'   => $args['class'],
	);

	if ( $id ) {
		$attributes['id'] = $id;
	}
	if ( $args['align'] ) {
		$attributes['align'] = $args['align'];
	}

	$attributes['linkDestination'] = 'none';

	$classes = 'wp-block-image size-full' . ( $args['align'] ? ' align' . $args['align'] : '' ) . ' ' . $args['class'];

	return sprintf(
		'<!-- wp:image %1$s --><figure class="%2$s"><img src="%3$s" alt="%4$s"%5$s style="aspect-ratio:%6$s;object-fit:cover"/></figure><!-- /wp:image -->',
		wp_json_encode( $attributes ),
		esc_attr( trim( $classes ) ),
		esc_url( $url ),
		esc_attr( $args['alt'] ),
		$id ? ' class="wp-image-' . (int) $id . '"' : '',
		esc_attr( $args['ratio'] )
	);
}

/**
 * The numbered rail that opens each band: "03 —— Selected work", a heading,
 * an optional standfirst, and an optional button on the right.
 *
 * @param array $args number, label, heading, body, button_text, button_url, align.
 * @return string
 */
function northline_section_head( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'number'      => '',
			'label'       => '',
			'heading'     => '',
			'body'        => '',
			'button_text' => '',
			'button_url'  => '',
			'align'       => 'start',
			'level'       => 2,
			'size'        => 'heading-2',
			'measure'     => 'nl-measure-head',
		)
	);

	$rail = '';
	if ( $args['number'] || $args['label'] ) {
		$rail = sprintf(
			'<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>%1$s</span><span>%2$s</span></p><!-- /wp:paragraph -->',
			esc_html( $args['number'] ),
			esc_html( $args['label'] )
		);
	}

	$heading = sprintf(
		'<!-- wp:heading {"level":%1$d,"className":"%2$s","fontSize":"%3$s"} --><h%1$d class="wp-block-heading %2$s has-%3$s-font-size">%4$s</h%1$d><!-- /wp:heading -->',
		(int) $args['level'],
		esc_attr( $args['measure'] ),
		esc_attr( $args['size'] ),
		wp_kses_post( $args['heading'] )
	);

	$body = '';
	if ( $args['body'] ) {
		$body = sprintf(
			'<!-- wp:paragraph {"className":"nl-quiet nl-measure","fontSize":"large"} --><p class="nl-quiet nl-measure has-large-font-size">%s</p><!-- /wp:paragraph -->',
			wp_kses_post( $args['body'] )
		);
	}

	$right = $heading . $body;

	if ( $args['button_text'] ) {
		$right = sprintf(
			'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group">%1$s<!-- wp:buttons --><div class="wp-block-buttons">%2$s</div><!-- /wp:buttons --></div>
<!-- /wp:group -->',
			$heading . $body,
			northline_button( $args['button_text'], $args['button_url'], 'secondary' )
		);
	}

	return sprintf(
		'<!-- wp:group {"className":"nl-rail-layout%1$s","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|70"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout%1$s" style="margin-bottom:var(--wp--preset--spacing--70)">%2$s<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group">%3$s</div><!-- /wp:group --></div>
<!-- /wp:group -->',
		'end' === $args['align'] ? ' is-bottom' : '',
		$rail,
		$right
	);
}

/**
 * A single button block.
 *
 * @param string $text  Label.
 * @param string $url   Destination.
 * @param string $style One of primary, secondary, inverse, link.
 * @param string $extra Extra classes on the button wrapper.
 * @return string
 */
function northline_button( $text, $url, $style = 'primary', $extra = '' ) {
	$class = trim( ( 'primary' === $style ? '' : 'is-style-' . $style ) . ' ' . $extra );

	return sprintf(
		'<!-- wp:button%1$s --><div class="wp-block-button%2$s"><a class="wp-block-button__link wp-element-button" href="%3$s">%4$s</a></div><!-- /wp:button -->',
		$class ? ' ' . wp_json_encode( array( 'className' => $class ) ) : '',
		$class ? ' ' . esc_attr( $class ) : '',
		esc_url( $url ),
		esc_html( $text )
	);
}

/**
 * The dark call-to-action band that closes most pages.
 *
 * @param array $args heading, body, button_text, button_url, link_text, link_url.
 * @return string
 */
function northline_cta_band( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'heading'     => '',
			'body'        => '',
			'button_text' => __( 'Book a call', 'northline' ),
			'button_url'  => '',
			'link_text'   => '',
			'link_url'    => '',
		)
	);

	if ( ! $args['button_url'] ) {
		$args['button_url'] = northline_page_url( 'contact' );
	}

	$link = '';
	if ( $args['link_text'] ) {
		$link = sprintf(
			'<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-light"}}}},"textColor":"accent-light","fontSize":"medium"} --><p class="has-accent-light-color has-text-color has-link-color has-medium-font-size"><a href="%s">%s</a></p><!-- /wp:paragraph -->',
			esc_url( $args['link_url'] ),
			esc_html( $args['link_text'] )
		);
	}

	return sprintf(
		'<!-- wp:group {"metadata":{"name":"Call to action"},"align":"full","className":"nl-invert","backgroundColor":"accent-dark","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull nl-invert has-base-color has-accent-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"62%%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:62%%">
<!-- wp:heading {"className":"nl-measure-tight","fontSize":"display"} --><h2 class="wp-block-heading nl-measure-tight has-display-font-size">%1$s</h2><!-- /wp:heading -->
<!-- wp:paragraph {"className":"nl-quiet nl-measure","fontSize":"large"} --><p class="nl-quiet nl-measure has-large-font-size">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"38%%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:38%%">
<!-- wp:buttons --><div class="wp-block-buttons">%3$s</div><!-- /wp:buttons -->
%4$s
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->',
		esc_html( $args['heading'] ),
		esc_html( $args['body'] ),
		northline_button( $args['button_text'], $args['button_url'], 'inverse' ),
		$link
	);
}

/**
 * One statistic in the divided figures band.
 *
 * @param string $value  Displayed value, e.g. "61" or "9.4".
 * @param string $label  Caption underneath.
 * @param string $suffix Trailing unit, e.g. "%" or "s".
 * @return string
 */
function northline_stat( $value, $label, $suffix = '' ) {
	// The counter animates from zero; "x" stands in for the decimal point in
	// the class name, since a full stop would start a second class.
	$key = str_replace( '.', 'x', preg_replace( '/[^0-9.]/', '', $value ) );

	return sprintf(
		'<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"clamp(2.75rem, 5vw, 4.25rem)"}}} --><p class="nl-numeral" style="font-size:clamp(2.75rem, 5vw, 4.25rem)"><span class="nl-count-%1$s">%2$s</span>%3$s</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">%4$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		esc_attr( $key ),
		esc_html( $value ),
		esc_html( $suffix ),
		esc_html( $label )
	);
}

/**
 * A row of statistics, divided by hairlines.
 *
 * @param array $stats List of [value, label, suffix].
 * @return string
 */
function northline_stats_row( $stats ) {
	$out = '';
	foreach ( $stats as $stat ) {
		$out .= northline_stat( $stat[0], $stat[1], $stat[2] ?? '' );
	}

	return sprintf(
		'<!-- wp:group {"className":"nl-divided","layout":{"type":"grid","columnCount":%1$d}} --><div class="wp-block-group nl-divided">%2$s</div><!-- /wp:group -->',
		count( $stats ),
		$out
	);
}

/**
 * A definition pair: small uppercase label over a value.
 *
 * @param string $label Label.
 * @param string $value Value.
 * @return string
 */
function northline_definition( $label, $value ) {
	return sprintf(
		'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">%1$s</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		esc_html( $label ),
		wp_kses_post( $value )
	);
}

/**
 * An accordion row: a clickable head with a "+" mark and a collapsible body.
 *
 * @param string $heading Row title.
 * @param string $body    Block markup for the open state.
 * @param bool   $open    Whether it starts open.
 * @param string $index   Optional S/01 style index shown on the left.
 * @param string $size    Font size preset for the question. A full-width band
 *                        carries heading-3; in a sidebar, beside the page's own
 *                        h2, drop to x-large so the two are not the same voice.
 * @return string
 */
function northline_accordion_row( $heading, $body, $open = false, $index = '', $size = 'heading-3' ) {
	$head_left = $index
		? sprintf(
			'<!-- wp:paragraph {"className":"nl-index","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-index" style="margin-bottom:0"><span>%s</span></p><!-- /wp:paragraph -->',
			esc_html( $index )
		)
		: '';

	// The "+" tracks the question rather than staying one fixed size.
	$mark = 'heading-3' === $size ? '1.6rem' : '1.25rem';

	return sprintf(
		'<!-- wp:group {"className":"nl-accordion nl-rule%1$s","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-accordion nl-rule%1$s" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
<!-- wp:group {"className":"nl-accordion-head","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group nl-accordion-head">
%2$s
<!-- wp:heading {"level":3,"className":"nl-fill","fontSize":"%5$s","style":{"spacing":{"margin":{"bottom":"0"}}}} --><h3 class="wp-block-heading nl-fill has-%5$s-font-size" style="margin-bottom:0">%3$s</h3><!-- /wp:heading -->
<!-- wp:paragraph {"className":"nl-accordion-mark","style":{"typography":{"fontSize":"%6$s"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-accordion-mark" style="font-size:%6$s;margin-bottom:0">+</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"nl-accordion-body","layout":{"type":"default"}} -->
<div class="wp-block-group nl-accordion-body">%4$s</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
		$open ? ' is-open' : '',
		$head_left,
		esc_html( $heading ),
		$body,
		esc_attr( $size ),
		esc_attr( $mark )
	);
}

/**
 * A short paragraph in the muted body tone.
 *
 * @param string $text  Copy.
 * @param string $class Extra classes.
 * @param string $size  Font size slug.
 * @return string
 */
function northline_para( $text, $class = 'nl-quiet nl-measure', $size = 'large' ) {
	return sprintf(
		'<!-- wp:paragraph {"className":"%1$s","fontSize":"%2$s"} --><p class="%1$s has-%2$s-font-size">%3$s</p><!-- /wp:paragraph -->',
		esc_attr( $class ),
		esc_attr( $size ),
		wp_kses_post( $text )
	);
}

/**
 * A list of short strings, one per line, without bullets.
 *
 * @param array  $items Strings.
 * @param string $size  Font size slug.
 * @return string
 */
function northline_plain_list( $items, $size = 'medium' ) {
	$out = '';
	foreach ( $items as $item ) {
		$out .= sprintf( '<!-- wp:list-item --><li>%s</li><!-- /wp:list-item -->', wp_kses_post( $item ) );
	}

	return sprintf(
		'<!-- wp:list {"className":"is-style-plain","fontSize":"%1$s","style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} --><ul class="wp-block-list is-style-plain has-%1$s-font-size">%2$s</ul><!-- /wp:list -->',
		esc_attr( $size ),
		$out
	);
}

/**
 * A row of tags.
 *
 * @param array  $tags  Labels.
 * @param string $style Tag style suffix: outline, accent, neutral.
 * @return string
 */
function northline_tags( $tags, $style = 'outline' ) {
	$out = '';
	foreach ( $tags as $tag ) {
		$out .= sprintf(
			'<!-- wp:paragraph {"className":"nl-tag nl-tag-%1$s","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-tag nl-tag-%1$s" style="margin-bottom:0">%2$s</p><!-- /wp:paragraph -->',
			esc_attr( $style ),
			esc_html( $tag )
		);
	}

	return sprintf(
		'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} --><div class="wp-block-group">%s</div><!-- /wp:group -->',
		$out
	);
}

/**
 * Open a full-bleed section.
 *
 * @param array $args name, background, class, top, bottom, plate.
 * @return string
 */
function northline_section_open( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'name'       => '',
			'background' => '',
			'class'      => 'nl-rule',
			'top'        => 'var:preset|spacing|80',
			'bottom'     => 'var:preset|spacing|80',
		)
	);

	$attributes = array(
		'align'     => 'full',
		'className' => $args['class'],
		'style'     => array(
			'spacing' => array(
				'padding' => array(
					'top'    => $args['top'],
					'bottom' => $args['bottom'],
				),
			),
		),
		'layout'    => array( 'type' => 'constrained' ),
	);

	if ( $args['name'] ) {
		$attributes['metadata'] = array( 'name' => $args['name'] );
	}

	$classes = 'wp-block-group alignfull ' . $args['class'];

	if ( $args['background'] ) {
		$attributes['backgroundColor'] = $args['background'];
		$classes                      .= ' has-' . $args['background'] . '-background-color has-background';
	}

	return sprintf(
		'<!-- wp:group %1$s --><div class="%2$s" style="padding-top:%3$s;padding-bottom:%4$s">',
		wp_json_encode( $attributes ),
		esc_attr( trim( $classes ) ),
		esc_attr( northline_spacing_css( $args['top'] ) ),
		esc_attr( northline_spacing_css( $args['bottom'] ) )
	);
}

/**
 * Turn a theme.json spacing token into the CSS the saved markup carries.
 *
 * @param string $token Either "var:preset|spacing|80" or a plain CSS length.
 * @return string
 */
function northline_spacing_css( $token ) {
	$prefix = 'var:preset|spacing|';

	if ( str_starts_with( $token, $prefix ) ) {
		return 'var(--wp--preset--spacing--' . substr( $token, strlen( $prefix ) ) . ')';
	}

	return $token;
}

/**
 * Close a full-bleed section.
 *
 * @return string
 */
function northline_section_close() {
	return '</div><!-- /wp:group -->';
}

/**
 * A page header: kicker, headline, standfirst, and an optional column on the
 * right holding an image, a figures box or a short definition list.
 *
 * @param array $args kicker, heading, lede, right, right_width, name, level, size.
 * @return string
 */
function northline_page_header( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'kicker'      => '',
			'heading'     => '',
			'lede'        => '',
			'right'       => '',
			'right_width' => '42%',
			'name'        => 'Page header',
			'size'        => 'display-xl',
			'align'       => 'end',
		)
	);

	$kicker = $args['kicker']
		? sprintf(
			'<!-- wp:paragraph {"className":"nl-kicker has-dot","textColor":"accent-deep","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} --><p class="nl-kicker has-dot has-accent-deep-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--50)">%s</p><!-- /wp:paragraph -->',
			esc_html( $args['kicker'] )
		)
		: '';

	$left = $kicker
		. sprintf(
			'<!-- wp:heading {"level":1,"className":"nl-measure-hero","fontSize":"%1$s"} --><h1 class="wp-block-heading nl-measure-hero has-%1$s-font-size">%2$s</h1><!-- /wp:heading -->',
			esc_attr( $args['size'] ),
			wp_kses_post( $args['heading'] )
		)
		. ( $args['lede'] ? northline_para( $args['lede'], 'nl-quiet nl-measure', 'x-large' ) : '' );

	$open = northline_section_open(
		array(
			'name'   => $args['name'],
			'class'  => 'nl-plate',
			'top'    => 'var:preset|spacing|90',
			'bottom' => 'var:preset|spacing|80',
		)
	);

	if ( ! $args['right'] ) {
		return $open . $left . northline_section_close();
	}

	$left_width = ( 100 - (int) $args['right_width'] ) . '%';

	return $open . sprintf(
		'<!-- wp:columns {"verticalAlignment":"%5$s","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-%5$s">
<!-- wp:column {"verticalAlignment":"%5$s","width":"%1$s"} --><div class="wp-block-column is-vertically-aligned-%5$s" style="flex-basis:%1$s">%2$s</div><!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"%5$s","width":"%3$s"} --><div class="wp-block-column is-vertically-aligned-%5$s" style="flex-basis:%3$s">%4$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		esc_attr( $left_width ),
		$left,
		esc_attr( $args['right_width'] ),
		$args['right'],
		esc_attr( $args['align'] )
	) . northline_section_close();
}

/**
 * A value that counts up from zero when it scrolls into view.
 *
 * @param string $value  The number, as it should finally read.
 * @param string $suffix Text after the number.
 * @return string
 */
function northline_counter( $value, $suffix = '' ) {
	$key = str_replace( '.', 'x', preg_replace( '/[^0-9.]/', '', $value ) );

	return sprintf(
		'<span class="nl-count-%1$s">%2$s</span>%3$s',
		esc_attr( $key ),
		esc_html( $value ),
		esc_html( $suffix )
	);
}

/**
 * The framed two-by-two figures box that sits beside several page headers.
 *
 * @param array $pairs List of [label, value]; values may contain a counter.
 * @return string
 */
function northline_figures_box( $pairs ) {
	$cells = '';

	foreach ( $pairs as $pair ) {
		$cells .= sprintf(
			'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">%1$s</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"1.625rem"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-numeral" style="font-size:1.625rem;margin-bottom:0">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
			esc_html( $pair[0] ),
			wp_kses_post( $pair[1] )
		);
	}

	return sprintf(
		'<!-- wp:group {"className":"nl-blueprint","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"layout":{"type":"grid","columnCount":2}} -->
<div class="wp-block-group nl-blueprint" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">%s</div>
<!-- /wp:group -->',
		$cells
	);
}

/**
 * A framed card: hairline box with corner marks and arbitrary contents.
 *
 * @param string $inner      Block markup.
 * @param array  $args       class, background, padding, reveal.
 * @return string
 */
function northline_panel( $inner, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class'      => 'nl-blueprint',
			'background' => '',
			'padding'    => 'var:preset|spacing|50',
			'reveal'     => '',
		)
	);

	$classes    = trim( $args['class'] . ' ' . $args['reveal'] );
	$attributes = array(
		'className' => $classes,
		'style'     => array(
			'spacing' => array(
				'padding' => array(
					'top'    => $args['padding'],
					'bottom' => $args['padding'],
					'left'   => $args['padding'],
					'right'  => $args['padding'],
				),
			),
		),
		'layout'    => array( 'type' => 'default' ),
	);

	$div_classes = 'wp-block-group ' . $classes;

	if ( $args['background'] ) {
		$attributes['backgroundColor'] = $args['background'];
		$div_classes                  .= ' has-' . $args['background'] . '-background-color has-background';
	}

	$pad = northline_spacing_css( $args['padding'] );

	return sprintf(
		'<!-- wp:group %1$s --><div class="%2$s" style="padding-top:%3$s;padding-right:%3$s;padding-bottom:%3$s;padding-left:%3$s">%4$s</div><!-- /wp:group -->',
		wp_json_encode( $attributes ),
		esc_attr( trim( $div_classes ) ),
		esc_attr( $pad ),
		$inner
	);
}

/**
 * A grid of equal columns.
 *
 * @param array $cells   Block markup per cell.
 * @param int   $columns Column count on desktop.
 * @param string $gap    Spacing token for the gap.
 * @param string $class  Extra classes.
 * @return string
 */
function northline_grid( $cells, $columns = 3, $gap = 'var:preset|spacing|60', $class = '' ) {
	return sprintf(
		'<!-- wp:group {"className":"%4$s","style":{"spacing":{"blockGap":{"top":"%3$s","left":"%3$s"}}},"layout":{"type":"grid","columnCount":%1$d}} --><div class="wp-block-group %4$s">%2$s</div><!-- /wp:group -->',
		(int) $columns,
		implode( '', $cells ),
		esc_attr( $gap ),
		esc_attr( $class )
	);
}

/**
 * A row of filter buttons. Each key matches a class WordPress already puts on
 * query-loop items — `project_type-headless`, `download_tag-free` — so the
 * filtering needs no extra markup on the cards themselves.
 *
 * @param array $filters List of [label, key]; "all" shows everything.
 * @return string
 */
function northline_filter_bar( $filters ) {
	$buttons = '';

	foreach ( $filters as $filter ) {
		$buttons .= northline_button( $filter[0], '#', 'secondary', 'nl-filter nl-filter-key-' . $filter[1] );
	}

	return sprintf(
		'<!-- wp:buttons {"className":"nl-rule-bottom","style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"bottom":"var:preset|spacing|50"},"margin":{"bottom":"var:preset|spacing|70"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-buttons nl-rule-bottom" style="margin-bottom:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--50)">%s</div>
<!-- /wp:buttons -->',
		$buttons
	);
}

/**
 * A read-more link dressed as a button, for use inside query loops where each
 * card needs to link to its own post.
 *
 * @param string $label   Link text.
 * @param string $variant primary or secondary.
 * @return string
 */
function northline_read_more( $label, $variant = 'primary' ) {
	$class = 'nl-as-button' . ( 'primary' === $variant ? '' : ' is-secondary' );

	return sprintf(
		'<!-- wp:read-more {"content":"%1$s","className":"%2$s"} /-->',
		esc_attr( $label ),
		esc_attr( $class )
	);
}

/**
 * The meta-line block, pointed at a list of custom fields.
 *
 * @param string $fields    Comma-separated meta keys.
 * @param string $class     Classes on the wrapper.
 * @param string $separator Separator between values.
 * @param string $fallback  Text shown when no field has a value.
 * @return string
 */
function northline_meta_line( $fields, $class = 'nl-meta', $separator = ' · ', $fallback = '' ) {
	$attributes = array(
		'fields'    => $fields,
		'separator' => $separator,
		'className' => $class,
	);

	if ( $fallback ) {
		$attributes['fallback'] = $fallback;
	}

	return sprintf( '<!-- wp:northline/meta-line %s /-->', wp_json_encode( $attributes ) );
}
