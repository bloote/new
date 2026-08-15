<?php
/**
 * Title: Contact — form and details
 * Slug: northline/contact-details
 * Categories: northline-page
 * Description: The enquiry form beside the studio's contact details, availability and what happens next.
 * Keywords: contact, form, enquiry, details
 * Viewport width: 1400
 */

$next_steps = '';
$steps      = array(
	array( '01', 'We read the brief and come back with questions, not a proposal.' ),
	array( '02', 'A 30-minute call to agree what the first phase would be.' ),
	array( '03', 'A fixed scope and price within a week of that call.' ),
);

foreach ( $steps as $step ) {
	$next_steps .= sprintf(
		'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-numeral","textColor":"accent-deep","style":{"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-numeral has-accent-deep-color has-text-color" style="margin-bottom:0;font-size:0.875rem">%s</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"bottom":"0"}}}} --><p style="margin-bottom:0">%s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		$step[0],
		$step[1]
	);
}

echo northline_section_open(
	array(
		'name'   => 'Contact form',
		'top'    => 'var:preset|spacing|70',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|90"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"56%"} -->
<div class="wp-block-column" style="flex-basis:56%">
<!-- wp:northline/form {"variant":"contact"} /-->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"44%"} -->
<div class="wp-block-column" style="flex-basis:44%">
<?php
echo northline_panel(
	'<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">Faster route</p><!-- /wp:paragraph -->'
	. '<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">Pick a slot directly</h3><!-- /wp:heading -->'
	. northline_para( 'Thirty minutes with Maya, usually within the same week. Bring the site you have now.', 'nl-quiet', 'medium' )
	. '<!-- wp:buttons {"layout":{"type":"flex","orientation":"vertical"}} --><div class="wp-block-buttons">'
	. northline_button( 'Open the calendar', 'mailto:studio@northline.co?subject=Booking%20a%20call' )
	. '</div><!-- /wp:buttons -->',
	array( 'background' => 'accent-tint' )
);
?>

<!-- wp:group {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rule" style="margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--50)">
<?php
echo northline_definition( 'Email', '<a href="mailto:studio@northline.co">studio@northline.co</a>' );
echo northline_definition( 'Phone', '+44 117 496 0182' );
echo northline_definition( 'Studio', 'Unit 4, Wapping Wharf<br>Bristol BS1 6WE' );
echo northline_definition( 'Availability', 'Next project start: March 2026' );
?>
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-rule" style="margin-top:var(--wp--preset--spacing--60);padding-top:var(--wp--preset--spacing--50)">
<!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">What happens next</p><!-- /wp:paragraph -->
<?php echo $next_steps; ?>
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
