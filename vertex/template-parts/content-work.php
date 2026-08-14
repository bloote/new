<?php
/**
 * Template part for a portfolio project card (archive).
 *
 * @package Vertex
 */
?>
<a class="vx-work vx-reveal" href="<?php the_permalink(); ?>">
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
