<?php
/**
 * Title: Journal — three latest posts
 * Slug: northline/journal-latest
 * Categories: northline-editorial
 * Description: A live query loop showing the three newest journal posts.
 * Keywords: blog, journal, posts, query
 * Viewport width: 1400
 */

echo northline_section_open( array( 'name' => 'Journal' ) );

echo northline_section_head(
	array(
		'number'      => '09',
		'label'       => 'Journal',
		'heading'     => 'Notes from the work.',
		'button_text' => 'All posts',
		'button_url'  => northline_page_url( 'journal' ),
		'align'       => 'end',
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","className":"nl-blueprint"} /-->

<!-- wp:post-date {"className":"nl-meta","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}}} /-->

<!-- wp:post-excerpt {"excerptLength":20,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet"} /-->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
