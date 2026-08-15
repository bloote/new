<?php
/**
 * Title: Studio — full team directory
 * Slug: northline/team-directory
 * Categories: northline-page
 * Description: All six people, with portraits, roles and a line on what each one does.
 * Keywords: team, people, directory, studio
 * Viewport width: 1400
 */

$team = array(
	array( 'team-maya-iyer.jpg', 'Maya Iyer', 'Founder, strategy', 'Runs discovery and writes the scope. Fifteen years in content strategy, six of them in-house at a hospital group.' ),
	array( 'team-daniel-okoro.jpg', 'Daniel Okoro', 'Design lead', 'Owns art direction and the design system. Previously eight years at a product studio in Berlin.' ),
	array( 'team-sofia-lindqvist.jpg', 'Sofia Lindqvist', 'Engineering lead', 'Architecture, headless builds and the CI pipeline. Maintains two small open source WordPress plugins.' ),
	array( 'team-ben-trawick.jpg', 'Ben Trawick', 'WordPress developer', 'Themes, block patterns and migrations. Has moved more legacy content than anyone should have to.' ),
	array( 'team-priya-raman.jpg', 'Priya Raman', 'Product designer', 'Interaction design, prototypes and accessibility reviews. Runs our WCAG audits before every launch.' ),
	array( 'team-iwan-petrov.jpg', 'Iwan Petrov', 'Front-end developer', 'Next.js, performance work and the care-plan queue. Keeps the median Lighthouse score honest.' ),
);

$cells = array();

foreach ( $team as $index => $person ) {
	$cells[] = sprintf(
		'<!-- wp:group {"className":"nl-reveal nl-delay-%1$d","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-reveal nl-delay-%1$d">
%2$s
<!-- wp:heading {"level":3,"fontSize":"heading-4","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|10"}}}} --><h3 class="wp-block-heading has-heading-4-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--10)">%3$s</h3><!-- /wp:heading -->
<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">%4$s</p><!-- /wp:paragraph -->
%5$s
</div>
<!-- /wp:group -->',
		$index % 3,
		northline_image_block( $person[0], array( 'ratio' => '1/1', 'alt' => 'Blueprint portrait study of ' . $person[1] ) ),
		$person[1],
		$person[2],
		northline_para( $person[3], 'nl-quiet', 'small' )
	);
}

echo northline_section_open(
	array(
		'name'       => 'Team directory',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '02',
		'label'   => 'Team',
		'heading' => 'The people who pitch are the people who build.',
	)
);

echo northline_grid( $cells, 3, 'var:preset|spacing|70' );
echo northline_section_close();
