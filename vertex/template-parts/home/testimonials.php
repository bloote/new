<?php
/**
 * Home testimonials section — pulls from vx_testimonial CPT.
 *
 * @package Vertex
 */

$q = new WP_Query(
	array(
		'post_type'      => 'vx_testimonial',
		'posts_per_page' => 3,
		'no_found_rows'  => true,
	)
);

$defaults = array(
	array( 'quote' => __( 'Vertex transformed our outdated site into a conversion machine. Sales are up 60% and the team is a genuine pleasure to work with.', 'vertex' ), 'name' => 'Sarah Chen', 'role' => __( 'CEO, Lumen Finance', 'vertex' ) ),
	array( 'quote' => __( 'The most professional, thoughtful, and talented studio we have ever partnered with. They just get it — design, code, and business.', 'vertex' ), 'name' => 'Marcus Reid', 'role' => __( 'Founder, Orbital', 'vertex' ) ),
	array( 'quote' => __( 'From strategy to launch, everything was seamless. Our new platform is fast, gorgeous, and our customers love it. Highly recommended.', 'vertex' ), 'name' => 'Priya Nair', 'role' => __( 'CMO, Vireo Health', 'vertex' ) ),
);
?>
<section class="vx-section" id="testimonials">
	<div class="vx-container">
		<div class="vx-section-head vx-section-head--center">
			<span class="vx-eyebrow"><?php esc_html_e( 'Testimonials', 'vertex' ); ?></span>
			<h2><?php esc_html_e( 'Loved by clients worldwide', 'vertex' ); ?></h2>
		</div>
		<div class="vx-grid vx-grid--3">
			<?php if ( $q->have_posts() ) : ?>
				<?php
				while ( $q->have_posts() ) :
					$q->the_post();
					$name = get_the_title();
					$role = get_post_meta( get_the_ID(), '_vx_role', true );
					?>
					<figure class="vx-testimonial vx-reveal">
						<div class="vx-testimonial__stars">★★★★★</div>
						<blockquote class="vx-testimonial__quote" style="border:0;background:none;padding:0;margin:0 0 1.5rem;font-style:normal;"><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></blockquote>
						<figcaption class="vx-testimonial__author">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'thumbnail' );
							} else {
								echo vertex_avatar_placeholder( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							}
							?>
							<span><b><?php echo esc_html( $name ); ?></b><span><?php echo esc_html( $role ); ?></span></span>
						</figcaption>
					</figure>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $defaults as $t ) : ?>
					<figure class="vx-testimonial vx-reveal">
						<div class="vx-testimonial__stars">★★★★★</div>
						<blockquote class="vx-testimonial__quote" style="border:0;background:none;padding:0;margin:0 0 1.5rem;font-style:normal;"><?php echo esc_html( $t['quote'] ); ?></blockquote>
						<figcaption class="vx-testimonial__author">
							<?php echo vertex_avatar_placeholder( $t['name'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<span><b><?php echo esc_html( $t['name'] ); ?></b><span><?php echo esc_html( $t['role'] ); ?></span></span>
						</figcaption>
					</figure>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
