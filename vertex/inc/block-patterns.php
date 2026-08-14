<?php
/**
 * Register block pattern categories.
 *
 * Individual patterns live in the /patterns directory and are auto-registered
 * by WordPress (6.0+) from their file headers.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Vertex pattern category.
 */
function vertex_register_pattern_categories() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}
	register_block_pattern_category(
		'vertex',
		array(
			'label'       => __( 'Vertex', 'vertex' ),
			'description' => __( 'Sections designed for the Vertex agency theme.', 'vertex' ),
		)
	);
	register_block_pattern_category( 'vertex-pages', array( 'label' => __( 'Vertex Pages', 'vertex' ) ) );
}
add_action( 'init', 'vertex_register_pattern_categories', 9 );

/**
 * Register block styles that pair with the design system.
 */
function vertex_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}
	register_block_style( 'core/button', array( 'name' => 'vx-pill', 'label' => __( 'Vertex Pill', 'vertex' ) ) );
	register_block_style( 'core/image', array( 'name' => 'vx-rounded', 'label' => __( 'Vertex Rounded', 'vertex' ) ) );
	register_block_style( 'core/group', array( 'name' => 'vx-card', 'label' => __( 'Vertex Card', 'vertex' ) ) );
	register_block_style( 'core/quote', array( 'name' => 'vx-testimonial', 'label' => __( 'Vertex Testimonial', 'vertex' ) ) );
	register_block_style( 'core/list', array( 'name' => 'none', 'label' => __( 'No Bullets', 'vertex' ) ) );
}
add_action( 'init', 'vertex_register_block_styles' );
