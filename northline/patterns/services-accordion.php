<?php
/**
 * Title: Services — expandable detail
 * Slug: northline/services-accordion
 * Categories: northline-page
 * Description: The six services as expandable rows, each opening onto a description and what it includes.
 * Keywords: services, accordion, detail
 * Viewport width: 1400
 */

$services = array(
	array(
		'S/01',
		'Discovery &amp; strategy',
		'We start with the people who own the outcomes: sales, marketing, support. Then the evidence — analytics, search console, session recordings, and every page you already have. The output is a sitemap, a content model and a written scope, so the project starts with agreement rather than assumptions.',
		array( 'Stakeholder interviews', 'Analytics &amp; search review', 'Content inventory', 'Sitemap &amp; content model', 'Scope document' ),
	),
	array(
		'S/02',
		'Interface design',
		'We design the templates that carry the most traffic first, then the system behind them: type scale, grid, spacing, components and every state. Real copy goes in early, so layouts are tested against the words they will actually hold.',
		array( 'Art direction', 'Template designs', 'Component library', 'Interactive prototype', 'WCAG 2.2 AA review' ),
	),
	array(
		'S/03',
		'WordPress builds',
		'Custom themes built on the block editor, with patterns for every section we designed and fields that cannot be used wrongly. Editors get a constrained, predictable set of choices instead of an empty canvas, and the theme ships with a documented pattern library.',
		array( 'Custom theme', 'Block patterns &amp; ACF fields', 'Content migration', 'Editor training', '60-day warranty' ),
	),
	array(
		'S/04',
		'Headless &amp; commerce',
		'When the front end needs its own release cycle, we keep WordPress as the editing surface and put Next.js in front of it. For selling, that means WooCommerce or Shopify behind a checkout we can actually design.',
		array( 'API &amp; schema design', 'Next.js front end', 'Preview &amp; revalidation', 'Checkout flows', 'CI/CD pipeline' ),
	),
	array(
		'S/05',
		'Performance &amp; SEO',
		'Page weight budgets are agreed during design, not discovered at launch. Migrations get a redirect map, a crawl diff and two weeks of monitoring, so rankings survive the move.',
		array( 'Performance budget', 'Core Web Vitals work', 'Structured data', 'Redirect mapping', 'Analytics &amp; events' ),
	),
	array(
		'S/06',
		'Care plans',
		'Launch is the start of the work, not the end. Care plans cover core and plugin updates, backups, uptime checks and a monthly block of design and development hours you decide how to spend.',
		array( 'Updates &amp; backups', 'Uptime &amp; error monitoring', '8 hours monthly', 'Quarterly review', 'Same-day support SLA' ),
	),
);

echo northline_section_open( array( 'name' => 'Service detail' ) );

foreach ( $services as $index => $service ) {
	$body = sprintf(
		'<!-- wp:columns {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40"},"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns" style="padding-top:var(--wp--preset--spacing--40)">
<!-- wp:column {"width":"58%%"} --><div class="wp-block-column" style="flex-basis:58%%">%1$s</div><!-- /wp:column -->
<!-- wp:column {"width":"42%%"} --><div class="wp-block-column" style="flex-basis:42%%"><!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">Includes</p><!-- /wp:paragraph -->%2$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		northline_para( $service[2], 'nl-quiet', 'large' ),
		northline_plain_list( $service[3], 'medium' )
	);

	echo northline_accordion_row( $service[1], $body, 0 === $index, $service[0] );
}

echo northline_section_close();
