<?php
/**
 * Title: Header — services
 * Slug: northline/hero-services
 * Categories: northline-hero
 * Description: A services page header with the entry price and a booking button in a framed panel on the right.
 * Keywords: hero, header, services
 * Viewport width: 1400
 */

$aside = northline_definition( 'Engagements start at', '' )
	. '<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"clamp(2.5rem,4vw,3.25rem)"},"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|40"}}}} --><p class="nl-numeral" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--40);font-size:clamp(2.5rem,4vw,3.25rem)">£6,500</p><!-- /wp:paragraph -->'
	. '<!-- wp:buttons --><div class="wp-block-buttons">' . northline_button( 'Book a call', northline_page_url( 'contact' ) ) . '</div><!-- /wp:buttons -->';

echo northline_page_header(
	array(
		'name'        => 'Services header',
		'kicker'      => 'Services',
		'heading'     => 'Strategy, design and code under one roof.',
		'lede'        => 'No handoff between agencies. The people who plan the site design it, and the people who design it build it.',
		'right'       => sprintf(
			'<!-- wp:group {"className":"nl-hairline","style":{"spacing":{"padding":{"left":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|20"},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"width":"0px","style":"none"}}},"layout":{"type":"default"}} --><div class="wp-block-group nl-hairline" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-style:none;border-bottom-width:0px;padding-left:var(--wp--preset--spacing--50)">%s</div><!-- /wp:group -->',
			$aside
		),
		'right_width' => '38%',
	)
);
