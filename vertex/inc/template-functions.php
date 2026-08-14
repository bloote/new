<?php
/**
 * Functions that hook into the front end and helpers.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fallback for the primary menu when none is assigned.
 */
function vertex_primary_menu_fallback() {
	echo '<ul id="primary-menu">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'vertex' ) . '</a></li>';

	$pages = array( 'services' => __( 'Services', 'vertex' ), 'about' => __( 'About', 'vertex' ) );
	foreach ( $pages as $slug => $label ) {
		$page = get_page_by_path( $slug );
		if ( $page ) {
			echo '<li><a href="' . esc_url( get_permalink( $page ) ) . '">' . esc_html( $label ) . '</a></li>';
		}
	}

	if ( post_type_exists( 'vx_work' ) ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'vx_work' ) ) . '">' . esc_html__( 'Work', 'vertex' ) . '</a></li>';
	}

	$blog = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
	echo '<li><a href="' . esc_url( $blog ) . '">' . esc_html__( 'Blog', 'vertex' ) . '</a></li>';

	$contact = get_page_by_path( 'contact' );
	if ( $contact ) {
		echo '<li><a href="' . esc_url( get_permalink( $contact ) ) . '">' . esc_html__( 'Contact', 'vertex' ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Customized search form.
 *
 * @param string $form Form markup.
 * @return string
 */
function vertex_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
		<label class="screen-reader-text" for="vx-s">' . esc_html__( 'Search for:', 'vertex' ) . '</label>
		<input type="search" id="vx-s" class="search-field" placeholder="' . esc_attr__( 'Search…', 'vertex' ) . '" value="' . get_search_query() . '" name="s" />
		<button type="submit" class="vx-btn vx-btn--primary search-submit">' . esc_html__( 'Search', 'vertex' ) . '</button>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'vertex_search_form' );

/**
 * Add a wrapper class to menu list items for styling depth.
 */
function vertex_nav_menu_css_class( $classes ) {
	return array_map( 'esc_attr', $classes );
}
add_filter( 'nav_menu_css_class', 'vertex_nav_menu_css_class' );

/**
 * Wrap embeds responsively.
 */
function vertex_oembed_wrap( $html ) {
	return '<div class="vx-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'vertex_oembed_wrap', 10, 1 );

/**
 * Improve the "read more" link on excerpts used in the_content.
 */
function vertex_content_more_link( $link ) {
	return str_replace( 'more-link', 'more-link vx-service__link', $link );
}
add_filter( 'the_content_more_link', 'vertex_content_more_link' );

/**
 * Add async/defer-friendly attributes are unnecessary; instead preconnect fonts.
 */
function vertex_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type && get_theme_mod( 'vertex_load_google_fonts', true ) ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
		$urls[] = 'https://fonts.googleapis.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'vertex_resource_hints', 10, 2 );
