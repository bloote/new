<?php
/**
 * Title: Section — people
 * Slug: northline/section-people
 * Categories: northline-page
 * Description: Three or four people with a portrait, a name and a role. The names are placeholders, so this is the one to use for a team of your own.
 * Keywords: team, people, portraits, staff, generic
 * Viewport width: 1400
 */

$people = array(
	array( 'team-maya-iyer.jpg', 'First name Surname', 'What they do here' ),
	array( 'team-daniel-okoro.jpg', 'First name Surname', 'What they do here' ),
	array( 'team-sofia-lindqvist.jpg', 'First name Surname', 'What they do here' ),
	array( 'team-priya-raman.jpg', 'First name Surname', 'What they do here' ),
);

$cells = array();

foreach ( $people as $index => $person ) {
	$cells[] = sprintf(
		'<!-- wp:group {"className":"nl-reveal nl-delay-%1$d","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-reveal nl-delay-%1$d">
%2$s
<!-- wp:heading {"level":3,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}}} --><h3 class="wp-block-heading has-heading-4-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0">%3$s</h3><!-- /wp:heading -->
<!-- wp:paragraph {"className":"nl-quieter","fontSize":"small"} --><p class="nl-quieter has-small-font-size">%4$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		$index % 4,
		northline_image_block( $person[0], array( 'ratio' => '1/1', 'alt' => 'Replace with a portrait of this person.' ) ),
		esc_html( $person[1] ),
		esc_html( $person[2] )
	);
}

echo northline_section_open( array( 'name' => 'People' ) );

echo northline_section_head(
	array(
		'number'  => '05',
		'label'   => 'Section label',
		'heading' => 'The people behind it.',
		'body'    => 'A sentence about who these people are and why the reader should care that they exist.',
	)
);

echo northline_grid( $cells, 4 );
echo northline_section_close();
