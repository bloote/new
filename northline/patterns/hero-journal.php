<?php
/**
 * Title: Header — journal
 * Slug: northline/hero-journal
 * Categories: northline-hero
 * Description: A single-column header for the journal index.
 * Keywords: hero, header, blog, journal
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'    => 'Journal header',
		'kicker'  => 'Journal',
		'heading' => 'Notes from the work, written by whoever did it.',
		'lede'    => 'Content modelling, performance, WordPress and the occasional post-mortem. Roughly two a month.',
	)
);
