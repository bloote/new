<?php
/**
 * Title: Work — three latest projects
 * Slug: northline/work-featured
 * Categories: northline-page
 * Description: A live query loop showing the three most recent case studies as cover cards.
 * Keywords: work, projects, case studies, query
 * Viewport width: 1400
 */

echo northline_section_open( array( 'name' => 'Selected work' ) );

echo northline_section_head(
	array(
		'number'      => '03',
		'label'       => 'Selected work',
		'heading'     => 'Recent builds and what changed after launch.',
		'button_text' => 'All projects',
		'button_url'  => northline_archive_url( 'project' ),
		'align'       => 'end',
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"project","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","className":"nl-blueprint"} /-->

<!-- wp:post-terms {"term":"project_type","className":"nl-meta","textColor":"accent-deep","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}}}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

<!-- wp:post-excerpt {"excerptLength":22,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet"} /-->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
