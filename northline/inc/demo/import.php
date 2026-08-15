<?php
/**
 * The demo import.
 *
 * Builds the whole site: terms, media, journal posts, case studies, the
 * download catalogue, every page assembled from patterns, the menu, and the
 * front-page setting. Everything it creates is tagged, so it can be removed
 * again without touching anything you wrote yourself.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

const NORTHLINE_DEMO_FLAG = '_northline_demo';

/**
 * Add the setup screen under Appearance.
 */
function northline_demo_menu() {
	add_theme_page(
		__( 'Northline setup', 'northline' ),
		__( 'Northline setup', 'northline' ),
		'edit_theme_options',
		'northline-setup',
		'northline_demo_screen'
	);
}
add_action( 'admin_menu', 'northline_demo_menu' );

/**
 * Point new installs at the setup screen once.
 */
function northline_demo_activation_notice() {
	if ( get_option( 'northline_demo_imported' ) || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$screen = get_current_screen();

	if ( $screen && 'appearance_page_northline-setup' === $screen->id ) {
		return;
	}

	printf(
		'<div class="notice notice-info"><p><strong>%s</strong> %s <a class="button button-primary" href="%s">%s</a></p></div>',
		esc_html__( 'Northline is active.', 'northline' ),
		esc_html__( 'Import the demo site to get every page, post, case study and catalogue entry in one step.', 'northline' ),
		esc_url( admin_url( 'themes.php?page=northline-setup' ) ),
		esc_html__( 'Open setup', 'northline' )
	);
}
add_action( 'admin_notices', 'northline_demo_activation_notice' );

/**
 * The setup screen.
 */
function northline_demo_screen() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to do that.', 'northline' ) );
	}

	$report = array();

	if ( isset( $_POST['northline_action'] ) && check_admin_referer( 'northline_demo' ) ) {
		$action = sanitize_key( wp_unslash( $_POST['northline_action'] ) );

		if ( 'import' === $action ) {
			$report = northline_demo_import();
		} elseif ( 'remove' === $action ) {
			$report = northline_demo_remove();
		}
	}

	$imported = (bool) get_option( 'northline_demo_imported' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Northline setup', 'northline' ); ?></h1>

		<?php if ( $report ) : ?>
			<div class="notice notice-success">
				<p><strong><?php esc_html_e( 'Done.', 'northline' ); ?></strong></p>
				<ul style="list-style:disc;margin-left:1.5em">
					<?php foreach ( $report as $line ) : ?>
						<li><?php echo esc_html( $line ); ?></li>
					<?php endforeach; ?>
				</ul>
				<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'View the site →', 'northline' ); ?></a></p>
			</div>
		<?php endif; ?>

		<p style="max-width:46em">
			<?php esc_html_e( 'The demo import builds the complete Northline site: thirteen pages assembled from the theme\'s own patterns, eight journal posts with categories and tags, nine case studies, a catalogue of twenty-nine themes, plugins, scripts and tools, every image, the primary menu and the front-page setting.', 'northline' ); ?>
		</p>
		<p style="max-width:46em">
			<?php esc_html_e( 'It is safe to run more than once: existing demo items are updated rather than duplicated, and nothing you created yourself is touched. Removing the demo content deletes only what the import created.', 'northline' ); ?>
		</p>

		<form method="post" style="margin-top:1.5em">
			<?php wp_nonce_field( 'northline_demo' ); ?>
			<p>
				<button type="submit" name="northline_action" value="import" class="button button-primary button-hero">
					<?php echo $imported ? esc_html__( 'Re-import the demo site', 'northline' ) : esc_html__( 'Import the demo site', 'northline' ); ?>
				</button>
			</p>
			<?php if ( $imported ) : ?>
				<p>
					<button type="submit" name="northline_action" value="remove" class="button button-secondary"
						onclick="return confirm('<?php echo esc_js( __( 'Delete every page, post, project, download and image the demo import created?', 'northline' ) ); ?>')">
						<?php esc_html_e( 'Remove the demo content', 'northline' ); ?>
					</button>
				</p>
			<?php endif; ?>
		</form>

		<h2><?php esc_html_e( 'From the command line', 'northline' ); ?></h2>
		<p><code>wp northline demo import</code> &nbsp; <code>wp northline demo remove</code></p>
	</div>
	<?php
}

/**
 * Create or update a term, and return its ID.
 *
 * @param string $taxonomy    Taxonomy.
 * @param string $slug        Term slug.
 * @param string $name        Term name.
 * @param string $description Term description.
 * @return int
 */
