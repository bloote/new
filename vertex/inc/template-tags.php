<?php
/**
 * Custom template tags for this theme.
 *
 * @package Vertex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output an inline SVG icon from a small icon library.
 *
 * @param string $name Icon key.
 * @param bool   $echo Whether to echo (default true).
 * @return string|void
 */
function vertex_icon( $name, $echo = true ) {
	$icons = array(
		'arrow-right'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'arrow-up'       => '<path d="M12 19V5M6 11l6-6 6 6"/>',
		'arrow-up-right' => '<path d="M7 17L17 7M8 7h9v9"/>',
		'check'          => '<path d="M20 6L9 17l-5-5"/>',
		'search'         => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
		'code'           => '<path d="M16 18l6-6-6-6M8 6l-6 6 6 6"/>',
		'layout'         => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
		'mobile'         => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
		'brand'          => '<circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 0 0 0 18 4.5 4.5 0 0 0 0-9 4.5 4.5 0 0 1 0-9z"/>',
		'seo'            => '<path d="M3 3v18h18"/><path d="M7 14l3-3 3 3 5-6"/>',
		'cart'           => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/>',
		'rocket'         => '<path d="M4.5 16.5c-1.5 1.3-2 5-2 5s3.7-.5 5-2c.7-.8.7-2 0-2.8a2 2 0 0 0-3 0z"/><path d="M12 15l-3-3a22 22 0 0 1 8-11 8.5 8.5 0 0 1 5 5 22 22 0 0 1-11 8z"/>',
		'shield'         => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
		'pen'            => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
		'chart'          => '<path d="M3 3v18h18"/><rect x="7" y="12" width="3" height="6"/><rect x="12" y="8" width="3" height="10"/><rect x="17" y="4" width="3" height="14"/>',
		'twitter'        => '<path d="M22 4a10 10 0 0 1-3 1 4.5 4.5 0 0 0-7.7 4A12.7 12.7 0 0 1 3 4a4.5 4.5 0 0 0 1.4 6A4 4 0 0 1 2 9.5a4.5 4.5 0 0 0 3.6 4.4 4 4 0 0 1-2 0 4.5 4.5 0 0 0 4.2 3.1A9 9 0 0 1 2 19a12.7 12.7 0 0 0 7 2c8.3 0 12.8-6.9 12.8-12.8v-.6A9 9 0 0 0 22 4z"/>',
		'linkedin'       => '<path d="M16 8a6 6 0 0 1 6 6v6h-4v-6a2 2 0 0 0-4 0v6h-4v-10h4v1.5A4 4 0 0 1 16 8z"/><rect x="2" y="9" width="4" height="11"/><circle cx="4" cy="4" r="2"/>',
		'instagram'      => '<rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/>',
		'facebook'       => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
		'dribbble'       => '<circle cx="12" cy="12" r="10"/><path d="M8 3.5c4 5 5.5 9.5 6 16M21.5 10c-6-1-12 0-16.5 3M3 13c5-1 11 .5 15 5"/>',
		'github'         => '<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.9a3.4 3.4 0 0 0-1-2.6c3-.3 6-1.5 6-6.6a5 5 0 0 0-1.4-3.5 4.6 4.6 0 0 0-.1-3.5s-1.1-.3-3.5 1.3a12 12 0 0 0-6 0C6.6 1.6 5.5 2 5.5 2a4.6 4.6 0 0 0-.1 3.5A5 5 0 0 0 4 9c0 5 3 6.3 6 6.6a3.4 3.4 0 0 0-1 2.6V22"/>',
		'mail'           => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/>',
		'phone'          => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.8.6a2 2 0 0 1 1.7 2z"/>',
		'map-pin'        => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
		'clock'          => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'star'           => '<path d="M12 2l3 6.5 7 .9-5 4.9 1.2 7L12 18l-6.2 3.3L7 14.3l-5-4.9 7-.9z"/>',
		'quote'          => '<path d="M6 17h3l2-4V7H5v6h3zM14 17h3l2-4V7h-6v6h3z"/>',
	);

	$path = isset( $icons[ $name ] ) ? $icons[ $name ] : $icons['arrow-right'];
	$svg  = sprintf(
		'<svg class="vx-icon vx-icon--%s" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%s</svg>',
		esc_attr( $name ),
		$path
	);

	if ( $echo ) {
		echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	return $svg;
}

/**
 * Output the Vertex logo mark (SVG).
 *
 * @param bool $light Use light variant.
 */
function vertex_logo_mark( $light = false ) {
	$c1 = $light ? '#ffffff' : '#6d5ef7';
	printf(
		'<svg class="vx-logo-mark" width="34" height="34" viewBox="0 0 34 34" fill="none" aria-hidden="true"><rect width="34" height="34" rx="9" fill="url(#vxg)"/><path d="M9 10l8 15 8-15h-4l-4 7.5L13 10z" fill="#fff"/><defs><linearGradient id="vxg" x1="0" y1="0" x2="34" y2="34"><stop stop-color="%s"/><stop offset="1" stop-color="#18e0c8"/></linearGradient></defs></svg>',
		esc_attr( $c1 )
	);
}

/**
 * Render social links from the Customizer.
 */
function vertex_social_links() {
	$networks = array(
		'twitter'   => get_theme_mod( 'vertex_social_twitter', 'https://twitter.com' ),
		'linkedin'  => get_theme_mod( 'vertex_social_linkedin', 'https://linkedin.com' ),
		'instagram' => get_theme_mod( 'vertex_social_instagram', 'https://instagram.com' ),
		'dribbble'  => get_theme_mod( 'vertex_social_dribbble', 'https://dribbble.com' ),
		'github'    => get_theme_mod( 'vertex_social_github', 'https://github.com' ),
	);

	$out = '';
	foreach ( $networks as $name => $url ) {
		if ( $url ) {
			$out .= sprintf(
				'<a href="%s" target="_blank" rel="noopener noreferrer" aria-label="%s">%s</a>',
				esc_url( $url ),
				esc_attr( ucfirst( $name ) ),
				vertex_icon( $name, false )
			);
		}
	}

	if ( $out ) {
		echo '<div class="vx-footer-social">' . $out . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Simple breadcrumbs.
 */
function vertex_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}
	echo '<nav class="vx-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'vertex' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'vertex' ) . '</a>';
	echo ' <span aria-hidden="true">/</span> ';

	if ( is_singular( 'vx_work' ) || is_post_type_archive( 'vx_work' ) ) {
		$link = get_post_type_archive_link( 'vx_work' );
		echo '<a href="' . esc_url( $link ) . '">' . esc_html__( 'Work', 'vertex' ) . '</a> <span aria-hidden="true">/</span> ';
	}

	if ( is_singular() ) {
		echo '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	} elseif ( is_archive() ) {
		echo '<span aria-current="page">' . wp_kses_post( get_the_archive_title() ) . '</span>';
	} elseif ( is_search() ) {
		echo '<span aria-current="page">' . esc_html__( 'Search', 'vertex' ) . '</span>';
	}
	echo '</nav>';
}

/**
 * Posted-on meta.
 */
function vertex_posted_on() {
	printf(
		'<span class="posted-on">%s <time datetime="%s">%s</time></span>',
		vertex_icon( 'clock', false ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	printf(
		'<span class="byline">%s <a href="%s">%s</a></span>',
		esc_html__( 'by', 'vertex' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Estimated reading time.
 */
function vertex_reading_time() {
	$content = get_post_field( 'post_content', get_the_ID() );
	$words   = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = max( 1, (int) ceil( $words / 200 ) );
	printf(
		'<span class="reading-time">%s %s</span>',
		esc_html( $minutes ),
		esc_html__( 'min read', 'vertex' )
	);
}

/**
 * Post category pills.
 */
function vertex_post_categories() {
	$cats = get_the_category();
	if ( ! $cats ) {
		return;
	}
	foreach ( $cats as $cat ) {
		printf( '<a class="vx-badge" href="%s">%s</a> ', esc_url( get_category_link( $cat->term_id ) ), esc_html( $cat->name ) );
	}
}

/**
 * Comma-separated taxonomy terms.
 *
 * @param int    $post_id Post ID.
 * @param string $tax     Taxonomy.
 * @return string
 */
function vertex_get_terms_list( $post_id, $tax ) {
	$terms = get_the_terms( $post_id, $tax );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return '';
	}
	return implode( ', ', wp_list_pluck( $terms, 'name' ) );
}

/**
 * Author box.
 */
function vertex_author_box() {
	$bio = get_the_author_meta( 'description' );
	if ( ! $bio ) {
		return;
	}
	?>
	<div class="author-box">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 72 ); ?>
		<div>
			<small style="font-family:var(--vx-font-mono);color:var(--vx-text-muted);"><?php esc_html_e( 'Written by', 'vertex' ); ?></small>
			<h3 style="margin:0.2em 0 0.5em;"><?php the_author(); ?></h3>
			<p style="margin:0;color:var(--vx-text-muted);"><?php echo esc_html( $bio ); ?></p>
		</div>
	</div>
	<?php
}

/**
 * Related posts by category.
 */
function vertex_related_posts() {
	$cats = wp_get_post_categories( get_the_ID() );
	if ( empty( $cats ) ) {
		return;
	}
	$q = new WP_Query(
		array(
			'category__in'        => $cats,
			'post__not_in'        => array( get_the_ID() ),
			'posts_per_page'      => 3,
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		)
	);
	if ( ! $q->have_posts() ) {
		return;
	}
	?>
	<section class="vx-related" style="margin-top:4rem;">
		<h2 style="margin-bottom:2rem;"><?php esc_html_e( 'Keep reading', 'vertex' ); ?></h2>
		<div class="vx-grid vx-grid--3">
			<?php
			while ( $q->have_posts() ) :
				$q->the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php
}

/**
 * Numbered pagination.
 */
function vertex_pagination() {
	$links = paginate_links(
		array(
			'type'      => 'array',
			'prev_text' => '←',
			'next_text' => '→',
		)
	);
	if ( ! $links ) {
		return;
	}
	echo '<nav class="vx-pagination" aria-label="' . esc_attr__( 'Posts navigation', 'vertex' ) . '">';
	foreach ( $links as $link ) {
		echo wp_kses_post( $link );
	}
	echo '</nav>';
}

/**
 * Get URL for a known page by slug, with a fallback.
 *
 * @param string $slug     Page slug.
 * @param string $fallback Fallback URL.
 * @return string
 */
function vertex_get_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page );
	}
	return $fallback ? $fallback : home_url( '/' . $slug );
}

/* ---------------------------------------------------------------------------
 * Generated SVG imagery — keeps the theme fully self-contained and premium
 * without shipping heavy binary assets. Colors follow the design system.
 * ------------------------------------------------------------------------- */

/**
 * Deterministic pick from an array based on a seed.
 */
function vertex_seed_pick( $seed, $array ) {
	$n = is_numeric( $seed ) ? (int) $seed : crc32( (string) $seed );
	return $array[ abs( $n ) % count( $array ) ];
}

/**
 * Hero illustration (abstract dashboard/browser mock).
 */
function vertex_hero_illustration() {
	return '<svg class="vx-visual-card vx-float" viewBox="0 0 560 460" width="560" height="460" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Studio dashboard preview">
		<defs>
			<linearGradient id="vh1" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#6d5ef7"/><stop offset="1" stop-color="#18e0c8"/></linearGradient>
			<linearGradient id="vh2" x1="0" y1="0" x2="0" y2="1"><stop stop-color="#ffffff"/><stop offset="1" stop-color="#f2f4fb"/></linearGradient>
		</defs>
		<rect x="20" y="30" width="520" height="360" rx="20" fill="url(#vh2)"/>
		<rect x="20" y="30" width="520" height="52" rx="20" fill="#0b0f1a"/>
		<circle cx="48" cy="56" r="6" fill="#ff6b6b"/><circle cx="70" cy="56" r="6" fill="#ffb020"/><circle cx="92" cy="56" r="6" fill="#18e0c8"/>
		<rect x="150" y="48" width="260" height="16" rx="8" fill="#2b3350"/>
		<rect x="48" y="110" width="180" height="120" rx="14" fill="url(#vh1)"/>
		<rect x="70" y="135" width="90" height="12" rx="6" fill="#ffffff" opacity="0.9"/>
		<rect x="70" y="158" width="130" height="10" rx="5" fill="#ffffff" opacity="0.5"/>
		<rect x="70" y="195" width="60" height="20" rx="10" fill="#ffffff"/>
		<rect x="250" y="110" width="242" height="56" rx="12" fill="#eef1f7"/>
		<rect x="270" y="130" width="150" height="12" rx="6" fill="#c3ccdc"/>
		<rect x="250" y="178" width="242" height="52" rx="12" fill="#eef1f7"/>
		<rect x="270" y="197" width="120" height="12" rx="6" fill="#c3ccdc"/>
		<rect x="48" y="255" width="444" height="105" rx="14" fill="#f2f4fb"/>
		<polyline points="70,335 130,300 190,320 250,270 310,295 370,250 430,280 470,255" fill="none" stroke="#6d5ef7" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
		<circle cx="470" cy="255" r="7" fill="#18e0c8"/>
		<g transform="translate(430,330)"><rect x="-20" y="-20" width="90" height="90" rx="18" fill="#0b0f1a"/><path d="M0 20h50M25 -5v50" stroke="#18e0c8" stroke-width="5" stroke-linecap="round"/></g>
	</svg>';
}

/**
 * About illustration.
 */
function vertex_about_illustration() {
	return '<svg class="vx-visual-card" viewBox="0 0 520 440" width="520" height="440" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Team collaboration illustration">
		<defs><linearGradient id="va1" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#ece9fe"/><stop offset="1" stop-color="#e6fbf7"/></linearGradient></defs>
		<rect width="520" height="440" rx="24" fill="url(#va1)"/>
		<rect x="40" y="60" width="220" height="300" rx="18" fill="#fff"/>
		<rect x="64" y="90" width="120" height="14" rx="7" fill="#0b0f1a"/>
		<rect x="64" y="120" width="172" height="10" rx="5" fill="#c3ccdc"/>
		<rect x="64" y="140" width="150" height="10" rx="5" fill="#dde3ee"/>
		<rect x="64" y="180" width="172" height="90" rx="12" fill="#6d5ef7"/>
		<rect x="64" y="288" width="80" height="30" rx="15" fill="#18e0c8"/>
		<circle cx="360" cy="150" r="70" fill="#6d5ef7"/>
		<circle cx="360" cy="130" r="26" fill="#fff"/>
		<path d="M320 200a40 40 0 0 1 80 0z" fill="#fff"/>
		<rect x="300" y="250" width="180" height="110" rx="16" fill="#0b0f1a"/>
		<path d="M330 305l20-20 20 20 30-35" fill="none" stroke="#18e0c8" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
		<circle cx="430" cy="300" r="8" fill="#ff6b6b"/>
	</svg>';
}

/**
 * Portfolio project placeholder image.
 */
function vertex_work_placeholder( $seed ) {
	$palettes = array(
		array( '#6d5ef7', '#8b7bff' ),
		array( '#18e0c8', '#0fc7b1' ),
		array( '#ff6b6b', '#ff9a6b' ),
		array( '#0b0f1a', '#1c2544' ),
		array( '#ffb020', '#ff8a3d' ),
		array( '#3b82f6', '#6d5ef7' ),
	);
	$p = vertex_seed_pick( $seed, $palettes );
	return sprintf(
		'<svg viewBox="0 0 720 540" width="720" height="540" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" role="img" aria-label="%s">
			<defs><linearGradient id="wp%1$s" x1="0" y1="0" x2="1" y2="1"><stop stop-color="%2$s"/><stop offset="1" stop-color="%3$s"/></linearGradient></defs>
			<rect width="720" height="540" fill="url(#wp%1$s)"/>
			<g fill="#ffffff" opacity="0.12"><circle cx="140" cy="120" r="120"/><rect x="440" y="300" width="220" height="220" rx="40"/></g>
			<rect x="90" y="180" width="360" height="26" rx="13" fill="#fff" opacity="0.85"/>
			<rect x="90" y="230" width="240" height="18" rx="9" fill="#fff" opacity="0.5"/>
			<rect x="90" y="300" width="120" height="44" rx="22" fill="#fff"/>
		</svg>',
		esc_attr__( 'Portfolio project', 'vertex' ),
		esc_attr( is_numeric( $seed ) ? $seed : crc32( (string) $seed ) ),
		esc_attr( $p[0] ),
		esc_attr( $p[1] )
	);
}

/**
 * Blog post placeholder image.
 */
function vertex_post_placeholder( $seed ) {
	$palettes = array(
		array( '#ece9fe', '#6d5ef7' ),
		array( '#e6fbf7', '#18e0c8' ),
		array( '#fff1f1', '#ff6b6b' ),
		array( '#fff6e6', '#ffb020' ),
	);
	$p = vertex_seed_pick( $seed, $palettes );
	return sprintf(
		'<svg viewBox="0 0 800 500" width="800" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" role="img" aria-label="%s">
			<rect width="800" height="500" fill="%2$s"/>
			<g fill="%3$s" opacity="0.9"><circle cx="640" cy="120" r="90"/></g>
			<g fill="%3$s" opacity="0.25"><rect x="80" y="360" width="640" height="80" rx="20"/></g>
			<g transform="translate(320,180)"><rect width="160" height="120" rx="16" fill="%3$s"/><path d="M40 90l30-30 30 30 20-24" stroke="#fff" stroke-width="6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></g>
		</svg>',
		esc_attr__( 'Article illustration', 'vertex' ),
		esc_attr( $p[0] ),
		esc_attr( $p[1] )
	);
}

/**
 * Avatar placeholder with initials.
 */
function vertex_avatar_placeholder( $name, $size = 96 ) {
	$parts    = preg_split( '/\s+/', trim( (string) $name ) );
	$initials = '';
	foreach ( array_slice( $parts, 0, 2 ) as $part ) {
		$initials .= mb_substr( $part, 0, 1 );
	}
	$initials = strtoupper( $initials ? $initials : 'V' );
	$palettes = array( '#6d5ef7', '#18e0c8', '#ff6b6b', '#ffb020', '#3b82f6', '#0b0f1a' );
	$bg       = vertex_seed_pick( $name, $palettes );
	return sprintf(
		'<svg viewBox="0 0 %1$d %1$d" width="%1$d" height="%1$d" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="%2$s">
			<rect width="%1$d" height="%1$d" fill="%3$s"/>
			<text x="50%%" y="50%%" dy="0.35em" text-anchor="middle" font-family="Sora, sans-serif" font-weight="700" font-size="%4$d" fill="#ffffff">%5$s</text>
		</svg>',
		absint( $size ),
		esc_attr( $name ),
		esc_attr( $bg ),
		absint( $size * 0.38 ),
		esc_html( $initials )
	);
}

/**
 * Client wordmark (text-based logo).
 */
function vertex_client_logo( $name ) {
	return sprintf(
		'<svg viewBox="0 0 160 40" width="160" height="40" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="%1$s">
			<circle cx="18" cy="20" r="12" fill="#0b0f1a"/><circle cx="18" cy="20" r="5" fill="#18e0c8"/>
			<text x="40" y="27" font-family="Sora, sans-serif" font-weight="700" font-size="20" fill="#0b0f1a">%1$s</text>
		</svg>',
		esc_html( $name )
	);
}
