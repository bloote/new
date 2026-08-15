<?php
/**
 * Title: Engagements — three ways to work
 * Slug: northline/pricing-cards
 * Categories: northline-page
 * Description: Three engagement cards — sprint, full build and care plan — with the middle one marked as the usual choice.
 * Keywords: pricing, engagements, packages
 * Viewport width: 1400
 */

$tiers = array(
	array( 'Sprint', '£6,500', '', 'Two weeks, one outcome: a landing page, a redesigned template, or a performance rescue.', 'Details', northline_page_url( 'pricing' ), 'secondary', false ),
	array( 'Full build', '£28,000', 'Most projects', 'Discovery through launch for a marketing site of up to 30 templates, with training and a 60-day warranty.', 'Book a call', northline_page_url( 'contact' ), 'primary', true ),
	array( 'Care plan', '£1,200', '', 'Updates, monitoring, backups and eight hours of design and development each month.', 'Details', northline_page_url( 'pricing' ), 'secondary', false ),
);

$cells = array();

foreach ( $tiers as $index => $tier ) {
	$head = $tier[2]
		? sprintf(
			'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%1$s</span></p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-tag nl-tag-accent","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-tag nl-tag-accent" style="margin-bottom:0">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
			$tier[0],
			$tier[2]
		)
		: sprintf(
			'<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%s</span></p><!-- /wp:paragraph -->',
			$tier[0]
		);

	$suffix = 'Care plan' === $tier[0] ? '<span class="nl-quiet" style="font-size:1.125rem">/mo</span>' : '';

	$inner = $head
		. sprintf(
			'<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"2.75rem"}}} --><p class="nl-numeral" style="font-size:2.75rem">%s%s</p><!-- /wp:paragraph -->',
			$tier[1],
			$suffix
		)
		. northline_para( $tier[3], 'nl-quiet nl-fill', 'small' )
		. sprintf(
			'<!-- wp:buttons {"layout":{"type":"flex","orientation":"vertical"}} --><div class="wp-block-buttons">%s</div><!-- /wp:buttons -->',
			northline_button( $tier[4], $tier[5], $tier[6], 'nl-block-button' )
		);

	$cells[] = northline_panel(
		$inner,
		array(
			'reveal'     => 'nl-reveal nl-delay-' . $index,
			'background' => $tier[7] ? 'accent-tint' : '',
		)
	);
}

echo northline_section_open( array( 'name' => 'Engagements' ) );

echo northline_section_head(
	array(
		'number'      => '07',
		'label'       => 'Engagements',
		'heading'     => 'Three ways to work with us.',
		'button_text' => 'Full pricing',
		'button_url'  => northline_page_url( 'pricing' ),
		'align'       => 'end',
	)
);

echo northline_grid( $cells, 3 );
echo northline_section_close();
