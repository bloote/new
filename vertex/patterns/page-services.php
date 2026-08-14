<?php
/**
 * Title: Page — Services
 * Slug: vertex/page-services
 * Categories: vertex-pages
 * Description: A complete Services page layout.
 * Inserter: no
 */
?>
<!-- wp:pattern {"slug":"vertex/services-grid"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--30)">
<!-- wp:group {"layout":{"type":"constrained","contentSize":"680px"}} -->
<div class="wp-block-group">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">How we work</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size">A proven, transparent process from first conversation to launch and beyond.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<div class="wp-block-columns alignwide" style="margin-top:2rem">
<?php
$steps = array(
	array( '01', 'Discover', 'We dig into your goals, users, and market to build a rock-solid strategy.' ),
	array( '02', 'Design', 'We craft wireframes, prototypes, and polished interfaces validated with real feedback.' ),
	array( '03', 'Develop', 'We engineer fast, secure, and scalable code with rigorous testing.' ),
	array( '04', 'Deploy & Grow', 'We launch, measure, and iterate — turning data into compounding growth.' ),
);
foreach ( $steps as $s ) :
	?>
	<!-- wp:column -->
	<div class="wp-block-column">
	<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700"}},"textColor":"primary","fontFamily":"mono"} -->
	<p class="has-primary-color has-text-color has-mono-font-family" style="font-weight:700"><?php echo esc_html( $s[0] ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"level":3,"fontSize":"large"} -->
	<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $s[1] ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"textColor":"muted"} -->
	<p class="has-muted-color has-text-color"><?php echo esc_html( $s[2] ); ?></p>
	<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"vertex/pricing"} /-->
<!-- wp:pattern {"slug":"vertex/faq"} /-->
<!-- wp:pattern {"slug":"vertex/cta"} /-->
