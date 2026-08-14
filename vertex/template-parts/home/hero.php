<?php
/**
 * Home hero section.
 *
 * @package Vertex
 */

$title    = get_theme_mod( 'vertex_hero_title', __( 'We design & build digital products that grow brands.', 'vertex' ) );
$text     = get_theme_mod( 'vertex_hero_text', __( 'Vertex is a full-service web design and development studio. We craft high-performance websites, apps, and brands for ambitious teams around the world.', 'vertex' ) );
$btn1_txt = get_theme_mod( 'vertex_hero_btn1_text', __( 'Start a Project', 'vertex' ) );
$btn1_url = get_theme_mod( 'vertex_hero_btn1_url', '#contact' );
$btn2_txt = get_theme_mod( 'vertex_hero_btn2_text', __( 'View Our Work', 'vertex' ) );
$btn2_url = get_theme_mod( 'vertex_hero_btn2_url', '#work' );
?>
<section class="vx-hero">
	<div class="vx-hero__grid" aria-hidden="true"></div>
	<div class="vx-container vx-hero__inner">
		<div class="vx-hero__content vx-reveal">
			<span class="vx-eyebrow" style="color:var(--vx-accent);"><?php esc_html_e( 'Design · Development · Strategy', 'vertex' ); ?></span>
			<h1 class="vx-hero__title"><?php echo wp_kses_post( $title ); ?></h1>
			<p class="vx-hero__text"><?php echo esc_html( $text ); ?></p>
			<div class="vx-hero__actions">
				<?php if ( $btn1_txt ) : ?>
					<a class="vx-btn vx-btn--primary vx-btn--lg" href="<?php echo esc_url( $btn1_url ); ?>"><?php echo esc_html( $btn1_txt ); ?> <?php vertex_icon( 'arrow-right' ); ?></a>
				<?php endif; ?>
				<?php if ( $btn2_txt ) : ?>
					<a class="vx-btn vx-btn--light vx-btn--lg" href="<?php echo esc_url( $btn2_url ); ?>"><?php echo esc_html( $btn2_txt ); ?></a>
				<?php endif; ?>
			</div>
			<div class="vx-hero__badges">
				<div class="vx-hero__badge"><b><?php echo esc_html( get_theme_mod( 'vertex_stat_1_num', '250+' ) ); ?></b><span><?php echo esc_html( get_theme_mod( 'vertex_stat_1_label', __( 'Projects Delivered', 'vertex' ) ) ); ?></span></div>
				<div class="vx-hero__badge"><b><?php echo esc_html( get_theme_mod( 'vertex_stat_2_num', '98%' ) ); ?></b><span><?php echo esc_html( get_theme_mod( 'vertex_stat_2_label', __( 'Client Retention', 'vertex' ) ) ); ?></span></div>
				<div class="vx-hero__badge"><b><?php echo esc_html( get_theme_mod( 'vertex_stat_3_num', '12yrs' ) ); ?></b><span><?php echo esc_html( get_theme_mod( 'vertex_stat_3_label', __( 'In Business', 'vertex' ) ) ); ?></span></div>
			</div>
		</div>
		<div class="vx-hero__visual vx-reveal">
			<?php
			$hero_img = get_theme_mod( 'vertex_hero_image', '' );
			if ( $hero_img ) {
				printf( '<img class="vx-visual-card vx-float" src="%s" alt="%s">', esc_url( $hero_img ), esc_attr__( 'Studio showcase', 'vertex' ) );
			} else {
				echo vertex_hero_illustration(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted inline SVG.
			}
			?>
		</div>
	</div>
</section>
