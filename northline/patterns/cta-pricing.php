<?php
/**
 * Title: Call to action — pricing
 * Slug: northline/cta-pricing
 * Categories: northline-cta
 * Description: The dark closing band, with the pricing wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Get a real number for your project.',
		'body'        => 'Thirty minutes on a call is usually enough for us to give you a band and the two things that would move it.',
		'button_text' => 'Book a call',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or see the work first',
		'link_url'    => northline_archive_url( 'project' ),
	)
);
