<?php
/**
 * Title: Docs — questions
 * Slug: northline/docs-faq
 * Categories: northline-page
 * Description: Four expandable answers about page builders, editor guardrails, updates and client documentation.
 * Keywords: docs, faq, questions, accordion
 * Viewport width: 1400
 */

$faqs = array(
	array( 'Do I need a page builder?', 'No, and we would rather you did not use one. Everything is core blocks and registered patterns, so the editor you already have is the editor you need. Adding a builder on top usually breaks the global styles.' ),
	array( 'Can my team break the design?', 'Not easily. Colour, font-size and spacing controls are constrained to the theme&#8217;s scales, and structural blocks inside patterns are locked. Editors change words and images; the layout stays as designed.' ),
	array( 'What happens to my edits when the theme updates?', 'Page content and any template you customised are stored in the database, so they survive updates untouched. Templates you never edited pick up improvements. For code changes, use a child theme.' ),
	array( 'Is there documentation I can hand to a client?', 'Yes. Every theme ships with a plain-language editor guide you can rebrand, plus the recorded walkthrough. Agencies on the all-access bundle can white-label both.' ),
);

$rows = '';
foreach ( $faqs as $index => $faq ) {
	$rows .= northline_accordion_row( $faq[0], northline_para( $faq[1], 'nl-quiet nl-measure', 'large' ), 0 === $index );
}

echo northline_section_open( array( 'name' => 'Docs questions' ) );
?>
<!-- wp:group {"className":"nl-rail-layout","layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>04</span><span>Questions</span></p><!-- /wp:paragraph -->
<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo $rows; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
