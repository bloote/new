<?php
/**
 * Title: Call to action — custom orders
 * Slug: northline/cta-custom
 * Categories: northline-cta
 * Description: The dark closing band, with the custom orders wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Not sure it is worth building?',
		'body'        => 'Half the orders we quote turn out to be solvable with something we already released. We will tell you when that is the case.',
		'button_text' => 'Book a call',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or look at what exists already',
		'link_url'    => northline_page_url( 'plugins' ),
	)
);
