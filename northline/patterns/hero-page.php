<?php
/**
 * Title: Header — plain page
 * Slug: northline/hero-page
 * Categories: northline-hero
 * Description: A blank page header to start any new page from: kicker, headline, standfirst.
 * Keywords: hero, header, page
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'    => 'Page header',
		'kicker'  => 'Section',
		'heading' => 'A headline that says what this page is for.',
		'lede'    => 'One or two sentences of standfirst. Keep it under fifty words; the page below has room for the detail.',
	)
);
