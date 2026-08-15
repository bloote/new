<?php
/**
 * Title: Process — four phases in tabs
 * Slug: northline/process-tabs
 * Categories: northline-page
 * Description: The four project phases as a tabbed panel, each with its deliverable, cadence and sign-off.
 * Keywords: process, tabs, phases, method
 * Viewport width: 1400
 */

$phases = array(
	array(
		'01 — Discover',
		'Discover · weeks 1–2',
		'We interview the people who own the outcomes, read the analytics, and inventory the content that already exists. You get a sitemap, a content model and a written scope before design starts.',
		array( array( 'Deliverable', 'Sitemap &amp; content model' ), array( 'Your time', 'Two 90-minute sessions' ), array( 'Sign-off', 'Scope document' ) ),
	),
	array(
		'02 — Design',
		'Design · weeks 3–5',
		'Key templates first, then the system behind them: type scale, grid, components and states. Real copy goes in early so layouts are tested against the words they will carry.',
		array( array( 'Deliverable', 'Templates &amp; design system' ), array( 'Reviews', 'Weekly, 45 minutes' ), array( 'Sign-off', 'Template set' ) ),
	),
	array(
		'03 — Build',
		'Build · weeks 5–10',
		'A custom theme with constrained editor fields, built against a performance budget. You get a staging URL from week six and can add content while we finish the remaining templates.',
		array( array( 'Deliverable', 'Staging site &amp; theme' ), array( 'Cadence', 'Fortnightly demos' ), array( 'Sign-off', 'QA checklist' ) ),
	),
	array(
		'04 — Launch &amp; care',
		'Launch &amp; care · week 11 on',
		'Redirects, analytics, schema and a training session recorded for whoever joins later. Then a care plan: updates, monitoring and a monthly block of hours for the next round of work.',
		array( array( 'Deliverable', 'Live site &amp; training' ), array( 'Handover', 'Recorded walkthrough' ), array( 'After', 'Care plan, monthly' ) ),
	),
);

$buttons = '';
$panels  = '';

foreach ( $phases as $phase ) {
	$buttons .= northline_button( $phase[0], '#', 'secondary', 'nl-tab-btn' );

	$definitions = '';
	foreach ( $phase[3] as $pair ) {
		$definitions .= northline_definition( $pair[0], $pair[1] );
	}

	$panels .= sprintf(
		'<!-- wp:group {"className":"nl-tab-panel","layout":{"type":"default"}} -->
<div class="wp-block-group nl-tab-panel">
<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">%1$s</h3><!-- /wp:heading -->
%2$s
<!-- wp:group {"className":"nl-divided","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} --><div class="wp-block-group nl-divided" style="margin-top:var(--wp--preset--spacing--60)">%3$s</div><!-- /wp:group -->
</div>
<!-- /wp:group -->',
		$phase[1],
		northline_para( $phase[2], 'nl-quiet nl-measure', 'large' ),
		$definitions
	);
}

echo northline_section_open( array( 'name' => 'Process' ) );

echo northline_section_head(
	array(
		'number'  => '04',
		'label'   => 'Process',
		'heading' => 'Four phases, each with something you can review.',
	)
);
?>
<!-- wp:group {"className":"nl-tabs nl-rail-layout nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-tabs nl-rail-layout nl-rule" style="padding-top:var(--wp--preset--spacing--60)">
<!-- wp:buttons {"className":"nl-tab-list","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-buttons nl-tab-list"><?php echo $buttons; ?></div>
<!-- /wp:buttons -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo $panels; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
