<?php
/**
 * Title: Section — questions and answers
 * Slug: northline/section-faq
 * Categories: northline-page
 * Description: Five expanding rows with the first one open. The questions are placeholders, so this is the FAQ to use on a page of your own rather than one of the ones already written for pricing or the docs.
 * Keywords: faq, questions, accordion, generic
 * Viewport width: 1400
 */

$faqs = array(
	array( 'The question people ask first.', 'Answer it in two or three sentences. The first row starts open so the pattern is obvious to anyone who has not met an accordion before.' ),
	array( 'The one they ask when the first answer worries them.', 'Say the awkward part out loud. An answer that dodges is worse than no question at all.' ),
	array( 'The practical one about time or money.', 'Give a number, or the reason there is not one yet.' ),
	array( 'The one about what happens afterwards.', 'Handover, support, ownership — whatever afterwards means for this page.' ),
	array( 'The one nobody asks until it is too late.', 'Ask it on their behalf and answer it here.' ),
);

$rows = '';
foreach ( $faqs as $index => $faq ) {
	$rows .= northline_accordion_row( $faq[0], northline_para( $faq[1], 'nl-quiet nl-measure', 'large' ), 0 === $index );
}

echo northline_section_open( array( 'name' => 'Questions' ) );

echo northline_section_head(
	array(
		'number'  => '03',
		'label'   => 'Questions',
		'heading' => 'Answers to the obvious ones.',
	)
);

echo $rows; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block markup.
echo northline_section_close();
