<?php
/**
 * Title: Download — often bought with
 * Slug: northline/download-related
 * Categories: northline-catalogue
 * Description: Three more products at the foot of a catalogue page.
 * Keywords: downloads, related, catalogue
 * Inserter: no
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Often bought with',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"fontSize":"heading-3","style":{"spacing":{"margin":{"bottom":"0"}}}} --><h2 class="wp-block-heading has-heading-3-font-size" style="margin-bottom:0">Often bought with</h2><!-- /wp:heading -->
<!-- wp:buttons --><div class="wp-block-buttons"><?php echo northline_button( 'All downloads', northline_archive_url( 'download' ), 'secondary' ); ?></div><!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":3,"pages":0,"offset":0,"postType":"download","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false},"className":"nl-cards","namespace":"northline/related","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"nl-blueprint","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-blueprint" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
<?php echo northline_meta_line( 'nl_price', 'nl-tag nl-tag-outline', ' · ' ); ?>
</div>
<!-- /wp:group -->
<!-- wp:post-excerpt {"excerptLength":18,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
