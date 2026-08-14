<?php
/**
 * Template part for a blog post card.
 *
 * @package Vertex
 */
?>
<article <?php post_class( 'vx-post vx-reveal' ); ?>>
	<a class="vx-post__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'vertex-post' );
		} else {
			echo vertex_post_placeholder( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</a>
	<div class="vx-post__body">
		<?php $cat = get_the_category(); if ( $cat ) : ?>
			<a class="vx-post__cat" href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>"><?php echo esc_html( $cat[0]->name ); ?></a>
		<?php endif; ?>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
		<div class="vx-post__foot">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 32, '', '', array( 'class' => 'vx-post__avatar' ) ); ?>
			<span><?php the_author(); ?></span>
			<span aria-hidden="true">·</span>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</div>
	</div>
</article>
