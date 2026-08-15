<?php
/**
 * Title: Services — six cards
 * Slug: northline/services-grid
 * Categories: northline-page
 * Description: Six framed service cards, each with an index, a short description and its scope as tags.
 * Keywords: services, grid, cards
 * Viewport width: 1400
 */

$services = array(
	array( 'S/01', 'Discovery &amp; strategy', 'Stakeholder interviews, analytics review and a sitemap you can argue about before anything is designed.', array( 'Workshops', 'Sitemap', 'Content audit' ) ),
	array( 'S/02', 'Interface design', 'Page systems, not one-off mockups. Type scale, grid, states and components documented as you go.', array( 'Design system', 'Prototypes', 'Accessibility' ) ),
	array( 'S/03', 'WordPress builds', 'Custom themes and block patterns. Editors get named, constrained fields instead of an empty canvas.', array( 'Block editor', 'ACF', 'Migration' ) ),
	array( 'S/04', 'Headless &amp; commerce', 'When the front end needs to move independently: WordPress as an API, Next.js in front, Woo or Shopify for checkout.', array( 'Next.js', 'WooCommerce', 'GraphQL' ) ),
	array( 'S/05', 'Performance &amp; SEO', 'Core Web Vitals budgets set at design time, plus redirects, schema and analytics handled at launch.', array( 'Web Vitals', 'Schema', 'Redirects' ) ),
	array( 'S/06', 'Care plans', 'Updates, backups, uptime checks and a monthly block of design and dev hours for whatever comes next.', array( 'Monitoring', 'Retainer', 'Support SLA' ) ),
);

$cells = array();

foreach ( $services as $index => $service ) {
	$inner = sprintf(
		'<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%s</span></p><!-- /wp:paragraph -->',
		$service[0]
	)
	. sprintf(
		'<!-- wp:heading {"level":3,"fontSize":"heading-4"} --><h3 class="wp-block-heading has-heading-4-font-size">%s</h3><!-- /wp:heading -->',
		$service[1]
	)
	. northline_para( $service[2], 'nl-quiet nl-fill', 'small' )
	. northline_tags( $service[3] );

	$cells[] = northline_panel( $inner, array( 'reveal' => 'nl-reveal nl-delay-' . ( $index % 3 ) ) );
}

echo northline_section_open( array( 'name' => 'Services' ) );

echo northline_section_head(
	array(
		'number'  => '01',
		'label'   => 'Services',
		'heading' => 'Six things we do, end to end.',
		'body'    => 'Most projects use three or four of these. We scope them together so nothing lands on your team by surprise.',
	)
);

echo northline_grid( $cells, 3 );
echo northline_section_close();
