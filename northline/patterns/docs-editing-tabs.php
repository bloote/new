<?php
/**
 * Title: Docs — editing guide
 * Slug: northline/docs-editing-tabs
 * Categories: northline-page
 * Description: Four tabbed lessons: Site Editor basics, patterns, templates and parts, and global styles.
 * Keywords: docs, editing, tabs, site editor
 * Viewport width: 1400
 */

$template_rows = array(
	array( 'front-page', 'The home page and its section order' ),
	array( 'page', 'Standard pages: services, pricing, contact' ),
	array( 'single', 'A journal post' ),
	array( 'index &middot; archive', 'Journal listing and category archives' ),
	array( 'single-project', 'Case studies' ),
	array( 'archive-project', 'The work index, including its filters' ),
	array( 'single-download &middot; archive-download', 'The catalogue' ),
	array( 'search &middot; 404', 'Search results and the not-found page' ),
	array( 'parts/header &middot; parts/footer', 'Navigation, brand mark, footer columns' ),
);

$table_body = '';
foreach ( $template_rows as $row ) {
	$table_body .= '<tr><td><code>' . $row[0] . '</code></td><td>' . $row[1] . '</td></tr>';
}

$panels = array();

$panels[] = '<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">Site Editor basics</h3><!-- /wp:heading -->'
	. northline_para( 'Appearance → Editor is where the whole site lives: templates, template parts, styles and patterns. The list view (top left) shows the block tree, which is the fastest way to select a section rather than clicking through nested blocks.', 'nl-quiet nl-measure', 'large' )
	. sprintf(
		'<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60"},"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--60)">
<!-- wp:column {"width":"58%%"} --><div class="wp-block-column" style="flex-basis:58%%">%1$s</div><!-- /wp:column -->
<!-- wp:column {"width":"42%%"} --><div class="wp-block-column" style="flex-basis:42%%">%2$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
		northline_image_block( 'docs-site-editor.jpg', array( 'ratio' => '16/10', 'alt' => 'Wireframe of the WordPress Site Editor' ) ),
		northline_definition( 'Save behaviour', 'Template and part changes are saved together and listed before you confirm.' )
		. northline_definition( 'Reverting', 'Any customised template can be reset to the theme version from its options menu.' )
		. northline_definition( 'Roles', 'Editors can edit pages and patterns; only administrators can change templates.' )
	);

$panels[] = '<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">Patterns</h3><!-- /wp:heading -->'
	. northline_para( 'Every section of every page in this theme is a registered pattern. Insert one and it becomes normal blocks on your page, editable and detached from the original. Synced patterns work the other way: edit once, change everywhere.', 'nl-quiet nl-measure', 'large' )
	. sprintf(
		'<!-- wp:columns {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60"},"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns" style="margin-top:var(--wp--preset--spacing--60)">
<!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph {"className":"nl-meta","textColor":"accent-deep"} --><p class="nl-meta has-accent-deep-color has-text-color">Use an unsynced pattern for</p><!-- /wp:paragraph -->%1$s</div><!-- /wp:column -->
<!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph {"className":"nl-meta","textColor":"accent-deep"} --><p class="nl-meta has-accent-deep-color has-text-color">Use a synced pattern for</p><!-- /wp:paragraph -->%2$s</div><!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:paragraph {"className":"nl-mono"} --><p class="nl-mono">patterns/hero-home.php &middot; patterns/services-grid.php &middot; patterns/cta-home.php</p><!-- /wp:paragraph -->',
		northline_plain_list( array( 'Page sections: heroes, service grids, figure rows', 'Anything whose copy differs per page', 'Layouts you want to cut down after inserting' ), 'medium' ),
		northline_plain_list( array( 'Contact details and opening hours', 'Compliance or legal notes', 'The call-to-action band that repeats on every page' ), 'medium' )
	);

$panels[] = '<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">Templates &amp; parts</h3><!-- /wp:heading -->'
	. northline_para( 'Templates control whole page types; parts are the pieces they share. Editing the header part once changes it on every template that includes it, which is all of them.', 'nl-quiet nl-measure', 'large' )
	. '<!-- wp:table --><figure class="wp-block-table"><table><thead><tr><th>Template</th><th>Controls</th></tr></thead><tbody>' . $table_body . '</tbody></table></figure><!-- /wp:table -->';

$panels[] = '<!-- wp:heading {"level":3,"fontSize":"heading-3"} --><h3 class="wp-block-heading has-heading-3-font-size">Global styles</h3><!-- /wp:heading -->'
	. northline_para( 'Styles → Colours, Typography and Layout write to theme.json, so they apply to core blocks as well as ours. Set the palette, the type scale and the content width there and stop thinking about CSS.', 'nl-quiet nl-measure', 'large' )
	. northline_grid(
		array(
			northline_panel(
				'<!-- wp:paragraph {"className":"nl-meta","textColor":"accent-deep"} --><p class="nl-meta has-accent-deep-color has-text-color">Colours</p><!-- /wp:paragraph -->' . northline_para( 'Ten palette slots. Blocks reference the slot, never a hex, so a rebrand is one change.', 'nl-quiet', 'small' ),
				array( 'background' => 'base', 'padding' => 'var:preset|spacing|40' )
			),
			northline_panel(
				'<!-- wp:paragraph {"className":"nl-meta","textColor":"accent-deep"} --><p class="nl-meta has-accent-deep-color has-text-color">Typography</p><!-- /wp:paragraph -->' . northline_para( 'Two families and a fluid scale. Web fonts are bundled locally, so no external requests.', 'nl-quiet', 'small' ),
				array( 'background' => 'base', 'padding' => 'var:preset|spacing|40' )
			),
			northline_panel(
				'<!-- wp:paragraph {"className":"nl-meta","textColor":"accent-deep"} --><p class="nl-meta has-accent-deep-color has-text-color">Layout</p><!-- /wp:paragraph -->' . northline_para( 'Content and wide widths plus the spacing scale every pattern uses for its padding.', 'nl-quiet', 'small' ),
				array( 'background' => 'base', 'padding' => 'var:preset|spacing|40' )
			),
		),
		3,
		'var:preset|spacing|50'
	);

$buttons = '';
foreach ( array( 'Site Editor basics', 'Patterns', 'Templates &amp; parts', 'Global styles' ) as $label ) {
	$buttons .= northline_button( $label, '#', 'secondary', 'nl-tab-btn' );
}

$panel_markup = '';
foreach ( $panels as $panel ) {
	$panel_markup .= sprintf(
		'<!-- wp:group {"className":"nl-tab-panel","layout":{"type":"default"}} --><div class="wp-block-group nl-tab-panel">%s</div><!-- /wp:group -->',
		$panel
	);
}

echo northline_section_open(
	array(
		'name'       => 'Editing guide',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '02',
		'label'   => 'Editing guide',
		'heading' => 'Four things every editor needs to know.',
	)
);
?>
<!-- wp:group {"className":"nl-tabs nl-rail-layout nl-rule","style":{"spacing":{"padding":{"top":"var:preset|spacing|60"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group nl-tabs nl-rail-layout nl-rule" style="padding-top:var(--wp--preset--spacing--60)">
<!-- wp:buttons {"className":"nl-tab-list","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-buttons nl-tab-list"><?php echo $buttons; ?></div>
<!-- /wp:buttons -->
<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><?php echo $panel_markup; ?></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<?php
echo northline_section_close();
