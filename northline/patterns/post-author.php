<?php
/**
 * Title: Post — author card
 * Slug: northline/post-author
 * Categories: northline-editorial
 * Description: The byline block that closes a journal post: portrait, name, biography and a way to reach them.
 * Keywords: author, byline, post, biography
 * Inserter: no
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'Author',
		'background' => 'surface',
		'top'        => 'var:preset|spacing|70',
		'bottom'     => 'var:preset|spacing|70',
	)
);
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"220px"} -->
<div class="wp-block-column" style="flex-basis:220px">
<!-- wp:avatar {"size":220,"className":"nl-blueprint"} /-->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">Written by</p><!-- /wp:paragraph -->
<!-- wp:post-author-name {"isLink":true,"fontSize":"heading-3","style":{"typography":{"fontFamily":"var(--wp--preset--font-family--heading)"}}} /-->
<!-- wp:post-author-biography {"className":"nl-quiet nl-measure","fontSize":"large"} /-->
<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)"><?php echo northline_button( 'Talk to the studio', northline_page_url( 'contact' ), 'secondary' ); ?></div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
