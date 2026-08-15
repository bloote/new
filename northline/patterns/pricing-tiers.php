<?php
/**
 * Title: Pricing — three tiers with a term switch
 * Slug: northline/pricing-tiers
 * Categories: northline-page
 * Description: Sprint, full build and platform, with a switch between the project fee and the same fee spread over six months.
 * Keywords: pricing, tiers, plans
 * Viewport width: 1400
 */

$tiers = array(
	array(
		'Sprint',
		'£6,500',
		'£1,150',
		'',
		'Two weeks, one outcome. A landing page, one redesigned template, or a performance rescue on a site you already have.',
		array( 'Kick-off workshop', 'One template, designed and built', 'Performance pass', 'Two weeks elapsed', '30-day warranty' ),
		'Enquire',
		'secondary',
		false,
	),
	array(
		'Full build',
		'£28,000',
		'£4,900',
		'Most projects',
		'Discovery through launch for a marketing site of up to 30 templates, including migration and editor training.',
		array( 'Discovery &amp; content model', 'Full design system', 'Custom WordPress theme', 'Migration &amp; redirects', 'Training &amp; 60-day warranty', '8–12 weeks elapsed' ),
		'Book a call',
		'primary',
		true,
	),
	array(
		'Platform',
		'£65,000+',
		'£10,800+',
		'',
		'Headless or commerce work: multiple front ends, integrations, and a release process your developers keep using.',
		array( 'Everything in Full build', 'API &amp; integration design', 'Next.js front end', 'Commerce &amp; checkout', 'CI/CD and test coverage', '16–24 weeks elapsed' ),
		'Enquire',
		'secondary',
		false,
	),
);

$cells = array();

foreach ( $tiers as $tier ) {
	$head = $tier[3]
		? sprintf(
			'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%1$s</span></p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-tag nl-tag-accent","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-tag nl-tag-accent" style="margin-bottom:0">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
			$tier[0],
			$tier[3]
		)
		: sprintf(
			'<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%s</span></p><!-- /wp:paragraph -->',
			$tier[0]
		);

	$inner = $head
		. sprintf(
			'<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"clamp(2.375rem,4vw,3.25rem)"}}} --><p class="nl-numeral" style="font-size:clamp(2.375rem,4vw,3.25rem)"><span class="nl-switch-a">%1$s</span><span class="nl-switch-b">%2$s</span></p><!-- /wp:paragraph -->',
			$tier[1],
			$tier[2]
		)
		. northline_para( $tier[4], 'nl-quiet', 'small' )
		. sprintf(
			'<!-- wp:group {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}},"layout":{"type":"default"}} --><div class="wp-block-group nl-rule" style="padding-top:var(--wp--preset--spacing--40)">%s</div><!-- /wp:group -->',
			northline_plain_list( $tier[5], 'small' )
		)
		. sprintf(
			'<!-- wp:buttons {"layout":{"type":"flex","orientation":"vertical"}} --><div class="wp-block-buttons">%s</div><!-- /wp:buttons -->',
			northline_button( $tier[6], northline_page_url( 'contact' ), $tier[7] )
		);

	$cells[] = northline_panel( $inner, array( 'background' => $tier[8] ? 'accent-tint' : '' ) );
}

echo northline_section_open(
	array(
		'name'   => 'Pricing tiers',
		'class'  => 'nl-rule nl-switch',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"bottom":"var:preset|spacing|70"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--70)">
<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">Show prices as</p><!-- /wp:paragraph -->
<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex"}} -->
<div class="wp-block-buttons">
<?php
echo northline_button( 'Project fee', '#', 'secondary', 'nl-switch-opt' );
echo northline_button( 'Monthly, 6 months', '#', 'secondary', 'nl-switch-opt' );
?>
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<?php
echo northline_grid( $cells, 3 );
echo northline_para( 'Monthly figures spread the same fee over six payments. VAT is added where applicable.', 'nl-quieter', 'small' );
echo northline_section_close();