function northline_demo_term( $taxonomy, $slug, $name, $description = '' ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );

	if ( $term && ! is_wp_error( $term ) ) {
		wp_update_term( $term->term_id, $taxonomy, array( 'description' => $description ) );
		return (int) $term->term_id;
	}

	$created = wp_insert_term(
		$name,
		$taxonomy,
		array(
			'slug'        => $slug,
			'description' => $description,
		)
	);

	if ( is_wp_error( $created ) ) {
		return 0;
	}

	update_term_meta( $created['term_id'], NORTHLINE_DEMO_FLAG, '1' );

	return (int) $created['term_id'];
}

/**
 * Create or update one demo post of any type.
 *
 * @param array $args post_type, post_title, post_name, post_content, etc.
 * @return int Post ID.
 */
function northline_demo_post( $args ) {
	$existing = get_page_by_path( $args['post_name'], OBJECT, $args['post_type'] );

	if ( $existing ) {
		$args['ID'] = $existing->ID;
	}

	$args = wp_parse_args(
		$args,
		array(
			'post_status' => 'publish',
			'post_author' => northline_demo_author_id(),
		)
	);

	$post_id = wp_insert_post( wp_slash( $args ), true );

	if ( is_wp_error( $post_id ) ) {
		return 0;
	}

	update_post_meta( $post_id, NORTHLINE_DEMO_FLAG, '1' );

	return (int) $post_id;
}

/**
 * The author demo content is attributed to: the current user, or the first
 * administrator when the import runs from WP-CLI.
 *
 * @return int
 */
function northline_demo_author_id() {
	$user_id = get_current_user_id();

	if ( $user_id ) {
		return $user_id;
	}

	$admins = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
			'fields' => 'ID',
		)
	);

	return $admins ? (int) $admins[0] : 1;
}

/**
 * Run the import.
 *
 * @return array Human-readable report lines.
 */
