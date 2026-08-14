<?php
/**
 * Vertex Theme Customizer.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function vertex_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a span',
				'render_callback' => function () {
					return get_bloginfo( 'name' );
				},
			)
		);
	}

	/* ------------------------------------------------------------------ *
	 * PANEL: Theme Options
	 * ------------------------------------------------------------------ */
	$wp_customize->add_panel(
		'vertex_panel',
		array(
			'title'    => __( 'Vertex Theme Options', 'vertex' ),
			'priority' => 20,
		)
	);

	/* ------- Section: Brand Colors ------- */
	$wp_customize->add_section( 'vertex_colors', array( 'title' => __( 'Brand Colors', 'vertex' ), 'panel' => 'vertex_panel' ) );

	$colors = array(
		'vertex_color_primary' => array( __( 'Primary Color', 'vertex' ), '#6d5ef7' ),
		'vertex_color_accent'  => array( __( 'Accent Color', 'vertex' ), '#18e0c8' ),
		'vertex_color_ink'     => array( __( 'Dark / Ink Color', 'vertex' ), '#0b0f1a' ),
	);
	foreach ( $colors as $id => $data ) {
		$wp_customize->add_setting( $id, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $data[0], 'section' => 'vertex_colors' ) ) );
	}

	/* ------- Section: Layout & Fonts ------- */
	$wp_customize->add_section( 'vertex_layout', array( 'title' => __( 'Layout & Typography', 'vertex' ), 'panel' => 'vertex_panel' ) );

	vertex_add_setting( $wp_customize, 'vertex_container_width', 1200, 'absint' );
	$wp_customize->add_control( 'vertex_container_width', array(
		'label'       => __( 'Content Width (px)', 'vertex' ),
		'section'     => 'vertex_layout',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1000, 'max' => 1600, 'step' => 20 ),
	) );

	vertex_add_setting( $wp_customize, 'vertex_load_google_fonts', true, 'vertex_sanitize_checkbox' );
	$wp_customize->add_control( 'vertex_load_google_fonts', array(
		'label'   => __( 'Load Google Fonts (Sora + Inter)', 'vertex' ),
		'section' => 'vertex_layout',
		'type'    => 'checkbox',
	) );

	vertex_add_setting( $wp_customize, 'vertex_blog_layout', 'grid', 'sanitize_text_field' );
	$wp_customize->add_control( 'vertex_blog_layout', array(
		'label'   => __( 'Blog Layout', 'vertex' ),
		'section' => 'vertex_layout',
		'type'    => 'select',
		'choices' => array( 'grid' => __( 'Grid', 'vertex' ), 'list' => __( 'List', 'vertex' ) ),
	) );

	/* ------- Section: Header ------- */
	$wp_customize->add_section( 'vertex_header', array( 'title' => __( 'Header', 'vertex' ), 'panel' => 'vertex_panel' ) );

	vertex_add_setting( $wp_customize, 'vertex_topbar_text', '', 'wp_kses_post' );
	$wp_customize->add_control( 'vertex_topbar_text', array( 'label' => __( 'Announcement Bar Text', 'vertex' ), 'description' => __( 'Leave empty to hide.', 'vertex' ), 'section' => 'vertex_header', 'type' => 'text' ) );

	vertex_add_setting( $wp_customize, 'vertex_header_search', true, 'vertex_sanitize_checkbox' );
	$wp_customize->add_control( 'vertex_header_search', array( 'label' => __( 'Show Search Icon', 'vertex' ), 'section' => 'vertex_header', 'type' => 'checkbox' ) );

	vertex_add_setting( $wp_customize, 'vertex_header_cta_text', __( "Let's Talk", 'vertex' ) );
	$wp_customize->add_control( 'vertex_header_cta_text', array( 'label' => __( 'Header Button Text', 'vertex' ), 'section' => 'vertex_header', 'type' => 'text' ) );

	vertex_add_setting( $wp_customize, 'vertex_header_cta_url', '#contact', 'esc_url_raw' );
	$wp_customize->add_control( 'vertex_header_cta_url', array( 'label' => __( 'Header Button URL', 'vertex' ), 'section' => 'vertex_header', 'type' => 'url' ) );

	/* ------- Section: Hero ------- */
	$wp_customize->add_section( 'vertex_hero', array( 'title' => __( 'Homepage Hero', 'vertex' ), 'panel' => 'vertex_panel' ) );

	vertex_add_setting( $wp_customize, 'vertex_hero_title', __( 'We design & build digital products that grow brands.', 'vertex' ), 'wp_kses_post', 'postMessage' );
	$wp_customize->add_control( 'vertex_hero_title', array( 'label' => __( 'Hero Title', 'vertex' ), 'section' => 'vertex_hero', 'type' => 'textarea' ) );

	vertex_add_setting( $wp_customize, 'vertex_hero_text', __( 'Vertex is a full-service web design and development studio.', 'vertex' ), 'sanitize_textarea_field', 'postMessage' );
	$wp_customize->add_control( 'vertex_hero_text', array( 'label' => __( 'Hero Text', 'vertex' ), 'section' => 'vertex_hero', 'type' => 'textarea' ) );

	vertex_add_setting( $wp_customize, 'vertex_hero_btn1_text', __( 'Start a Project', 'vertex' ) );
	$wp_customize->add_control( 'vertex_hero_btn1_text', array( 'label' => __( 'Primary Button Text', 'vertex' ), 'section' => 'vertex_hero', 'type' => 'text' ) );
	vertex_add_setting( $wp_customize, 'vertex_hero_btn1_url', '#contact', 'esc_url_raw' );
	$wp_customize->add_control( 'vertex_hero_btn1_url', array( 'label' => __( 'Primary Button URL', 'vertex' ), 'section' => 'vertex_hero', 'type' => 'url' ) );
	vertex_add_setting( $wp_customize, 'vertex_hero_btn2_text', __( 'View Our Work', 'vertex' ) );
	$wp_customize->add_control( 'vertex_hero_btn2_text', array( 'label' => __( 'Secondary Button Text', 'vertex' ), 'section' => 'vertex_hero', 'type' => 'text' ) );
	vertex_add_setting( $wp_customize, 'vertex_hero_btn2_url', '#work', 'esc_url_raw' );
	$wp_customize->add_control( 'vertex_hero_btn2_url', array( 'label' => __( 'Secondary Button URL', 'vertex' ), 'section' => 'vertex_hero', 'type' => 'url' ) );

	$wp_customize->add_setting( 'vertex_hero_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vertex_hero_image', array( 'label' => __( 'Hero Image (optional, replaces illustration)', 'vertex' ), 'section' => 'vertex_hero' ) ) );

	/* ------- Section: Stats ------- */
	$wp_customize->add_section( 'vertex_stats', array( 'title' => __( 'Statistics', 'vertex' ), 'panel' => 'vertex_panel' ) );
	$stats = array(
		1 => array( '250+', __( 'Projects Delivered', 'vertex' ) ),
		2 => array( '98%', __( 'Client Retention', 'vertex' ) ),
		3 => array( '12yrs', __( 'Of Experience', 'vertex' ) ),
		4 => array( '40+', __( 'Team Members', 'vertex' ) ),
	);
	foreach ( $stats as $i => $s ) {
		vertex_add_setting( $wp_customize, "vertex_stat_{$i}_num", $s[0] );
		$wp_customize->add_control( "vertex_stat_{$i}_num", array( 'label' => sprintf( __( 'Stat %d Number', 'vertex' ), $i ), 'section' => 'vertex_stats', 'type' => 'text' ) );
		vertex_add_setting( $wp_customize, "vertex_stat_{$i}_label", $s[1] );
		$wp_customize->add_control( "vertex_stat_{$i}_label", array( 'label' => sprintf( __( 'Stat %d Label', 'vertex' ), $i ), 'section' => 'vertex_stats', 'type' => 'text' ) );
	}

	/* ------- Section: Call to Action ------- */
	$wp_customize->add_section( 'vertex_cta', array( 'title' => __( 'Call To Action', 'vertex' ), 'panel' => 'vertex_panel' ) );
	vertex_add_setting( $wp_customize, 'vertex_cta_title', __( 'Ready to build something great?', 'vertex' ) );
	$wp_customize->add_control( 'vertex_cta_title', array( 'label' => __( 'CTA Title', 'vertex' ), 'section' => 'vertex_cta', 'type' => 'text' ) );
	vertex_add_setting( $wp_customize, 'vertex_cta_text', __( 'Tell us about your project and let’s turn your idea into a product people love.', 'vertex' ), 'sanitize_textarea_field' );
	$wp_customize->add_control( 'vertex_cta_text', array( 'label' => __( 'CTA Text', 'vertex' ), 'section' => 'vertex_cta', 'type' => 'textarea' ) );
	vertex_add_setting( $wp_customize, 'vertex_cta_btn_text', __( 'Start Your Project', 'vertex' ) );
	$wp_customize->add_control( 'vertex_cta_btn_text', array( 'label' => __( 'CTA Button Text', 'vertex' ), 'section' => 'vertex_cta', 'type' => 'text' ) );
	vertex_add_setting( $wp_customize, 'vertex_cta_btn_url', '', 'esc_url_raw' );
	$wp_customize->add_control( 'vertex_cta_btn_url', array( 'label' => __( 'CTA Button URL', 'vertex' ), 'section' => 'vertex_cta', 'type' => 'url' ) );

	/* ------- Section: Contact Info ------- */
	$wp_customize->add_section( 'vertex_contact', array( 'title' => __( 'Contact Information', 'vertex' ), 'panel' => 'vertex_panel' ) );
	vertex_add_setting( $wp_customize, 'vertex_contact_email', 'hello@vertexstudio.com', 'sanitize_email' );
	$wp_customize->add_control( 'vertex_contact_email', array( 'label' => __( 'Email', 'vertex' ), 'section' => 'vertex_contact', 'type' => 'email' ) );
	vertex_add_setting( $wp_customize, 'vertex_contact_phone', '+1 (555) 012-3456' );
	$wp_customize->add_control( 'vertex_contact_phone', array( 'label' => __( 'Phone', 'vertex' ), 'section' => 'vertex_contact', 'type' => 'text' ) );
	vertex_add_setting( $wp_customize, 'vertex_contact_address', '100 Market Street, Suite 400, San Francisco, CA', 'sanitize_textarea_field' );
	$wp_customize->add_control( 'vertex_contact_address', array( 'label' => __( 'Address', 'vertex' ), 'section' => 'vertex_contact', 'type' => 'textarea' ) );

	/* ------- Section: Social ------- */
	$wp_customize->add_section( 'vertex_social', array( 'title' => __( 'Social Links', 'vertex' ), 'panel' => 'vertex_panel' ) );
	$socials = array(
		'twitter'   => 'https://twitter.com',
		'linkedin'  => 'https://linkedin.com',
		'instagram' => 'https://instagram.com',
		'dribbble'  => 'https://dribbble.com',
		'github'    => 'https://github.com',
	);
	foreach ( $socials as $key => $default ) {
		vertex_add_setting( $wp_customize, "vertex_social_{$key}", $default, 'esc_url_raw' );
		$wp_customize->add_control( "vertex_social_{$key}", array( 'label' => ucfirst( $key ) . ' URL', 'section' => 'vertex_social', 'type' => 'url' ) );
	}

	/* ------- Section: Footer ------- */
	$wp_customize->add_section( 'vertex_footer', array( 'title' => __( 'Footer', 'vertex' ), 'panel' => 'vertex_panel' ) );
	vertex_add_setting( $wp_customize, 'vertex_footer_tagline', __( 'A web design & development studio building fast, beautiful digital products.', 'vertex' ), 'sanitize_textarea_field' );
	$wp_customize->add_control( 'vertex_footer_tagline', array( 'label' => __( 'Footer Tagline', 'vertex' ), 'section' => 'vertex_footer', 'type' => 'textarea' ) );
	vertex_add_setting( $wp_customize, 'vertex_footer_copyright', '', 'wp_kses_post' );
	$wp_customize->add_control( 'vertex_footer_copyright', array( 'label' => __( 'Copyright Text', 'vertex' ), 'description' => __( 'Leave empty for the default.', 'vertex' ), 'section' => 'vertex_footer', 'type' => 'text' ) );
}
add_action( 'customize_register', 'vertex_customize_register' );

/**
 * Shortcut to add a setting.
 */
function vertex_add_setting( $wp_customize, $id, $default = '', $sanitize = 'sanitize_text_field', $transport = 'refresh' ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => $transport,
		)
	);
}

/**
 * Checkbox sanitizer.
 */
function vertex_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === (bool) $checked );
}

/**
 * Binds JS handlers for live preview.
 */
function vertex_customize_preview_js() {
	wp_enqueue_script( 'vertex-customizer', VERTEX_URI . '/assets/js/customizer-preview.js', array( 'customize-preview' ), VERTEX_VERSION, true );
}
add_action( 'customize_preview_init', 'vertex_customize_preview_js' );
