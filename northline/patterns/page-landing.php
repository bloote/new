<?php
/**
 * Title: Page — a landing page
 * Slug: northline/page-landing
 * Categories: northline-pages
 * Post Types: page
 * Description: A page with one job: a header with the figures beside it, the numbers, the explanation, a quotation and the ask. Built from the general-purpose sections.
 * Keywords: page, landing, campaign, layout, starter
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Page header',
		'kicker'      => 'Campaign',
		'heading'     => 'The one thing this page is for.',
		'lede'        => 'A standfirst that repeats the offer in plainer words than the headline, and says what it costs to find out more.',
		'right'       => northline_figures_box(
			array(
				array( 'A measure', northline_counter( '120' ) ),
				array( 'Another', northline_counter( '48', '%' ) ),
				array( 'A third', northline_counter( '9.4' ) ),
				array( 'A fourth', northline_counter( '15', ' yrs' ) ),
			)
		),
		'right_width' => '38%',
	)
);

echo northline_patterns(
	array(
		'section-figures',
		'section-media-text',
		'section-quote',
		'cta-plain',
	)
);
