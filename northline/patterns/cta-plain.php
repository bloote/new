<?php
/**
 * Title: Call to action — plain
 * Slug: northline/cta-plain
 * Categories: northline-cta
 * Description: The dark closing band with placeholder wording, for pages you write yourself. The others in this group are the same band with the copy already fixed to a particular page.
 * Keywords: cta, call to action, contact, generic
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'One sentence asking for the next step.',
		'body'        => 'A line under it saying what happens when they take it, and how long it takes.',
		'button_text' => 'The action',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or a quieter second option',
		'link_url'    => '#',
	)
);
