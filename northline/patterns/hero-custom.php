<?php
/**
 * Title: Header — custom orders
 * Slug: northline/hero-custom
 * Categories: northline-hero
 * Description: The custom orders header with turnaround, entry price and quote time.
 * Keywords: hero, header, custom, orders
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Custom orders header',
		'kicker'      => 'Per-order work',
		'heading'     => 'Themes, plugins and scripts built to your order.',
		'lede'        => 'One fixed price, one delivery date, and the source in your repository at the end. Smaller than a full site project and quoted the same way: after we understand it, not before.',
		'right'       => northline_figures_box(
			array(
				array( 'Orders delivered', northline_counter( '180', '+' ) ),
				array( 'Typical turnaround', '2–5 weeks' ),
				array( 'Orders start at', '£850' ),
				array( 'Quote sent within', '2 days' ),
			)
		),
		'right_width' => '42%',
	)
);
