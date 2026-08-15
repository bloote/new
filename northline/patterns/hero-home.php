<?php
/**
 * Title: Header — home
 * Slug: northline/hero-home
 * Categories: northline-hero
 * Description: The studio's opening statement: positioning line, headline, standfirst, two calls to action, a studio plate, and the four facts that qualify the work.
 * Keywords: hero, header, home, opening
 * Viewport width: 1400
 */

echo northline_section_open(
	array(
		'name'   => 'Hero',
		'class'  => 'nl-plate',
		'top'    => 'var:preset|spacing|90',
		'bottom' => 'var:preset|spacing|80',
	)
);
?>
<!-- wp:columns {"verticalAlignment":"bottom","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-bottom">
<!-- wp:column {"verticalAlignment":"bottom","width":"62%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:62%">
<!-- wp:paragraph {"className":"nl-kicker has-dot","textColor":"accent-deep","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}}} -->
<p class="nl-kicker has-dot has-accent-deep-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--50)">Web design &amp; development studio</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"nl-measure-hero","fontSize":"display-xl","style":{"typography":{"lineHeight":"0.94"}}} -->
<h1 class="wp-block-heading nl-measure-hero has-display-xl-font-size" style="line-height:0.94">Websites that work as hard as your team.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"nl-quiet nl-measure","fontSize":"x-large"} -->
<p class="nl-quiet nl-measure has-x-large-font-size">We plan, design and build sites for companies that have outgrown their template. Clear structure, fast pages, and a CMS your team can actually use.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
<?php
echo northline_button( 'Book a call', northline_page_url( 'contact' ) );
echo northline_button( 'See the work', northline_archive_url( 'project' ), 'secondary' );
?>
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","width":"38%"} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:38%">
<?php
echo northline_image_block(
	'hero-studio.jpg',
	array(
		'ratio' => '4/5',
		'alt'   => 'Blueprint plate standing in for a studio photograph',
	)
);
?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"var:preset|spacing|70"} -->
<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<?php
echo sprintf(
	'<!-- wp:group {"className":"nl-divided","layout":{"type":"grid","columnCount":4}} --><div class="wp-block-group nl-divided">%s</div><!-- /wp:group -->',
	northline_definition( 'Founded', '2016, Bristol' )
	. northline_definition( 'Launches', '61 sites shipped' )
	. northline_definition( 'Typical build', '8–12 weeks' )
	. northline_definition( 'Stack', 'WordPress &amp; headless' )
);

echo northline_section_close();
