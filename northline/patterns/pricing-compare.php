<?php
/**
 * Title: Pricing — comparison table
 * Slug: northline/pricing-compare
 * Categories: northline-page
 * Description: What each engagement includes, side by side.
 * Keywords: pricing, table, comparison
 * Viewport width: 1400
 */

$rows = array(
	array( 'Discovery &amp; content model', 'Half day', 'Two weeks', 'Three weeks' ),
	array( 'Templates designed', '1', 'Up to 30', 'Unlimited' ),
	array( 'Design system', 'Existing only', 'Full library', 'Full library' ),
	array( 'Content migration', '—', 'Included', 'Included' ),
	array( 'Performance budget', 'Included', 'Included', 'Included' ),
	array( 'Accessibility audit', '—', 'WCAG 2.2 AA', 'WCAG 2.2 AA' ),
	array( 'Editor training', '—', 'Two sessions', 'Four sessions' ),
	array( 'Warranty', '30 days', '60 days', '90 days' ),
	array( 'Care plan', 'Optional', 'First month free', 'First three months free' ),
);

$body = '';
foreach ( $rows as $row ) {
	$body .= '<tr><td>' . implode( '</td><td>', $row ) . '</td></tr>';
}

echo northline_section_open(
	array(
		'name'       => 'Comparison',
		'background' => 'surface',
	)
);
?>
<!-- wp:heading {"fontSize":"heading-2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}}} -->
<h2 class="wp-block-heading has-heading-2-font-size" style="margin-bottom:var(--wp--preset--spacing--60)">What is included</h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th>&nbsp;</th><th>Sprint</th><th>Full build</th><th>Platform</th></tr></thead><tbody><?php echo $body; ?></tbody></table></figure>
<!-- /wp:table -->
<?php
echo northline_section_close();
