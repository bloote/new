<?php
/**
 * Title: Section — four figures
 * Slug: northline/section-figures
 * Categories: northline-page
 * Description: Four numbers divided by hairlines, each counting up when it scrolls into view. Change a number and the count follows it — the value in the markup is the value it counts to.
 * Keywords: stats, figures, numbers, counter, generic
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'Figures',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '04',
		'label'   => 'Section label',
		'heading' => 'Four numbers worth knowing.',
	)
);

echo northline_stats_row(
	array(
		array( '120', 'What this number counts' ),
		array( '48', 'A second measure', '%' ),
		array( '9.4', 'A third, with a decimal' ),
		array( '15', 'A fourth, in years' ),
	)
);

echo northline_section_close();
