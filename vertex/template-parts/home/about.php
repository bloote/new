<?php
/**
 * Home about / feature split section.
 *
 * @package Vertex
 */

$features = array(
	__( 'Pixel-perfect, responsive design on every device', 'vertex' ),
	__( 'Clean, documented code you actually own', 'vertex' ),
	__( 'Core Web Vitals & performance baked in', 'vertex' ),
	__( 'Accessible (WCAG) and SEO-ready from day one', 'vertex' ),
);
?>
<section class="vx-section" id="about">
	<div class="vx-container">
		<div class="vx-hero__inner" style="align-items:center;">
			<div class="vx-reveal">
				<span class="vx-eyebrow"><?php esc_html_e( 'Why Vertex', 'vertex' ); ?></span>
				<h2><?php echo esc_html( get_theme_mod( 'vertex_about_title', __( 'A partner obsessed with craft and results', 'vertex' ) ) ); ?></h2>
				<p class="vx-lead"><?php echo esc_html( get_theme_mod( 'vertex_about_text', __( 'We blend strategy, design, and engineering into one seamless team. No hand-offs, no surprises — just thoughtful work that ships on time and performs in the real world.', 'vertex' ) ) ); ?></p>
				<ul class="vx-check-list" style="list-style:none;padding:0;margin:2rem 0;">
					<?php foreach ( $features as $f ) : ?>
						<li style="display:flex;gap:0.7em;align-items:flex-start;padding:0.5em 0;font-weight:500;">
							<span style="color:var(--vx-accent-600);flex-shrink:0;"><?php vertex_icon( 'check' ); ?></span>
							<?php echo esc_html( $f ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
				<a class="vx-btn vx-btn--dark" href="<?php echo esc_url( vertex_get_page_url( 'about' ) ); ?>"><?php esc_html_e( 'More About Us', 'vertex' ); ?></a>
			</div>
			<div class="vx-reveal">
				<?php echo vertex_about_illustration(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>
</section>
