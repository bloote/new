<?php
/**
 * Title: FAQ
 * Slug: vertex/faq
 * Categories: vertex, text
 * Description: Frequently asked questions using details blocks.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Frequently asked questions</h2>
<!-- /wp:heading -->
<!-- wp:spacer {"height":"32px"} -->
<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
<?php
$faqs = array(
	array( 'How long does a typical project take?', 'Most websites take 6–10 weeks from kickoff to launch, depending on scope and complexity. We share a detailed timeline during onboarding.' ),
	array( 'Do you work with clients remotely?', 'Absolutely. We partner with teams around the world and run a fully remote-friendly process with regular check-ins and clear communication.' ),
	array( 'What platforms do you build on?', 'We specialize in WordPress, but also build on Webflow, Shopify, and custom React/Next.js stacks depending on your needs.' ),
	array( 'Do you offer ongoing support?', 'Yes — we offer maintenance and growth retainers to keep your site fast, secure, and continuously improving after launch.' ),
);
foreach ( $faqs as $faq ) :
	?>
	<!-- wp:details {"style":{"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem","left":"1.5rem","right":"1.5rem"},"margin":{"bottom":"1rem"}},"border":{"radius":"14px","color":"#dde3ee","width":"1px"}}} -->
	<details class="wp-block-details has-border-color" style="border-color:#dde3ee;border-width:1px;border-radius:14px;margin-bottom:1rem;padding:1.25rem 1.5rem"><summary><?php echo esc_html( $faq[0] ); ?></summary>
	<!-- wp:paragraph {"textColor":"muted"} -->
	<p class="has-muted-color has-text-color"><?php echo esc_html( $faq[1] ); ?></p>
	<!-- /wp:paragraph -->
	</details>
	<!-- /wp:details -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->
