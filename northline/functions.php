<?php
/**
 * Northline — theme bootstrap.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

define( 'NORTHLINE_VERSION', '1.0.0' );
define( 'NORTHLINE_DIR', get_template_directory() );
define( 'NORTHLINE_URI', get_template_directory_uri() );

require_once NORTHLINE_DIR . '/inc/setup.php';
require_once NORTHLINE_DIR . '/inc/post-types.php';
require_once NORTHLINE_DIR . '/inc/blocks.php';
require_once NORTHLINE_DIR . '/inc/patterns.php';
require_once NORTHLINE_DIR . '/inc/forms.php';
require_once NORTHLINE_DIR . '/inc/template-tags.php';
require_once NORTHLINE_DIR . '/inc/demo/media.php';
require_once NORTHLINE_DIR . '/inc/demo/content.php';
require_once NORTHLINE_DIR . '/inc/demo/import.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once NORTHLINE_DIR . '/inc/demo/cli.php';
}
