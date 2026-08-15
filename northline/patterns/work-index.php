<?php
/**
 * Title: Work — filterable project index
 * Slug: northline/work-index
 * Categories: northline-page
 * Description: Every case study as a cover card, with a filter bar across the top. Filtering happens in the browser; the full set is always in the page.
 * Keywords: work, projects, index, filter, query
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Project index',
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
		array( 'All work', 'all' ),
		array( 'WordPress', 'project_type-wordpress' ),
		array( 'Headless', 'project_type-headless' ),
		array( 'Commerce', 'project_type-commerce' ),
		array( 'Design only', 'project_type-design' ),
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":24,"pages":0,"offset":0,"postType":"project","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"nl-blueprint"} /-->

<!-- wp:post-terms {"term":"project_type","className":"nl-meta","textColor":"accent-deep","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}}}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

<!-- wp:post-excerpt {"excerptLength":20,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"nl-quiet"} --><p class="nl-quiet">No projects here yet.</p><!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->

<!-- wp:paragraph {"className":"nl-filter-empty nl-quiet"} -->
<p class="nl-filter-empty nl-quiet">Nothing in that category yet — try another filter.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
