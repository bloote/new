<?php
/**
 * One-click demo content importer and theme setup screen.
 *
 * Creates pages, posts, categories, portfolio projects, services, team
 * members, testimonials, navigation menus, and default settings so the site
 * is fully populated and ready to use immediately after activation.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the setup page under Appearance.
 */
function vertex_setup_menu() {
	add_theme_page(
		__( 'Vertex Setup', 'vertex' ),
		__( 'Vertex Setup', 'vertex' ),
		'edit_theme_options',
		'vertex-setup',
		'vertex_setup_page'
	);
}
add_action( 'admin_menu', 'vertex_setup_menu' );

/**
 * Show a welcome notice after activation prompting the user to import demo data.
 */
function vertex_activation_notice() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	if ( get_option( 'vertex_demo_imported' ) || get_user_meta( get_current_user_id(), 'vertex_notice_dismissed', true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( $screen && 'appearance_page_vertex-setup' === $screen->id ) {
		return;
	}
	?>
	<div class="notice notice-info is-dismissible vertex-activation-notice">
		<p style="font-size:14px;">
			<strong><?php esc_html_e( 'Welcome to Vertex!', 'vertex' ); ?></strong>
			<?php esc_html_e( 'Import the demo content to get a fully populated, ready-to-launch agency website in one click.', 'vertex' ); ?>
		</p>
		<p>
			<a href="<?php echo esc_url( admin_url( 'themes.php?page=vertex-setup' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to Vertex Setup', 'vertex' ); ?></a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'vertex_activation_notice' );

/**
 * Dismiss notice via AJAX-less link.
 */
function vertex_dismiss_notice() {
	if ( isset( $_GET['vertex_dismiss'] ) && check_admin_referer( 'vertex_dismiss' ) ) {
		update_user_meta( get_current_user_id(), 'vertex_notice_dismissed', 1 );
	}
}
add_action( 'admin_init', 'vertex_dismiss_notice' );

/**
 * Enqueue setup-page styles.
 */
function vertex_setup_assets( $hook ) {
	if ( 'appearance_page_vertex-setup' === $hook ) {
		wp_enqueue_style( 'vertex-admin', VERTEX_URI . '/assets/css/admin.css', array(), VERTEX_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'vertex_setup_assets' );

/**
 * Render the setup / welcome page.
 */
function vertex_setup_page() {
	$imported = get_option( 'vertex_demo_imported' );
	?>
	<div class="vx-setup">
		<div class="vx-setup__header">
			<div class="vx-setup__badge">V</div>
			<div>
				<h1><?php esc_html_e( 'Vertex Theme Setup', 'vertex' ); ?></h1>
				<p><?php esc_html_e( 'Launch a professional web design & development agency site in minutes.', 'vertex' ); ?></p>
			</div>
		</div>

		<?php if ( isset( $_GET['imported'] ) && 'success' === $_GET['imported'] ) : ?>
			<div class="vx-setup__alert vx-setup__alert--success">
				<strong><?php esc_html_e( 'Demo content imported successfully!', 'vertex' ); ?></strong>
				<?php esc_html_e( 'Your homepage, pages, portfolio, services, blog posts and menus are ready.', 'vertex' ); ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank"><?php esc_html_e( 'View your site →', 'vertex' ); ?></a>
			</div>
		<?php endif; ?>

		<div class="vx-setup__grid">
			<div class="vx-setup__card">
				<span class="vx-setup__step">1</span>
				<h2><?php esc_html_e( 'Import Demo Content', 'vertex' ); ?></h2>
				<p><?php esc_html_e( 'This creates all pages, blog posts, categories, portfolio projects, services, team members, testimonials, and navigation menus — and configures your homepage automatically.', 'vertex' ); ?></p>
				<ul class="vx-setup__list">
					<li><?php esc_html_e( '7 pre-built pages (Home, About, Services, Portfolio, Blog, Contact, Privacy)', 'vertex' ); ?></li>
					<li><?php esc_html_e( '6 portfolio projects across 4 categories', 'vertex' ); ?></li>
					<li><?php esc_html_e( '6 services & 4 team members', 'vertex' ); ?></li>
					<li><?php esc_html_e( '6 blog posts in 5 categories, plus testimonials', 'vertex' ); ?></li>
					<li><?php esc_html_e( 'Primary + footer menus, assigned automatically', 'vertex' ); ?></li>
				</ul>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'vertex_import_demo', 'vertex_import_nonce' ); ?>
					<input type="hidden" name="action" value="vertex_import_demo">
					<?php if ( $imported ) : ?>
						<p class="vx-setup__done">✓ <?php esc_html_e( 'Demo content has already been imported.', 'vertex' ); ?></p>
						<button type="submit" class="button button-secondary" name="reimport" value="1" onclick="return confirm('<?php esc_attr_e( 'Import again? This may create duplicate content.', 'vertex' ); ?>');"><?php esc_html_e( 'Re-import Demo Content', 'vertex' ); ?></button>
					<?php else : ?>
						<button type="submit" class="button button-primary button-hero"><?php esc_html_e( 'Import Demo Content', 'vertex' ); ?></button>
					<?php endif; ?>
				</form>
			</div>

			<div class="vx-setup__card">
				<span class="vx-setup__step">2</span>
				<h2><?php esc_html_e( 'Make It Yours', 'vertex' ); ?></h2>
				<p><?php esc_html_e( 'Customize every detail from the dashboard:', 'vertex' ); ?></p>
				<ul class="vx-setup__list">
					<li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Colors, fonts & layout →', 'vertex' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=vertex_hero' ) ); ?>"><?php esc_html_e( 'Homepage hero →', 'vertex' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=vertex_social' ) ); ?>"><?php esc_html_e( 'Social & contact links →', 'vertex' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=vx_work' ) ); ?>"><?php esc_html_e( 'Manage Portfolio →', 'vertex' ); ?></a></li>
					<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=vx_service' ) ); ?>"><?php esc_html_e( 'Manage Services →', 'vertex' ); ?></a></li>
				</ul>
				<p class="vx-setup__hint"><?php esc_html_e( 'Tip: Every homepage section also exists as a block pattern — insert them into any page from the block editor’s Patterns tab under “Vertex”.', 'vertex' ); ?></p>
			</div>
		</div>

		<div class="vx-setup__footer">
			<p><?php esc_html_e( 'Vertex v', 'vertex' ); ?><?php echo esc_html( VERTEX_VERSION ); ?> · <?php esc_html_e( 'Need help? Check the README included with the theme.', 'vertex' ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Handle the import request.
 */
function vertex_handle_import() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'Permission denied.', 'vertex' ) );
	}
	check_admin_referer( 'vertex_import_demo', 'vertex_import_nonce' );

	vertex_import_demo_content();

	update_option( 'vertex_demo_imported', time() );

	wp_safe_redirect( admin_url( 'themes.php?page=vertex-setup&imported=success' ) );
	exit;
}
add_action( 'admin_post_vertex_import_demo', 'vertex_handle_import' );

