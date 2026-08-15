<?php
/**
 * Title: Docs — tutorial index
 * Slug: northline/docs-tutorial-index
 * Categories: northline-page
 * Description: Every tutorial as a row with its level, reading time and a link, filterable by topic.
 * Keywords: docs, tutorials, index, filter
 * Viewport width: 1400
 */

$tutorials = array(
	array( 'Installing the theme and importing demo content', 'Zip upload, WP-CLI, and how to undo the import cleanly.', 'Beginner', '6 min', 'start' ),
	array( 'Building a page from patterns', 'Insert, reorder and trim the section patterns.', 'Beginner', '9 min', 'patterns start' ),
	array( 'Changing colours and fonts for the whole site', 'Palette slots, the type scale, and what not to override per block.', 'Beginner', '7 min', 'styles' ),
	array( 'Synced patterns for content that repeats', 'Opening hours, contact blocks and the CTA band, edited once.', 'Intermediate', '8 min', 'patterns' ),
	array( 'Editing the header and footer template parts', 'Navigation menus, the brand mark and the footer columns.', 'Intermediate', '10 min', 'styles patterns' ),
	array( 'Registering your own pattern', 'A PHP file, a header comment, and a category that keeps the inserter tidy.', 'Developer', '12 min', 'dev' ),
	array( 'theme.json without the guesswork', 'Settings versus styles, block-level overrides, and locking options down.', 'Developer', '14 min', 'dev styles' ),
	array( 'Building a child theme', 'Override a template or a pattern and keep receiving updates.', 'Developer', '11 min', 'dev' ),
	array( 'Moving from a classic theme or page builder', 'What converts automatically, what needs rebuilding, and in what order.', 'Intermediate', '15 min', 'start dev' ),
);

$rows = '';

foreach ( $tutorials as $tutorial ) {
	$keys = '';
	foreach ( explode( ' ', $tutorial[4] ) as $key ) {
		$keys .= ' nl-topic-' . $key;
	}

	$rows .= sprintf(
		'<!-- wp:group {"className":"nl-filterable nl-tutorial-row nl-rule-bottom%5$s","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-filterable nl-tutorial-row nl-rule-bottom%5$s" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:heading {"level":3,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} --><h3 class="wp-block-heading has-heading-4-font-size" style="margin-top:0;margin-bottom:0">%1$s</h3><!-- /wp:heading -->
<!-- wp:paragraph {"className":"nl-quiet","fontSize":"small","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-quiet has-small-font-size" style="margin-bottom:0">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph {"className":"nl-tag nl-tag-neutral","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-tag nl-tag-neutral" style="margin-bottom:0">%3$s</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">%4$s</p><!-- /wp:paragraph -->
<!-- wp:buttons --><div class="wp-block-buttons">%6$s</div><!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
		$tutorial[0],
		$tutorial[1],
		$tutorial[2],
		$tutorial[3],
		$keys,
		northline_button( 'Read', northline_page_url( 'journal' ), 'secondary' )
	);
}

echo northline_section_open( array( 'name' => 'Tutorial index' ) );

echo northline_section_head(
	array(
		'number'  => '03',
		'label'   => 'All tutorials',
		'heading' => 'Step-by-step, with screenshots.',
	)
);
?>
<!-- wp:group {"className":"nl-filter-group","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-filter-group">
<?php
echo northline_filter_bar(
	array(
		array( 'Everything', 'all' ),
		array( 'Getting started', 'nl-topic-start' ),
		array( 'Patterns', 'nl-topic-patterns' ),
		array( 'Styles', 'nl-topic-styles' ),
		array( 'Developer', 'nl-topic-dev' ),
	)
);
echo $rows;
?>
<!-- wp:paragraph {"className":"nl-filter-empty nl-quiet"} -->
<p class="nl-filter-empty nl-quiet">Nothing on that topic yet.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
