<?php
/**
 * Title: Stack — what we build with
 * Slug: northline/stack-columns
 * Categories: northline-page
 * Description: Four columns listing the tools used for design, CMS, front end and infrastructure.
 * Keywords: stack, tools, technology
 * Viewport width: 1400
 */

$stack = array(
	array( 'Design', array( 'Figma', 'Tokens Studio', 'Axe DevTools' ) ),
	array( 'CMS', array( 'WordPress', 'ACF Pro', 'Timber / Twig' ) ),
	array( 'Front end', array( 'Next.js', 'Vite', 'Alpine.js' ) ),
	array( 'Infrastructure', array( 'Cloudflare', 'Kinsta', 'GitHub Actions' ) ),
);

$cells = array();

foreach ( $stack as $group ) {
	$cells[] = sprintf(
		'<!-- wp:group {"layout":{"type":"default"}} --><div class="wp-block-group"><!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">%s</p><!-- /wp:paragraph -->%s</div><!-- /wp:group -->',
		$group[0],
		northline_plain_list( $group[1], 'medium' )
	);
}

echo northline_section_open(
	array(
		'name'       => 'Stack',
		'background' => 'surface',
		'top'        => 'var:preset|spacing|70',
		'bottom'     => 'var:preset|spacing|70',
	)
);
?>
<!-- wp:group {"className":"nl-rail-layout","layout":{"type":"default"}} -->
<div class="wp-block-group nl-rail-layout">
<!-- wp:paragraph {"className":"nl-index"} --><p class="nl-index"><span>06</span><span>Stack</span></p><!-- /wp:paragraph -->
<?php echo northline_grid( $cells, 4, 'var:preset|spacing|60' ); ?>
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
