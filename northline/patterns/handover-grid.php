<?php
/**
 * Title: Handover — what you own
 * Slug: northline/handover-grid
 * Categories: northline-page
 * Description: Four framed cards listing what the client keeps at the end of a project.
 * Keywords: handover, deliverables, ownership
 * Viewport width: 1400
 */

$items = array(
	array( 'Source &amp; repository', 'The theme repo, commit history and deployment pipeline, transferred to your organisation.' ),
	array( 'Design files', 'Figma library with tokens, components and every template, organised for reuse.' ),
	array( 'Documentation', 'Pattern reference, editor guide and a recorded walkthrough for whoever joins later.' ),
	array( 'Measurement', 'Analytics, events and a dashboard tracking the outcomes we agreed in discovery.' ),
);

$cells = array();

foreach ( $items as $index => $item ) {
	$cells[] = northline_panel(
		sprintf( '<!-- wp:heading {"level":3,"fontSize":"heading-4"} --><h3 class="wp-block-heading has-heading-4-font-size">%s</h3><!-- /wp:heading -->', $item[0] )
		. northline_para( $item[1], 'nl-quiet', 'small' ),
		array( 'reveal' => 'nl-reveal nl-delay-' . ( $index % 4 ) )
	);
}

echo northline_section_open(
	array(
		'name'       => 'Handover',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '09',
		'label'   => 'Handover',
		'heading' => 'What you own at the end.',
	)
);

echo northline_grid( $cells, 4 );
echo northline_section_close();
