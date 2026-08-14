<?php
/**
 * A lightweight nav walker that keeps default behavior but exposes hooks
 * for future customization. The default Walker_Nav_Menu markup already suits
 * the Vertex stylesheet, so this class is intentionally minimal.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Walker_Nav_Menu' ) && ! class_exists( 'Vertex_Nav_Walker' ) ) {

	/**
	 * Class Vertex_Nav_Walker
	 */
	class Vertex_Nav_Walker extends Walker_Nav_Menu {

		/**
		 * Start the sub-menu, adding a wrapper class for styling.
		 *
		 * @param string $output Passed by reference.
		 * @param int    $depth  Depth of menu item.
		 * @param array  $args   Menu args.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class=\"sub-menu vx-sub-menu\">\n";
		}
	}
}
