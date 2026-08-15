<?php
/**
 * Title: Call to action — services
 * Slug: northline/cta-services
 * Categories: northline-cta
 * Description: The dark closing band, with the services wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Not sure which of these you need?',
		'body'        => 'Send us the site you have now. We will tell you what we would change first, whether or not you hire us.',
		'button_text' => 'Book a call',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or see pricing first',
		'link_url'    => northline_page_url( 'pricing' ),
	)
);
