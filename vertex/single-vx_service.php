<?php
/**
 * Single service template.
 *
 * @package Vertex
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<main id="primary" class="site-main">

		<section class="page-hero">
			<div class="vx-container page-hero__inner">
				<?php vertex_breadcrumbs(); ?>
				<span class="vx-eyebrow"><?php esc_html_e( 'Service', 'vertex' ); ?></span>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<article <?php post_class( 'vx-section' ); ?>>
			<div class="vx-container vx-container--narrow">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="single-featured"><?php the_post_thumbnail( 'vertex-wide' ); ?></figure>
				<?php endif; ?>
				<div class="vx-content vx-entry-content"><?php the_content(); ?></div>
			</div>
		</article>

		<?php get_template_part( 'template-parts/cta' ); ?>
	</main>

	<?php
endwhile;

get_footer();
