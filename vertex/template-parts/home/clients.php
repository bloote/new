<?php
/**
 * Home client logo marquee.
 *
 * @package Vertex
 */

$clients = array( 'Northwind', 'Lumen', 'Quantic', 'Vireo', 'Halcyon', 'Beacon', 'Orbital', 'Pinnacle' );
?>
<section class="vx-section--tight" aria-label="<?php esc_attr_e( 'Trusted by', 'vertex' ); ?>">
	<div class="vx-container">
		<p class="text-center vx-lead" style="font-size:var(--vx-fs-sm);text-transform:uppercase;letter-spacing:0.12em;margin-bottom:1.5rem;"><?php esc_html_e( 'Trusted by teams at leading companies', 'vertex' ); ?></p>
	</div>
	<div class="vx-marquee">
		<div class="vx-marquee__track">
			<?php
			// Duplicate the list so the marquee loops seamlessly.
			foreach ( array_merge( $clients, $clients ) as $client ) {
				echo vertex_client_logo( $client ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
	</div>
</section>
