<?php
/**
 * WP-CLI commands for the demo content.
 *
 *     wp northline demo import
 *     wp northline demo remove
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build or remove the Northline demo site.
 */
class Northline_Demo_Command {

	/**
	 * Import or remove the demo content.
	 *
	 * ## OPTIONS
	 *
	 * <action>
	 * : Either `import` or `remove`.
	 *
	 * ## EXAMPLES
	 *
	 *     wp northline demo import
	 *     wp northline demo remove
	 *
	 * @param array $args Positional arguments.
	 */
	public function demo( $args ) {
		$action = $args[0] ?? '';

		if ( 'import' === $action ) {
			foreach ( northline_demo_import() as $line ) {
				WP_CLI::log( '  ' . $line );
			}
			WP_CLI::success( 'Demo site imported.' );
			return;
		}

		if ( 'remove' === $action ) {
			foreach ( northline_demo_remove() as $line ) {
				WP_CLI::log( '  ' . $line );
			}
			WP_CLI::success( 'Demo content removed.' );
			return;
		}

		WP_CLI::error( 'Expected `import` or `remove`.' );
	}
}

WP_CLI::add_command( 'northline', 'Northline_Demo_Command' );
