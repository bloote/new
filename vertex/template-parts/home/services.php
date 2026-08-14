<?php
/**
 * Home services section — pulls from the vx_service CPT, with defaults.
 *
 * @package Vertex
 */

$services = new WP_Query(
	array(
		'post_type'      => 'vx_service',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

$defaults = array(
	array( 'icon' => 'layout', 'title' => __( 'UI/UX Design', 'vertex' ), 'text' => __( 'Human-centered interfaces and design systems that are beautiful, usable, and built to convert.', 'vertex' ) ),
	array( 'icon' => 'code', 'title' => __( 'Web Development', 'vertex' ), 'text' => __( 'Fast, accessible, and scalable websites built with modern frameworks and clean, maintainable code.', 'vertex' ) ),
	array( 'icon' => 'mobile', 'title' => __( 'App Development', 'vertex' ), 'text' => __( 'Native and cross-platform mobile apps engineered for performance and delightful experiences.', 'vertex' ) ),
	array( 'icon' => 'brand', 'title' => __( 'Brand Identity', 'vertex' ), 'text' => __( 'Distinctive brand systems — logos, guidelines, and visual language that make you unforgettable.', 'vertex' ) ),
	array( 'icon' => 'seo', 'title' => __( 'SEO & Growth', 'vertex' ), 'text' => __( 'Data-driven optimization and content strategy that drives traffic, leads, and measurable growth.', 'vertex' ) ),
	array( 'icon' => 'cart', 'title' => __( 'E-Commerce', 'vertex' ), 'text' => __( 'Conversion-focused online stores on WooCommerce and Shopify that turn browsers into buyers.', 'vertex' ) ),
);
?>
<section class="vx-section vx-bg-alt" id="services">
	<div class="vx-container">
		<div class="vx-section-head vx-section-head--center">
			<span class="vx-eyebrow"><?php esc_html_e( 'What We Do', 'vertex' ); ?></span>
			<h2><?php echo esc_html( get_theme_mod( 'vertex_services_title', __( 'Services built to move the needle', 'vertex' ) ) ); ?></h2>
			<p class="vx-lead"><?php esc_html_e( 'From first sketch to final deploy, we cover the full digital product lifecycle under one roof.', 'vertex' ); ?></p>
		</div>

		<div class="vx-grid vx-grid--3">
			<?php if ( $services->have_posts() ) : ?>
				<?php
				while ( $services->have_posts() ) :
					$services->the_post();
					$icon = get_post_meta( get_the_ID(), '_vx_icon', true );
					$icon = $icon ? $icon : 'code';
					?>
					<a class="vx-card vx-service" href="<?php the_permalink(); ?>">
						<div class="vx-service__icon"><?php vertex_icon( $icon ); ?></div>
						<h3><?php the_title(); ?></h3>
						<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
						<span class="vx-service__link"><?php esc_html_e( 'Learn more', 'vertex' ); ?></span>
					</a>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php else : ?>
				<?php foreach ( $defaults as $s ) : ?>
					<div class="vx-card vx-service">
						<div class="vx-service__icon"><?php vertex_icon( $s['icon'] ); ?></div>
						<h3><?php echo esc_html( $s['title'] ); ?></h3>
						<p><?php echo esc_html( $s['text'] ); ?></p>
						<span class="vx-service__link"><?php esc_html_e( 'Learn more', 'vertex' ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
