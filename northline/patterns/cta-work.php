<?php
/**
 * Title: Call to action — work
 * Slug: northline/cta-work
 * Categories: northline-cta
 * Description: The dark closing band, with the work wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Want the version of this with your name on it?',
		'body'        => 'We can share the full case studies, including the ones that were harder than they look.',
		'button_text' => 'Book a call',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or read what we do',
		'link_url'    => northline_page_url( 'services' ),
	)
);
