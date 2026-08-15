<?php
/**
 * Title: Journal — filterable post index
 * Slug: northline/journal-index
 * Categories: northline-editorial
 * Description: The journal archive as a three-column card grid, with category filters and pagination.
 * Keywords: blog, journal, index, archive, query
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Post index',
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
		array( 'Everything', 'all' ),
		array( 'Strategy', 'category-strategy' ),
		array( 'Design', 'category-design' ),
		array( 'WordPress', 'category-wordpress' ),
		array( 'Performance', 'category-performance' ),
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":9,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","className":"nl-blueprint"} /-->

<!-- wp:group {"className":"nl-meta","style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group nl-meta" style="margin-top:var(--wp--preset--spacing--30)">
<!-- wp:post-date {"className":"nl-meta"} /-->
<?php echo northline_meta_line( 'nl_reading_time', 'nl-meta' ); ?>
</div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

<!-- wp:post-excerpt {"excerptLength":20,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet"} /-->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|80"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous {"label":"Newer"} /-->
<!-- wp:query-pagination-numbers /-->
<!-- wp:query-pagination-next {"label":"Older posts"} /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"nl-quiet"} --><p class="nl-quiet">Nothing published here yet.</p><!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->

<!-- wp:paragraph {"className":"nl-filter-empty nl-quiet"} -->
<p class="nl-filter-empty nl-quiet">Nothing in that category on this page — try another filter, or page back.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
