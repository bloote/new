<?php
/**
 * Template part for a service card (archive).
 *
 * @package Vertex
 */

$icon = get_post_meta( get_the_ID(), '_vx_icon', true );
$icon = $icon ? $icon : 'code';
?>
<a class="vx-card vx-service vx-reveal" href="<?php the_permalink(); ?>">
	<div class="vx-service__icon"><?php vertex_icon( $icon ); ?></div>
	<h3><?php the_title(); ?></h3>
	<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
	<span class="vx-service__link"><?php esc_html_e( 'Learn more', 'vertex' ); ?></span>
</a>
