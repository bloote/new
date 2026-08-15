<?php
/**
 * Title: Section — text beside an image
 * Slug: northline/section-media-text
 * Categories: northline-page
 * Description: A general-purpose band: a heading, a paragraph and a list on one side, a framed picture on the other. Nothing in it is specific to a page, so it is the one to reach for when building your own.
 * Keywords: media, text, image, two columns, generic
 * Viewport width: 1400
 */

echo northline_section_open( array( 'name' => 'Text and image' ) );
?>
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"48%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%">
<!-- wp:paragraph {"className":"nl-kicker has-dot","textColor":"accent-deep"} --><p class="nl-kicker has-dot has-accent-deep-color has-text-color">Section label</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"nl-measure-head","fontSize":"heading-2"} --><h2 class="wp-block-heading nl-measure-head has-heading-2-font-size">A heading of about six words.</h2><!-- /wp:heading -->
<?php
echo northline_para( 'Two or three sentences that explain the thing beside them. Keep the picture doing the showing and let this side do the telling — the two together should make the point without either repeating the other.' );
echo northline_plain_list(
	array(
		'A short supporting point.',
		'A second one, of about the same length.',
		'A third, if three is the right number.',
	),
	'medium'
);
?>
<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
<?php echo northline_button( 'Read more', '#', 'secondary' ); ?>
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"52%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%">
<?php
echo northline_image_block(
	'studio-room.jpg',
	array(
		'ratio' => '4/3',
		'alt'   => 'Replace this picture with one of your own.',
	)
);
?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
