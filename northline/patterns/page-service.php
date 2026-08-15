<?php
/**
 * Title: Page — a single service
 * Slug: northline/page-service
 * Categories: northline-pages
 * Post Types: page
 * Description: A whole page for one service: header, what it is, three parts, the questions people ask, and a closing band. Every section is one of the general-purpose patterns, so you can delete or reorder any of them.
 * Keywords: page, service, layout, starter
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'    => 'Page header',
		'kicker'  => 'Services',
		'heading' => 'The name of the service.',
		'lede'    => 'One sentence saying who it is for and what they get at the end of it. Under forty words.',
	)
);

echo northline_patterns(
	array(
		'section-media-text',
		'section-cards',
		'section-faq',
		'cta-plain',
	)
);
