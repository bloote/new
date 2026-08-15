<?php
/**
 * Title: Care plans
 * Slug: northline/care-plans
 * Categories: northline-page
 * Description: Three monthly care plans, from updates only to an embedded designer and developer.
 * Keywords: pricing, care, retainer, support
 * Viewport width: 1400
 */

$plans = array(
	array( 'Essential', '£450', 'Updates, backups, uptime monitoring and two hours of support.' ),
	array( 'Standard', '£1,200', 'Everything in Essential plus eight hours of design and development each month.' ),
	array( 'Embedded', '£3,400', 'A designer and a developer on your roadmap, four days a month, with quarterly planning.' ),
);

$cells = array();

foreach ( $plans as $index => $plan ) {
	$inner = sprintf(
		'<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%s</span></p><!-- /wp:paragraph -->',
		$plan[0]
	)
	. sprintf(
		'<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"2.375rem"}}} --><p class="nl-numeral" style="font-size:2.375rem">%s<span class="nl-quiet" style="font-size:1rem">/mo</span></p><!-- /wp:paragraph -->',
		$plan[1]
	)
	. northline_para( $plan[2], 'nl-quiet', 'small' );

	$cells[] = northline_panel( $inner, array( 'reveal' => 'nl-reveal nl-delay-' . $index ) );
}

echo northline_section_open( array( 'name' => 'Care plans' ) );

echo northline_section_head(
	array(
		'number'  => '02',
		'label'   => 'After launch',
		'heading' => 'Care plans, billed monthly.',
	)
);

echo northline_grid( $cells, 3 );
echo northline_section_close();
