<?php
/**
 * Reusable call-to-action band.
 *
 * @package Vertex
 */

$title = get_theme_mod( 'vertex_cta_title', __( 'Ready to build something great?', 'vertex' ) );
$text  = get_theme_mod( 'vertex_cta_text', __( 'Tell us about your project and let’s turn your idea into a product people love.', 'vertex' ) );
$btn   = get_theme_mod( 'vertex_cta_btn_text', __( 'Start Your Project', 'vertex' ) );
$url   = get_theme_mod( 'vertex_cta_btn_url', '' );
$url   = $url ? $url : vertex_get_page_url( 'contact' );
?>
<section class="vx-section" id="contact-cta">
	<div class="vx-container">
		<div class="vx-cta vx-reveal">
			<h2><?php echo esc_html( $title ); ?></h2>
			<p><?php echo esc_html( $text ); ?></p>
			<a class="vx-btn vx-btn--light vx-btn--lg" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $btn ); ?> <?php vertex_icon( 'arrow-right' ); ?></a>
		</div>
	</div>
</section>
