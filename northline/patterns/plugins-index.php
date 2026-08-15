<?php
/**
 * Title: Catalogue — plugins
 * Slug: northline/plugins-index
 * Categories: northline-catalogue
 * Description: The plugin catalogue as a list of rows: letter mark, name and price, description, version line and links.
 * Keywords: downloads, plugins, catalogue, query, filter
 * Viewport width: 1400
 */

$term = northline_term_id( 'download_type', 'plugins' );

echo northline_section_open(
	array(
		'name'   => 'Plugin index',
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
		array( 'All plugins', 'all' ),
		array( 'Free', 'download_tag-free' ),
		array( 'Pro', 'download_tag-pro' ),
		array( 'Editor', 'download_tag-editor' ),
		array( 'SEO', 'download_tag-seo' ),
		array( 'Commerce', 'download_tag-commerce' ),
		array( 'Operations', 'download_tag-ops' ),
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":24,"pages":0,"offset":0,"postType":"download","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"download_type":[<?php echo (int) $term; ?>]}},"className":"nl-cards nl-rows-list","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards nl-rows-list">
<!-- wp:post-template {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<!-- wp:group {"className":"nl-listing-row nl-rule-bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-listing-row nl-rule-bottom" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
<?php echo northline_meta_line( 'nl_mark', 'nl-listing-mark nl-blueprint', '', '··' ); ?>

<!-- wp:group {"layout":{"type":"default"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
<div class="wp-block-group">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
<?php echo northline_meta_line( 'nl_price', 'nl-tag nl-tag-outline', ' · ' ); ?>
</div>
<!-- /wp:group -->
<!-- wp:post-excerpt {"excerptLength":30,"showMoreOnNewLine":false,"fontSize":"medium","className":"nl-quiet nl-measure"} /-->
</div>
<!-- /wp:group -->

<?php echo northline_meta_line( 'nl_version,nl_installs', 'nl-meta' ); ?>

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"right"}} -->
<div class="wp-block-group">
<?php
echo northline_read_more( 'Get it', 'primary' );
echo northline_read_more( 'Docs', 'secondary' );
?>
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"nl-quiet"} --><p class="nl-quiet">No plugins published yet.</p><!-- /wp:paragraph -->
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
