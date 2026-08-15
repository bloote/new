<?php
/**
 * Title: Docs — video series
 * Slug: northline/docs-video
 * Categories: northline-page
 * Description: A still from the walkthrough series beside a short pitch and two buttons.
 * Keywords: docs, video, walkthrough
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'Video series',
		'background' => 'surface',
	)
);
?>
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"54%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%">
<?php echo northline_image_block( 'docs-walkthrough.jpg', array( 'ratio' => '16/9', 'alt' => 'Still from the theme walkthrough series' ) ); ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"46%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%">
<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">Video series · 8 parts</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"nl-measure-tight","fontSize":"heading-2"} --><h2 class="wp-block-heading nl-measure-tight has-heading-2-font-size">Watch a whole site get built in 48 minutes.</h2><!-- /wp:heading -->
<?php echo northline_para( 'Unedited, from theme activation to a published five-page site. Each part is chaptered, so you can jump to the bit you are stuck on.', 'nl-quiet nl-measure', 'large' ); ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<?php
echo northline_button( 'Start watching', northline_page_url( 'journal' ) );
echo northline_button( 'Get the theme first', northline_page_url( 'themes' ), 'secondary' );
?>
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
