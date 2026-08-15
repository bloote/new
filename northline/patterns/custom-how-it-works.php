<?php
/**
 * Title: Custom orders — how ordering works
 * Slug: northline/custom-how-it-works
 * Categories: northline-page
 * Description: Four numbered steps from brief to handover, with the point where you can walk away marked.
 * Keywords: process, ordering, steps
 * Viewport width: 1400
 */

$steps = array(
	array( '01', 'Send the order brief', 'The form below, or an email with whatever you already have. Screenshots of the thing you wish existed are ideal.' ),
	array( '02', 'Fixed quote in two days', 'A price, a delivery date and a written list of what is and is not included. Free, and yours to walk away from.' ),
	array( '03', 'Build, with two review points', '50% up front. You see it working halfway through and again before delivery, with one round of revisions at each.' ),
	array( '04', 'Handover and 60 days of fixes', 'Source in your repository, documentation, and a recorded walkthrough. Anything broken in the first 60 days is fixed free.' ),
);

$rows = '';

foreach ( $steps as $step ) {
	$rows .= sprintf(
		'<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"90px"} --><div class="wp-block-column" style="flex-basis:90px"><!-- wp:paragraph {"className":"nl-numeral","textColor":"accent-deep","style":{"typography":{"fontSize":"1.625rem"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-numeral has-accent-deep-color has-text-color" style="margin-bottom:0;font-size:1.625rem">%1$s</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column {"width":"38%%"} --><div class="wp-block-column" style="flex-basis:38%%"><!-- wp:heading {"level":3,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} --><h3 class="wp-block-heading has-heading-4-font-size" style="margin-top:0;margin-bottom:0">%2$s</h3><!-- /wp:heading --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column">%3$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		$step[0],
		$step[1],
		northline_para( $step[2], 'nl-quiet', 'large' )
	);
}

echo northline_section_open(
	array(
		'name'       => 'How ordering works',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '02',
		'label'   => 'How it works',
		'heading' => 'Four steps, and you can stop after the second.',
	)
);
?>
<!-- wp:group {"className":"nl-rows","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rows"><?php echo $rows; ?></div>
<!-- /wp:group -->
<?php
echo northline_section_close();
