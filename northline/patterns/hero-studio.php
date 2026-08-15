<?php
/**
 * Title: Header — studio
 * Slug: northline/hero-studio
 * Categories: northline-hero
 * Description: The about page header, with a studio plate on the right.
 * Keywords: hero, header, about, studio
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Studio header',
		'kicker'      => 'The studio',
		'heading'     => 'Six people, no account managers.',
		'lede'        => 'Northline has been a small studio since 2016, on purpose. You talk to the person doing the work, and the estimate comes from them.',
		'right'       => northline_image_block(
			'studio-room.jpg',
			array(
				'ratio' => '5/4',
				'alt'   => 'Blueprint plate standing in for a photograph of the studio',
			)
		),
		'right_width' => '42%',
	)
);
