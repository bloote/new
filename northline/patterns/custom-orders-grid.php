<?php
/**
 * Title: Custom orders — six kinds of order
 * Slug: northline/custom-orders-grid
 * Categories: northline-page
 * Description: The six things you can order, each with a price band and a turnaround.
 * Keywords: custom, orders, pricing, services
 * Viewport width: 1400
 */

$orders = array(
	array( 'O/01', 'Custom WordPress theme', 'Designed and built from your brand, or built from your existing designs. Block patterns, constrained editor fields and a child theme starter.', '£4,500', '3–6 weeks · design included' ),
	array( 'O/02', 'Custom plugin', 'A private plugin for your site, or a feature added to one of ours. Includes tests, an uninstall routine and documentation for your team.', '£2,200', '2–4 weeks · private or public' ),
	array( 'O/03', 'Script or widget', 'A single-purpose JavaScript: a calculator, configurator, embeddable widget or an interaction your CMS cannot do on its own.', '£850', '1–2 weeks · framework-free' ),
	array( 'O/04', 'Internal tool', 'A small browser tool for your team: a quote builder, a data cleaner, a bulk editor. Runs on your hosting or entirely client-side.', '£3,400', '3–5 weeks · scoped per feature' ),
	array( 'O/05', 'Theme customisation', 'Changes to one of our themes, or to a third-party theme you already run. Delivered as a child theme so updates keep working.', '£950', '1–2 weeks · child theme' ),
	array( 'O/06', 'Migration or rescue', 'Moving off a page builder, off Wix or Squarespace, or onto a maintainable theme. Includes the redirect map and post-launch monitoring.', '£1,900', '2–4 weeks · content included' ),
);

$cells = array();

foreach ( $orders as $index => $order ) {
	$inner = sprintf(
		'<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%s</span></p><!-- /wp:paragraph -->',
		$order[0]
	)
	. sprintf(
		'<!-- wp:heading {"level":3,"fontSize":"heading-4"} --><h3 class="wp-block-heading has-heading-4-font-size">%s</h3><!-- /wp:heading -->',
		$order[1]
	)
	. northline_para( $order[2], 'nl-quiet nl-fill', 'small' )
	. sprintf(
		'<!-- wp:group {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group nl-rule" style="padding-top:var(--wp--preset--spacing--30)">
<!-- wp:paragraph {"className":"nl-quiet","fontSize":"small","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-quiet has-small-font-size" style="margin-bottom:0">From</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"1.25rem"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-numeral" style="margin-bottom:0;font-size:1.25rem">%s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		$order[3]
	)
	. sprintf(
		'<!-- wp:paragraph {"className":"nl-quieter","fontSize":"small","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-quieter has-small-font-size" style="margin-bottom:0">%s</p><!-- /wp:paragraph -->',
		$order[4]
	);

	$cells[] = northline_panel( $inner, array( 'reveal' => 'nl-reveal nl-delay-' . ( $index % 3 ) ) );
}

echo northline_section_open( array( 'name' => 'What you can order' ) );

echo northline_section_head(
	array(
		'number'  => '01',
		'label'   => 'What you can order',
		'heading' => 'Six kinds of order, each with a price band.',
	)
);

echo northline_grid( $cells, 3 );
echo northline_section_close();
