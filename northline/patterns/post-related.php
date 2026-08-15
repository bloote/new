<?php
/**
 * Title: Post — keep reading
 * Slug: northline/post-related
 * Categories: northline-editorial
 * Description: Three more posts at the foot of an article, excluding the one being read.
 * Keywords: related, posts, keep reading
 * Inserter: no
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Keep reading',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"fontSize":"heading-3","style":{"spacing":{"margin":{"bottom":"0"}}}} --><h2 class="wp-block-heading has-heading-3-font-size" style="margin-bottom:0">Keep reading</h2><!-- /wp:heading -->
<!-- wp:buttons --><div class="wp-block-buttons"><?php echo northline_button( 'All posts', northline_page_url( 'journal' ), 'secondary' ); ?></div><!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"className":"nl-cards","namespace":"northline/related","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","className":"nl-blueprint"} /-->
<!-- wp:post-date {"className":"nl-meta","style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}}} /-->
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"0"}}}} /-->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
