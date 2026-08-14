<?php
/**
 * Home team section — pulls from vx_team CPT.
 *
 * @package Vertex
 */

$q = new WP_Query(
	array(
		'post_type'      => 'vx_team',
		'posts_per_page' => 4,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

$defaults = array(
	array( 'name' => 'Alex Morgan', 'role' => __( 'Founder & Creative Director', 'vertex' ) ),
	array( 'name' => 'Jordan Blake', 'role' => __( 'Lead Developer', 'vertex' ) ),
	array( 'name' => 'Maya Patel', 'role' => __( 'Senior Product Designer', 'vertex' ) ),
	array( 'name' => 'Leo Fischer', 'role' => __( 'Head of Strategy', 'vertex' ) ),
);
?>
<section class="vx-section vx-bg-alt" id="team">
	<div class="vx-container">
		<div class="vx-section-head vx-section-head--center">
			<span class="vx-eyebrow"><?php esc_html_e( 'Our Team', 'vertex' ); ?></span>
			<h2><?php esc_html_e( 'The people behind the pixels', 'vertex' ); ?></h2>
		</div>
		<div class="vx-grid vx-grid--4">
			<?php if ( $q->have_posts() ) : ?>
				<?php
				while ( $q->have_posts() ) :
					$q->the_post();
					$role = get_post_meta( get_the_ID(), '_vx_role', true );
					?>
					<div class="vx-team vx-reveal">
						<div class="vx-team__photo">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'vertex-team' );
							} else {
								echo vertex_avatar_placeholder( get_the_title(), 480 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							?>
						</div>
						<h3><?php the_title(); ?></h3>
						<span class="vx-team__role"><?php echo esc_html( $role ); ?></span>
						<div class="vx-team__social">
							<a href="#" aria-label="Twitter"><?php vertex_icon( 'twitter' ); ?></a>
							<a href="#" aria-label="LinkedIn"><?php vertex_icon( 'linkedin' ); ?></a>
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $defaults as $m ) : ?>
					<div class="vx-team vx-reveal">
						<div class="vx-team__photo"><?php echo vertex_avatar_placeholder( $m['name'], 480 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
						<h3><?php echo esc_html( $m['name'] ); ?></h3>
						<span class="vx-team__role"><?php echo esc_html( $m['role'] ); ?></span>
						<div class="vx-team__social">
							<a href="#" aria-label="Twitter"><?php vertex_icon( 'twitter' ); ?></a>
							<a href="#" aria-label="LinkedIn"><?php vertex_icon( 'linkedin' ); ?></a>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
