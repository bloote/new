<?php
/**
 * Title: Custom orders — order form
 * Slug: northline/custom-order-form
 * Categories: northline-page
 * Description: The order form, with a note on what a good brief contains and four expandable answers beside it.
 * Keywords: order, form, brief, faq
 * Viewport width: 1400
 */

$faqs = array(
	array( 'Who owns the code?', 'You do, outright, on final payment. It lands in your repository under whichever licence you ask for. We keep no rights to resell it unless we agree that up front, in exchange for a lower price.' ),
	array( 'How many revisions?', 'One round at each of the two review points, which covers changes within the agreed scope. New requirements are quoted separately rather than absorbed quietly.' ),
	array( 'Can you work with our developers?', 'Yes. We work in a branch on your repository, open pull requests, and follow your conventions and review process.' ),
	array( 'What if it turns out to be bigger?', 'We say so in the quote, before you commit. If a project is really a site build, we will tell you that and point you at the studio pricing instead.' ),
);

$rows = '';
foreach ( $faqs as $index => $faq ) {
	// These sit in the sidebar, beside the section's own h2, so the questions
	// are set a step down from the full-width FAQ bands elsewhere.
	$rows .= northline_accordion_row( $faq[0], northline_para( $faq[1], 'nl-quiet', 'medium' ), 0 === $index, '', 'x-large' );
}

echo northline_section_open( array( 'name' => 'Order form' ) );
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|80","left":"var:preset|spacing|90"}}}} -->
<div class="wp-block-columns">
<!-- wp:column {"width":"56%"} -->
<div class="wp-block-column" style="flex-basis:56%">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>03</span><span>Place an order</span></p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"nl-measure-tight","fontSize":"heading-2","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}}} --><h2 class="wp-block-heading nl-measure-tight has-heading-2-font-size" style="margin-bottom:var(--wp--preset--spacing--60)">Tell us what to build.</h2><!-- /wp:heading -->
<!-- wp:northline/form {"variant":"order"} /-->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"44%"} -->
<div class="wp-block-column" style="flex-basis:44%">
<!-- wp:group {"className":"nl-sticky","layout":{"type":"default"}} -->
<div class="wp-block-group nl-sticky">
<?php
echo northline_panel(
	'<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">A good brief has</p><!-- /wp:paragraph -->'
	. northline_plain_list(
		array(
			'One sentence on what the thing does.',
			'Who uses it, and how often.',
			'What your team does today instead.',
			'Anything already fixed: stack, deadline, brand.',
			'A screenshot of something similar, if one exists.',
		),
		'medium'
	),
	array( 'background' => 'accent-tint' )
);
?>

<!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--60)"><?php echo $rows; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
