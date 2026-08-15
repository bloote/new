<?php
/**
 * Title: Licensing — free versus pro
 * Slug: northline/themes-licensing
 * Categories: northline-catalogue
 * Description: What a free download includes and what a paid licence adds.
 * Keywords: licence, gpl, pricing, table
 * Viewport width: 1400
 */

$rows = array(
	array( 'Full theme, no feature locks', 'Yes', 'Yes' ),
	array( 'Licence', 'GPL v2+', 'GPL v2+ with paid updates' ),
	array( 'Sites per licence', 'Unlimited', '1, 5 or unlimited' ),
	array( 'Automatic updates', 'Via WordPress.org', '12 months included' ),
	array( 'Support', 'Community forum', 'Email, two working days' ),
	array( 'Extra templates &amp; patterns', 'Core set', 'Full set' ),
	array( 'Child theme starter', '—', 'Included' ),
	array( 'Commercial use', 'Yes', 'Yes' ),
);

$body = '';
foreach ( $rows as $row ) {
	$body .= '<tr><td>' . implode( '</td><td>', $row ) . '</td></tr>';
}

echo northline_section_open(
	array(
		'name'       => 'Licensing',
		'background' => 'surface',
	)
);

echo northline_section_head(
	array(
		'number'  => '01',
		'label'   => 'Licensing',
		'heading' => 'What free gets you, and what pro adds.',
	)
);
?>
<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th>&nbsp;</th><th>Free</th><th>Pro licence</th></tr></thead><tbody><?php echo $body; ?></tbody></table></figure>
<!-- /wp:table -->
<?php
echo northline_section_close();
