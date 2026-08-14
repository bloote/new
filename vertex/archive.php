<?php
/**
 * The template for displaying archive pages.
 *
 * @package Vertex
 */

get_header();

$is_work    = is_post_type_archive( 'vx_work' ) || is_tax( 'vx_work_cat' );
$is_service = is_post_type_archive( 'vx_service' );
?>

<main id="primary" class="site-main">

	<section class="page-hero">
		<div class="vx-container page-hero__inner">
			<?php vertex_breadcrumbs(); ?>
			<span class="vx-eyebrow">
				<?php
				if ( $is_work ) {
					esc_html_e( 'Selected Work', 'vertex' );
				} elseif ( $is_service ) {
					esc_html_e( 'What We Do', 'vertex' );
				} else {
					esc_html_e( 'Archive', 'vertex' );
				}
				?>
			</span>
			<?php
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<p>', '</p>' );
			?>
		</div>
	</section>

	<div class="vx-container vx-section">
		<?php if ( have_posts() ) : ?>

			<?php if ( $is_work ) : ?>
				<div class="vx-grid vx-grid--3">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'work' );
					endwhile;
					?>
				</div>
			<?php elseif ( $is_service ) : ?>
				<div class="vx-grid vx-grid--3">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'service' );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<div class="vx-page-wrap has-sidebar">
					<div>
						<div class="vx-grid vx-grid--2">
							<?php
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/content', 'card' );
							endwhile;
							?>
						</div>
						<?php vertex_pagination(); ?>
					</div>
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>

			<?php if ( $is_work || $is_service ) { vertex_pagination(); } ?>

		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>

</main>

<?php
get_footer();
