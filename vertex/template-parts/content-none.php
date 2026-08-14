<?php
/**
 * Template part shown when no posts are found.
 *
 * @package Vertex
 */
?>
<div class="vx-no-results" style="text-align:center;padding:3rem 0;">
	<h2><?php esc_html_e( 'Nothing found here yet', 'vertex' ); ?></h2>
	<p class="vx-lead" style="margin:1rem auto 2rem;max-width:480px;"><?php esc_html_e( 'We couldn’t find any content matching your request. Try a different search or head back home.', 'vertex' ); ?></p>
	<div style="max-width:460px;margin:0 auto;"><?php get_search_form(); ?></div>
</div>
