<?php
/**
 * Title: Docs — quick start
 * Slug: northline/docs-quickstart
 * Categories: northline-page
 * Description: Four numbered steps from installing the theme to publishing a page, with the WP-CLI equivalents.
 * Keywords: docs, tutorial, install, quick start
 * Viewport width: 1400
 */

$steps = array(
	array( '01', 'Install and activate', 'Upload the zip under Appearance → Themes → Add New. Activate it, then open Appearance → Editor to confirm the Site Editor loads.', 'wp theme install northline.zip --activate' ),
	array( '02', 'Import the starter content', 'Optional, and reversible. It creates the demo pages, menus and sample posts so you can see how each pattern is assembled before writing your own.', 'wp northline demo import' ),
	array( '03', 'Set your brand once', 'In the Site Editor, open Styles → Colours and Typography. Change the palette and the two font families there and every template, pattern and block follows. Nothing is hard-coded in a stylesheet you cannot reach.', '' ),
	array( '04', 'Build a page from patterns', 'Add a new page, open the inserter, choose the Patterns tab, and drop in the sections you need. Each one arrives as ordinary core blocks: edit the text in place, swap the image, delete what you do not want.', '' ),
);

$rows = '';

foreach ( $steps as $step ) {
	$right = northline_para( $step[2], 'nl-quiet', 'large' );

	if ( $step[3] ) {
		$right .= sprintf(
			'<!-- wp:paragraph {"className":"nl-mono"} --><p class="nl-mono">%s</p><!-- /wp:paragraph -->',
			esc_html( $step[3] )
		);
	}

	$rows .= sprintf(
		'<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"90px"} --><div class="wp-block-column" style="flex-basis:90px"><!-- wp:paragraph {"className":"nl-numeral","textColor":"accent-deep","style":{"typography":{"fontSize":"1.625rem"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-numeral has-accent-deep-color has-text-color" style="margin-bottom:0;font-size:1.625rem">%1$s</p><!-- /wp:paragraph --></div><!-- /wp:column -->
<!-- wp:column {"width":"32%%"} --><div class="wp-block-column" style="flex-basis:32%%"><!-- wp:heading {"level":3,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} --><h3 class="wp-block-heading has-heading-4-font-size" style="margin-top:0;margin-bottom:0">%2$s</h3><!-- /wp:heading --></div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column">%3$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		$step[0],
		$step[1],
		$right
	);
}

echo northline_section_open( array( 'name' => 'Quick start' ) );

echo northline_section_head(
	array(
		'number'  => '01',
		'label'   => 'Quick start',
		'heading' => 'From download to a published page in about ten minutes.',
	)
);
?>
<!-- wp:group {"className":"nl-rows","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rows"><?php echo $rows; ?></div>
<!-- /wp:group -->
<?php
echo northline_section_close();
