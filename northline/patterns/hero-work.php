<?php
/**
 * Title: Header — work
 * Slug: northline/hero-work
 * Categories: northline-hero
 * Description: The work index header, with the sectors and typical project size listed beside it.
 * Keywords: hero, header, work, portfolio
 * Viewport width: 1400
 */

$aside = northline_definition( 'Sectors', 'Healthcare · Rail · Media · B2B SaaS' )
	. northline_definition( 'Typical size', '15–90 templates' );

echo northline_page_header(
	array(
		'name'        => 'Work header',
		'kicker'      => 'Work',
		'heading'     => 'Twenty-four builds, three that we still think about.',
		'lede'        => 'A sample of recent projects, with what actually changed after launch. Filter by the kind of build.',
		'right'       => sprintf(
			'<!-- wp:group {"className":"nl-hairline","style":{"spacing":{"padding":{"left":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|40"},"border":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"width":"0px","style":"none"}}},"layout":{"type":"default"}} --><div class="wp-block-group nl-hairline" style="border-top-style:none;border-top-width:0px;border-right-style:none;border-right-width:0px;border-bottom-style:none;border-bottom-width:0px;padding-left:var(--wp--preset--spacing--50)">%s</div><!-- /wp:group -->',
			$aside
		),
		'right_width' => '38%',
	)
);
