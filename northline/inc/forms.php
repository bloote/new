<?php
/**
 * The site's forms: markup, validation, delivery.
 *
 * Everything is handled in WordPress — no third-party endpoint, no bundled
 * analytics, and no JavaScript required to submit. Submissions are emailed to
 * the site's admin address and stored as a private `nl_enquiry` post so
 * nothing is lost if mail fails.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Field definitions for each form variant.
 *
 * @return array
 */
function northline_form_schema() {
	return array(
		'contact'    => array(
			'title'  => __( 'Project enquiry', 'northline' ),
			'submit' => __( 'Send enquiry', 'northline' ),
			'note'   => __( 'We reply within two working days. Nothing you send is shared or added to a mailing list.', 'northline' ),
			'fields' => array(
				'name'    => array( 'label' => __( 'Your name', 'northline' ), 'type' => 'text', 'required' => true, 'placeholder' => 'Alex Mercer', 'width' => 'half' ),
				'company' => array( 'label' => __( 'Company', 'northline' ), 'type' => 'text', 'placeholder' => 'Mercer & Partners', 'width' => 'half' ),
				'email'   => array( 'label' => __( 'Email', 'northline' ), 'type' => 'email', 'required' => true, 'placeholder' => 'alex@company.com', 'width' => 'half' ),
				'website' => array( 'label' => __( 'Current site', 'northline' ), 'type' => 'url', 'placeholder' => 'company.com', 'width' => 'half' ),
				'need'    => array(
					'label'   => __( 'What do you need?', 'northline' ),
					'type'    => 'choice',
					'options' => array( 'New site', 'Redesign', 'Headless build', 'Commerce', 'Care plan', 'Not sure yet' ),
				),
				'budget'  => array(
					'label'   => __( 'Budget band', 'northline' ),
					'type'    => 'radio',
					'options' => array( 'Under £10k', '£10k–£30k', '£30k–£70k', '£70k+' ),
				),
				'timing'  => array( 'label' => __( 'When does it need to be live?', 'northline' ), 'type' => 'text', 'placeholder' => __( 'e.g. before the September conference', 'northline' ) ),
				'message' => array( 'label' => __( 'Tell us about the project', 'northline' ), 'type' => 'textarea', 'required' => true, 'placeholder' => __( 'What the site needs to do, who it is for, and anything that has already been decided.', 'northline' ) ),
			),
		),
		'order'      => array(
			'title'  => __( 'Custom order', 'northline' ),
			'submit' => __( 'Request a quote', 'northline' ),
			'note'   => __( 'Quotes are free and come back within two working days. We will sign your NDA if you need one.', 'northline' ),
			'fields' => array(
				'order'   => array(
					'label'   => __( 'What are you ordering?', 'northline' ),
					'type'    => 'choice',
					'options' => array( 'Custom theme', 'Custom plugin', 'Script or widget', 'Internal tool', 'Theme customisation', 'Migration' ),
				),
				'name'    => array( 'label' => __( 'Your name', 'northline' ), 'type' => 'text', 'required' => true, 'placeholder' => 'Alex Mercer', 'width' => 'half' ),
				'email'   => array( 'label' => __( 'Email', 'northline' ), 'type' => 'email', 'required' => true, 'placeholder' => 'alex@company.com', 'width' => 'half' ),
				'website' => array( 'label' => __( 'Site it is for', 'northline' ), 'type' => 'url', 'placeholder' => 'company.com', 'width' => 'half' ),
				'timing'  => array( 'label' => __( 'Needed by', 'northline' ), 'type' => 'text', 'placeholder' => __( 'e.g. mid October', 'northline' ), 'width' => 'half' ),
				'budget'  => array(
					'label'   => __( 'Budget band', 'northline' ),
					'type'    => 'radio',
					'options' => array( 'Under £1k', '£1k–£3k', '£3k–£8k', '£8k+' ),
				),
				'message' => array( 'label' => __( 'The brief', 'northline' ), 'type' => 'textarea', 'required' => true, 'placeholder' => __( 'What it needs to do, who uses it, what happens today instead, and anything that is already decided.', 'northline' ) ),
				'links'   => array( 'label' => __( 'Links or references', 'northline' ), 'type' => 'text', 'placeholder' => __( 'Figma, a repo, or a product that does something similar', 'northline' ) ),
			),
		),
		'newsletter' => array(
			'title'  => __( 'Journal subscription', 'northline' ),
			'submit' => __( 'Subscribe', 'northline' ),
			'note'   => '',
			'inline' => true,
			'fields' => array(
				'email' => array( 'label' => __( 'Email', 'northline' ), 'type' => 'email', 'required' => true, 'placeholder' => 'you@company.com' ),
			),
		),
	);
}

/**
 * Collected errors and the values to repopulate after a failed submission.
 *
 * @return array
 */
function &northline_form_state() {
	static $state = array(
		'errors' => array(),
		'values' => array(),
		'sent'   => '',
	);
	return $state;
}

/**
 * Validate and deliver a submission before anything is rendered.
 */
