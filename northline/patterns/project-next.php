<?php
/**
 * Title: Project — next projects
 * Slug: northline/project-next
 * Categories: northline-page
 * Description: Two more case studies at the foot of a project page.
 * Keywords: projects, related, next, work
 * Inserter: no
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Next project',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"fontSize":"heading-3","style":{"spacing":{"margin":{"bottom":"0"}}}} --><h2 class="wp-block-heading has-heading-3-font-size" style="margin-bottom:0">Next project</h2><!-- /wp:heading -->
<!-- wp:buttons --><div class="wp-block-buttons"><?php echo northline_button( 'All work', northline_archive_url( 'project' ), 'secondary' ); ?></div><!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":2,"pages":0,"offset":0,"postType":"project","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","namespace":"northline/related","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","className":"nl-blueprint"} /-->
<!-- wp:post-terms {"term":"project_type","className":"nl-meta","textColor":"accent-deep","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}}}} /-->
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-3","style":{"spacing":{"margin":{"top":"var:preset|spacing|20","bottom":"0"}}}} /-->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
