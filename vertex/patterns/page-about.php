<?php
/**
 * Title: Page — About
 * Slug: vertex/page-about
 * Categories: vertex-pages
 * Description: A complete About page layout.
 * Inserter: no
 */
?>
<!-- wp:pattern {"slug":"vertex/feature-split"} /-->

<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Our story</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size">Founded in 2013, Vertex began as two friends with a laptop and a belief that great design and solid engineering should never be at odds. A decade later, we're a team of 40+ designers, developers, and strategists helping brands ship products that matter.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","textColor":"muted"} -->
<p class="has-text-align-center has-muted-color has-text-color">We've partnered with early-stage startups and Fortune 500 teams alike — but our approach never changes: listen closely, design thoughtfully, build carefully, and measure everything. We treat every project like it's our own product.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"vertex/stats"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--30)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">The values that guide us</h2>
<!-- /wp:heading -->
<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<div class="wp-block-columns alignwide" style="margin-top:2rem">
<?php
$values = array(
	array( 'Craft over shortcuts', 'We sweat the details others skip. Quality is a habit, not an afterthought.' ),
	array( 'Radical transparency', 'Clear timelines, honest updates, and no jargon. You always know where things stand.' ),
	array( 'Impact, measured', 'Beautiful is not enough. We build for outcomes and prove the results with data.' ),
);
foreach ( $values as $v ) :
	?>
	<!-- wp:column -->
	<div class="wp-block-column">
	<!-- wp:heading {"level":3,"fontSize":"large"} -->
	<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $v[0] ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"textColor":"muted"} -->
	<p class="has-muted-color has-text-color"><?php echo esc_html( $v[1] ); ?></p>
	<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"vertex/cta"} /-->
