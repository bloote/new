<?php
/**
 * Title: Downloads — four routes
 * Slug: northline/downloads-grid
 * Categories: northline-catalogue
 * Description: Four linked cards pointing at themes, plugins, scripts and custom orders.
 * Keywords: downloads, catalogue, themes, plugins
 * Viewport width: 1400
 */

$cards = array(
	array( 'D/01', 'WordPress themes', 'Block themes that shipped on a real project first. Six pro versions add the templates a bigger site needs.', '14 free', 'Browse themes →', northline_page_url( 'themes' ), false ),
	array( 'D/02', 'WordPress plugins', 'Forms, redirects, schema, backups, editor blocks. No upsell nags and no bundled analytics.', '11 free', 'Browse plugins →', northline_page_url( 'plugins' ), false ),
	array( 'D/03', 'Scripts &amp; tools', 'Dependency-free JavaScript under 5 KB, plus six utilities that run entirely in the browser.', 'All free', 'Browse scripts →', northline_page_url( 'scripts-and-tools' ), false ),
	array( 'D/04', 'Built to order', 'A theme, plugin, script or internal tool built to your brief. Fixed price, fixed date, source in your repository.', 'From £850', 'Place an order →', northline_page_url( 'custom-orders' ), true ),
);

$cells = array();

foreach ( $cards as $index => $card ) {
	$inner = sprintf(
		'<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"top"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"nl-index","textColor":"accent-deep"} --><p class="nl-index has-accent-deep-color has-text-color"><span>%1$s</span></p><!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"nl-tag nl-tag-%3$s","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-tag nl-tag-%3$s" style="margin-bottom:0">%2$s</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->',
		$card[0],
		$card[3],
		$card[6] ? 'outline' : 'accent'
	)
	. sprintf(
		'<!-- wp:heading {"level":3,"fontSize":"heading-4"} --><h3 class="wp-block-heading has-heading-4-font-size">%s</h3><!-- /wp:heading -->',
		$card[1]
	)
	. northline_para( $card[2], 'nl-quiet nl-fill', 'small' )
	. sprintf(
		'<!-- wp:paragraph {"className":"nl-kicker","textColor":"accent-deep","style":{"spacing":{"margin":{"bottom":"0"}}}} --><p class="nl-kicker has-accent-deep-color has-text-color" style="margin-bottom:0"><a href="%s">%s</a></p><!-- /wp:paragraph -->',
		esc_url( $card[5] ),
		$card[4]
	);

	$cells[] = northline_panel(
		$inner,
		array(
			'reveal'     => 'nl-reveal nl-delay-' . ( $index % 4 ),
			'background' => $card[6] ? 'accent-tint' : '',
		)
	);
}

echo northline_section_open( array( 'name' => 'Downloads' ) );

echo northline_section_head(
	array(
		'number'      => '02',
		'label'       => 'Downloads',
		'heading'     => 'Themes, plugins and scripts we release from client work.',
		'button_text' => 'Order something custom',
		'button_url'  => northline_page_url( 'custom-orders' ),
		'align'       => 'end',
	)
);

echo northline_grid( $cells, 4 );
echo northline_section_close();
