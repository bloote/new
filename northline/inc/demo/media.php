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
		'hero-studio.jpg'                  => 'Abstract composition of overlapping planes and a circle, in the studio\'s blues',
		'studio-room.jpg'                  => 'Abstract composition of overlapping planes, in the studio\'s blues',
		'project-northgate-health.jpg'     => 'The rebuilt Northgate Health site, showing a treatment page',
		'project-fieldnote.jpg'            => 'The Fieldnote editorial platform, showing a long-form article',
		'project-kelso-rail.jpg'           => 'The Kelso Rail ticket booking flow on a phone',
		'project-halcyon.jpg'              => 'The Halcyon product marketing site and its pricing row',
		'project-merrick-co.jpg'           => 'The Merrick &amp; Co design system: colour swatches, type scale and components',
		'project-sablefield.jpg'           => 'The Sablefield coffee storefront, showing the subscription range',
		'project-ordnance-trust.jpg'       => 'The Ordnance Trust archive, showing faceted search across the catalogue',
		'project-loom-analytics.jpg'       => 'The Loom Analytics documentation site',
		'project-brayton-cycles.jpg'       => 'The Brayton Cycles configurator, showing a frame and its options',
		'case-northgate-hero.jpg'          => 'A Northgate Health treatment page, full width',
		'case-detail-template.jpg'         => 'The Northgate Health locations template',
		'case-detail-editor.jpg'           => 'The constrained editor view built for the Northgate marketing team',
		'team-maya-iyer.jpg'               => 'Illustrated portrait of Maya Iyer',
		'team-daniel-okoro.jpg'            => 'Illustrated portrait of Daniel Okoro',
		'team-sofia-lindqvist.jpg'         => 'Illustrated portrait of Sofia Lindqvist',
		'team-ben-trawick.jpg'             => 'Illustrated portrait of Ben Trawick',
		'team-priya-raman.jpg'             => 'Illustrated portrait of Priya Raman',
		'team-iwan-petrov.jpg'             => 'Illustrated portrait of Iwan Petrov',
		'post-content-models.jpg'          => 'Diagram of a content model: three linked types, each with its own fields',
		'post-performance-budget.jpg'      => 'Chart of page weight falling below a budget line and staying there',
		'post-migrating-400-pages.jpg'     => 'Diagram of many old URLs resolving into three destinations',
		'post-twelve-patterns.jpg'         => 'A modular grid in which a few cells carry the layout',
		'post-block-patterns-contract.jpg' => 'Concentric rings marked off in degrees, with one sector filled',
		'post-discovery-questions.jpg'     => 'Lines radiating from a single point, one reaching further than the rest',
		'post-web-fonts-layout-shift.jpg'  => 'A type specimen reading Aa, with cap height, x-height and baseline drawn in',
		'post-editor-training.jpg'         => 'A stepped path rising in four stages',
		'post-content-models-wide.jpg'     => 'Diagram of a content model, drawn wide: linked types and their fields',
		'theme-ledger.jpg'                 => 'The Ledger theme, showing a professional services front page',
		'theme-ledger-pro.jpg'             => 'The Ledger Pro theme, showing a professional services front page',
		'theme-wharf.jpg'                  => 'The Wharf theme, showing a long-form article layout',
		'theme-kelpie.jpg'                 => 'The Kelpie theme, showing a product catalogue',
		'theme-wharf-pro.jpg'              => 'The Wharf Pro theme, showing a members article layout',
		'theme-signal.jpg'                 => 'The Signal theme, showing a one-page launch site with pricing',
		'theme-kelpie-pro.jpg'             => 'The Kelpie Pro theme, showing a subscription catalogue',
		'theme-fieldbook.jpg'              => 'The Fieldbook theme, showing documentation with a sidebar',
		'theme-atlas.jpg'                  => 'The Atlas theme, showing a group of locations',
		'product-ledger-pro-main.jpg'      => 'Ledger Pro front page template',
		'product-ledger-pro-01.jpg'        => 'Ledger Pro locations template',
		'product-ledger-pro-02.jpg'        => 'Ledger Pro shop template',
		'product-ledger-pro-03.jpg'        => 'Ledger Pro pricing template',
		'product-ledger-pro-04.jpg'        => 'Ledger Pro journal template',
		'docs-site-editor.jpg'             => 'The WordPress Site Editor, editing a template part',
		'docs-walkthrough.jpg'             => 'A still from the theme walkthrough series',
		'og-default.jpg'                   => 'Northline — a web design and development studio in Bristol',
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
	$source = NORTHLINE_DIR . '/assets/images/' . $file;

	if ( ! file_exists( $source ) ) {
		return 0;
	}

	$hash     = md5_file( $source );
	$existing = northline_attachment_id( $file );

	if ( $existing ) {
		// A theme update can redraw the artwork. When the bundled file no
		// longer matches the library copy, replace the bytes in place rather
		// than adding a second attachment, so every featured image and every
		// reference in page content keeps pointing at the same ID.
		if ( get_post_meta( $existing, '_northline_source_hash', true ) !== $hash ) {
			northline_refresh_media( $existing, $source, $hash, $alt );
		}

		return $existing;
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
	update_post_meta( $attachment_id, '_northline_source_hash', $hash );
	update_post_meta( $attachment_id, '_northline_demo', '1' );

	return (int) $attachment_id;
}

/**
 * Replace an existing attachment's file with a newer bundled version.
 *
 * @param int    $attachment_id Attachment to refresh.
 * @param string $source        Path to the bundled file.
 * @param string $hash          Its md5.
 * @param string $alt           Alt text.
 */
function northline_refresh_media( $attachment_id, $source, $hash, $alt ) {
	$path = get_attached_file( $attachment_id );

	if ( ! $path ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';

	// The old intermediate sizes describe an image that no longer exists.
	$meta = wp_get_attachment_metadata( $attachment_id );
	$dir  = dirname( $path );

	if ( ! empty( $meta['sizes'] ) ) {
		foreach ( $meta['sizes'] as $size ) {
			if ( ! empty( $size['file'] ) && file_exists( $dir . '/' . $size['file'] ) ) {
				wp_delete_file( $dir . '/' . $size['file'] );
			}
		}
	}

	copy( $source, $path );

	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $path ) );
	update_post_meta( $attachment_id, '_northline_source_hash', $hash );

	if ( $alt ) {
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
	}
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
