<?php
/**
 * Title: Pricing Table
 * Slug: vertex/pricing
 * Categories: vertex, columns
 * Description: Three-tier pricing table.
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Simple, transparent pricing</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size">Flexible packages that scale with your ambitions.</p>
<!-- /wp:paragraph -->
<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<?php
$plans = array(
	array( 'Starter', '$2,900', 'Perfect for landing pages and small business sites.', array( '5-page website', 'Responsive design', 'Basic SEO setup', '2 rounds of revisions' ), false ),
	array( 'Growth', '$6,500', 'For growing brands that need a full custom build.', array( 'Up to 15 pages', 'Custom design system', 'CMS integration', 'Performance optimization', 'Priority support' ), true ),
	array( 'Scale', 'Custom', 'Tailored solutions for complex products & apps.', array( 'Unlimited pages', 'Web & mobile apps', 'Dedicated team', 'Ongoing retainer', 'SLA & analytics' ), false ),
);
foreach ( $plans as $plan ) :
	$border = $plan[4] ? '#6d5ef7' : '#dde3ee';
	?>
	<!-- wp:column {"style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem","left":"2rem","right":"2rem"}},"border":{"radius":"22px","color":"<?php echo esc_attr( $border ); ?>","width":"<?php echo $plan[4] ? '2px' : '1px'; ?>"}},"backgroundColor":"base"} -->
	<div class="wp-block-column has-border-color has-base-background-color has-background" style="border-color:<?php echo esc_attr( $border ); ?>;border-width:<?php echo $plan[4] ? '2px' : '1px'; ?>;border-radius:22px;padding:2.5rem 2rem">
	<!-- wp:heading {"level":3,"fontSize":"large"} -->
	<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $plan[0] ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"2.75rem","fontWeight":"800"}}} -->
	<h2 class="wp-block-heading" style="font-size:2.75rem;font-weight:800"><?php echo esc_html( $plan[1] ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"textColor":"muted"} -->
	<p class="has-muted-color has-text-color"><?php echo esc_html( $plan[2] ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:list -->
	<ul class="wp-block-list">
	<?php foreach ( $plan[3] as $feature ) : ?>
		<!-- wp:list-item --><li><?php echo esc_html( $feature ); ?></li><!-- /wp:list-item -->
	<?php endforeach; ?>
	</ul>
	<!-- /wp:list -->
	<!-- wp:buttons -->
	<div class="wp-block-buttons">
	<!-- wp:button {"width":100,"className":"<?php echo $plan[4] ? 'is-style-fill' : 'is-style-outline'; ?>"} -->
	<div class="wp-block-button has-custom-width wp-block-button__width-100 <?php echo $plan[4] ? 'is-style-fill' : 'is-style-outline'; ?>"><a class="wp-block-button__link wp-element-button">Get Started</a></div>
	<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
	</div>
	<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
