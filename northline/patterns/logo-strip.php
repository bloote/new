<?php
/**
 * Title: Client logo strip
 * Slug: northline/logo-strip
 * Categories: northline-page
 * Description: A quiet band of client names set in the heading face, revealed in sequence.
 * Keywords: logos, clients, trust
 * Viewport width: 1400
 */

$names = array( 'Halcyon', 'Merrick &amp; Co', 'Fieldnote', 'Northgate Health', 'Kelso Rail' );
$out   = '<!-- wp:paragraph {"className":"nl-meta nl-fill"} --><p class="nl-meta nl-fill">Trusted by teams at</p><!-- /wp:paragraph -->';

foreach ( $names as $index => $name ) {
	$out .= sprintf(
		'<!-- wp:paragraph {"className":"nl-numeral nl-reveal nl-delay-%1$d","style":{"typography":{"fontSize":"1.375rem","letterSpacing":"0.04em"},"spacing":{"margin":{"bottom":"0"}}},"textColor":"muted"} --><p class="nl-numeral nl-reveal nl-delay-%1$d has-muted-color has-text-color" style="margin-bottom:0;font-size:1.375rem;letter-spacing:0.04em">%2$s</p><!-- /wp:paragraph -->',
		$index % 4,
		$name
	);
}

echo northline_section_open(
	array(
		'name'       => 'Client logos',
		'background' => 'surface',
		'top'        => 'var:preset|spacing|50',
		'bottom'     => 'var:preset|spacing|50',
	)
);
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><?php echo $out; ?></div>
<!-- /wp:group -->
<?php
echo northline_section_close();
