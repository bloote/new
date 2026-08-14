<?php
/**
 * Template Name: Full Width (No Sidebar)
 *
 * @package Vertex
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="primary" class="site-main">
		<?php if ( ! has_blocks( get_the_content() ) || '' === trim( get_the_content() ) ) : ?>
			<section class="page-hero">
				<div class="vx-container page-hero__inner">
					<?php vertex_breadcrumbs(); ?>
					<h1><?php the_title(); ?></h1>
					<?php if ( has_excerpt() ) : ?><p><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				</div>
			</section>
		<?php endif; ?>

		<article <?php post_class(); ?>>
			<div class="vx-entry-content vx-full-content"><?php the_content(); ?></div>
		</article>
	</main>
	<?php
endwhile;

get_footer();
