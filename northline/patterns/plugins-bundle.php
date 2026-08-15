<?php
/**
 * Title: All-access bundle
 * Slug: northline/plugins-bundle
 * Categories: northline-catalogue
 * Description: The agency bundle: every pro product on one annual licence, in a framed panel.
 * Keywords: bundle, licence, agency, pricing
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'       => 'All-access bundle',
		'background' => 'surface',
	)
);
?>
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"56%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%">
<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep"} --><p class="nl-kicker has-accent-deep-color has-text-color">All-access bundle</p><!-- /wp:paragraph -->
<!-- wp:heading {"className":"nl-measure-tight","fontSize":"heading-2"} --><h2 class="wp-block-heading nl-measure-tight has-heading-2-font-size">Every pro plugin and theme, one licence.</h2><!-- /wp:heading -->
<?php echo northline_para( 'For agencies and freelancers who use two or more of these regularly. Unlimited client sites, twelve months of updates and support, and every new release during the term.', 'nl-quiet nl-measure', 'large' ); ?>
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"44%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%">
<?php
echo northline_panel(
	'<!-- wp:paragraph {"className":"nl-numeral","style":{"typography":{"fontSize":"clamp(2.5rem,4vw,3.5rem)"},"spacing":{"margin":{"bottom":"var:preset|spacing|10"}}}} --><p class="nl-numeral" style="margin-bottom:var(--wp--preset--spacing--10);font-size:clamp(2.5rem,4vw,3.5rem)">£399 <span class="nl-quiet" style="font-size:1rem">per year</span></p><!-- /wp:paragraph -->'
	. northline_para( 'Renews at £299. Cancel and keep using every version released while you were licensed.', 'nl-quiet', 'small' )
	. sprintf(
		'<!-- wp:group {"className":"nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}},"layout":{"type":"default"}} --><div class="wp-block-group nl-rule" style="padding-top:var(--wp--preset--spacing--40)">%s</div><!-- /wp:group -->',
		northline_plain_list(
			array( '16 pro products, including Atlas', 'Unlimited client sites', 'Two-working-day support', 'Early access to new releases' ),
			'medium'
		)
	)
	. sprintf(
		'<!-- wp:buttons {"layout":{"type":"flex","orientation":"vertical"}} --><div class="wp-block-buttons">%s</div><!-- /wp:buttons -->',
		northline_button( 'Buy the bundle', northline_page_url( 'contact' ) )
	),
	array( 'background' => 'base' )
);
?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<?php
echo northline_section_close();
