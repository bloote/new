<?php
/**
 * Title: Header — themes catalogue
 * Slug: northline/hero-themes
 * Categories: northline-hero
 * Description: The themes catalogue header with a framed figures box: free and pro counts, installs and licence.
 * Keywords: hero, header, downloads, themes
 * Viewport width: 1400
 */

echo northline_page_header(
	array(
		'name'        => 'Themes header',
		'kicker'      => 'Downloads · WordPress themes',
		'heading'     => 'Themes we build for our own clients, then release.',
		'lede'        => 'Every theme here shipped on a real project first. The free ones are GPL and complete. The pro ones add the templates and options a bigger site needs.',
		'right'       => northline_figures_box(
			array(
				array( 'Free themes', northline_counter( '14', ' available' ) ),
				array( 'Pro themes', northline_counter( '6', ' available' ) ),
				array( 'Installs', northline_counter( '48', 'k+' ) ),
				array( 'Licence', 'GPL v2+' ),
			)
		),
		'right_width' => '42%',
	)
);
