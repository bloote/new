<?php
/**
 * Title: 404 — page not found
 * Slug: northline/not-found
 * Categories: northline-page
 * Description: The not-found page: a large 404, an apology that admits the page may never have existed, a search box and the five most visited pages.
 * Keywords: 404, error, not found, search
 * Inserter: no
 * Viewport width: 1400
 */

$links = array(
	array( 'Selected work', northline_archive_url( 'project' ) ),
	array( 'Services', northline_page_url( 'services' ) ),
	array( 'Pricing', northline_page_url( 'pricing' ) ),
	array( 'Journal', northline_page_url( 'journal' ) ),
	array( 'Contact', northline_page_url( 'contact' ) ),
);

$list = '';
foreach ( $links as $link ) {
	$list .= sprintf(
		'<!-- wp:paragraph {"className":"nl-rule nl-link-list","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"},"margin":{"bottom":"0"}}},"fontSize":"large"} --><p class="nl-rule nl-link-list has-large-font-size" style="margin-bottom:0;padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)"><a href="%s">%s</a></p><!-- /wp:paragraph -->',
		esc_url( $link[1] ),
		esc_html( $link[0] )
	);
}

echo northline_section_open(
	array(
		'name'   => '404',
		'class'  => 'nl-plate',
		'top'    => 'var:preset|spacing|90',
		'bottom' => 'var:preset|spacing|90',
	)
);
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|90"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"55%"} -->
<div class="wp-block-column" style="flex-basis:55%">
<!-- wp:paragraph {"className":"nl-numeral","textColor":"accent","style":{"typography":{"fontSize":"clamp(5.625rem,13vw,11.875rem)","lineHeight":"0.82","letterSpacing":"-0.04em"}}} -->
<p class="nl-numeral has-accent-color has-text-color" style="font-size:clamp(5.625rem,13vw,11.875rem);line-height:0.82;letter-spacing:-0.04em">404</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"nl-measure-tight","fontSize":"display"} -->
<h1 class="wp-block-heading nl-measure-tight has-display-font-size">This page has been retired, moved, or never existed.</h1>
<!-- /wp:heading -->

<?php echo northline_para( 'If you followed a link from our site, tell us and we will fix the redirect. Otherwise, try one of these.', 'nl-quiet nl-measure', 'x-large' ); ?>

<!-- wp:buttons -->
<div class="wp-block-buttons">
<?php
echo northline_button( 'Back to home', home_url( '/' ) );
echo northline_button( 'Report a broken link', northline_page_url( 'contact' ), 'secondary' );
?>
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"45%"} -->
<div class="wp-block-column" style="flex-basis:45%">
<?php
echo northline_panel(
	'<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">Search the site</p><!-- /wp:paragraph -->'
	. '<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Try “content model”","buttonText":"Search","buttonPosition":"button-outside"} /-->'
	. '<!-- wp:spacer {"height":"var:preset|spacing|50"} --><div style="height:var(--wp--preset--spacing--50)" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->'
	. '<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">Most visited</p><!-- /wp:paragraph -->'
	. $list,
	array( 'padding' => 'var:preset|spacing|60' )
);
?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
