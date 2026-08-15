<?php
/**
 * Title: Figures band
 * Slug: northline/stats-band
 * Categories: northline-page
 * Description: Four figures that count up as they scroll into view, divided by hairlines.
 * Keywords: stats, figures, numbers, counters
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'Figures',
		'background' => 'surface',
		'top'        => 'var:preset|spacing|70',
		'bottom'     => 'var:preset|spacing|70',
	)
);

echo northline_stats_row(
	array(
		array( '61', 'Sites launched' ),
		array( '96', 'Median Lighthouse score' ),
		array( '9.4', 'Avg. weeks to launch' ),
		array( '87', 'Clients on a care plan', '%' ),
	)
);

echo northline_section_close();
