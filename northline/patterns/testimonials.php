<?php
/**
 * Title: Client quotes — carousel
 * Slug: northline/testimonials
 * Categories: northline-page
 * Description: Three client quotes in a carousel with dots and arrows. Without JavaScript the first quote simply stays put.
 * Keywords: testimonials, quotes, clients, carousel
 * Viewport width: 1400
 */

$quotes = array(
	array( 'They rebuilt the site around how our patients actually search, not how our departments are organised. Enquiries went up without us spending more on ads.', 'Ruth Adeyemi · Marketing Director, Northgate Health' ),
	array( 'The editor training took an hour and we have not needed a developer to publish anything since. That was the whole point for us.', 'Tom Vasquez · Head of Content, Fieldnote' ),
	array( 'Scope was fixed, the estimate held, and they flagged the two things that would have blown the timeline in week one instead of week nine.', 'Ellie Fraser · Operations Lead, Kelso Rail' ),
);

$slides = '';

foreach ( $quotes as $quote ) {
	$slides .= sprintf(
		'<!-- wp:group {"className":"nl-carousel-slide","layout":{"type":"default"}} -->
<div class="wp-block-group nl-carousel-slide">
<!-- wp:paragraph {"className":"nl-measure-tight","fontSize":"heading-2","style":{"typography":{"fontFamily":"var(--wp--preset--font-family--heading)","lineHeight":"1.32"}}} --><p class="nl-measure-tight has-heading-2-font-size" style="font-family:var(--wp--preset--font-family--heading);line-height:1.32">%1$s</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-quiet","fontSize":"small"} --><p class="nl-quiet has-small-font-size">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		$quote[0],
		$quote[1]
	);
}

echo northline_section_open( array( 'name' => 'Client quotes' ) );
?>
<!-- wp:group {"className":"nl-rail-layout","layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>05</span><span>Clients</span></p><!-- /wp:paragraph -->

<!-- wp:group {"className":"nl-carousel","layout":{"type":"default"}} -->
<div class="wp-block-group nl-carousel">
<!-- wp:group {"className":"nl-carousel-window","layout":{"type":"default"}} -->
<div class="wp-block-group nl-carousel-window">
<!-- wp:group {"className":"nl-carousel-track","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-carousel-track"><?php echo $slides; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"nl-carousel-nav nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group nl-carousel-nav nl-rule" style="margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--40)">
<!-- wp:html -->
<div style="display:flex;gap:8px">
	<button class="nl-carousel-dot" type="button" aria-label="Quote 1"></button>
	<button class="nl-carousel-dot" type="button" aria-label="Quote 2"></button>
	<button class="nl-carousel-dot" type="button" aria-label="Quote 3"></button>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<div style="display:flex;gap:8px">
	<button class="nl-carousel-prev" type="button" aria-label="Previous quote">&#8592;</button>
	<button class="nl-carousel-next" type="button" aria-label="Next quote">&#8594;</button>
</div>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
