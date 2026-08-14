<?php
/**
 * Title: Page — Contact
 * Slug: vertex/page-contact
 * Categories: vertex-pages
 * Description: A complete Contact page with info and form.
 * Inserter: no
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<!-- wp:column {"width":"42%"} -->
<div class="wp-block-column" style="flex-basis:42%">
<!-- wp:paragraph {"style":{"typography":{"letterSpacing":"0.14em","textTransform":"uppercase","fontWeight":"600"}},"textColor":"primary","fontFamily":"mono","fontSize":"small"} -->
<p class="has-primary-color has-text-color has-mono-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.14em;text-transform:uppercase">Get in touch</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Let's start a conversation</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size">Tell us about your project, your goals, and your timeline. We'll get back to you within one business day.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<p style="margin-top:2rem"><strong>Email</strong><br>hello@vertexstudio.com</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><strong>Phone</strong><br>+1 (555) 012-3456</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><strong>Studio</strong><br>100 Market Street, Suite 400<br>San Francisco, CA 94105</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"58%","style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem","left":"2.5rem","right":"2.5rem"}},"border":{"radius":"22px","color":"#dde3ee","width":"1px"}},"backgroundColor":"base"} -->
<div class="wp-block-column has-border-color has-base-background-color has-background" style="border-color:#dde3ee;border-width:1px;border-radius:22px;padding:2.5rem;flex-basis:58%">
<!-- wp:html -->
<form class="vx-contact-form" method="post" action="#" novalidate>
	<div class="vx-field"><label for="cf-name">Name</label><input type="text" id="cf-name" name="name" placeholder="Jane Doe" required></div>
	<div class="vx-field"><label for="cf-email">Email</label><input type="email" id="cf-email" name="email" placeholder="jane@company.com" required></div>
	<div class="vx-field"><label for="cf-subject">Subject</label><input type="text" id="cf-subject" name="subject" placeholder="Project inquiry"></div>
	<div class="vx-field"><label for="cf-message">Message</label><textarea id="cf-message" name="message" placeholder="Tell us about your project…" required></textarea></div>
	<button type="submit" class="vx-btn vx-btn--primary vx-btn--lg vx-btn--block">Send Message</button>
	<p style="font-size:0.85rem;color:#6b7690;margin-top:1rem;">This is a demo form. Connect a plugin like Contact Form 7 or WPForms to receive submissions.</p>
</form>
<!-- /wp:html -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
