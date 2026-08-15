<?php
/**
 * Title: Catalogue — themes
 * Slug: northline/themes-index
 * Categories: northline-catalogue
 * Description: Every theme in the catalogue as a boxed card with screenshot, price, version line and a link through to its page.
 * Keywords: downloads, themes, catalogue, query, filter
 * Viewport width: 1400
 */

$term = northline_term_id( 'download_type', 'themes' );

echo northline_section_open(
	array(
		'name'   => 'Theme index',
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
		array( 'All themes', 'all' ),
		array( 'Free', 'download_tag-free' ),
		array( 'Pro', 'download_tag-pro' ),
		array( 'Block themes', 'download_tag-block-theme' ),
		array( 'Editorial', 'download_tag-editorial' ),
		array( 'Commerce', 'download_tag-commerce' ),
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":24,"pages":0,"offset":0,"postType":"download","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"download_type":[<?php echo (int) $term; ?>]}},"className":"nl-cards nl-cards-boxed","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards nl-cards-boxed">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/10"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
<?php echo northline_meta_line( 'nl_price', 'nl-tag nl-tag-outline', ' · ' ); ?>
</div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"excerptLength":26,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet nl-fill"} /-->

<?php echo northline_meta_line( 'nl_version,nl_installs,nl_requires', 'nl-meta' ); ?>

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--30)">
<?php
echo northline_read_more( 'Get it', 'primary' );
echo northline_read_more( 'Details', 'secondary' );
?>
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"nl-quiet"} --><p class="nl-quiet">No themes published yet.</p><!-- /wp:paragraph -->
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
