<?php
/**
 * Title: Call to action — themes
 * Slug: northline/cta-themes
 * Categories: northline-cta
 * Description: The dark closing band, with the themes wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Need a theme that does not exist yet?',
		'body'        => 'We build themes to order, starting from any of these. You get the source, the licence and the documentation.',
		'button_text' => 'Order a custom theme',
		'button_url'  => northline_page_url( 'custom-orders' ),
		'link_text'   => 'or browse the plugins',
		'link_url'    => northline_page_url( 'plugins' ),
	)
);
