<?php
/**
 * Title: Section — enquiry form
 * Slug: northline/section-form
 * Categories: northline-page
 * Description: The theme's own enquiry form beside a framed box of details. Placeholder wording throughout, so it can go on any page that needs to be written to.
 * Keywords: form, contact, enquiry, generic
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Enquiry form',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|90"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"56%"} -->
<div class="wp-block-column" style="flex-basis:56%">
<!-- wp:heading {"className":"nl-measure-tight","fontSize":"heading-2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}}} --><h2 class="wp-block-heading nl-measure-tight has-heading-2-font-size" style="margin-bottom:var(--wp--preset--spacing--60)">Send us the details.</h2><!-- /wp:heading -->
<!-- wp:northline/form {"variant":"contact"} /-->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"44%"} -->
<div class="wp-block-column" style="flex-basis:44%">
<?php
echo northline_panel(
	'<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">Another way</p><!-- /wp:paragraph -->'
	. '<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">Or skip the form</h3><!-- /wp:heading -->'
	. northline_para( 'A sentence offering the quicker route, and what it costs the reader to take it.', 'nl-quiet', 'medium' )
	. '<!-- wp:buttons {"layout":{"type":"flex","orientation":"vertical"}} --><div class="wp-block-buttons">'
	. northline_button( 'The quicker route', '#' )
	. '</div><!-- /wp:buttons -->',
	array( 'background' => 'accent-tint' )
);
?>

<!-- wp:group {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rule" style="margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--50)">
<?php
echo northline_definition( 'Email', 'you@example.com' );
echo northline_definition( 'Phone', '+44 000 000 0000' );
echo northline_definition( 'Address', 'Street<br>Town, postcode' );
echo northline_definition( 'Hours', 'Monday to Friday, 9 to 5' );
?>
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
