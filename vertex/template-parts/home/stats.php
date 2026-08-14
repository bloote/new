<?php
/**
 * Home stats band.
 *
 * @package Vertex
 */

$stats = array(
	array( get_theme_mod( 'vertex_stat_1_num', '250+' ), get_theme_mod( 'vertex_stat_1_label', __( 'Projects Delivered', 'vertex' ) ) ),
	array( get_theme_mod( 'vertex_stat_2_num', '98%' ), get_theme_mod( 'vertex_stat_2_label', __( 'Client Retention', 'vertex' ) ) ),
	array( get_theme_mod( 'vertex_stat_4_num', '40+' ), get_theme_mod( 'vertex_stat_4_label', __( 'Team Members', 'vertex' ) ) ),
	array( get_theme_mod( 'vertex_stat_3_num', '12yrs' ), get_theme_mod( 'vertex_stat_3_label', __( 'Of Experience', 'vertex' ) ) ),
);
?>
<section class="vx-section--sm vx-bg-alt">
	<div class="vx-container">
		<div class="vx-stats">
			<?php foreach ( $stats as $stat ) : ?>
				<div class="vx-stat vx-reveal">
					<b class="vx-gradient-text"><?php echo esc_html( $stat[0] ); ?></b>
					<span><?php echo esc_html( $stat[1] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
