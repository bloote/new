<?php
/**
 * Title: Header — tutorials and docs
 * Slug: northline/hero-docs
 * Categories: northline-hero
 * Description: The documentation header, explaining that everything is editable from the Site Editor.
 * Keywords: hero, header, docs, tutorials
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Docs header',
		'kicker'      => 'Tutorials &amp; docs',
		'heading'     => 'Everything here is a block theme you edit from the admin.',
		'lede'        => 'Every page and section is a pattern built from core blocks, so templates, colours, type and content are editable in the Site Editor. No page builder, no shortcodes, no theme options screen to learn.',
		'right'       => northline_figures_box(
			array(
				array( 'Tutorials', northline_counter( '24', ' written' ) ),
				array( 'Video walkthroughs', northline_counter( '8', ' recorded' ) ),
				array( 'Editing surface', 'Site Editor' ),
				array( 'Requires', 'WP 6.4+' ),
			)
		),
		'right_width' => '42%',
	)
);
