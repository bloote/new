<?php
/**
 * Title: Stats Band
 * Slug: vertex/stats
 * Categories: vertex, columns
 * Description: A four-column band of key statistics.
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"ink","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-color has-ink-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<?php
$stats = array(
	array( '250+', 'Projects Delivered' ),
	array( '98%', 'Client Retention' ),
	array( '12yrs', 'In Business' ),
	array( '40+', 'Team Members' ),
);
foreach ( $stats as $stat ) :
	?>
	<!-- wp:column -->
	<div class="wp-block-column">
	<!-- wp:heading {"textAlign":"center","level":2,"style":{"typography":{"fontSize":"3.25rem"}},"textColor":"accent"} -->
	<h2 class="wp-block-heading has-text-align-center has-accent-color has-text-color" style="font-size:3.25rem"><?php echo esc_html( $stat[0] ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","textColor":"line"} -->
	<p class="has-text-align-center has-line-color has-text-color"><?php echo esc_html( $stat[1] ); ?></p>
	<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
