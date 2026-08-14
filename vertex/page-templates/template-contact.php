<?php
/**
 * Template Name: Contact (Dynamic)
 *
 * A contact page that pulls address, email and phone from the Customizer.
 *
 * @package Vertex
 */

get_header();

$email   = get_theme_mod( 'vertex_contact_email', 'hello@vertexstudio.com' );
$phone   = get_theme_mod( 'vertex_contact_phone', '+1 (555) 012-3456' );
$address = get_theme_mod( 'vertex_contact_address', '100 Market Street, Suite 400, San Francisco, CA' );

while ( have_posts() ) {
	the_post();
}
?>

<main id="primary" class="site-main">
	<section class="page-hero">
		<div class="vx-container page-hero__inner">
			<?php vertex_breadcrumbs(); ?>
			<span class="vx-eyebrow"><?php esc_html_e( 'Get in touch', 'vertex' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p><?php esc_html_e( 'Tell us about your project and we’ll get back to you within one business day.', 'vertex' ); ?></p>
		</div>
	</section>

	<div class="vx-container vx-section">
		<div class="vx-hero__inner" style="align-items:flex-start;">
			<div class="vx-reveal">
				<div class="vx-contact-detail"><span class="vx-service__icon"><?php vertex_icon( 'mail' ); ?></span><div><b><?php esc_html_e( 'Email', 'vertex' ); ?></b><br><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></div></div>
				<div class="vx-contact-detail"><span class="vx-service__icon"><?php vertex_icon( 'phone' ); ?></span><div><b><?php esc_html_e( 'Phone', 'vertex' ); ?></b><br><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></div></div>
				<div class="vx-contact-detail"><span class="vx-service__icon"><?php vertex_icon( 'map-pin' ); ?></span><div><b><?php esc_html_e( 'Studio', 'vertex' ); ?></b><br><?php echo nl2br( esc_html( $address ) ); ?></div></div>
				<?php if ( trim( get_the_content() ) ) : ?>
					<div class="vx-entry-content" style="margin-top:2rem;"><?php the_content(); ?></div>
				<?php endif; ?>
			</div>

			<div class="vx-card vx-reveal">
				<h3 style="margin-bottom:1.5rem;"><?php esc_html_e( 'Send us a message', 'vertex' ); ?></h3>
				<?php echo do_shortcode( '[contact-form-7]' ); // Renders if CF7 is present; otherwise falls through. ?>
				<form class="vx-contact-form" method="post" action="#" novalidate>
					<div class="vx-field"><label for="cf-name"><?php esc_html_e( 'Name', 'vertex' ); ?></label><input type="text" id="cf-name" name="name" required></div>
					<div class="vx-field"><label for="cf-email"><?php esc_html_e( 'Email', 'vertex' ); ?></label><input type="email" id="cf-email" name="email" required></div>
					<div class="vx-field"><label for="cf-message"><?php esc_html_e( 'Message', 'vertex' ); ?></label><textarea id="cf-message" name="message" required></textarea></div>
					<button type="submit" class="vx-btn vx-btn--primary vx-btn--lg vx-btn--block"><?php esc_html_e( 'Send Message', 'vertex' ); ?></button>
					<p style="font-size:0.85rem;color:var(--vx-text-muted);margin-top:1rem;"><?php esc_html_e( 'Connect a form plugin (Contact Form 7, WPForms) to receive submissions.', 'vertex' ); ?></p>
				</form>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
