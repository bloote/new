<?php
/**
 * The main template file — blog listing.
 *
 * @package Vertex
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-hero">
		<div class="vx-container page-hero__inner">
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<span class="vx-eyebrow"><?php esc_html_e( 'Journal', 'vertex' ); ?></span>
				<h1><?php echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Insights & Ideas', 'vertex' ) ); ?></h1>
				<p><?php esc_html_e( 'Thoughts on design, development, and building products people love.', 'vertex' ); ?></p>
			<?php else : ?>
				<span class="vx-eyebrow"><?php esc_html_e( 'Journal', 'vertex' ); ?></span>
				<h1><?php esc_html_e( 'From the Studio', 'vertex' ); ?></h1>
				<p><?php esc_html_e( 'Thoughts on design, development, and building products people love.', 'vertex' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<div class="vx-container vx-section">
		<div class="vx-page-wrap has-sidebar">
			<div>
				<?php if ( have_posts() ) : ?>
					<div class="vx-grid vx-grid--2 vx-posts-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', 'card' );
						endwhile;
						?>
					</div>
					<?php vertex_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>

</main>

<?php
get_footer();
