<?php
/**
 * Home selected work section — pulls from the vx_work CPT.
 *
 * @package Vertex
 */

$work = new WP_Query(
	array(
		'post_type'      => 'vx_work',
		'posts_per_page' => 6,
		'no_found_rows'  => true,
	)
);

$defaults = array(
	array( 'cat' => 'Web Design', 'title' => 'Lumen Finance Platform', 'img' => 1 ),
	array( 'cat' => 'Branding', 'title' => 'Vireo Health Rebrand', 'img' => 2 ),
	array( 'cat' => 'E-Commerce', 'title' => 'Halcyon Fashion Store', 'img' => 3 ),
	array( 'cat' => 'App Design', 'title' => 'Orbital Travel App', 'img' => 4 ),
	array( 'cat' => 'Development', 'title' => 'Beacon SaaS Dashboard', 'img' => 5 ),
	array( 'cat' => 'Web Design', 'title' => 'Pinnacle Agency Site', 'img' => 6 ),
);
?>
<section class="vx-section vx-bg-ink" id="work">
	<div class="vx-container">
		<div class="vx-section-head" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:1rem;max-width:100%;">
			<div>
				<span class="vx-eyebrow" style="color:var(--vx-accent);"><?php esc_html_e( 'Selected Work', 'vertex' ); ?></span>
				<h2 style="color:#fff;"><?php echo esc_html( get_theme_mod( 'vertex_work_title', __( 'Recent projects we’re proud of', 'vertex' ) ) ); ?></h2>
			</div>
			<a class="vx-btn vx-btn--light" href="<?php echo esc_url( vertex_get_page_url( 'portfolio', get_post_type_archive_link( 'vx_work' ) ) ); ?>"><?php esc_html_e( 'View All Projects', 'vertex' ); ?></a>
		</div>

		<div class="vx-grid vx-grid--3">
			<?php if ( $work->have_posts() ) : ?>
				<?php
				while ( $work->have_posts() ) :
					$work->the_post();
					?>
					<a class="vx-work" href="<?php the_permalink(); ?>">
						<div class="vx-work__media">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'vertex-work' );
							} else {
								echo vertex_work_placeholder( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							?>
						</div>
						<div class="vx-work__overlay">
							<span class="vx-work__cat"><?php echo esc_html( vertex_get_terms_list( get_the_ID(), 'vx_work_cat' ) ); ?></span>
							<span class="vx-work__title"><?php the_title(); ?></span>
						</div>
						<span class="vx-work__arrow"><?php vertex_icon( 'arrow-up-right' ); ?></span>
					</a>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $defaults as $i => $w ) : ?>
					<div class="vx-work">
						<div class="vx-work__media"><?php echo vertex_work_placeholder( $w['img'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<div class="vx-work__overlay">
							<span class="vx-work__cat"><?php echo esc_html( $w['cat'] ); ?></span>
							<span class="vx-work__title"><?php echo esc_html( $w['title'] ); ?></span>
						</div>
						<span class="vx-work__arrow"><?php vertex_icon( 'arrow-up-right' ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
