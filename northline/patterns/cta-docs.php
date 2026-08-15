<?php
/**
 * Title: Call to action — docs
 * Slug: northline/cta-docs
 * Categories: northline-cta
 * Description: The dark closing band, with the docs wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Stuck on something the docs do not cover?',
		'body'        => 'Ask us. Questions that come up twice become tutorials, so you are doing the next person a favour.',
		'button_text' => 'Ask a question',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or have us build it for you',
		'link_url'    => northline_page_url( 'custom-orders' ),
	)
);
