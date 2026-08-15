<?php
/**
 * Title: Newsletter band
 * Slug: northline/newsletter-band
 * Categories: northline-cta
 * Description: A quiet subscribe band with a working, self-hosted email form.
 * Keywords: newsletter, subscribe, email
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'Subscribe',
		'background' => 'surface',
		'top'        => 'var:preset|spacing|70',
		'bottom'     => 'var:preset|spacing|70',
	)
);
?>
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%">
<!-- wp:heading {"className":"nl-measure-tight","fontSize":"heading-2"} --><h2 class="wp-block-heading nl-measure-tight has-heading-2-font-size">One email a month, no other list.</h2><!-- /wp:heading -->
<?php echo northline_para( 'New posts and the occasional teardown of a site we admire. Unsubscribe in one click.', 'nl-quiet nl-measure', 'large' ); ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
<!-- wp:northline/form {"variant":"newsletter"} /-->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
