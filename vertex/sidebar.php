<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Vertex
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area vx-sidebar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
