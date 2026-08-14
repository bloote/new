<?php
/**
 * The template for displaying search results.
 *
 * @package Vertex
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-hero">
		<div class="vx-container page-hero__inner">
			<span class="vx-eyebrow"><?php esc_html_e( 'Search', 'vertex' ); ?></span>
			<h1>
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Results for “%s”', 'vertex' ), '<span class="vx-gradient-text">' . esc_html( get_search_query() ) . '</span>' );
				?>
			</h1>
			<div style="max-width:520px;margin:1.5rem auto 0;"><?php get_search_form(); ?></div>
		</div>
	</section>

	<div class="vx-container vx-section">
		<div class="vx-page-wrap has-sidebar">
			<div>
				<?php if ( have_posts() ) : ?>
					<div class="vx-grid vx-grid--2">
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
