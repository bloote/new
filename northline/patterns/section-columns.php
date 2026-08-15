<?php
/**
 * Title: Section — two columns of prose
 * Slug: northline/section-columns
 * Categories: northline-page
 * Description: A numbered section head over two columns of running text. The plainest way to put a few hundred words on a page and still have it look like the rest of the site.
 * Keywords: text, prose, two columns, generic
 * Viewport width: 1400
 */

echo northline_section_open( array( 'name' => 'Two columns of text' ) );

echo northline_section_head(
	array(
		'number'  => '01',
		'label'   => 'Section label',
		'heading' => 'A heading over two columns.',
	)
);
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<?php
echo northline_para( 'The first column carries the argument. Two or three paragraphs is usually the right length: long enough to say something, short enough that nobody scrolls past it.', 'nl-quiet', 'large' );
echo northline_para( 'Write in whatever voice the rest of the page uses. Nothing here is styled as an exception — it is ordinary paragraphs at the theme\'s reading size.', 'nl-quiet', 'large' );
?>
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<?php
echo northline_para( 'The second column continues it, or takes the other side. Delete it and widen the first if one column is all you need.', 'nl-quiet', 'large' );
echo northline_para( 'Anything you would put in a page belongs here too: a list, a quotation, a link. The column is a plain container.', 'nl-quiet', 'large' );
?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
