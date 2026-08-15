<?php
/**
 * Title: Section — a single quotation
 * Slug: northline/section-quote
 * Categories: northline-page
 * Description: One quotation set large, with an attribution under it. No carousel and no client list — a standalone pull quote for any page.
 * Keywords: quote, testimonial, pull quote, generic
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'Quotation',
		'background' => 'surface',
	)
);
?>
<!-- wp:group {"className":"nl-rail-layout","layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>02</span><span>Section label</span></p><!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-measure-tight","fontSize":"heading-2","style":{"typography":{"fontFamily":"var(--wp--preset--font-family--heading)","lineHeight":"1.32"}}} --><p class="nl-measure-tight has-heading-2-font-size" style="font-family:var(--wp--preset--font-family--heading);line-height:1.32">A sentence in someone else's words, worth about thirty of your own.</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-quiet","fontSize":"small"} --><p class="nl-quiet has-small-font-size">Their name · Their job, their company</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
