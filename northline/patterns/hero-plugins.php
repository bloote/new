<?php
/**
 * Title: Header — plugins catalogue
 * Slug: northline/hero-plugins
 * Categories: northline-hero
 * Description: The plugins catalogue header with a framed figures box.
 * Keywords: hero, header, downloads, plugins
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Plugins header',
		'kicker'      => 'Downloads · WordPress plugins',
		'heading'     => 'Small plugins that do one thing properly.',
		'lede'        => 'Each one came out of a client build where nothing on the repository fit. No upsell nags, no bundled analytics, no admin dashboard widgets.',
		'right'       => northline_figures_box(
			array(
				array( 'Free plugins', northline_counter( '11', ' available' ) ),
				array( 'Pro plugins', northline_counter( '5', ' available' ) ),
				array( 'Active installs', northline_counter( '72', 'k+' ) ),
				array( 'Tested to', 'WP 6.8' ),
			)
		),
		'right_width' => '42%',
	)
);
