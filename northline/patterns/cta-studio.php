<?php
/**
 * Title: Call to action — studio
 * Slug: northline/cta-studio
 * Categories: northline-cta
 * Description: The dark closing band, with the studio wording.
 * Keywords: cta, call to action, contact
 * Viewport width: 1400
 */

echo northline_cta_band(
	array(
		'heading'     => 'Come and talk to the people who will build it.',
		'body'        => 'We take on roughly one new project a month. Tell us what you are planning and when it needs to be live.',
		'button_text' => 'Book a call',
		'button_url'  => northline_page_url( 'contact' ),
		'link_text'   => 'or look at the work',
		'link_url'    => northline_archive_url( 'project' ),
	)
);
