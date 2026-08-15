<?php
/**
 * Title: Header — scripts catalogue
 * Slug: northline/hero-scripts
 * Categories: northline-hero
 * Description: The scripts and tools header with a framed figures box.
 * Keywords: hero, header, downloads, scripts
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Scripts header',
		'kicker'      => 'Downloads · Scripts &amp; tools',
		'heading'     => 'Dependency-free scripts, and tools that run in the browser.',
		'lede'        => 'All free, all MIT. Vanilla JavaScript with no framework and no build step, plus the small utilities we got tired of rewriting.',
		'right'       => northline_figures_box(
			array(
				array( 'Scripts', northline_counter( '9', ' released' ) ),
				array( 'Browser tools', northline_counter( '6', ' live' ) ),
				array( 'Licence', 'MIT' ),
				array( 'Dependencies', 'None' ),
			)
		),
		'right_width' => '42%',
	)
);
