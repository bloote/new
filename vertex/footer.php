<?php
/**
 * The template for displaying the footer.
 *
 * @package Vertex
 */
?>
</div><!-- #content -->

<footer id="colophon" class="site-footer">
	<div class="vx-container">

		<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
			<div class="vx-footer-top">
				<div class="vx-footer-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php vertex_logo_mark( true ); ?> <span><?php bloginfo( 'name' ); ?></span></a></p>
					<?php endif; ?>
					<p><?php echo esc_html( get_theme_mod( 'vertex_footer_tagline', get_bloginfo( 'description' ) ) ); ?></p>
					<?php vertex_social_links(); ?>
				</div>

				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<div class="vx-footer-col">
						<?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
							<?php dynamic_sidebar( 'footer-' . $i ); ?>
						<?php endif; ?>
					</div>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<div class="vx-footer-bottom">
			<p class="vx-footer-copy">
				<?php
				$copyright = get_theme_mod( 'vertex_footer_copyright', '' );
				if ( $copyright ) {
					echo wp_kses_post( $copyright );
				} else {
					/* translators: 1: year, 2: site name. */
					printf( esc_html__( '© %1$s %2$s. Crafted with care.', 'vertex' ), esc_html( gmdate( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
				}
				?>
			</p>

			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => 'nav',
						'container_class' => 'vx-footer-nav',
						'depth'          => 1,
						'menu_class'     => 'vx-footer-menu',
					)
				);
			}
			?>
		</div>
	</div>
</footer>

<button class="vx-to-top" data-to-top aria-label="<?php esc_attr_e( 'Back to top', 'vertex' ); ?>">
	<?php vertex_icon( 'arrow-up' ); ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
