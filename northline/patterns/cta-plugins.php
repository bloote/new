<?php
/**
 * Title: Call to action — plugins
 * Slug: northline/cta-plugins
 * Categories: northline-cta
 * Description: The dark closing band, with the plugins wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Need one of these to do something else?',
		'body'        => 'We take plugin work to order, either as a private build for your site or as a feature in the public release.',
		'button_text' => 'Order a custom plugin',
		'button_url'  => northline_page_url( 'custom-orders' ),
		'link_text'   => 'or browse scripts and tools',
		'link_url'    => northline_page_url( 'scripts-and-tools' ),
	)
);
