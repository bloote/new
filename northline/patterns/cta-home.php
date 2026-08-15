<?php
/**
 * Title: Call to action — home
 * Slug: northline/cta-home
 * Categories: northline-cta
 * Description: The dark closing band, with the home wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Tell us what you are building.',
		'body'        => 'A 30-minute call, no deck. We will tell you what we would do first and roughly what it costs.',
		'button_text' => 'Book a call',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or email studio@northline.co',
		'link_url'    => 'mailto:studio@northline.co',
	)
);
