<?php
/**
 * Title: Page — contact
 * Slug: northline/page-contact
 * Categories: northline-pages
 * Post Types: page
 * Description: A header, the theme's enquiry form beside your details, and the questions people ask before they send it. The form posts to WordPress and needs no plugin.
 * Keywords: page, contact, form, enquiry, layout, starter
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'    => 'Page header',
		'kicker'  => 'Contact',
		'heading' => 'Get in touch.',
		'lede'    => 'A sentence promising a reply, and saying how long it takes.',
	)
);

echo northline_patterns(
	array(
		'section-form',
		'section-faq',
		'cta-plain',
	)
);
