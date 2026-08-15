<?php
/**
 * Pattern plumbing.
 *
 * Patterns are the single source of truth for every page section: the demo
 * import builds its pages by concatenating pattern files, so what you see in
 * the inserter is exactly what the demo site is made of.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render a pattern file and return its block markup.
 *
 * The registry is deliberately bypassed. Patterns are PHP, and the importer
 * runs after media has been copied into the library, so evaluating the file
 * fresh is what picks up the real attachment IDs and permalinks.
 *
 * @param string $slug Pattern file name, with or without the northline/ prefix.
 * @return string Block markup, or an empty string when the file is missing.
 */
function northline_pattern( $slug ) {
	$slug = str_replace( 'northline/', '', $slug );
	$file = NORTHLINE_DIR . '/patterns/' . $slug . '.php';

	if ( ! file_exists( $file ) ) {
		return '';
	}

	ob_start();
	include $file;
	return trim( (string) ob_get_clean() );
}

/**
 * Block markup for a list of patterns, in order.
 *
 * @param array $slugs Pattern file names.
 * @return string
 */
function northline_patterns( $slugs ) {
	$out = array();

	foreach ( (array) $slugs as $slug ) {
		$markup = northline_pattern( $slug );
		if ( '' !== $markup ) {
			$out[] = $markup;
		}
	}

	return implode( "\n\n", $out );
}
