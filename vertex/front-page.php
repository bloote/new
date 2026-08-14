<?php
/**
 * The front page template.
 *
 * If a static front page is assigned and has content (e.g. built from the
 * bundled block patterns), that content is rendered so it stays fully editable
 * in the block editor. Otherwise a rich, coded homepage is assembled from the
 * theme's custom post types and Customizer settings.
 *
 * @package Vertex
 */

get_header();

$front_id      = (int) get_option( 'page_on_front' );
$has_page_body = $front_id && is_front_page() && ! is_home() && trim( get_post_field( 'post_content', $front_id ) ) !== '';

if ( $has_page_body ) :
	while ( have_posts() ) :
		the_post();
		?>
		<main id="primary" class="site-main">
			<article <?php post_class(); ?>>
				<div class="vx-entry-content"><?php the_content(); ?></div>
			</article>
		</main>
		<?php
	endwhile;
else :
	?>
	<main id="primary" class="site-main vx-home">
		<?php
		get_template_part( 'template-parts/home/hero' );
		get_template_part( 'template-parts/home/clients' );
		get_template_part( 'template-parts/home/services' );
		get_template_part( 'template-parts/home/about' );
		get_template_part( 'template-parts/home/work' );
		get_template_part( 'template-parts/home/process' );
		get_template_part( 'template-parts/home/stats' );
		get_template_part( 'template-parts/home/testimonials' );
		get_template_part( 'template-parts/home/team' );
		get_template_part( 'template-parts/home/blog' );
		get_template_part( 'template-parts/cta' );
		?>
	</main>
	<?php
endif;

get_footer();
