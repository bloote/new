<?php
/**
 * Title: Studio — four principles
 * Slug: northline/principles-grid
 * Categories: northline-page
 * Description: Four principles in a two-by-two grid divided by hairlines.
 * Keywords: about, principles, values, studio
 * Viewport width: 1400
 */

$principles = array(
	array( 'P/01', 'Content model before layout', 'A site that is easy to publish to stays good. One that depends on a designer for every page decays within a year.' ),
	array( 'P/02', 'Fixed scope, honest estimates', 'We would rather tell you a number you do not like in week one than discover it together in week nine.' ),
	array( 'P/03', 'Performance is a design decision', 'Weight budgets are agreed before the first mockup, so nothing gets designed that cannot ship fast.' ),
	array( 'P/04', 'You own everything', 'Repository, hosting, design files and documentation, in your accounts and your name from day one.' ),
);

$cells = array();

foreach ( $principles as $index => $principle ) {
	$cells[] = sprintf(
		'<!-- wp:group {"className":"nl-reveal nl-delay-%1$d","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-reveal nl-delay-%1$d" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%2$s</span></p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">%3$s</h3><!-- /wp:heading -->
%4$s
</div>
<!-- /wp:group -->',
		$index % 2,
		$principle[0],
		$principle[1],
		northline_para( $principle[2], 'nl-quiet nl-measure-tight', 'large' )
	);
}

echo northline_section_open( array( 'name' => 'Principles' ) );

echo northline_section_head(
	array(
		'number'  => '01',
		'label'   => 'How we work',
		'heading' => 'Four things we hold to, even when it costs us the job.',
	)
);

echo northline_grid( $cells, 2, 'var:preset|spacing|70', 'nl-divided-grid' );
echo northline_section_close();
