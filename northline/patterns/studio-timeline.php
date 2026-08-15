<?php
/**
 * Title: Studio — history
 * Slug: northline/studio-timeline
 * Categories: northline-page
 * Description: Four dated rows tracing how the studio grew.
 * Keywords: about, history, timeline, studio
 * Viewport width: 1400
 */

$years = array(
	array( '2016', 'Maya starts the studio from a desk in Bristol, building WordPress sites for healthcare and charity clients.' ),
	array( '2019', 'Design and engineering leads join. We stop taking single-page projects and start quoting whole builds.' ),
	array( '2022', 'First headless build ships. Care plans become a standing offer rather than an afterthought.' ),
	array( '2026', 'Six people, remote-first, 61 launches. Still no account managers.' ),
);

$rows = '';

foreach ( $years as $year ) {
	$rows .= sprintf(
		'<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"140px"} --><div class="wp-block-column" style="flex-basis:140px"><!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"1.375rem"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-numeral" style="margin-bottom:0;font-size:1.375rem">%1$s</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column">%2$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		$year[0],
		northline_para( $year[1], 'nl-quiet nl-measure', 'large' )
	);
}

echo northline_section_open( array( 'name' => 'History' ) );
?>
<!-- wp:group {"className":"nl-rail-layout","layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>03</span><span>History</span></p><!-- /wp:paragraph -->
<!-- wp:group {"className":"nl-rows","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rows"><?php echo $rows; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
