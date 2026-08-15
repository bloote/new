<?php
/**
 * Title: Section — three cards
 * Slug: northline/section-cards
 * Categories: northline-page
 * Description: Three framed cards with an index, a heading, a paragraph and a link. Add or delete a card and the row still lines up.
 * Keywords: cards, grid, three, columns, generic
 * Viewport width: 1400
 */

$cards = array(
	array( '01', 'The first of three', 'A paragraph of about twenty-five words explaining what this one is. Cards in a row are the same height however much you write, and the links sit on one line.' ),
	array( '02', 'The second', 'This one is deliberately shorter.' ),
	array( '03', 'The third', 'And this one runs longer than either of the others, so you can see what happens to a row of cards when the copy is uneven — which it always is.' ),
);

$cells = array();

foreach ( $cards as $index => $card ) {
	$inner = sprintf(
		'<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%s</span></p><!-- /wp:paragraph -->',
		esc_html( $card[0] )
	)
	. sprintf(
		'<!-- wp:heading {"level":3,"fontSize":"heading-4"} --><h3 class="wp-block-heading has-heading-4-font-size">%s</h3><!-- /wp:heading -->',
		esc_html( $card[1] )
	)
	. northline_para( $card[2], 'nl-quiet nl-fill', 'small' )
	. sprintf(
		'<!-- wp:buttons --><div class="wp-block-buttons">%s</div><!-- /wp:buttons -->',
		northline_button( 'Read more', '#', 'secondary' )
	);

	$cells[] = northline_panel( $inner, array( 'reveal' => 'nl-reveal nl-delay-' . $index ) );
}

echo northline_section_open( array( 'name' => 'Three cards' ) );

echo northline_section_head(
	array(
		'number'  => '02',
		'label'   => 'Section label',
		'heading' => 'Three things, side by side.',
		'body'    => 'A sentence introducing the row. Delete it if the headings speak for themselves.',
	)
);

echo northline_grid( $cells, 3 );
echo northline_section_close();