function northline_handle_form() {
	if ( empty( $_POST['nl_form'] ) ) {
		return;
	}

	$variant = sanitize_key( wp_unslash( $_POST['nl_form'] ) );
	$schema  = northline_form_schema();

	if ( ! isset( $schema[ $variant ] ) ) {
		return;
	}

	$state = &northline_form_state();

	// Honeypot: a real person never fills a field they cannot see.
	if ( ! empty( $_POST['nl_website_url'] ) ) {
		$state['errors'][] = __( 'That submission looked automated. Please try again.', 'northline' );
		return;
	}

	if ( ! isset( $_POST['nl_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nl_nonce'] ) ), 'nl_form_' . $variant ) ) {
		$state['errors'][] = __( 'This form expired before it was sent. Please try again.', 'northline' );
		return;
	}

	$values = array();
	foreach ( $schema[ $variant ]['fields'] as $key => $field ) {
		$raw = isset( $_POST[ 'nl_' . $key ] ) ? wp_unslash( $_POST[ 'nl_' . $key ] ) : '';

		if ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} elseif ( 'email' === $field['type'] ) {
			$value = sanitize_email( $raw );
		} elseif ( 'url' === $field['type'] ) {
			$value = sanitize_text_field( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}

		if ( ! empty( $field['required'] ) && '' === $value ) {
			/* translators: %s: field label. */
			$state['errors'][] = sprintf( __( '%s is required.', 'northline' ), $field['label'] );
		}

		if ( 'email' === $field['type'] && '' !== $value && ! is_email( $value ) ) {
			$state['errors'][] = __( 'That email address does not look right.', 'northline' );
		}

		$values[ $key ] = $value;
	}

	$state['values'] = $values;

	if ( ! empty( $state['errors'] ) ) {
		return;
	}

	northline_store_enquiry( $variant, $schema[ $variant ], $values );
	northline_mail_enquiry( $variant, $schema[ $variant ], $values );

	$redirect = add_query_arg( 'nl-sent', $variant, wp_get_referer() ? wp_get_referer() : home_url( add_query_arg( array() ) ) );
	wp_safe_redirect( remove_query_arg( 'nl-error', $redirect ) );
	exit;
}
add_action( 'template_redirect', 'northline_handle_form', 5 );

/**
 * Keep a private copy of every submission, so a mail failure is not a lost lead.
 *
 * @param string $variant Form variant.
 * @param array  $schema  Variant schema.
 * @param array  $values  Submitted values.
 */
function northline_store_enquiry( $variant, $schema, $values ) {
	$lines = array();
	foreach ( $schema['fields'] as $key => $field ) {
		if ( '' === ( $values[ $key ] ?? '' ) ) {
			continue;
		}
		$lines[] = $field['label'] . ': ' . $values[ $key ];
	}

	wp_insert_post(
		array(
			'post_type'    => 'nl_enquiry',
			'post_status'  => 'private',
			'post_title'   => sprintf(
				'%s — %s',
				$schema['title'],
				$values['name'] ?? ( $values['email'] ?? __( 'anonymous', 'northline' ) )
			),
			'post_content' => implode( "\n", $lines ),
		)
	);
}

/**
 * A quiet, private post type to hold submissions.
 */
