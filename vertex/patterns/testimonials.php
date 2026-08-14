<?php
/**
 * Title: Testimonials
 * Slug: vertex/testimonials
 * Categories: vertex, testimonials
 * Description: Three client testimonial cards.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Loved by clients worldwide</h2>
<!-- /wp:heading -->
<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<?php
$items = array(
	array( 'Vertex transformed our outdated site into a conversion machine. Sales are up 60% and the team is a genuine pleasure to work with.', 'Sarah Chen', 'CEO, Lumen Finance' ),
	array( 'The most professional, thoughtful, and talented studio we have ever partnered with. They just get it — design, code, and business.', 'Marcus Reid', 'Founder, Orbital' ),
	array( 'From strategy to launch, everything was seamless. Our new platform is fast, gorgeous, and our customers love it.', 'Priya Nair', 'CMO, Vireo Health' ),
);
foreach ( $items as $item ) :
	?>
	<!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"radius":"22px","color":"#dde3ee","width":"1px"}},"backgroundColor":"base"} -->
	<div class="wp-block-column has-border-color has-base-background-color has-background" style="border-color:#dde3ee;border-width:1px;border-radius:22px;padding:2rem">
	<!-- wp:paragraph {"textColor":"amber"} -->
	<p class="has-amber-color has-text-color">★★★★★</p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"fontSize":"large"} -->
	<p class="has-large-font-size">“<?php echo esc_html( $item[0] ); ?>”</p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700"}},"fontFamily":"heading"} -->
	<p class="has-heading-font-family" style="font-weight:700"><?php echo esc_html( $item[1] ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:paragraph {"textColor":"muted","fontSize":"small","style":{"spacing":{"margin":{"top":"-1rem"}}}} -->
	<p class="has-muted-color has-text-color has-small-font-size" style="margin-top:-1rem"><?php echo esc_html( $item[2] ); ?></p>
	<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
