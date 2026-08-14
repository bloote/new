<?php
/**
 * Custom post types, taxonomies and meta boxes.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom post types.
 */
function vertex_register_post_types() {

	// Portfolio / Work.
	register_post_type(
		'vx_work',
		array(
			'labels'       => array(
				'name'               => __( 'Portfolio', 'vertex' ),
				'singular_name'      => __( 'Project', 'vertex' ),
				'add_new'            => __( 'Add Project', 'vertex' ),
				'add_new_item'       => __( 'Add New Project', 'vertex' ),
				'edit_item'          => __( 'Edit Project', 'vertex' ),
				'new_item'           => __( 'New Project', 'vertex' ),
				'view_item'          => __( 'View Project', 'vertex' ),
				'search_items'       => __( 'Search Projects', 'vertex' ),
				'not_found'          => __( 'No projects found', 'vertex' ),
				'menu_name'          => __( 'Portfolio', 'vertex' ),
			),
			'public'       => true,
			'has_archive'  => 'portfolio',
			'menu_icon'    => 'dashicons-portfolio',
			'menu_position' => 20,
			'rewrite'      => array( 'slug' => 'work' ),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest' => true,
		)
	);

	// Services.
	register_post_type(
		'vx_service',
		array(
			'labels'       => array(
				'name'          => __( 'Services', 'vertex' ),
				'singular_name' => __( 'Service', 'vertex' ),
				'add_new_item'  => __( 'Add New Service', 'vertex' ),
				'edit_item'     => __( 'Edit Service', 'vertex' ),
				'menu_name'     => __( 'Services', 'vertex' ),
			),
			'public'        => true,
			'has_archive'   => 'services-list',
			'menu_icon'     => 'dashicons-screenoptions',
			'menu_position' => 21,
			'rewrite'       => array( 'slug' => 'service' ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest'  => true,
		)
	);

	// Team.
	register_post_type(
		'vx_team',
		array(
			'labels'       => array(
				'name'          => __( 'Team', 'vertex' ),
				'singular_name' => __( 'Team Member', 'vertex' ),
				'add_new_item'  => __( 'Add Team Member', 'vertex' ),
				'edit_item'     => __( 'Edit Team Member', 'vertex' ),
				'menu_name'     => __( 'Team', 'vertex' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 22,
			'rewrite'       => array( 'slug' => 'team' ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'show_in_rest'  => true,
		)
	);

	// Testimonials.
	register_post_type(
		'vx_testimonial',
		array(
			'labels'       => array(
				'name'          => __( 'Testimonials', 'vertex' ),
				'singular_name' => __( 'Testimonial', 'vertex' ),
				'add_new_item'  => __( 'Add Testimonial', 'vertex' ),
				'edit_item'     => __( 'Edit Testimonial', 'vertex' ),
				'menu_name'     => __( 'Testimonials', 'vertex' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 23,
			'supports'      => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest'  => true,
		)
	);
}
add_action( 'init', 'vertex_register_post_types' );

/**
 * Register taxonomies.
 */
function vertex_register_taxonomies() {
	register_taxonomy(
		'vx_work_cat',
		'vx_work',
		array(
			'labels'            => array(
				'name'          => __( 'Project Categories', 'vertex' ),
				'singular_name' => __( 'Project Category', 'vertex' ),
				'menu_name'     => __( 'Categories', 'vertex' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'work-category' ),
		)
	);
}
add_action( 'init', 'vertex_register_taxonomies' );

/**
 * Register meta boxes.
 */
function vertex_add_meta_boxes() {
	add_meta_box( 'vx_work_details', __( 'Project Details', 'vertex' ), 'vertex_work_meta_box', 'vx_work', 'side', 'high' );
	add_meta_box( 'vx_service_details', __( 'Service Options', 'vertex' ), 'vertex_service_meta_box', 'vx_service', 'side', 'high' );
	add_meta_box( 'vx_team_details', __( 'Member Details', 'vertex' ), 'vertex_team_meta_box', 'vx_team', 'side', 'high' );
	add_meta_box( 'vx_testimonial_details', __( 'Testimonial Details', 'vertex' ), 'vertex_testimonial_meta_box', 'vx_testimonial', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'vertex_add_meta_boxes' );

/**
 * Helper to print a text field.
 */
function vertex_meta_field( $post_id, $key, $label, $placeholder = '' ) {
	$value = get_post_meta( $post_id, $key, true );
	printf(
		'<p><label for="%1$s" style="display:block;font-weight:600;margin-bottom:4px;">%2$s</label><input type="text" id="%1$s" name="%1$s" value="%3$s" placeholder="%4$s" style="width:100%%;"></p>',
		esc_attr( $key ),
		esc_html( $label ),
		esc_attr( $value ),
		esc_attr( $placeholder )
	);
}

function vertex_work_meta_box( $post ) {
	wp_nonce_field( 'vertex_meta', 'vertex_meta_nonce' );
	vertex_meta_field( $post->ID, '_vx_client', __( 'Client', 'vertex' ), 'Acme Inc.' );
	vertex_meta_field( $post->ID, '_vx_year', __( 'Year', 'vertex' ), '2025' );
	vertex_meta_field( $post->ID, '_vx_services', __( 'Services', 'vertex' ), 'Design, Development' );
	vertex_meta_field( $post->ID, '_vx_project_url', __( 'Live URL', 'vertex' ), 'https://' );
}

function vertex_service_meta_box( $post ) {
	wp_nonce_field( 'vertex_meta', 'vertex_meta_nonce' );
	$icons   = array( 'layout', 'code', 'mobile', 'brand', 'seo', 'cart', 'rocket', 'shield', 'pen', 'chart' );
	$current = get_post_meta( $post->ID, '_vx_icon', true );
	echo '<p><label for="_vx_icon" style="display:block;font-weight:600;margin-bottom:4px;">' . esc_html__( 'Icon', 'vertex' ) . '</label><select id="_vx_icon" name="_vx_icon" style="width:100%;">';
	foreach ( $icons as $icon ) {
		printf( '<option value="%1$s" %2$s>%1$s</option>', esc_attr( $icon ), selected( $current, $icon, false ) );
	}
	echo '</select></p>';
}

function vertex_team_meta_box( $post ) {
	wp_nonce_field( 'vertex_meta', 'vertex_meta_nonce' );
	vertex_meta_field( $post->ID, '_vx_role', __( 'Role / Title', 'vertex' ), 'Lead Designer' );
	vertex_meta_field( $post->ID, '_vx_twitter', __( 'Twitter URL', 'vertex' ), 'https://' );
	vertex_meta_field( $post->ID, '_vx_linkedin', __( 'LinkedIn URL', 'vertex' ), 'https://' );
}

function vertex_testimonial_meta_box( $post ) {
	wp_nonce_field( 'vertex_meta', 'vertex_meta_nonce' );
	vertex_meta_field( $post->ID, '_vx_role', __( 'Role / Company', 'vertex' ), 'CEO, Company' );
}

/**
 * Save meta box values.
 */
function vertex_save_meta( $post_id ) {
	if ( ! isset( $_POST['vertex_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vertex_meta_nonce'] ) ), 'vertex_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array( '_vx_client', '_vx_year', '_vx_services', '_vx_project_url', '_vx_icon', '_vx_role', '_vx_twitter', '_vx_linkedin' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			$value = wp_unslash( $_POST[ $field ] );
			$value = ( false !== strpos( $field, 'url' ) || false !== strpos( $field, 'twitter' ) || false !== strpos( $field, 'linkedin' ) )
				? esc_url_raw( $value )
				: sanitize_text_field( $value );
			update_post_meta( $post_id, $field, $value );
		}
	}
}
add_action( 'save_post', 'vertex_save_meta' );

/**
 * Flush rewrite rules on theme activation so CPT permalinks work immediately.
 */
function vertex_rewrite_flush() {
	vertex_register_post_types();
	vertex_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'vertex_rewrite_flush' );
