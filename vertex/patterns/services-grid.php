<?php
/**
 * Title: Services Grid
 * Slug: vertex/services-grid
 * Categories: vertex, columns, featured
 * Description: A three-column grid of service cards.
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:group {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"680px"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"align":"center","style":{"typography":{"letterSpacing":"0.14em","textTransform":"uppercase","fontWeight":"600"}},"textColor":"primary","fontFamily":"mono","fontSize":"small"} -->
<p class="has-text-align-center has-primary-color has-text-color has-mono-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.14em;text-transform:uppercase">What We Do</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Services built to move the needle</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size">From first sketch to final deploy, we cover the full digital product lifecycle under one roof.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<?php
$cards = array(
	array( 'UI/UX Design', 'Human-centered interfaces and design systems that are beautiful, usable, and built to convert.' ),
	array( 'Web Development', 'Fast, accessible, and scalable websites built with modern frameworks and clean code.' ),
	array( 'Brand Identity', 'Distinctive brand systems — logos, guidelines, and visual language that make you unforgettable.' ),
);
foreach ( $cards as $card ) :
	?>
	<!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}},"border":{"radius":"22px","color":"#dde3ee","width":"1px"}},"backgroundColor":"base"} -->
	<div class="wp-block-column has-border-color has-base-background-color has-background" style="border-color:#dde3ee;border-width:1px;border-radius:22px;padding:2rem">
	<!-- wp:heading {"level":3,"fontSize":"large"} -->
	<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $card[0] ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"textColor":"muted"} -->
	<p class="has-muted-color has-text-color"><?php echo esc_html( $card[1] ); ?></p>
	<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
