<?php
/**
 * Block styles, pattern categories and the two dynamic blocks the catalogue
 * needs: a meta line for cards and a working enquiry form.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Button and image variants used across the patterns.
 */
function northline_register_block_styles() {
	register_block_style( 'core/button', array(
		'name'  => 'secondary',
		'label' => __( 'Secondary', 'northline' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'inverse',
		'label' => __( 'Inverse', 'northline' ),
	) );
	register_block_style( 'core/button', array(
		'name'  => 'link',
		'label' => __( 'Quiet link', 'northline' ),
	) );

	register_block_style( 'core/image', array(
		'name'  => 'blueprint',
		'label' => __( 'Blueprint frame', 'northline' ),
	) );
	register_block_style( 'core/group', array(
		'name'  => 'blueprint',
		'label' => __( 'Blueprint frame', 'northline' ),
	) );
	register_block_style( 'core/columns', array(
		'name'  => 'divided',
		'label' => __( 'Divided by hairlines', 'northline' ),
	) );
	register_block_style( 'core/list', array(
		'name'  => 'plain',
		'label' => __( 'No bullets', 'northline' ),
	) );
}
add_action( 'init', 'northline_register_block_styles' );

/**
 * Style variations for the blueprint frame need real CSS; the register_block_style
 * name only adds the class, so map each one onto the component layer.
 */
function northline_block_style_css() {
	$css = '
	.wp-block-image.is-style-blueprint,
	.wp-block-group.is-style-blueprint { position: relative; border: 1px solid var(--nl-divider); }
	.wp-block-image.is-style-blueprint::before,
	.wp-block-group.is-style-blueprint::before {
		--c: color-mix(in srgb, var(--wp--preset--color--ink) 55%, transparent);
		content: ""; position: absolute; inset: -6px; pointer-events: none; background-repeat: no-repeat;
		background-image:
			linear-gradient(var(--c),var(--c)),linear-gradient(var(--c),var(--c)),
			linear-gradient(var(--c),var(--c)),linear-gradient(var(--c),var(--c)),
			linear-gradient(var(--c),var(--c)),linear-gradient(var(--c),var(--c)),
			linear-gradient(var(--c),var(--c)),linear-gradient(var(--c),var(--c));
		background-size: 1px 11px, 11px 1px, 1px 11px, 11px 1px, 1px 11px, 11px 1px, 1px 11px, 11px 1px;
		background-position:
			left 5px top 0, left 0 top 5px, right 5px top 0, right 0 top 5px,
			left 5px bottom 0, left 0 bottom 5px, right 5px bottom 0, right 0 bottom 5px;
	}
	.wp-block-list.is-style-plain { list-style: none; padding-left: 0; }
	.wp-block-list.is-style-plain li { margin-bottom: 0.5rem; }
	';
	wp_add_inline_style( 'northline-style', $css );
}
add_action( 'wp_enqueue_scripts', 'northline_block_style_css', 20 );

/**
 * Pattern categories, so the inserter groups the section library sensibly.
 */
function northline_register_pattern_categories() {
	$categories = array(
		'northline-page'      => __( 'Northline — page sections', 'northline' ),
		'northline-hero'      => __( 'Northline — headers', 'northline' ),
		'northline-catalogue' => __( 'Northline — catalogue', 'northline' ),
		'northline-editorial' => __( 'Northline — editorial', 'northline' ),
		'northline-cta'       => __( 'Northline — calls to action', 'northline' ),
		'northline-pages'     => __( 'Northline — whole pages', 'northline' ),
	);

	foreach ( $categories as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', 'northline_register_pattern_categories', 9 );

/**
 * Register the theme's own blocks.
 */
function northline_register_blocks() {
	wp_register_script(
		'northline-blocks',
		NORTHLINE_URI . '/assets/js/blocks.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render', 'wp-i18n' ),
		NORTHLINE_VERSION,
		true
	);

	register_block_type( NORTHLINE_DIR . '/blocks/meta-line' );
	register_block_type( NORTHLINE_DIR . '/blocks/form' );
}
add_action( 'init', 'northline_register_blocks' );

/**
 * Render a dot-separated line of post meta — "v2.4 · 12,400 installs · WP 6.4+".
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Inner content (unused).
 * @param WP_Block $block      Block instance, for post context.
 * @return string
 */
function northline_render_meta_line( $attributes, $content, $block ) {
	$post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$keys      = array_filter( array_map( 'trim', explode( ',', (string) ( $attributes['fields'] ?? '' ) ) ) );
	$separator = (string) ( $attributes['separator'] ?? ' · ' );
	$values    = array();

	foreach ( $keys as $key ) {
		$value = get_post_meta( $post_id, $key, true );
		if ( '' !== $value && null !== $value ) {
			$values[] = $value;
		}
	}

	if ( empty( $values ) ) {
		$values = array_filter( array( (string) ( $attributes['fallback'] ?? '' ) ) );
	}

	if ( empty( $values ) ) {
		return '';
	}

	$text = ( $attributes['prefix'] ?? '' ) . implode( $separator, $values );

	return sprintf(
		'<div %s>%s</div>',
		get_block_wrapper_attributes( array( 'class' => 'nl-meta-line' ) ),
		esc_html( $text )
	);
}

/**
 * Render one of the site's forms.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function northline_render_form( $attributes ) {
	$variant = (string) ( $attributes['variant'] ?? 'contact' );

	ob_start();
	northline_form_markup( $variant );
	$form = ob_get_clean();

	return sprintf(
		'<div %s>%s</div>',
		get_block_wrapper_attributes( array( 'class' => 'nl-form-wrap' ) ),
		$form
	);
}
