<?php
/**
 * The template for displaying comments.
 *
 * @package Vertex
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$count = get_comments_number();
			if ( '1' === $count ) {
				esc_html_e( 'One Comment', 'vertex' );
			} else {
				/* translators: %s: comment count. */
				printf( esc_html( _n( '%s Comment', '%s Comments', $count, 'vertex' ) ), number_format_i18n( $count ) );
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( '← Older comments', 'vertex' ),
				'next_text' => esc_html__( 'Newer comments →', 'vertex' ),
			)
		);
	endif;

	if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'vertex' ); ?></p>
	<?php endif;

	comment_form(
		array(
			'title_reply'        => esc_html__( 'Join the conversation', 'vertex' ),
			'class_submit'       => 'vx-btn vx-btn--primary',
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h3>',
		)
	);
	?>
</div>
