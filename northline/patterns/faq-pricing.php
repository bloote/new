<?php
/**
 * Title: Pricing — questions
 * Slug: northline/faq-pricing
 * Categories: northline-page
 * Description: Four expandable answers about scope changes, working with in-house teams, payment terms and hosting.
 * Keywords: faq, questions, pricing, accordion
 * Viewport width: 1400
 */

$faqs = array(
	array( 'What happens if the scope changes mid-project?', 'We quote the change as its own small piece of work with its own price and timeline. You decide whether it goes in now or into a follow-up phase. Nothing is billed that you have not approved in writing.' ),
	array( 'Do you work with our existing developers?', 'Often. In that case we design and document the system, review pull requests, and pair with your team through the first few templates so the patterns hold after we leave.' ),
	array( 'How do payments work?', 'Thirty per cent to start, thirty at design sign-off, the balance at launch. Longer projects can be spread monthly instead. Care plans are billed monthly in advance and can be cancelled with 30 days notice.' ),
	array( 'Who hosts the site?', 'You do, on an account in your name. We will set it up and recommend a configuration, usually Kinsta or Cloudflare, so you are never locked to us for access.' ),
);

$rows = '';
foreach ( $faqs as $index => $faq ) {
	$rows .= northline_accordion_row( $faq[0], northline_para( $faq[1], 'nl-quiet nl-measure', 'large' ), 0 === $index );
}

echo northline_section_open( array( 'name' => 'Questions' ) );
?>
<!-- wp:group {"className":"nl-rail-layout","layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>03</span><span>Questions</span></p><!-- /wp:paragraph -->
<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo $rows; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
