<?php
/**
 * Theme supports, assets and editor plumbing.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare what the theme supports.
 */
function northline_setup() {
	load_theme_textdomain( 'northline', NORTHLINE_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-logo', array(
		'height'      => 48,
		'width'       => 48,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	add_editor_style( 'assets/css/editor.css' );

	// Image sizes that match the aspect ratios the patterns ask for.
	add_image_size( 'northline-card', 800, 600, true );
	add_image_size( 'northline-wide', 1600, 900, true );
	add_image_size( 'northline-portrait', 800, 1000, true );
	add_image_size( 'northline-square', 800, 800, true );
}
add_action( 'after_setup_theme', 'northline_setup' );

/**
 * Front-end stylesheet and behaviour script.
 */
function northline_enqueue_assets() {
	wp_enqueue_style(
		'northline-style',
		get_stylesheet_uri(),
		array(),
		NORTHLINE_VERSION
	);

	wp_enqueue_script(
		'northline-interactions',
		NORTHLINE_URI . '/assets/js/northline.js',
		array(),
		NORTHLINE_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'northline_enqueue_assets' );

/**
 * Mark the document as scripted before first paint, so components that
 * collapse (tabs, accordions, reveals) never flash open and then shut.
 */
function northline_js_flag() {
	echo "<script>document.documentElement.classList.add('nl-js');</script>\n";
}
add_action( 'wp_head', 'northline_js_flag', 1 );

/**
 * Skip link ahead of the sticky header.
 */
function northline_skip_link() {
	printf(
		'<a class="skip-link screen-reader-text" href="#nl-content">%s</a>',
		esc_html__( 'Skip to content', 'northline' )
	);
}
add_action( 'wp_body_open', 'northline_skip_link' );

/**
 * Give the editor canvas the same component layer as the front end, so
 * patterns look in the editor exactly as they do on the site.
 */
function northline_editor_assets() {
	wp_enqueue_style(
		'northline-editor-shell',
		get_stylesheet_uri(),
		array(),
		NORTHLINE_VERSION
	);
}
add_action( 'enqueue_block_assets', 'northline_editor_assets' );

/**
 * Default excerpt length and ending, tuned for the card grids.
 *
 * @param int $length Word count.
 * @return int
 */
function northline_excerpt_length( $length ) {
	return 26;
}
add_filter( 'excerpt_length', 'northline_excerpt_length' );

/**
 * @param string $more Excerpt suffix.
 * @return string
 */
function northline_excerpt_more( $more ) {
	return '…';
}
add_filter( 'excerpt_more', 'northline_excerpt_more' );

/**
 * A social card for pages that have no featured image of their own.
 */
function northline_default_social_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		return;
	}
	printf(
		'<meta property="og:image" content="%s">' . "\n",
		esc_url( NORTHLINE_URI . '/assets/images/og-default.jpg' )
	);
}
add_action( 'wp_head', 'northline_default_social_image' );
