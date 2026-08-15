<?php
/**
 * Copying the bundled images into the media library.
 *
 * Every picture the demo site uses ships with the theme, so the import needs
 * no network access. Each attachment records the file it came from, which is
 * how patterns find the library copy afterwards — and how an uninstall knows
 * exactly what to remove.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/**
 * Alt text for each bundled image, so the demo site is not full of blanks.
 *
 * @return array
 */
function northline_demo_media_manifest() {
	return array(
		'hero-studio.jpg'                  => 'Blueprint plate standing in for a photograph of the studio at work',
		'studio-room.jpg'                  => 'Isometric blueprint of the studio floor',
		'project-northgate-health.jpg'     => 'Wireframe of the rebuilt Northgate Health treatment template',
		'project-fieldnote.jpg'            => 'Contour drawing standing in for the Fieldnote editorial platform',
		'project-kelso-rail.jpg'           => 'Isometric blueprint of the Kelso Rail ticketing flow',
		'project-halcyon.jpg'              => 'Wireframe of the Halcyon product marketing site',
		'project-merrick-co.jpg'           => 'Radial diagram standing in for the Merrick &amp; Co design system',
		'project-sablefield.jpg'           => 'Plan drawing of the Sablefield subscription storefront',
		'project-ordnance-trust.jpg'       => 'Contour drawing standing in for the Ordnance Trust archive',
		'project-loom-analytics.jpg'       => 'Chart plate standing in for the Loom Analytics documentation site',
		'project-brayton-cycles.jpg'       => 'Isometric blueprint of the Brayton Cycles configurator',
		'case-northgate-hero.jpg'          => 'Wide wireframe of the Northgate Health treatment template',
		'case-detail-template.jpg'         => 'Plan drawing of a treatment page template',
		'case-detail-editor.jpg'           => 'Wireframe of the constrained editor view built for the client',
		'team-maya-iyer.jpg'               => 'Blueprint portrait study of Maya Iyer',
		'team-daniel-okoro.jpg'            => 'Blueprint portrait study of Daniel Okoro',
		'team-sofia-lindqvist.jpg'         => 'Blueprint portrait study of Sofia Lindqvist',
		'team-ben-trawick.jpg'             => 'Blueprint portrait study of Ben Trawick',
		'team-priya-raman.jpg'             => 'Blueprint portrait study of Priya Raman',
		'team-iwan-petrov.jpg'             => 'Blueprint portrait study of Iwan Petrov',
		'post-content-models.jpg'          => 'Plan drawing of a content model laid out as rooms',
		'post-performance-budget.jpg'      => 'Chart plate showing a page weight budget',
		'post-migrating-400-pages.jpg'     => 'Contour drawing standing in for a site migration map',
		'post-twelve-patterns.jpg'         => 'Wireframe of twelve reusable page patterns',
		'post-block-patterns-contract.jpg' => 'Isometric blueprint of a block pattern library',
		'post-discovery-questions.jpg'     => 'Radial diagram of discovery questions',
		'post-web-fonts-layout-shift.jpg'  => 'Layered drawing standing in for font loading stages',
		'post-editor-training.jpg'         => 'Wireframe of an editor training session',
		'post-content-models-wide.jpg'     => 'Wide layered drawing: one content model, ninety pages',
		'theme-ledger.jpg'                 => 'Screenshot wireframe of the Ledger theme',
		'theme-ledger-pro.jpg'             => 'Screenshot wireframe of the Ledger Pro theme',
		'theme-wharf.jpg'                  => 'Screenshot wireframe of the Wharf theme',
		'theme-kelpie.jpg'                 => 'Screenshot wireframe of the Kelpie theme',
		'theme-wharf-pro.jpg'              => 'Screenshot wireframe of the Wharf Pro theme',
		'theme-signal.jpg'                 => 'Screenshot wireframe of the Signal theme',
		'theme-kelpie-pro.jpg'             => 'Screenshot wireframe of the Kelpie Pro theme',
		'theme-fieldbook.jpg'              => 'Screenshot wireframe of the Fieldbook theme',
		'theme-atlas.jpg'                  => 'Screenshot wireframe of the Atlas theme',
		'product-ledger-pro-main.jpg'      => 'Ledger Pro front page template',
		'product-ledger-pro-01.jpg'        => 'Ledger Pro services template',
		'product-ledger-pro-02.jpg'        => 'Ledger Pro team directory',
		'product-ledger-pro-03.jpg'        => 'Ledger Pro pricing pattern',
		'product-ledger-pro-04.jpg'        => 'Ledger Pro shop templates',
		'docs-site-editor.jpg'             => 'Wireframe of the WordPress Site Editor',
		'docs-walkthrough.jpg'             => 'Still from the theme walkthrough series',
		'og-default.jpg'                   => 'Northline — web design and development studio',
	);
}

/**
 * Copy one bundled image into the media library, or return the existing copy.
 *
 * @param string $file File name inside assets/images.
 * @param string $alt  Alt text.
 * @return int Attachment ID, or 0 on failure.
 */
function northline_import_media( $file, $alt = '' ) {
	$existing = northline_attachment_id( $file );

	if ( $existing ) {
		return $existing;
	}

	$source = NORTHLINE_DIR . '/assets/images/' . $file;

	if ( ! file_exists( $source ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$upload = wp_upload_bits( $file, null, file_get_contents( $source ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- local theme file.

	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$title = ucfirst( str_replace( array( '-', '_' ), ' ', pathinfo( $file, PATHINFO_FILENAME ) ) );

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => wp_check_filetype( $upload['file'] )['type'],
			'post_title'     => $title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		return 0;
	}

	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );

	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt ? $alt : $title );
	update_post_meta( $attachment_id, '_northline_source', $file );
	update_post_meta( $attachment_id, '_northline_demo', '1' );

	return (int) $attachment_id;
}

/**
 * Copy every bundled image into the library.
 *
 * @return int How many attachments now exist.
 */
function northline_import_all_media() {
	$count = 0;

	foreach ( northline_demo_media_manifest() as $file => $alt ) {
		if ( northline_import_media( $file, $alt ) ) {
			$count++;
		}
	}

	// Patterns rendered after this point should point at the library copies.
	northline_attachment_map( true );

	return $count;
}