/**
 * The actual content generator.
 */
function vertex_import_demo_content() {
	// Prevent timeouts on large imports.
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 120 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}

	$pages = vertex_import_pages();
	vertex_import_blog();
	vertex_import_portfolio();
	vertex_import_services();
	vertex_import_team();
	vertex_import_testimonials();
	vertex_import_menus( $pages );
	vertex_configure_front_page( $pages );

	flush_rewrite_rules();
}

/**
 * Find an existing post by exact title within a post type (replaces the
 * deprecated get_page_by_title()).
 *
 * @param string $title     Post title.
 * @param string $post_type Post type.
 * @return int Post ID or 0.
 */
function vertex_post_exists_by_title( $title, $post_type ) {
	$query = new WP_Query(
		array(
			'post_type'              => $post_type,
			'title'                  => $title,
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'fields'                 => 'ids',
		)
	);
	return $query->have_posts() ? (int) $query->posts[0] : 0;
}

/**
 * Create a page from a block pattern, returning its ID (reuses by slug).
 */
function vertex_create_page( $title, $slug, $content = '', $template = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return $existing->ID;
	}
	$id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
		)
	);
	if ( $id && ! is_wp_error( $id ) && $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return $id;
}

/**
 * Create the site pages.
 *
 * @return array Map of slug => page ID.
 */
