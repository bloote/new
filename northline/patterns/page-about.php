<?php
/**
 * Title: Page — about
 * Slug: northline/page-about
 * Categories: northline-pages
 * Post Types: page
 * Description: Who you are, in the usual order: a header, two columns of the story, the people, someone else's opinion of you, and a way to get in touch.
 * Keywords: page, about, team, story, layout, starter
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'    => 'Page header',
		'kicker'  => 'About',
		'heading' => 'Who we are, in one line.',
		'lede'    => 'A standfirst with the two facts a stranger needs: what you do, and how long you have been doing it.',
	)
);

echo northline_patterns(
	array(
		'section-columns',
		'section-people',
		'section-quote',
		'cta-plain',
	)
);
