<?php
/**
 * Title: Team — four portraits
 * Slug: northline/team-grid
 * Categories: northline-page
 * Description: Four studio portraits with names and roles, linking through to the studio page.
 * Keywords: team, people, studio
 * Viewport width: 1400
 */

$team = array(
	array( 'team-maya-iyer.jpg', 'Maya Iyer', 'Founder, strategy' ),
	array( 'team-daniel-okoro.jpg', 'Daniel Okoro', 'Design lead' ),
	array( 'team-sofia-lindqvist.jpg', 'Sofia Lindqvist', 'Engineering lead' ),
	array( 'team-ben-trawick.jpg', 'Ben Trawick', 'WordPress developer' ),
);

$cells = array();

foreach ( $team as $index => $person ) {
	$cells[] = sprintf(
		'<!-- wp:group {"className":"nl-reveal nl-delay-%1$d","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-reveal nl-delay-%1$d">
%2$s
<!-- wp:heading {"level":4,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0"}}}} --><h4 class="wp-block-heading has-heading-4-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0">%3$s</h4><!-- /wp:heading -->
<!-- wp:paragraph {"className":"nl-quieter","fontSize":"small"} --><p class="nl-quieter has-small-font-size">%4$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		$index % 4,
		northline_image_block( $person[0], array( 'ratio' => '1/1', 'alt' => 'Blueprint portrait study of ' . $person[1] ) ),
		$person[1],
		$person[2]
	);
}

echo northline_section_open( array( 'name' => 'Team' ) );

echo northline_section_head(
	array(
		'number'      => '08',
		'label'       => 'Studio',
		'heading'     => 'A team of six. The people who pitch are the people who build.',
		'button_text' => 'About the studio',
		'button_url'  => northline_page_url( 'studio' ),
		'align'       => 'end',
	)
);

echo northline_grid( $cells, 4 );
echo northline_section_close();