function vertex_import_pages() {
	$ids = array();

	$ids['home']    = vertex_create_page( __( 'Home', 'vertex' ), 'home' );
	$ids['about']   = vertex_create_page( __( 'About', 'vertex' ), 'about', '<!-- wp:pattern {"slug":"vertex/page-about"} /-->', 'page-templates/template-full-width.php' );
	$ids['services'] = vertex_create_page( __( 'Services', 'vertex' ), 'services', '<!-- wp:pattern {"slug":"vertex/page-services"} /-->', 'page-templates/template-full-width.php' );
	$ids['contact'] = vertex_create_page( __( 'Contact', 'vertex' ), 'contact', '<!-- wp:pattern {"slug":"vertex/page-contact"} /-->', 'page-templates/template-full-width.php' );
	$ids['blog']    = vertex_create_page( __( 'Blog', 'vertex' ), 'blog' );
	$ids['portfolio_page'] = vertex_create_page( __( 'Portfolio', 'vertex' ), 'our-work', '<!-- wp:paragraph --><p>' . esc_html__( 'Explore our latest projects below.', 'vertex' ) . '</p><!-- /wp:paragraph -->', 'page-templates/template-portfolio.php' );

	// Privacy page.
	$privacy_content = '<!-- wp:paragraph --><p>' . esc_html__( 'This is a sample privacy policy page. Replace this text with your own policy describing how you collect, use, and protect visitor data.', 'vertex' ) . '</p><!-- /wp:paragraph -->';
	$ids['privacy']  = vertex_create_page( __( 'Privacy Policy', 'vertex' ), 'privacy-policy', $privacy_content );
	if ( $ids['privacy'] && ! is_wp_error( $ids['privacy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', $ids['privacy'] );
	}

	return $ids;
}

/**
 * Create blog categories and posts.
 */
function vertex_import_blog() {
	$categories = array(
		'design'      => __( 'Design', 'vertex' ),
		'development' => __( 'Development', 'vertex' ),
		'business'    => __( 'Business', 'vertex' ),
		'tutorials'   => __( 'Tutorials', 'vertex' ),
		'news'        => __( 'Studio News', 'vertex' ),
	);
	$cat_ids = array();
	foreach ( $categories as $slug => $name ) {
		$term = term_exists( $slug, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $term ) ) {
			$cat_ids[ $slug ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
		}
	}

	$posts = array(
		array(
			'title'   => __( '10 Web Design Trends Shaping 2026', 'vertex' ),
			'cat'     => 'design',
			'tags'    => array( 'UI', 'Trends', 'Inspiration' ),
			'excerpt' => __( 'From bold typography to AI-assisted interfaces, here are the trends defining great digital experiences this year.', 'vertex' ),
		),
		array(
			'title'   => __( 'A Practical Guide to Core Web Vitals', 'vertex' ),
			'cat'     => 'development',
			'tags'    => array( 'Performance', 'SEO', 'Web' ),
			'excerpt' => __( 'Learn what LCP, CLS, and INP really mean — and the concrete steps we use to make sites lightning fast.', 'vertex' ),
		),
		array(
			'title'   => __( 'How to Write a Website Brief That Gets Results', 'vertex' ),
			'cat'     => 'business',
			'tags'    => array( 'Strategy', 'Clients' ),
			'excerpt' => __( 'A great project starts with a great brief. Here is the framework we share with every new client.', 'vertex' ),
		),
		array(
			'title'   => __( 'Building a Design System From Scratch', 'vertex' ),
			'cat'     => 'tutorials',
			'tags'    => array( 'Design Systems', 'Figma', 'CSS' ),
			'excerpt' => __( 'Design tokens, components, and documentation — a step-by-step look at how we scale consistency.', 'vertex' ),
		),
		array(
			'title'   => __( 'Why We Switched to a Headless WordPress Stack', 'vertex' ),
			'cat'     => 'development',
			'tags'    => array( 'WordPress', 'React', 'Architecture' ),
			'excerpt' => __( 'The trade-offs, the wins, and the lessons learned from going headless on our largest client build.', 'vertex' ),
		),
		array(
			'title'   => __( 'Vertex Named Agency of the Year', 'vertex' ),
			'cat'     => 'news',
			'tags'    => array( 'Awards', 'Team' ),
			'excerpt' => __( 'We are honored to be recognized for our work in digital product design and development.', 'vertex' ),
		),
	);

	$body = vertex_sample_post_body();

	foreach ( $posts as $i => $p ) {
		// Avoid duplicates by title.
		if ( vertex_post_exists_by_title( $p['title'], 'post' ) ) {
			continue;
		}
		$post_id = wp_insert_post(
			array(
				'post_title'   => $p['title'],
				'post_content' => $body,
				'post_excerpt' => $p['excerpt'],
				'post_status'  => 'publish',
				'post_type'    => 'post',
				'post_date'    => gmdate( 'Y-m-d H:i:s', strtotime( "-{$i} weeks" ) ),
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			if ( isset( $cat_ids[ $p['cat'] ] ) ) {
				wp_set_post_categories( $post_id, array( $cat_ids[ $p['cat'] ] ) );
			}
			wp_set_post_tags( $post_id, $p['tags'] );
		}
	}
}

/**
 * Sample rich post body used for all demo articles.
 */
function vertex_sample_post_body() {
	return '<!-- wp:paragraph --><p>Great digital products are never an accident. They are the result of deliberate strategy, thoughtful design, and disciplined engineering working in concert. In this article we break down the ideas and processes that consistently produce results for our clients.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Start with the problem, not the solution</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>It is tempting to jump straight to visuals or code. But the best outcomes come from teams who obsess over understanding the underlying problem first — who the users are, what they need, and how success will be measured.</p><!-- /wp:paragraph -->
<!-- wp:quote --><blockquote class="wp-block-quote"><p>Design is not just what it looks like and feels like. Design is how it works.</p><cite>Steve Jobs</cite></blockquote><!-- /wp:quote -->
<!-- wp:heading --><h2 class="wp-block-heading">Ship, measure, iterate</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Launch is the beginning, not the end. We instrument every project so we can watch how real people use it and continuously improve. The compounding effect of small, data-driven improvements is where the real magic happens.</p><!-- /wp:paragraph -->
<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li>Define clear, measurable goals up front</li><!-- /wp:list-item --><!-- wp:list-item --><li>Prototype early and validate with users</li><!-- /wp:list-item --><!-- wp:list-item --><li>Optimize relentlessly for speed and accessibility</li><!-- /wp:list-item --></ul><!-- /wp:list -->
<!-- wp:paragraph --><p>Want to talk about your next project? We would love to hear from you.</p><!-- /wp:paragraph -->';
}

/**
 * Create portfolio projects and their categories.
 */
function vertex_import_portfolio() {
	$cats = array(
		'web-design'  => __( 'Web Design', 'vertex' ),
		'branding'    => __( 'Branding', 'vertex' ),
		'ecommerce'   => __( 'E-Commerce', 'vertex' ),
		'app-design'  => __( 'App Design', 'vertex' ),
	);
	$cat_ids = array();
	foreach ( $cats as $slug => $name ) {
		$term = term_exists( $slug, 'vx_work_cat' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'vx_work_cat', array( 'slug' => $slug ) );
		}
		if ( ! is_wp_error( $term ) ) {
			$cat_ids[ $slug ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
		}
	}

	$projects = array(
		array( 'Lumen Finance Platform', 'web-design', 'Lumen', '2025', 'Design, Development', __( 'A complete redesign of a fintech platform focused on clarity, trust, and conversion. We rebuilt the marketing site and product dashboard from the ground up.', 'vertex' ) ),
		array( 'Vireo Health Rebrand', 'branding', 'Vireo Health', '2025', 'Branding, Strategy', __( 'A fresh, human brand identity for a fast-growing healthcare startup — from logo and color system to full brand guidelines.', 'vertex' ) ),
		array( 'Halcyon Fashion Store', 'ecommerce', 'Halcyon', '2024', 'E-Commerce, Design', __( 'A high-converting WooCommerce storefront with a bold editorial aesthetic and a checkout optimized for mobile.', 'vertex' ) ),
		array( 'Orbital Travel App', 'app-design', 'Orbital', '2024', 'App Design, UX', __( 'An award-winning travel booking app that makes planning trips feel effortless and joyful across iOS and Android.', 'vertex' ) ),
		array( 'Beacon SaaS Dashboard', 'web-design', 'Beacon', '2024', 'Development, UI', __( 'A data-dense analytics dashboard engineered for speed, with a component library that scales across the product.', 'vertex' ) ),
		array( 'Pinnacle Agency Site', 'web-design', 'Pinnacle', '2023', 'Design, Development', __( 'A striking portfolio website for a creative agency, built to showcase their work with immersive interactions.', 'vertex' ) ),
	);

	foreach ( $projects as $order => $proj ) {
		if ( vertex_post_exists_by_title( $proj[0], 'vx_work' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => $proj[0],
				'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $proj[5] ) . '</p><!-- /wp:paragraph -->' . vertex_project_body(),
				'post_excerpt' => $proj[5],
				'post_status'  => 'publish',
				'post_type'    => 'vx_work',
				'menu_order'   => $order,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			if ( isset( $cat_ids[ $proj[1] ] ) ) {
				wp_set_object_terms( $id, array( $cat_ids[ $proj[1] ] ), 'vx_work_cat' );
			}
			update_post_meta( $id, '_vx_client', $proj[2] );
			update_post_meta( $id, '_vx_year', $proj[3] );
			update_post_meta( $id, '_vx_services', $proj[4] );
			update_post_meta( $id, '_vx_project_url', 'https://example.com' );
		}
	}
}

function vertex_project_body() {
	return '<!-- wp:heading --><h2 class="wp-block-heading">The challenge</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>The client came to us with an ambitious goal and a tight timeline. Their existing experience was holding them back, and they needed a partner who could move fast without compromising on quality.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">Our approach</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>We ran a focused discovery sprint, designed a fresh system in Figma, and shipped production-ready code in weekly increments. Every decision was validated against real user feedback and business metrics.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2 class="wp-block-heading">The results</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>The launch exceeded every target: faster load times, higher engagement, and a measurable lift in conversions. Most importantly, the client now has a platform built to grow with them.</p><!-- /wp:paragraph -->';
}

/**
 * Create services.
 */
function vertex_import_services() {
	$services = array(
		array( 'UI/UX Design', 'layout', __( 'Human-centered interfaces and design systems that are beautiful, usable, and built to convert visitors into customers.', 'vertex' ) ),
		array( 'Web Development', 'code', __( 'Fast, accessible, and scalable websites built with modern frameworks and clean, maintainable, well-documented code.', 'vertex' ) ),
		array( 'App Development', 'mobile', __( 'Native and cross-platform mobile apps engineered for performance and delightful, intuitive user experiences.', 'vertex' ) ),
		array( 'Brand Identity', 'brand', __( 'Distinctive brand systems — logos, guidelines, and visual language that make your business unforgettable.', 'vertex' ) ),
		array( 'SEO & Growth', 'seo', __( 'Data-driven optimization and content strategy that drives qualified traffic, leads, and measurable growth.', 'vertex' ) ),
		array( 'E-Commerce', 'cart', __( 'Conversion-focused online stores on WooCommerce and Shopify that turn browsers into loyal buyers.', 'vertex' ) ),
	);
	foreach ( $services as $order => $svc ) {
		if ( vertex_post_exists_by_title( $svc[0], 'vx_service' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => $svc[0],
				'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $svc[2] ) . '</p><!-- /wp:paragraph -->' . vertex_service_body(),
				'post_excerpt' => $svc[2],
				'post_status'  => 'publish',
				'post_type'    => 'vx_service',
				'menu_order'   => $order,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_vx_icon', $svc[1] );
		}
	}
}

function vertex_service_body() {
	return '<!-- wp:heading --><h2 class="wp-block-heading">What’s included</h2><!-- /wp:heading -->
<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li>Discovery &amp; strategy workshop</li><!-- /wp:list-item --><!-- wp:list-item --><li>Wireframes and interactive prototypes</li><!-- /wp:list-item --><!-- wp:list-item --><li>Production-ready implementation</li><!-- /wp:list-item --><!-- wp:list-item --><li>Quality assurance &amp; launch support</li><!-- /wp:list-item --></ul><!-- /wp:list -->
<!-- wp:paragraph --><p>Every engagement is tailored to your goals. Let’s talk about how we can help.</p><!-- /wp:paragraph -->';
}

/**
 * Create team members.
 */
function vertex_import_team() {
	$team = array(
		array( 'Alex Morgan', __( 'Founder & Creative Director', 'vertex' ) ),
		array( 'Jordan Blake', __( 'Lead Developer', 'vertex' ) ),
		array( 'Maya Patel', __( 'Senior Product Designer', 'vertex' ) ),
		array( 'Leo Fischer', __( 'Head of Strategy', 'vertex' ) ),
	);
	foreach ( $team as $order => $member ) {
		if ( vertex_post_exists_by_title( $member[0], 'vx_team' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => $member[0],
				'post_content' => '<!-- wp:paragraph --><p>' . esc_html__( 'A passionate member of the Vertex team dedicated to crafting exceptional digital experiences.', 'vertex' ) . '</p><!-- /wp:paragraph -->',
				'post_status'  => 'publish',
				'post_type'    => 'vx_team',
				'menu_order'   => $order,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_vx_role', $member[1] );
		}
	}
}

/**
 * Create testimonials.
 */
function vertex_import_testimonials() {
	$items = array(
		array( 'Sarah Chen', __( 'CEO, Lumen Finance', 'vertex' ), __( 'Vertex transformed our outdated site into a conversion machine. Sales are up 60% and the team is a genuine pleasure to work with.', 'vertex' ) ),
		array( 'Marcus Reid', __( 'Founder, Orbital', 'vertex' ), __( 'The most professional, thoughtful, and talented studio we have ever partnered with. They just get it — design, code, and business.', 'vertex' ) ),
		array( 'Priya Nair', __( 'CMO, Vireo Health', 'vertex' ), __( 'From strategy to launch, everything was seamless. Our new platform is fast, gorgeous, and our customers love it. Highly recommended.', 'vertex' ) ),
	);
	foreach ( $items as $item ) {
		if ( vertex_post_exists_by_title( $item[0], 'vx_testimonial' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => $item[0],
				'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $item[2] ) . '</p><!-- /wp:paragraph -->',
				'post_status'  => 'publish',
				'post_type'    => 'vx_testimonial',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_vx_role', $item[1] );
		}
	}
}

/**
 * Build and assign navigation menus.
 *
 * @param array $pages Slug => page ID.
 */
function vertex_import_menus( $pages ) {
	// Primary menu.
	$menu_name = __( 'Primary Menu', 'vertex' );
	$menu      = wp_get_nav_menu_object( $menu_name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( ! is_wp_error( $menu_id ) ) {
			$items = array(
				array( 'title' => __( 'Home', 'vertex' ), 'object_id' => $pages['home'], 'type' => 'post_type', 'object' => 'page' ),
				array( 'title' => __( 'About', 'vertex' ), 'object_id' => $pages['about'], 'type' => 'post_type', 'object' => 'page' ),
				array( 'title' => __( 'Services', 'vertex' ), 'object_id' => $pages['services'], 'type' => 'post_type', 'object' => 'page' ),
				array( 'title' => __( 'Portfolio', 'vertex' ), 'object_id' => $pages['portfolio_page'], 'type' => 'post_type', 'object' => 'page' ),
				array( 'title' => __( 'Blog', 'vertex' ), 'object_id' => $pages['blog'], 'type' => 'post_type', 'object' => 'page' ),
				array( 'title' => __( 'Contact', 'vertex' ), 'object_id' => $pages['contact'], 'type' => 'post_type', 'object' => 'page' ),
			);
			foreach ( $items as $item ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => $item['title'],
						'menu-item-object-id' => $item['object_id'],
						'menu-item-object'    => $item['object'],
						'menu-item-type'      => $item['type'],
						'menu-item-status'    => 'publish',
					)
				);
			}
			vertex_assign_menu( 'primary', $menu_id );
		}
	}

	// Footer menu.
	$footer_name = __( 'Footer Menu', 'vertex' );
	if ( ! wp_get_nav_menu_object( $footer_name ) ) {
		$footer_id = wp_create_nav_menu( $footer_name );
		if ( ! is_wp_error( $footer_id ) ) {
			foreach ( array( 'about' => __( 'About', 'vertex' ), 'services' => __( 'Services', 'vertex' ), 'contact' => __( 'Contact', 'vertex' ), 'privacy' => __( 'Privacy Policy', 'vertex' ) ) as $slug => $title ) {
				if ( ! empty( $pages[ $slug ] ) ) {
					wp_update_nav_menu_item(
						$footer_id,
						0,
						array(
							'menu-item-title'     => $title,
							'menu-item-object-id' => $pages[ $slug ],
							'menu-item-object'    => 'page',
							'menu-item-type'      => 'post_type',
							'menu-item-status'    => 'publish',
						)
					);
				}
			}
			vertex_assign_menu( 'footer', $footer_id );
		}
	}
}

/**
 * Assign a menu to a theme location without clobbering others.
 */
function vertex_assign_menu( $location, $menu_id ) {
	$locations              = get_theme_mod( 'nav_menu_locations', array() );
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Configure the static front page and posts page.
 *
 * @param array $pages Slug => page ID.
 */
function vertex_configure_front_page( $pages ) {
	if ( ! empty( $pages['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );
	}
	if ( ! empty( $pages['blog'] ) ) {
		update_option( 'page_for_posts', $pages['blog'] );
	}
}
