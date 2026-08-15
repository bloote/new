<?php
/**
 * Title: Catalogue — browser tools
 * Slug: northline/tools-grid
 * Categories: northline-catalogue
 * Description: Six utilities that run entirely in the visitor's browser, as linked cards.
 * Keywords: tools, utilities, downloads, query
 * Viewport width: 1400
 */

$term = northline_term_id( 'download_type', 'tools' );

echo northline_section_open(
	array(
		'name'       => 'Tools',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '02',
		'label'   => 'Tools',
		'heading' => 'Six utilities that run entirely in your browser.',
		'body'    => 'No account, no upload, nothing leaves your machine.',
	)
);
?>
<!-- wp:query {"queryId":0,"query":{"perPage":12,"pages":0,"offset":0,"postType":"download","order":"asc","orderBy":"menu_order","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"download_type":[<?php echo (int) $term; ?>]}},"className":"nl-cards","layout":{"type":"default"}} -->
<div class="wp-block-query nl-cards">
<!-- wp:post-template {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}},"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"nl-blueprint","backgroundColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-blueprint has-base-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
<?php echo northline_meta_line( 'nl_mark', 'nl-index', '', 'T' ); ?>
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->
<!-- wp:post-excerpt {"excerptLength":24,"showMoreOnNewLine":false,"fontSize":"small","className":"nl-quiet"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"nl-quiet"} --><p class="nl-quiet">No tools published yet.</p><!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
<?php
echo northline_section_close();
