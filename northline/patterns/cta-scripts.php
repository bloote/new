<?php
/**
 * Title: Call to action — scripts
 * Slug: northline/cta-scripts
 * Categories: northline-cta
 * Description: The dark closing band, with the scripts wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Want a script written for your stack?',
		'body'        => 'Single-purpose scripts, widgets and internal tools, quoted per order and delivered with tests and documentation.',
		'button_text' => 'Order a script',
		'button_url'  => northline_page_url( 'custom-orders' ),
		'link_text'   => 'or browse the themes',
		'link_url'    => northline_page_url( 'themes' ),
	)
);
