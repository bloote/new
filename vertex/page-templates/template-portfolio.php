<?php
/**
 * Template Name: Portfolio Grid
 *
 * Displays all portfolio projects with category filtering.
 *
 * @package Vertex
 */

get_header();

$terms   = get_terms( array( 'taxonomy' => 'vx_work_cat', 'hide_empty' => true ) );
$active  = isset( $_GET['work_cat'] ) ? sanitize_title( wp_unslash( $_GET['work_cat'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$args    = array(
	'post_type'      => 'vx_work',
	'posts_per_page' => 12,
	'paged'          => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
);
if ( $active ) {
	$args['tax_query'] = array( array( 'taxonomy' => 'vx_work_cat', 'field' => 'slug', 'terms' => $active ) ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
}
$work = new WP_Query( $args );

while ( have_posts() ) {
	the_post();
}
?>

<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="vx-container page-hero__inner">
			<?php vertex_breadcrumbs(); ?>
			<span class="vx-eyebrow"><?php esc_html_e( 'Selected Work', 'vertex' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p><?php esc_html_e( 'A selection of projects we’ve designed and built for clients around the world.', 'vertex' ); ?></p>
		</div>
	</section>

	<div class="vx-container vx-section">
		<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
			<div class="vx-filter" style="display:flex;flex-wrap:wrap;gap:0.5rem;justify-content:center;margin-bottom:3rem;">
				<a class="vx-pill<?php echo $active ? '' : ' is-active'; ?>" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'All', 'vertex' ); ?></a>
				<?php foreach ( $terms as $term ) : ?>
					<a class="vx-pill<?php echo $active === $term->slug ? ' is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'work_cat', $term->slug, get_permalink() ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $work->have_posts() ) : ?>
			<div class="vx-grid vx-grid--3">
				<?php
				while ( $work->have_posts() ) :
					$work->the_post();
					get_template_part( 'template-parts/content', 'work' );
				endwhile;
				?>
			</div>

			<?php
			echo '<nav class="vx-pagination" aria-label="' . esc_attr__( 'Projects navigation', 'vertex' ) . '">';
			echo wp_kses_post(
				paginate_links(
					array(
						'total'     => $work->max_num_pages,
						'current'   => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
						'prev_text' => '←',
						'next_text' => '→',
					)
				)
			);
			echo '</nav>';
			?>
		<?php else : ?>
			<p class="text-center"><?php esc_html_e( 'No projects found in this category yet.', 'vertex' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>

	<?php
	// Show the page body content (if any) below the grid.
	if ( trim( get_the_content() ) ) :
		?>
		<div class="vx-container vx-section--tight vx-entry-content"><?php the_content(); ?></div>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/cta' ); ?>
</main>

<?php
get_footer();
