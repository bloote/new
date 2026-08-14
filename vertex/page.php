<?php
/**
 * The template for displaying all single pages.
 *
 * @package Vertex
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<section class="page-hero">
			<div class="vx-container page-hero__inner">
				<?php vertex_breadcrumbs(); ?>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'vx-section' ); ?>>
			<div class="vx-container">
				<?php if ( has_post_thumbnail() && ! is_page_template() ) : ?>
					<figure class="single-featured">
						<?php the_post_thumbnail( 'vertex-wide' ); ?>
					</figure>
				<?php endif; ?>

				<div class="vx-content vx-entry-content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'vertex' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			echo '<div class="vx-container vx-section--tight">';
			comments_template();
			echo '</div>';
		endif;
		?>

	<?php endwhile; ?>
</main>

<?php
get_footer();
