<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Vertex
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="vx-section" style="text-align:center;">
		<div class="vx-container vx-container--narrow">
			<div class="vx-gradient-text" style="font-family:var(--vx-font-head);font-weight:800;font-size:clamp(6rem,20vw,12rem);line-height:1;">404</div>
			<h1><?php esc_html_e( 'This page took a creative detour.', 'vertex' ); ?></h1>
			<p class="vx-lead" style="margin:1rem auto 2rem;max-width:520px;"><?php esc_html_e( 'The page you are looking for could not be found. Let’s get you back to something great.', 'vertex' ); ?></p>
			<div class="vx-actions-row" style="justify-content:center;">
				<a class="vx-btn vx-btn--primary vx-btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'vertex' ); ?></a>
			</div>
			<div style="max-width:480px;margin:3rem auto 0;"><?php get_search_form(); ?></div>
		</div>
	</section>
</main>

<?php
get_footer();
