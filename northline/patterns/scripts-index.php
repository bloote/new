<?php
/**
 * Title: Catalogue — scripts
 * Slug: northline/scripts-index
 * Categories: northline-catalogue
 * Description: The dependency-free scripts, two to a row, each with its size and the line of code that uses it.
 * Keywords: downloads, scripts, javascript, catalogue, query
 * Viewport width: 1400
 */

$term = northline_term_id( 'download_type', 'scripts' );

echo northline_section_open(
	array(
		'name'   => 'Scripts',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:group {"className":"nl-filter-group","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-filter-group">
<?php
echo northline_filter_bar(
	array(
		array( 'All scripts', 'all' ),
		array( 'Interface', 'download_tag-ui' ),
		array( 'Motion', 'download_tag-motion' ),
		array( 'Forms', 'download_tag-forms' ),
		array( 'Performance', 'download_tag-performance' ),
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":24,"pages":0,"offset":0,"postType":"download","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"download_type":[<?php echo (int) $term; ?>]}},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"className":"nl-blueprint","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-blueprint" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
<?php echo northline_meta_line( 'nl_price', 'nl-tag nl-tag-accent', ' · ' ); ?>
</div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"excerptLength":30,"showMoreOnNewLine":false,"fontSize":"medium","className":"nl-quiet"} /-->

<?php echo northline_meta_line( 'nl_usage', 'nl-mono' ); ?>

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group">
<?php
echo northline_read_more( 'Download', 'primary' );
echo northline_read_more( 'Docs', 'secondary' );
?>
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"nl-quiet"} --><p class="nl-quiet">No scripts published yet.</p><!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->

<!-- wp:paragraph {"className":"nl-filter-empty nl-quiet"} -->
<p class="nl-filter-empty nl-quiet">Nothing matches that filter yet.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
