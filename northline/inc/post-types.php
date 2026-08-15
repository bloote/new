<?php
/**
 * Content types the studio site needs beyond posts and pages.
 *
 * Projects are case studies; downloads are the themes, plugins, scripts and
 * browser tools in the catalogue. Both are registered by the theme so the
 * demo site works out of the box. If you would rather own them in a plugin,
 * return false from the `northline_register_post_types` filter and register
 * them yourself with the same names — everything else keeps working.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Projects and Downloads types and their taxonomies.
 */
function northline_register_post_types() {
	if ( ! apply_filters( 'northline_register_post_types', true ) ) {
		return;
	}

	// Taxonomies are registered first. Their permalinks sit under the post
	// type's own slug — /work/type/headless — and WordPress matches rewrite
	// rules in registration order, so the taxonomy rules have to be added
	// before the single-project rule swallows /work/type as a project name.
	register_taxonomy(
		'project_type',
		'project',
		array(
			'labels'            => array(
				'name'          => __( 'Project types', 'northline' ),
				'singular_name' => __( 'Project type', 'northline' ),
				'menu_name'     => __( 'Types', 'northline' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'work/type',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'download_type',
		'download',
		array(
			'labels'            => array(
				'name'          => __( 'Download types', 'northline' ),
				'singular_name' => __( 'Download type', 'northline' ),
				'menu_name'     => __( 'Types', 'northline' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'downloads/type',
				'with_front' => false,
			),
		)
	);

	register_taxonomy(
		'download_tag',
		'download',
		array(
			'labels'            => array(
				'name'          => __( 'Download tags', 'northline' ),
				'singular_name' => __( 'Download tag', 'northline' ),
				'menu_name'     => __( 'Tags', 'northline' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'downloads/tag',
				'with_front' => false,
			),
		)
	);

	register_post_type(
		'project',
		array(
			'labels'        => array(
				'name'               => __( 'Projects', 'northline' ),
				'singular_name'      => __( 'Project', 'northline' ),
				'add_new_item'       => __( 'Add project', 'northline' ),
				'edit_item'          => __( 'Edit project', 'northline' ),
				'new_item'           => __( 'New project', 'northline' ),
				'view_item'          => __( 'View project', 'northline' ),
				'search_items'       => __( 'Search projects', 'northline' ),
				'not_found'          => __( 'No projects yet', 'northline' ),
				'all_items'          => __( 'All projects', 'northline' ),
				'menu_name'          => __( 'Projects', 'northline' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-portfolio',
			'menu_position' => 21,
			'has_archive'   => 'work',
			'rewrite'       => array(
				'slug'       => 'work',
				'with_front' => false,
			),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
		)
	);

	register_post_type(
		'download',
		array(
			'labels'        => array(
				'name'          => __( 'Downloads', 'northline' ),
				'singular_name' => __( 'Download', 'northline' ),
				'add_new_item'  => __( 'Add download', 'northline' ),
				'edit_item'     => __( 'Edit download', 'northline' ),
				'new_item'      => __( 'New download', 'northline' ),
				'view_item'     => __( 'View download', 'northline' ),
				'search_items'  => __( 'Search downloads', 'northline' ),
				'not_found'     => __( 'No downloads yet', 'northline' ),
				'all_items'     => __( 'All downloads', 'northline' ),
				'menu_name'     => __( 'Downloads', 'northline' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-download',
			'menu_position' => 22,
			'has_archive'   => 'downloads',
			'rewrite'       => array(
				'slug'       => 'downloads',
				'with_front' => false,
			),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'northline_register_post_types' );

/**
 * Meta shown on catalogue cards. Registered so the block editor and the REST
 * API can both read and write it without a plugin.
 */
function northline_register_meta() {
	$string_meta = array(
		'download'  => array(
			'nl_version'  => __( 'Version', 'northline' ),
			'nl_release'  => __( 'Released', 'northline' ),
			'nl_price'    => __( 'Price', 'northline' ),
			'nl_installs' => __( 'Installs or licences', 'northline' ),
			'nl_requires' => __( 'Requires', 'northline' ),
			'nl_rating'   => __( 'Rating', 'northline' ),
			'nl_licence'  => __( 'Licence', 'northline' ),
			'nl_action'   => __( 'Primary action label', 'northline' ),
			'nl_mark'     => __( 'Letter mark', 'northline' ),
			'nl_usage'    => __( 'Usage snippet', 'northline' ),
		),
		'project'   => array(
			'nl_client'     => __( 'Client', 'northline' ),
			'nl_sector'     => __( 'Sector', 'northline' ),
			'nl_year'       => __( 'Year', 'northline' ),
			'nl_engagement' => __( 'Engagement', 'northline' ),
			'nl_duration'   => __( 'Duration', 'northline' ),
			'nl_stack'      => __( 'Stack', 'northline' ),
			'nl_outcome'    => __( 'Headline outcome', 'northline' ),
		),
		'post'      => array(
			'nl_reading_time' => __( 'Reading time', 'northline' ),
		),
	);

	// A usage snippet is a line of code shown as text — "<div data-cue="fade-up">".
	// sanitize_text_field() reads that as a tag and strips the whole value, so
	// those keys get a sanitiser that keeps the brackets instead.
	$code_meta = array( 'nl_usage' );

	foreach ( $string_meta as $post_type => $keys ) {
		foreach ( $keys as $key => $label ) {
			register_post_meta(
				$post_type,
				$key,
				array(
					'type'              => 'string',
					'description'       => $label,
					'single'            => true,
					'default'           => '',
					'show_in_rest'      => true,
					'sanitize_callback' => in_array( $key, $code_meta, true ) ? 'northline_sanitize_code_meta' : 'sanitize_text_field',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}

/**
 * Sanitise a meta value that is displayed as code rather than rendered as
 * markup, so angle brackets have to survive being saved.
 *
 * Everything that reads these values escapes them on output — the meta-line
 * block runs esc_html() — so the value only needs to be a clean, single-line
 * UTF-8 string with no control characters in it.
 *
 * @param mixed $value Raw meta value.
 * @return string
 */
function northline_sanitize_code_meta( $value ) {
	if ( ! is_scalar( $value ) ) {
		return '';
	}

	$value = wp_check_invalid_utf8( (string) $value );
	$value = preg_replace( '/[\r\n\t]+/', ' ', $value );
	$value = preg_replace( '/[\x00-\x1F\x7F]/', '', $value );

	return trim( (string) $value );
}
add_action( 'init', 'northline_register_meta' );

/**
 * Projects and downloads are browsed as full catalogues rather than paged
 * feeds, so their archives show everything.
 *
 * @param WP_Query $query The main query.
 */
function northline_archive_size( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( array( 'project', 'download' ) ) || $query->is_tax( array( 'project_type', 'download_type', 'download_tag' ) ) ) {
		$query->set( 'posts_per_page', 40 );
		$query->set( 'orderby', 'menu_order date' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'northline_archive_size' );

/**
 * Flush rewrite rules once after the theme is switched on, so the /work and
 * /downloads permalinks resolve without a manual visit to Settings.
 */
function northline_flush_rewrites() {
	northline_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'northline_flush_rewrites' );
