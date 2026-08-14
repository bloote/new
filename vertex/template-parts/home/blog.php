<?php
/**
 * Home latest posts section.
 *
 * @package Vertex
 */

$q = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
		'ignore_sticky_posts' => true,
	)
);

if ( ! $q->have_posts() ) {
	return;
}
?>
<section class="vx-section" id="blog">
	<div class="vx-container">
		<div class="vx-section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;max-width:100%;">
			<div>
				<span class="vx-eyebrow"><?php esc_html_e( 'Journal', 'vertex' ); ?></span>
				<h2><?php esc_html_e( 'Latest insights & ideas', 'vertex' ); ?></h2>
			</div>
			<a class="vx-btn vx-btn--ghost" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Read the Blog', 'vertex' ); ?></a>
		</div>
		<div class="vx-grid vx-grid--3">
			<?php
			while ( $q->have_posts() ) :
				$q->the_post();
				get_template_part( 'template-parts/content', 'card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
