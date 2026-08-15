<?php
/**
 * Title: Journal — featured post
 * Slug: northline/journal-featured
 * Categories: northline-editorial
 * Description: The newest post given the full width: cover image on the left, standfirst and byline on the right.
 * Keywords: blog, journal, featured, query
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Featured post',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|70',
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"layout":{"type":"default"}} -->
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/10","className":"nl-blueprint"} /-->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
<!-- wp:post-terms {"term":"category","className":"nl-terms","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|40"}}}} /-->

<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"display","className":"nl-measure-tight","style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|40"}}}} /-->

<!-- wp:post-excerpt {"excerptLength":34,"showMoreOnNewLine":false,"fontSize":"large","className":"nl-quiet nl-measure","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} /-->

<!-- wp:group {"className":"nl-meta","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group nl-meta">
<!-- wp:post-author-name {"className":"nl-meta"} /-->
<!-- wp:post-date {"className":"nl-meta"} /-->
<?php echo northline_meta_line( 'nl_reading_time', 'nl-meta' ); ?>
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
