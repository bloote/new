<?php
/**
 * The template for displaying all single posts.
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

		<section class="page-hero single-hero">
			<div class="vx-container vx-container--narrow page-hero__inner">
				<?php vertex_breadcrumbs(); ?>
				<div class="entry-cats"><?php vertex_post_categories(); ?></div>
				<h1><?php the_title(); ?></h1>
				<div class="entry-meta" style="justify-content:center;">
					<?php vertex_posted_on(); ?>
					<?php vertex_reading_time(); ?>
				</div>
			</div>
		</section>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'vx-section' ); ?>>
			<div class="vx-container vx-container--narrow">

				<?php if ( has_post_thumbnail() ) : ?>
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

				<?php if ( has_tag() ) : ?>
					<div class="vx-tag-list" style="margin-top:2rem;">
						<?php
						foreach ( (array) get_the_tags() as $tag ) {
							printf( '<a class="vx-pill" href="%s">#%s</a>', esc_url( get_tag_link( $tag->term_id ) ), esc_html( $tag->name ) );
						}
						?>
					</div>
				<?php endif; ?>

				<?php vertex_author_box(); ?>

				<?php
				the_post_navigation(
					array(
						'prev_text' => '<div class="prev-post"><small>' . esc_html__( '← Previous', 'vertex' ) . '</small><strong>%title</strong></div>',
						'next_text' => '<div class="next-post"><small>' . esc_html__( 'Next →', 'vertex' ) . '</small><strong>%title</strong></div>',
						'class'     => 'post-nav',
					)
				);
				?>

				<?php vertex_related_posts(); ?>

				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</div>
		</article>

	<?php endwhile; ?>
</main>

<?php
get_footer();