function northline_demo_import() {
	$report = array();

	// Custom types must exist before anything is filed against them.
	northline_register_post_types();

	// Pretty permalinks, so /work/ and /downloads/ resolve.
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}

	// WordPress ships a sample post and page. Left in place they outrank the
	// demo content on the journal index, so they go before anything is added.
	northline_demo_clear_samples();

	/* ------------------------------------------------------------- terms -- */

	foreach ( northline_demo_categories() as $slug => $term ) {
		northline_demo_term( 'category', $slug, $term[0], $term[1] );
	}

	foreach ( northline_demo_project_types() as $slug => $term ) {
		northline_demo_term( 'project_type', $slug, $term[0], $term[1] );
	}

	foreach ( northline_demo_download_terms() as $taxonomy => $terms ) {
		foreach ( $terms as $slug => $term ) {
			northline_demo_term( $taxonomy, $slug, $term[0], $term[1] );
		}
	}

	$report[] = __( 'Categories, project types and catalogue terms created.', 'northline' );

	/* ------------------------------------------------------------- media -- */

	$media_count = northline_import_all_media();
	/* translators: %d: number of images. */
	$report[] = sprintf( __( '%d images copied into the media library.', 'northline' ), $media_count );

	/* ------------------------------------------------------------- posts -- */

	$posts = 0;

	foreach ( northline_demo_posts() as $post ) {
		$post_id = northline_demo_post(
			array(
				'post_type'    => 'post',
				'post_title'   => $post['title'],
				'post_name'    => $post['slug'],
				'post_date'    => $post['date'],
				'post_excerpt' => $post['excerpt'],
				'post_content' => northline_demo_body( $post['body'] ),
			)
		);

		if ( ! $post_id ) {
			continue;
		}

		$posts++;
		wp_set_object_terms( $post_id, array( $post['category'] ), 'category' );
		wp_set_object_terms( $post_id, $post['tags'], 'post_tag' );
		update_post_meta( $post_id, 'nl_reading_time', $post['reading'] );

		$image_id = northline_attachment_id( $post['image'] );
		if ( $image_id ) {
			set_post_thumbnail( $post_id, $image_id );
		}
	}

	/* translators: %d: number of posts. */
	$report[] = sprintf( __( '%d journal posts published.', 'northline' ), $posts );

	/* ---------------------------------------------------------- projects -- */

	$projects = 0;
	$order    = 0;

	foreach ( northline_demo_projects() as $project ) {
		$order++;
		$post_id = northline_demo_post(
			array(
				'post_type'    => 'project',
				'post_title'   => $project['title'],
				'post_name'    => $project['slug'],
				'post_excerpt' => $project['excerpt'],
				'post_content' => northline_demo_body( $project['body'] ),
				'menu_order'   => $order,
			)
		);

		if ( ! $post_id ) {
			continue;
		}

		$projects++;
		wp_set_object_terms( $post_id, $project['types'], 'project_type' );

		foreach ( $project['meta'] as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		$image_id = northline_attachment_id( $project['image'] );
		if ( $image_id ) {
			set_post_thumbnail( $post_id, $image_id );
		}
	}

	/* translators: %d: number of case studies. */
	$report[] = sprintf( __( '%d case studies published.', 'northline' ), $projects );

	/* --------------------------------------------------------- downloads -- */

	$downloads = 0;
	$order     = 0;

	foreach ( northline_demo_downloads() as $item ) {
		$order++;
		$post_id = northline_demo_post(
			array(
				'post_type'    => 'download',
				'post_title'   => $item['title'],
				'post_name'    => $item['slug'],
				'post_excerpt' => $item['excerpt'],
				'post_content' => northline_demo_body( $item['body'] ),
				'menu_order'   => $order,
			)
		);

		if ( ! $post_id ) {
			continue;
		}

		$downloads++;
		wp_set_object_terms( $post_id, array( $item['type'] ), 'download_type' );
		wp_set_object_terms( $post_id, $item['tags'], 'download_tag' );

		foreach ( $item['meta'] as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		if ( ! empty( $item['image'] ) ) {
			$image_id = northline_attachment_id( $item['image'] );
			if ( $image_id ) {
				set_post_thumbnail( $post_id, $image_id );
			}
		}
	}

	/* translators: %d: number of catalogue entries. */
	$report[] = sprintf( __( '%d catalogue entries published — themes, plugins, scripts and tools.', 'northline' ), $downloads );

	/* ------------------------------------------------------------- pages -- */

	$pages       = northline_demo_pages();
	$page_ids    = array();
	$page_count  = 0;

	// First pass: make sure every page exists, so the patterns that link
	// between them resolve to real permalinks in the second pass.
	foreach ( $pages as $slug => $page ) {
		$page_ids[ $slug ] = northline_demo_post(
			array(
				'post_type'    => 'page',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_excerpt' => $page['excerpt'],
				'post_content' => '',
			)
		);
	}

	northline_page_url( '__flush__' );

	// Second pass: render the sections now that everything they point at exists.
	foreach ( $pages as $slug => $page ) {
		if ( empty( $page_ids[ $slug ] ) ) {
			continue;
		}

		$content = isset( $page['patterns'] )
			? northline_patterns( $page['patterns'] )
			: northline_demo_body( $page['body'] );

		wp_update_post(
			array(
				'ID'           => $page_ids[ $slug ],
				'post_content' => wp_slash( $content ),
			)
		);

		update_post_meta( $page_ids[ $slug ], '_wp_page_template', $page['template'] );
		$page_count++;
	}

	/* translators: %d: number of pages. */
	$report[] = sprintf( __( '%d pages built from the theme\'s patterns.', 'northline' ), $page_count );

	/* -------------------------------------------------------- front page -- */

	if ( ! empty( $page_ids['privacy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $page_ids['privacy'] );
	}

	if ( ! empty( $page_ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['home'] );
		update_option( 'page_for_posts', 0 );
		$report[] = __( 'Home set as the front page.', 'northline' );
	}

	/* -------------------------------------------------------------- menu -- */

	northline_demo_navigation_menu();
	$report[] = __( 'Primary menu created and attached to the header.', 'northline' );

	/* ---------------------------------------------------------- identity -- */

	if ( in_array( get_option( 'blogname' ), array( '', 'My WordPress Site', 'WordPress Site' ), true ) || ! get_option( 'northline_demo_imported' ) ) {
		update_option( 'blogname', 'Northline' );
		update_option( 'blogdescription', 'A web design and development studio. We plan, design and build sites that hold up after launch.' );
	}

	northline_demo_localise_parts();

	update_option( 'northline_demo_imported', gmdate( 'c' ) );
	flush_rewrite_rules();

	return $report;
}

/**
 * Remove the sample post, page and comment WordPress installs with.
 *
 * Only the untouched originals are removed: anything edited, renamed or
 * commented on beyond the default is left where it is.
 */
function northline_demo_clear_samples() {
	$sample_post = get_page_by_path( 'hello-world', OBJECT, 'post' );

	if ( $sample_post && 'Hello world!' === $sample_post->post_title ) {
		wp_delete_post( $sample_post->ID, true );
	}

	$sample_page = get_page_by_path( 'sample-page', OBJECT, 'page' );

	if ( $sample_page && 'Sample Page' === $sample_page->post_title ) {
		wp_delete_post( $sample_page->ID, true );
	}

	$privacy_draft = get_option( 'wp_page_for_privacy_policy' );

	if ( $privacy_draft && 'draft' === get_post_status( $privacy_draft ) ) {
		wp_delete_post( $privacy_draft, true );
	}
}

/**
 * Create the primary navigation menu.
 *
 * The header uses a Navigation block with no reference, so WordPress falls
 * back to the most recently created menu — which is this one.
 *
 * @return int Navigation post ID.
 */
function northline_demo_navigation_menu() {
	$existing = get_posts(
		array(
			'post_type'      => 'wp_navigation',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'title'          => 'Primary',
			'fields'         => 'ids',
		)
	);

	$args = array(
		'post_type'    => 'wp_navigation',
		'post_title'   => 'Primary',
		'post_status'  => 'publish',
		'post_content' => northline_demo_navigation(),
	);

	if ( $existing ) {
		$args['ID'] = $existing[0];
	}

	$navigation_id = wp_insert_post( wp_slash( $args ) );

	if ( ! is_wp_error( $navigation_id ) ) {
		update_post_meta( $navigation_id, NORTHLINE_DEMO_FLAG, '1' );
		return (int) $navigation_id;
	}

	return 0;
}

/**
 * On a subdirectory install, the root-relative links in the header and footer
 * would point outside the site. Save localised copies of those parts so the
 * demo works wherever WordPress happens to live.
 */
function northline_demo_localise_parts() {
	$path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );

	if ( ! $path || '/' === $path ) {
		return;
	}

	foreach ( array( 'header', 'footer' ) as $slug ) {
		$file = NORTHLINE_DIR . '/parts/' . $slug . '.html';

		if ( ! file_exists( $file ) ) {
			continue;
		}

		$content = str_replace( 'href="/', 'href="' . untrailingslashit( $path ) . '/', file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.

		$existing = get_posts(
			array(
				'post_type'      => 'wp_template_part',
				'post_status'    => 'any',
				'name'           => $slug,
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		$args = array(
			'post_type'    => 'wp_template_part',
			'post_name'    => $slug,
			'post_title'   => ucfirst( $slug ),
			'post_status'  => 'publish',
			'post_content' => $content,
			'tax_input'    => array(
				'wp_theme'              => array( get_stylesheet() ),
				'wp_template_part_area' => array( $slug ),
			),
		);

		if ( $existing ) {
			$args['ID'] = $existing[0];
		}

		$part_id = wp_insert_post( wp_slash( $args ) );

		if ( ! is_wp_error( $part_id ) ) {
			wp_set_object_terms( $part_id, get_stylesheet(), 'wp_theme' );
			wp_set_object_terms( $part_id, $slug, 'wp_template_part_area' );
			update_post_meta( $part_id, NORTHLINE_DEMO_FLAG, '1' );
		}
	}
}

/**
 * Delete everything the import created.
 *
 * @return array Report lines.
 */
function northline_demo_remove() {
	$deleted = 0;

	$posts = get_posts(
		array(
			'post_type'      => array( 'post', 'page', 'project', 'download', 'attachment', 'wp_navigation', 'wp_template_part' ),
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'meta_key'       => NORTHLINE_DEMO_FLAG, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'fields'         => 'ids',
		)
	);

	foreach ( $posts as $post_id ) {
		if ( 'attachment' === get_post_type( $post_id ) ) {
			wp_delete_attachment( $post_id, true );
		} else {
			wp_delete_post( $post_id, true );
		}
		$deleted++;
	}

	foreach ( array( 'category', 'post_tag', 'project_type', 'download_type', 'download_tag' ) as $taxonomy ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'meta_key'   => NORTHLINE_DEMO_FLAG, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			)
		);

		if ( is_wp_error( $terms ) ) {
			continue;
		}

		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, $taxonomy );
		}
	}

	update_option( 'show_on_front', 'posts' );
	update_option( 'page_on_front', 0 );
	delete_option( 'northline_demo_imported' );
	northline_attachment_map( true );
	northline_page_url( '__flush__' );

	/* translators: %d: number of items removed. */
	return array( sprintf( __( '%d items removed, and the front page reset to the blog.', 'northline' ), $deleted ) );
}
