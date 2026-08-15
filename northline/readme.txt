=== Northline ===

Contributors: northlinestudio
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.0
Stable tag: 1.1.0
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: full-site-editing, block-patterns, blog, portfolio, business, one-column, two-columns, custom-colors, custom-logo, custom-menu, editor-style, featured-images, block-styles, wide-blocks, accessibility-ready, translation-ready

A full-site-editing theme for studios that build websites and release themes,
plugins and scripts — with the complete demo site included.

== Description ==

Northline is a block theme for a web design and development studio that also
publishes downloads. It ships with 80 block patterns, eighteen templates, two
custom content types, and a one-click import that builds the entire demo site:
pages, journal posts with categories and tags, case studies, a catalogue of
themes, plugins, scripts and browser tools, every image, and the menus.

Every section of every page is a registered pattern built from core blocks, so
what you edit in the Site Editor is exactly what the demo site is made of. There
is no page builder, no shortcodes and no theme options screen.

Alongside the sixty-seven sections the demo site is made of, there are nine
general-purpose sections with placeholder copy and four whole-page layouts that
appear when you create a new page — so building a page the demo site does not
have starts from something rather than from nothing.

* Colour, type, spacing and layout are set in theme.json, so a rebrand is one
  change in Styles rather than a hunt through stylesheets.
* Barlow and Barlow Condensed are subset and bundled locally. The theme makes no
  external requests.
* Tabs, accordions, filters, carousels and count-up figures are one dependency-free
  script, and all of them degrade gracefully without JavaScript.
* The contact, order and subscribe forms are handled in WordPress: server-side
  validation, honeypot spam handling, mail to the site address, and a private
  record of every submission. No third-party service.

== Installation ==

1. Upload the theme under Appearance → Themes → Add New, and activate it.
2. Follow the notice to Appearance → Northline setup.
3. Press "Import the demo site".

From WP-CLI:

  wp theme install northline.zip --activate
  wp northline demo import

The import can be run more than once without duplicating anything, and
`wp northline demo remove` deletes exactly what it created.

== Frequently Asked Questions ==

= Do I need a page builder? =

No, and we would rather you did not use one. Everything is core blocks and
registered patterns, so the editor you already have is the editor you need.

= Can my team break the design? =

Not easily. Colour, font-size and spacing controls are constrained to the theme's
scales. Editors change words and images; the layout stays as designed.

= What happens to my edits when the theme updates? =

Page content and any template you customised are stored in the database, so they
survive updates untouched. Templates you never edited pick up improvements. For
code changes, use a child theme.

= Where do Projects and Downloads come from? =

The theme registers them so the demo site works out of the box. If you would
rather own them in a plugin, return false from the `northline_register_post_types`
filter and register them yourself under the same names — everything else keeps
working.

== Copyright ==

Northline WordPress Theme, (C) 2026 Northline Studio Ltd.
Northline is distributed under the terms of the GNU GPL version 2 or later.

Barlow and Barlow Condensed
Copyright (c) Jeremy Tribby
Licensed under the SIL Open Font License, Version 1.1
Source: https://fonts.google.com/specimen/Barlow

Bundled images
Copyright (c) 2026 Northline Studio Ltd.
Licensed under the GNU GPL version 2 or later.
Rendered by tools/generate-images.mjs in the theme's source repository.

== Changelog ==

= 1.1.0 =
* Added nine general-purpose section patterns and four whole-page layouts, so a
  page that is not in the demo site can be started from a pattern too. The
  "whole pages" inserter category is no longer empty.
* Fixed: usage snippets on catalogue entries were being stripped on save, so
  four of the six script cards showed no code at all.
* Cards in a grid are now the height of their row, and a trailing row of buttons
  is aligned along the bottom of the row rather than following the copy.
* Accordion questions can be set a step smaller, so a sidebar FAQ no longer
  competes with the heading of the section it sits beside.
* The radio rows in the contact and order forms are styled to match the rest of
  the form instead of falling back to the browser's own controls.

= 1.0.0 =
* Initial release.
