<?php
/**
 * Vertex theme functions and definitions.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VERTEX_VERSION', '1.0.0' );
define( 'VERTEX_DIR', get_template_directory() );
define( 'VERTEX_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function vertex_setup() {
	load_theme_textdomain( 'vertex', VERTEX_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support(
		'post-formats',
		array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio' )
	);

	// Custom image sizes for the design system.
	add_image_size( 'vertex-work', 720, 540, true );
	add_image_size( 'vertex-post', 800, 500, true );
	add_image_size( 'vertex-team', 480, 480, true );
	add_image_size( 'vertex-wide', 1400, 720, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'vertex' ),
			'footer'  => __( 'Footer Menu', 'vertex' ),
			'social'  => __( 'Social Links', 'vertex' ),
		)
	);

	// Set content width for embeds/images.
	if ( ! isset( $GLOBALS['content_width'] ) ) {
		$GLOBALS['content_width'] = 1200;
	}
}
add_action( 'after_setup_theme', 'vertex_setup' );

/**
 * Register widget areas.
 */
function vertex_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'vertex' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widgets shown on blog and archive pages.', 'vertex' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer column number. */
				'name'          => sprintf( __( 'Footer Column %d', 'vertex' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => __( 'Appears in the site footer.', 'vertex' ),
				'before_widget' => '<div id="%1$s" class="widget vx-footer-widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'vertex_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function vertex_scripts() {
	// Google Fonts (Sora + Inter + JetBrains Mono).
	if ( get_theme_mod( 'vertex_load_google_fonts', true ) ) {
		wp_enqueue_style(
			'vertex-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap',
			array(),
			null
		);
	}

	wp_enqueue_style( 'vertex-style', get_stylesheet_uri(), array(), VERTEX_VERSION );

	// Dynamic Customizer CSS variables.
	wp_add_inline_style( 'vertex-style', vertex_dynamic_css() );

	wp_enqueue_script( 'vertex-main', VERTEX_URI . '/assets/js/main.js', array(), VERTEX_VERSION, true );
	wp_localize_script(
		'vertex-main',
		'vertexData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'vertex_scripts' );

/**
 * Enqueue block editor assets so patterns match the front end.
 */
function vertex_editor_assets() {
	if ( get_theme_mod( 'vertex_load_google_fonts', true ) ) {
		wp_enqueue_style(
			'vertex-fonts',
			'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap',
			array(),
			null
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'vertex_editor_assets' );

/**
 * Build dynamic CSS from Customizer settings.
 *
 * @return string
 */
function vertex_dynamic_css() {
	$primary = get_theme_mod( 'vertex_color_primary', '#6d5ef7' );
	$accent  = get_theme_mod( 'vertex_color_accent', '#18e0c8' );
	$ink     = get_theme_mod( 'vertex_color_ink', '#0b0f1a' );

	$css  = ':root{';
	$css .= '--vx-primary:' . sanitize_hex_color( $primary ) . ';';
	$css .= '--vx-primary-600:' . vertex_adjust_brightness( $primary, -14 ) . ';';
	$css .= '--vx-primary-700:' . vertex_adjust_brightness( $primary, -28 ) . ';';
	$css .= '--vx-accent:' . sanitize_hex_color( $accent ) . ';';
	$css .= '--vx-accent-600:' . vertex_adjust_brightness( $accent, -14 ) . ';';
	$css .= '--vx-ink:' . sanitize_hex_color( $ink ) . ';';
	$css .= '--vx-gradient:linear-gradient(120deg,' . $primary . ' 0%, ' . vertex_adjust_brightness( $primary, 24 ) . ' 40%, ' . $accent . ' 100%);';
	$css .= '}';

	$container = absint( get_theme_mod( 'vertex_container_width', 1200 ) );
	if ( $container && 1200 !== $container ) {
		$css .= ':root{--vx-container:' . $container . 'px;}';
	}

	return $css;
}

/**
 * Lighten or darken a hex color.
 *
 * @param string $hex   Hex color.
 * @param int    $steps Amount to adjust (-255 to 255).
 * @return string
 */
function vertex_adjust_brightness( $hex, $steps ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( 6 !== strlen( $hex ) ) {
		return '#' . $hex;
	}
	$steps = max( -255, min( 255, $steps ) );
	$r     = max( 0, min( 255, hexdec( substr( $hex, 0, 2 ) ) + $steps ) );
	$g     = max( 0, min( 255, hexdec( substr( $hex, 2, 2 ) ) + $steps ) );
	$b     = max( 0, min( 255, hexdec( substr( $hex, 4, 2 ) ) + $steps ) );

	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}

/**
 * Add a helpful body class and pingback header.
 */
function vertex_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'vx-archive';
	}
	if ( is_page_template( 'page-templates/template-full-width.php' ) ) {
		$classes[] = 'vx-full-width';
	}
	$classes[] = 'vx-layout-' . get_theme_mod( 'vertex_blog_layout', 'grid' );
	return $classes;
}
add_filter( 'body_class', 'vertex_body_classes' );

function vertex_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'vertex_pingback_header' );

/**
 * Allow SVG uploads (used by the demo importer for lightweight imagery).
 */
function vertex_allow_svg( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'vertex_allow_svg' );

function vertex_fix_svg_display( $data, $file, $filename, $mimes ) {
	$ext = isset( pathinfo( $filename )['extension'] ) ? strtolower( pathinfo( $filename )['extension'] ) : '';
	if ( 'svg' === $ext ) {
		$data['type'] = 'image/svg+xml';
		$data['ext']  = 'svg';
	}
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'vertex_fix_svg_display', 10, 4 );

/**
 * Excerpt tweaks.
 */
function vertex_excerpt_length() {
	return 24;
}
add_filter( 'excerpt_length', 'vertex_excerpt_length' );

function vertex_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'vertex_excerpt_more' );

/**
 * Load includes.
 */
require VERTEX_DIR . '/inc/template-tags.php';
require VERTEX_DIR . '/inc/template-functions.php';
require VERTEX_DIR . '/inc/class-vertex-nav-walker.php';
require VERTEX_DIR . '/inc/custom-post-types.php';
require VERTEX_DIR . '/inc/customizer.php';
require VERTEX_DIR . '/inc/block-patterns.php';
require VERTEX_DIR . '/inc/demo-import.php';