function northline_register_enquiry_type() {
	register_post_type(
		'nl_enquiry',
		array(
			'labels'          => array(
				'name'          => __( 'Enquiries', 'northline' ),
				'singular_name' => __( 'Enquiry', 'northline' ),
				'menu_name'     => __( 'Enquiries', 'northline' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 26,
			'capability_type' => 'post',
			'capabilities'    => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap'    => true,
			'supports'        => array( 'title', 'editor' ),
		)
	);
}
add_action( 'init', 'northline_register_enquiry_type' );

/**
 * Email the submission to the site address.
 *
 * @param string $variant Form variant.
 * @param array  $schema  Variant schema.
 * @param array  $values  Submitted values.
 */
function northline_mail_enquiry( $variant, $schema, $values ) {
	$to      = apply_filters( 'northline_enquiry_recipient', get_option( 'admin_email' ), $variant );
	$subject = sprintf(
		/* translators: 1: form name, 2: site name. */
		__( '[%2$s] %1$s', 'northline' ),
		$schema['title'],
		get_bloginfo( 'name' )
	);

	$body = array();
	foreach ( $schema['fields'] as $key => $field ) {
		$body[] = $field['label'] . ': ' . ( '' !== ( $values[ $key ] ?? '' ) ? $values[ $key ] : '—' );
	}
	$body[] = '';
	$body[] = __( 'Sent from', 'northline' ) . ': ' . home_url( '/' );

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( ! empty( $values['email'] ) && is_email( $values['email'] ) ) {
		$headers[] = 'Reply-To: ' . $values['email'];
	}

	wp_mail( $to, $subject, implode( "\n", $body ), $headers );
}

/**
 * Print a form.
 *
 * @param string $variant Form variant.
 */
function northline_form_markup( $variant ) {
	$schema = northline_form_schema();

	if ( ! isset( $schema[ $variant ] ) ) {
		return;
	}

	$config = $schema[ $variant ];
	$state  = northline_form_state();
	$sent   = isset( $_GET['nl-sent'] ) ? sanitize_key( wp_unslash( $_GET['nl-sent'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only display flag.
	$values = $state['values'];

	if ( $sent === $variant ) {
		printf(
			'<p class="nl-form-message">%s</p>',
			esc_html__( 'Thank you — that is with us. We reply within two working days.', 'northline' )
		);
	}

	if ( ! empty( $state['errors'] ) ) {
		echo '<div class="nl-form-message is-error"><ul class="nl-form-errors">';
		foreach ( array_unique( $state['errors'] ) as $error ) {
			printf( '<li>%s</li>', esc_html( $error ) );
		}
		echo '</ul></div>';
	}

	$inline = ! empty( $config['inline'] );
	printf(
		'<form class="nl-form%s" method="post" action="%s">',
		$inline ? ' is-inline' : '',
		esc_url( home_url( add_query_arg( array() ) ) )
	);

	wp_nonce_field( 'nl_form_' . $variant, 'nl_nonce' );
	printf( '<input type="hidden" name="nl_form" value="%s">', esc_attr( $variant ) );

	echo '<div class="nl-honeypot" aria-hidden="true">';
	echo '<label for="nl_website_url_' . esc_attr( $variant ) . '">' . esc_html__( 'Leave this field empty', 'northline' ) . '</label>';
	echo '<input type="text" id="nl_website_url_' . esc_attr( $variant ) . '" name="nl_website_url" tabindex="-1" autocomplete="off">';
	echo '</div>';

	$pending_half = array();

	$flush_half = function () use ( &$pending_half ) {
		if ( count( $pending_half ) < 1 ) {
			return;
		}
		echo '<div class="nl-form-row">';
		foreach ( $pending_half as $markup ) {
			echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built below with escaping.
		}
		echo '</div>';
		$pending_half = array();
	};

	foreach ( $config['fields'] as $key => $field ) {
		$id      = 'nl-' . $variant . '-' . $key;
		$name    = 'nl_' . $key;
		$value   = $values[ $key ] ?? '';
		$req     = ! empty( $field['required'] );
		$markup  = '';

		if ( 'choice' === $field['type'] || 'radio' === $field['type'] ) {
			$flush_half();
			$class  = 'choice' === $field['type'] ? 'nl-choice-row' : 'nl-radio-row';
			echo '<fieldset class="nl-field">';
			printf( '<legend>%s</legend>', esc_html( $field['label'] ) );
			printf( '<div class="%s">', esc_attr( $class ) );
			foreach ( $field['options'] as $index => $option ) {
				printf(
					'<label for="%1$s-%2$d"><input type="radio" id="%1$s-%2$d" name="%3$s" value="%4$s"%5$s><span>%4$s</span></label>',
					esc_attr( $id ),
					(int) $index,
					esc_attr( $name ),
					esc_html( $option ),
					checked( $value, $option, false )
				);
			}
			echo '</div></fieldset>';
			continue;
		}

		if ( 'textarea' === $field['type'] ) {
			$flush_half();
			$markup .= '<div class="nl-field">';
			$markup .= sprintf( '<label for="%s">%s</label>', esc_attr( $id ), esc_html( $field['label'] ) );
			$markup .= sprintf(
				'<textarea id="%s" name="%s" placeholder="%s"%s>%s</textarea>',
				esc_attr( $id ),
				esc_attr( $name ),
				esc_attr( $field['placeholder'] ?? '' ),
				$req ? ' required' : '',
				esc_textarea( $value )
			);
			$markup .= '</div>';
			echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
			continue;
		}

		$markup .= '<div class="nl-field">';
		if ( ! $inline ) {
			$markup .= sprintf( '<label for="%s">%s</label>', esc_attr( $id ), esc_html( $field['label'] ) );
		} else {
			$markup .= sprintf( '<label class="nl-screen-reader-text" for="%s">%s</label>', esc_attr( $id ), esc_html( $field['label'] ) );
		}
		$markup .= sprintf(
			'<input type="%s" id="%s" name="%s" value="%s" placeholder="%s"%s>',
			esc_attr( $field['type'] ),
			esc_attr( $id ),
			esc_attr( $name ),
			esc_attr( $value ),
			esc_attr( $field['placeholder'] ?? '' ),
			$req ? ' required' : ''
		);
		$markup .= '</div>';

		if ( ! empty( $field['width'] ) && 'half' === $field['width'] ) {
			$pending_half[] = $markup;
			if ( 2 === count( $pending_half ) ) {
				$flush_half();
			}
			continue;
		}

		$flush_half();
		echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
	}

	$flush_half();

	echo '<div class="nl-form-actions">';
	printf( '<button type="submit">%s</button>', esc_html( $config['submit'] ) );
	if ( ! empty( $config['note'] ) ) {
		printf( '<span class="nl-form-note">%s</span>', esc_html( $config['note'] ) );
	}
	echo '</div>';

	echo '</form>';
}
