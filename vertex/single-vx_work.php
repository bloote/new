<?php
/**
 * Single portfolio project template.
 *
 * @package Vertex
 */

get_header();

while ( have_posts() ) :
	the_post();

	$client   = get_post_meta( get_the_ID(), '_vx_client', true );
	$year     = get_post_meta( get_the_ID(), '_vx_year', true );
	$services = get_post_meta( get_the_ID(), '_vx_services', true );
	$url      = get_post_meta( get_the_ID(), '_vx_project_url', true );
	?>

	<main id="primary" class="site-main">

		<section class="page-hero">
			<div class="vx-container page-hero__inner">
				<?php vertex_breadcrumbs(); ?>
				<span class="vx-eyebrow"><?php echo esc_html( vertex_get_terms_list( get_the_ID(), 'vx_work_cat' ) ); ?></span>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<article <?php post_class( 'vx-section' ); ?>>
			<div class="vx-container">

				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="vx-visual-card" style="margin-bottom:3rem;">
						<?php the_post_thumbnail( 'vertex-wide' ); ?>
					</figure>
				<?php endif; ?>

				<div class="vx-page-wrap has-sidebar">
					<div class="vx-content vx-entry-content"><?php the_content(); ?></div>

					<aside class="vx-project-meta">
						<div class="vx-card">
							<?php if ( $client ) : ?>
								<div class="vx-meta-row"><span><?php esc_html_e( 'Client', 'vertex' ); ?></span><b><?php echo esc_html( $client ); ?></b></div>
							<?php endif; ?>
							<?php if ( $year ) : ?>
								<div class="vx-meta-row"><span><?php esc_html_e( 'Year', 'vertex' ); ?></span><b><?php echo esc_html( $year ); ?></b></div>
							<?php endif; ?>
							<?php if ( $services ) : ?>
								<div class="vx-meta-row"><span><?php esc_html_e( 'Services', 'vertex' ); ?></span><b><?php echo esc_html( $services ); ?></b></div>
							<?php endif; ?>
							<div class="vx-meta-row"><span><?php esc_html_e( 'Category', 'vertex' ); ?></span><b><?php echo esc_html( vertex_get_terms_list( get_the_ID(), 'vx_work_cat' ) ); ?></b></div>
							<?php if ( $url ) : ?>
								<a class="vx-btn vx-btn--dark vx-btn--block" style="margin-top:1.5rem;" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Visit Live Site', 'vertex' ); ?></a>
							<?php endif; ?>
						</div>
					</aside>
				</div>

				<?php
				the_post_navigation(
					array(
						'prev_text' => '<div class="prev-post"><small>' . esc_html__( '← Previous project', 'vertex' ) . '</small><strong>%title</strong></div>',
						'next_text' => '<div class="next-post"><small>' . esc_html__( 'Next project →', 'vertex' ) . '</small><strong>%title</strong></div>',
						'class'     => 'post-nav',
					)
				);
				?>
			</div>
		</article>

		<?php get_template_part( 'template-parts/cta' ); ?>
	</main>

	<?php
endwhile;

get_footer();
