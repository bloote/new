<?php
/**
 * The demo site's content.
 *
 * Everything the import creates is defined here as data: pages assembled from
 * patterns, journal posts, case studies, the download catalogue and the menus.
 * Editing this file changes what a fresh import produces.
 *
 * @package Northline
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------- block tools */

/**
 * Turn a compact node list into block markup.
 *
 * Nodes are single-key arrays: h2, h3, p, lede, list, quote, pull, note, code,
 * image, table, stats, columns.
 *
 * @param array $nodes Content nodes.
 * @return string
 */
function northline_demo_body( $nodes ) {
	$out = array();

	foreach ( $nodes as $node ) {
		$type  = key( $node );
		$value = current( $node );

		switch ( $type ) {
			case 'h2':
				$out[] = sprintf( '<!-- wp:heading {"fontSize":"heading-3"} --><h2 class="wp-block-heading has-heading-3-font-size">%s</h2><!-- /wp:heading -->', $value );
				break;

			case 'h3':
				$out[] = sprintf( '<!-- wp:heading {"level":3,"fontSize":"heading-4"} --><h3 class="wp-block-heading has-heading-4-font-size">%s</h3><!-- /wp:heading -->', $value );
				break;

			case 'p':
				$out[] = sprintf( '<!-- wp:paragraph --><p>%s</p><!-- /wp:paragraph -->', $value );
				break;

			case 'lede':
				$out[] = sprintf( '<!-- wp:paragraph {"className":"nl-quiet","fontSize":"x-large"} --><p class="nl-quiet has-x-large-font-size">%s</p><!-- /wp:paragraph -->', $value );
				break;

			case 'list':
				$items = '';
				foreach ( $value as $item ) {
					$items .= sprintf( '<!-- wp:list-item --><li>%s</li><!-- /wp:list-item -->', $item );
				}
				$out[] = sprintf( '<!-- wp:list --><ul class="wp-block-list">%s</ul><!-- /wp:list -->', $items );
				break;

			case 'quote':
				$out[] = sprintf(
					'<!-- wp:pullquote {"className":"nl-measure"} --><figure class="wp-block-pullquote nl-measure"><blockquote><p>%s</p><cite>%s</cite></blockquote></figure><!-- /wp:pullquote -->',
					$value[0],
					$value[1]
				);
				break;

			case 'note':
				$out[] = northline_panel(
					sprintf( '<!-- wp:paragraph {"fontSize":"heading-4","style":{"typography":{"fontFamily":"var(--wp--preset--font-family--heading)","lineHeight":"1.32"},"spacing":{"margin":{"bottom":"0"}}}} --><p class="has-heading-4-font-size" style="margin-bottom:0;font-family:var(--wp--preset--font-family--heading);line-height:1.32">%s</p><!-- /wp:paragraph -->', $value ),
					array( 'background' => 'accent-tint' )
				);
				break;

			case 'code':
				$out[] = sprintf( '<!-- wp:code --><pre class="wp-block-code"><code>%s</code></pre><!-- /wp:code -->', esc_html( $value ) );
				break;

			case 'image':
				$out[] = northline_image_block(
					$value[0],
					array(
						'ratio' => $value[1] ?? '16/9',
						'alt'   => $value[2] ?? '',
					)
				);
				break;

			case 'table':
				$head = '<tr><th>' . implode( '</th><th>', $value[0] ) . '</th></tr>';
				$body = '';
				foreach ( $value[1] as $row ) {
					$body .= '<tr><td>' . implode( '</td><td>', $row ) . '</td></tr>';
				}
				$out[] = sprintf(
					'<!-- wp:table --><figure class="wp-block-table"><table><thead>%s</thead><tbody>%s</tbody></table></figure><!-- /wp:table -->',
					$head,
					$body
				);
				break;

			case 'stats':
				$out[] = sprintf(
					'<!-- wp:group {"align":"wide","className":"nl-rule nl-rule-bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"default"}} --><div class="wp-block-group alignwide nl-rule nl-rule-bottom" style="margin-top:var(--wp--preset--spacing--70);margin-bottom:var(--wp--preset--spacing--70);padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">%s</div><!-- /wp:group -->',
					northline_stats_row( $value )
				);
				break;

			case 'columns':
				$columns = '';
				foreach ( $value as $column ) {
					$columns .= sprintf(
						'<!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph {"className":"nl-meta"} --><p class="nl-meta">%s</p><!-- /wp:paragraph -->%s</div><!-- /wp:column -->',
						$column[0],
						northline_plain_list( $column[1], 'medium' )
					);
				}
				$out[] = sprintf(
					'<!-- wp:columns {"align":"wide"} --><div class="wp-block-columns alignwide">%s</div><!-- /wp:columns -->',
					$columns
				);
				break;
		}
	}

	return implode( "\n\n", $out );
}

/* --------------------------------------------------------------- taxonomies */

/**
 * Journal categories. The slugs match the filter buttons on the journal index.
 *
 * @return array
 */
function northline_demo_categories() {
	return array(
		'strategy'    => array( 'Strategy', 'Discovery, content models and the decisions taken before anything is designed.' ),
		'design'      => array( 'Design', 'Art direction, design systems and the craft of making a template that holds up.' ),
		'wordpress'   => array( 'WordPress', 'Block themes, patterns, migrations and the editor experience we hand over.' ),
		'performance' => array( 'Performance', 'Weight budgets, Core Web Vitals and the measurements that keep a site fast.' ),
	);
}

/**
 * Project types.
 *
 * @return array
 */
function northline_demo_project_types() {
	return array(
		'wordpress' => array( 'WordPress', 'Custom block themes, content models and migrations on WordPress.' ),
		'headless'  => array( 'Headless', 'WordPress kept as the editing surface, with a separate front end in front of it.' ),
		'commerce'  => array( 'Commerce', 'Selling: catalogues, checkouts and subscription flows.' ),
		'design'    => array( 'Design only', 'Design systems and template sets handed to an in-house team to build.' ),
	);
}

/**
 * Download types and tags.
 *
 * @return array
 */
function northline_demo_download_terms() {
	return array(
		'download_type' => array(
			'themes'  => array( 'Themes', 'Block themes that shipped on a real client project before they were released.' ),
			'plugins' => array( 'Plugins', 'Small plugins that each do one thing properly, with no upsell nags.' ),
			'scripts' => array( 'Scripts', 'Dependency-free JavaScript under five kilobytes, MIT licensed.' ),
			'tools'   => array( 'Tools', 'Utilities that run entirely in your browser. No account, no upload.' ),
		),
		'download_tag'  => array(
			'free'        => array( 'Free', '' ),
			'pro'         => array( 'Pro', '' ),
			'block-theme' => array( 'Block theme', '' ),
			'editorial'   => array( 'Editorial', '' ),
			'commerce'    => array( 'Commerce', '' ),
			'seo'         => array( 'SEO', '' ),
			'ops'         => array( 'Operations', '' ),
			'editor'      => array( 'Editor', '' ),
			'ui'          => array( 'Interface', '' ),
			'motion'      => array( 'Motion', '' ),
			'forms'       => array( 'Forms', '' ),
			'performance' => array( 'Performance', '' ),
		),
	);
}

/* -------------------------------------------------------------------- pages */

/**
 * Every page the demo site publishes, and the patterns each is built from.
 *
 * @return array
 */
function northline_demo_pages() {
	return array(
		'home'               => array(
			'title'    => 'Home',
			'excerpt'  => 'A web design and development studio. We plan, design and build sites that hold up after launch.',
			'template' => 'page-wide',
			'patterns' => array(
				'hero-home',
				'logo-strip',
				'services-grid',
				'downloads-grid',
				'work-featured',
				'stats-band',
				'process-tabs',
				'testimonials',
				'stack-columns',
				'pricing-cards',
				'team-grid',
				'journal-latest',
				'cta-home',
			),
		),
		'services'           => array(
			'title'    => 'Services',
			'excerpt'  => 'Strategy, design and code under one roof. No handoff between agencies.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-services', 'services-accordion', 'handover-grid', 'cta-services' ),
		),
		'studio'             => array(
			'title'    => 'Studio',
			'excerpt'  => 'Six people, no account managers. Northline has been a small studio since 2016, on purpose.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-studio', 'principles-grid', 'team-directory', 'studio-timeline', 'cta-studio' ),
		),
		'journal'            => array(
			'title'    => 'Journal',
			'excerpt'  => 'Notes from the work, written by whoever did it. Roughly two a month.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-journal', 'journal-featured', 'journal-index', 'newsletter-band' ),
		),
		'pricing'            => array(
			'title'    => 'Pricing',
			'excerpt'  => 'Fixed scope, fixed price, no surprise invoices. The bands most work falls into.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-pricing', 'pricing-tiers', 'pricing-compare', 'care-plans', 'faq-pricing', 'cta-pricing' ),
		),
		'themes'             => array(
			'title'    => 'Themes',
			'excerpt'  => 'Block themes we build for our own clients, then release. Free ones are GPL and complete.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-themes', 'themes-index', 'themes-licensing', 'cta-themes' ),
		),
		'plugins'            => array(
			'title'    => 'Plugins',
			'excerpt'  => 'Small WordPress plugins that do one thing properly. No upsell nags, no bundled analytics.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-plugins', 'plugins-index', 'plugins-bundle', 'cta-plugins' ),
		),
		'scripts-and-tools'  => array(
			'title'    => 'Scripts &amp; tools',
			'excerpt'  => 'Dependency-free scripts and six utilities that run entirely in your browser. All free, all MIT.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-scripts', 'scripts-index', 'tools-grid', 'cta-scripts' ),
		),
		'custom-orders'      => array(
			'title'    => 'Custom orders',
			'excerpt'  => 'Themes, plugins and scripts built to your order. One fixed price, one delivery date.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-custom', 'custom-orders-grid', 'custom-how-it-works', 'custom-order-form', 'cta-custom' ),
		),
		'tutorials-and-docs' => array(
			'title'    => 'Tutorials &amp; docs',
			'excerpt'  => 'Everything here is a block theme you edit from the admin. These tutorials cover how.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-docs', 'docs-quickstart', 'docs-editing-tabs', 'docs-tutorial-index', 'docs-video', 'docs-faq', 'cta-docs' ),
		),
		'contact'            => array(
			'title'    => 'Contact',
			'excerpt'  => 'Book a call, or send the brief. Thirty minutes, no deck.',
			'template' => 'page-wide',
			'patterns' => array( 'hero-contact', 'contact-details' ),
		),
		'privacy'            => array(
			'title'    => 'Privacy',
			'excerpt'  => 'What we collect, why, and how long we keep it.',
			'template' => 'page-plain',
			'body'     => array(
				array( 'lede' => 'This page describes what Northline Studio Ltd collects through this website, why, and how long it is kept. It is written to be read rather than to be defensible.' ),
				array( 'h2' => 'What we collect' ),
				array( 'p' => 'If you send an enquiry, we keep what you typed into the form: your name, your email address, your company and site if you gave them, and the brief itself. It reaches us by email and is stored in this site&#8217;s database so a mail failure never loses a lead.' ),
				array( 'p' => 'If you subscribe to the journal, we keep your email address and nothing else. There is an unsubscribe link on every issue and it works in one click.' ),
				array( 'p' => 'Our server keeps standard access logs — IP address, page requested, timestamp, browser — for thirty days, which is how we find out that something broke.' ),
				array( 'h2' => 'What we do not do' ),
				array( 'list' => array( 'We do not sell or share your details with anyone.', 'We do not add enquiries to a mailing list.', 'We do not run third-party advertising or behavioural tracking.', 'We do not load analytics that follow you across other sites.' ) ),
				array( 'h2' => 'Cookies' ),
				array( 'p' => 'This site sets no marketing cookies. WordPress sets a session cookie if you leave a comment or log in, and that is the extent of it.' ),
				array( 'h2' => 'How long we keep things' ),
				array( 'p' => 'Enquiries are kept for two years, because projects often restart. Subscriptions are kept until you unsubscribe. Server logs are kept for thirty days.' ),
				array( 'h2' => 'Your rights' ),
				array( 'p' => 'You can ask what we hold about you, ask us to correct it, or ask us to delete it, and we will do so within thirty days. Write to <a href="mailto:studio@northline.co">studio@northline.co</a>.' ),
				array( 'p' => 'Northline Studio Ltd is registered in England and Wales. Our registered address is Unit 4, Wapping Wharf, Bristol BS1 6WE.' ),
			),
		),
		'terms'              => array(
			'title'    => 'Terms',
			'excerpt'  => 'The terms projects and downloads are supplied under.',
			'template' => 'page-plain',
			'body'     => array(
				array( 'lede' => 'These are the terms our project work and our downloads are supplied under. A signed statement of work takes precedence over anything here.' ),
				array( 'h2' => 'Project work' ),
				array( 'p' => 'Every project is quoted after discovery, with a written scope listing what is and is not included. Work starts on a thirty per cent deposit. The balance is due at design sign-off and at launch, in the proportions set out in the statement of work.' ),
				array( 'p' => 'Changes to an agreed scope are quoted separately, with their own price and delivery date, before any work on them begins. Nothing is invoiced that you have not approved in writing.' ),
				array( 'p' => 'On final payment, all intellectual property in the work we produced for you transfers to you outright, including the repository, its history and the design files.' ),
				array( 'h2' => 'Warranty' ),
				array( 'p' => 'Defects reported within sixty days of launch — ninety on platform engagements — are fixed at no cost. That covers anything that does not do what the agreed scope says it should. It does not cover new requirements, third-party service changes, or content edits made after handover.' ),
				array( 'h2' => 'Downloads' ),
				array( 'p' => 'Free themes and plugins are licensed under the GNU General Public Licence v2 or later. Scripts are MIT. You may use them commercially, on any number of sites, and modify them freely.' ),
				array( 'p' => 'Paid licences are also GPL v2 or later. What you are buying is twelve months of updates and support, and the number of supported sites your licence tier covers. After twelve months the software keeps working; renew to keep receiving updates.' ),
				array( 'p' => 'Refunds on paid licences are available for fourteen days, for any reason, including changing your mind.' ),
				array( 'h2' => 'Liability' ),
				array( 'p' => 'Our liability under any engagement is limited to the fees paid for it. We are not liable for indirect or consequential loss. Nothing here limits liability that cannot be limited in law.' ),
				array( 'h2' => 'Governing law' ),
				array( 'p' => 'These terms are governed by the law of England and Wales.' ),
			),
		),
	);
}

/* ------------------------------------------------------------------- posts */

/**
 * Journal posts, newest first.
 *
 * @return array
 */
function northline_demo_posts() {
	return array(
		array(
			'title'    => 'Content models beat page builders',
			'slug'     => 'content-models-beat-page-builders',
			'date'     => '2026-01-14 09:30:00',
			'category' => 'strategy',
			'tags'     => array( 'Content strategy', 'WordPress', 'Design systems' ),
			'image'    => 'post-content-models.jpg',
			'reading'  => '6 min read',
			'excerpt'  => 'Every builder-driven site we have inherited had the same problem: fifteen ways to make a hero, and no way to change all of them at once. Here is what we do instead.',
			'body'     => array(
				array( 'h2' => 'The symptom' ),
				array( 'p' => 'A client asks us to change the button colour on their hero sections. There are 46 hero sections. Each was built by hand in a page builder, and eleven of them are not really heroes at all, they are two-column rows with a background image. The change takes a day and a half and gets missed in four places.' ),
				array( 'p' => 'This is the predictable end state of tools that give editors an empty canvas. The canvas is genuinely liberating for the first ten pages. By page 200 nobody knows what a hero is, and the site has no design system, only a history of decisions.' ),
				array( 'h2' => 'What a model is' ),
				array( 'p' => 'A content model is a written answer to two questions: what kinds of thing does this site publish, and what does each of them have? For a clinic, the kinds are treatments, consultants and locations. A treatment has a name, a summary, a body, a price band, a list of consultants who perform it and the locations where it is offered.' ),
				array( 'p' => 'Once that exists, the relationships do the work. A consultant page lists their treatments because the treatments point at them, not because someone remembered to add a link.' ),
				array( 'note' => 'If two pages differ only in their content, they should be the same template. If they differ in their structure, they are different types.' ),
				array( 'image' => array( 'post-content-models-wide.jpg', '21/9', 'One content model standing behind ninety pages' ) ),
				array( 'h2' => 'Fields, not canvases' ),
				array( 'p' => 'In practice this means the editor sees named fields with help text, and a small set of block patterns for the parts that genuinely vary. On the last build, that was twelve patterns covering 90 pages. An editor adding a treatment fills in nine fields and publishes; there is no decision to make about layout because there is no layout decision to make.' ),
				array( 'p' => 'The constraint is the feature. When the marketing team asked for a change to every treatment hero last quarter, it was one template edit and a deploy.' ),
				array( 'h2' => 'What it costs' ),
				array( 'p' => 'Two weeks of discovery before design starts, and a real conversation about what the site is for. That is the whole bill. What you get back is a site that stays consistent without anyone policing it, and a team that can publish on a Friday afternoon without calling us.' ),
				array( 'p' => 'If you are staring at a builder-driven site and wondering whether to rebuild or retrofit, the answer usually depends on how many templates you can retire. We are happy to look at yours.' ),
			),
		),
		array(
			'title'    => 'A performance budget you can hold to',
			'slug'     => 'a-performance-budget-you-can-hold-to',
			'date'     => '2025-12-02 10:00:00',
			'category' => 'performance',
			'tags'     => array( 'Performance', 'Core Web Vitals', 'Process' ),
			'image'    => 'post-performance-budget.jpg',
			'reading'  => '9 min read',
			'excerpt'  => 'Setting weight limits during design, not after the build is finished. A budget agreed in week two is a design constraint; the same number in week ten is an argument.',
			'body'     => array(
				array( 'lede' => 'Almost every site we inherit was fast when it launched. Performance is not something you achieve once; it is something a team either has permission to protect or does not.' ),
				array( 'h2' => 'Agree the number before the first mockup' ),
				array( 'p' => 'We set three numbers at the end of discovery: a byte budget for the heaviest template, a Largest Contentful Paint target on a mid-range Android over 4G, and a cap on third-party requests. They go in the scope document next to the page count, because they are the same kind of decision.' ),
				array( 'p' => 'Typical starting numbers for a marketing site: 400 KB of transferred bytes on the heaviest template, LCP under 1.8 seconds, and no more than two third-party origins. None of that is heroic. It is simply what you get if nobody is allowed to add a video hero in week nine without trading something away.' ),
				array( 'stats' => array( array( '400', 'KB budget, heaviest template' ), array( '1.8', 'Second LCP target', 's' ), array( '2', 'Third-party origins allowed' ), array( '96', 'Median Lighthouse at handover' ) ) ),
				array( 'h2' => 'Design against it, not after it' ),
				array( 'p' => 'A budget only works if the designer knows it while choosing. Two full-bleed photographs above the fold is a decision with a price, and the price is legible if the number is on the wall. In practice this changes surprisingly little about how a site looks. It changes how many hero variants get invented.' ),
				array( 'list' => array( 'Type: two families, subset to the characters actually used.', 'Imagery: one hero asset per template, sized to the largest breakpoint it appears at.', 'Motion: CSS first; a JavaScript animation library needs a reason and a receipt.', 'Embeds: facades for video and maps, loaded on click.' ) ),
				array( 'h2' => 'Enforce it where it cannot be argued with' ),
				array( 'p' => 'A budget that lives in a document is a suggestion. We put it in CI: Lighthouse runs against the staging URL on every pull request, and the build fails if the heaviest template goes over. The failure message says which asset grew and by how much, which turns a philosophical conversation into a two-minute fix.' ),
				array( 'code' => "# .github/workflows/budget.yml\n- name: Lighthouse CI\n  run: lhci autorun --collect.url=\$STAGING_URL/services/ \\\n       --assert.preset=lighthouse:recommended \\\n       --assert.assertions.resource-summary:total:size=error:400000" ),
				array( 'h2' => 'What happens after launch' ),
				array( 'p' => 'Sites get heavier because somebody adds a tag manager, and the tag manager loads four things nobody chose. On care plans we report page weight monthly against the launch number, which is usually enough: nobody wants to be the person who added 300 KB of chat widget.' ),
				array( 'p' => 'The budget is not the point. The point is that when the number moves, somebody notices in a week rather than in two years.' ),
			),
		),
		array(
			'title'    => 'Migrating 400 pages without losing rankings',
			'slug'     => 'migrating-400-pages-without-losing-rankings',
			'date'     => '2025-11-18 09:00:00',
			'category' => 'wordpress',
			'tags'     => array( 'Migration', 'SEO', 'WordPress' ),
			'image'    => 'post-migrating-400-pages.jpg',
			'reading'  => '5 min read',
			'excerpt'  => 'The redirect map, the crawl diff and the two weeks of monitoring after. Retiring three quarters of a site is safe if you are honest about what the traffic actually wants.',
			'body'     => array(
				array( 'lede' => 'We retired 322 URLs on the Northgate Health rebuild. Organic sessions dipped four per cent in week one and were up thirty-four per cent by the end of the second quarter. Here is the whole method.' ),
				array( 'h2' => 'Crawl the old site properly first' ),
				array( 'p' => 'Not the sitemap — the sitemap is a claim, not evidence. Crawl every reachable URL, then join it against twelve months of Search Console and analytics data. What you want is one spreadsheet with a row per URL and four columns: clicks, impressions, inbound internal links, and external backlinks.' ),
				array( 'p' => 'On that project, 38 pages carried 91 per cent of the traffic. Everything else was either duplicated, unvisited, or a departmental page written for a different audience than the one landing on it.' ),
				array( 'h2' => 'Map every URL to a destination, including the dead ones' ),
				array( 'table' => array(
					array( 'Old URL type', 'Count', 'Destination' ),
					array(
						array( 'Kept, same content', '38', 'New equivalent, 301' ),
						array( 'Merged into a treatment page', '164', 'Treatment page, 301' ),
						array( 'Merged into a location page', '71', 'Location page, 301' ),
						array( 'Genuinely obsolete', '87', 'Parent section, 301' ),
						array( 'Never indexed, no links', '52', '410 Gone' ),
					),
				) ),
				array( 'p' => 'The rule we hold to: every retired URL redirects to the most specific page that answers the same question. A blanket redirect to the homepage is treated by search engines as a soft 404, and it deserves to be.' ),
				array( 'h2' => 'Diff the crawls before you switch' ),
				array( 'p' => 'Crawl staging with the same tool and the same settings, then diff the two exports. You are looking for four things: redirect chains longer than one hop, redirect loops, destinations that 404, and titles or canonical tags that were silently lost in the content migration.' ),
				array( 'h2' => 'Watch for a fortnight, and do not panic in week one' ),
				array( 'p' => 'A dip in the first ten days is normal while crawlers re-index. What is not normal is a fall in impressions for the terms your top 38 pages ranked for. We check that daily for two weeks, with the redirect log open next to it, and fix anything that shows up as a 404 with referrers.' ),
				array( 'p' => 'We built <a href="/downloads/">Redirect Desk</a> during this project because doing it by hand twice was enough.' ),
			),
		),
		array(
			'title'    => 'Designing the twelve patterns, not the forty pages',
			'slug'     => 'designing-the-twelve-patterns-not-the-forty-pages',
			'date'     => '2025-10-30 09:00:00',
			'category' => 'design',
			'tags'     => array( 'Design systems', 'Patterns', 'Process' ),
			'image'    => 'post-twelve-patterns.jpg',
			'reading'  => '7 min read',
			'excerpt'  => 'How we decide what becomes a reusable block and what stays bespoke — and why the answer is usually fewer patterns than the client expects.',
			'body'     => array(
				array( 'lede' => 'A pattern library is not a collection of everything you designed. It is the smallest set of sections that can build every page in the sitemap, plus the next twenty pages nobody has thought of yet.' ),
				array( 'h2' => 'Start from the sitemap, not the mockups' ),
				array( 'p' => 'Before drawing anything, we list every page type in the sitemap and write down what each one has to do: introduce, list, compare, persuade, explain, capture. Most sites need six verbs. The pattern set falls out of the verbs, not out of the visual ideas.' ),
				array( 'h2' => 'The test for a new pattern' ),
				array( 'p' => 'A section earns a place in the library if it passes three questions. Does it appear on at least three pages? Would an editor plausibly reach for it on a page that does not exist yet? Can it survive its copy getting fifty per cent longer? If a section fails the third question, it is not a pattern, it is an illustration.' ),
				array( 'list' => array( 'Used three times or more, or on a page type that will multiply.', 'Understandable from its name alone in the inserter.', 'Survives long copy, short copy and a missing image.', 'Has a defined behaviour at every breakpoint, not just the desktop one.' ) ),
				array( 'h2' => 'Variants beat new patterns' ),
				array( 'p' => 'Six hero patterns is a smell. One hero with a media slot that can be empty, an eyebrow that can be hidden and an alignment toggle covers the same ground and leaves one thing to maintain. We would rather explain three options than let an editor choose between six near-identical entries in the inserter.' ),
				array( 'quote' => array( 'The library got better every time we deleted something from it.', 'Daniel Okoro, design lead' ) ),
				array( 'h2' => 'Name them the way editors talk' ),
				array( 'p' => 'Names in the inserter should describe the job, not the layout: &#8220;Services — six cards&#8221; rather than &#8220;Three-column grid B&#8221;. Editors search by what they are trying to say. This costs nothing at design time and saves a training session later.' ),
				array( 'h2' => 'Twelve is not a target' ),
				array( 'p' => 'It is what a thirty-template marketing site usually needs. A documentation site needs seven. A group of clinics with locations, treatments and consultants needs about eighteen, because the relationships between types earn their own sections. Count the verbs, not the pages.' ),
			),
		),
		array(
			'title'    => 'Block patterns as a design system contract',
			'slug'     => 'block-patterns-as-a-design-system-contract',
			'date'     => '2025-10-09 09:00:00',
			'category' => 'wordpress',
			'tags'     => array( 'WordPress', 'Design systems', 'theme.json' ),
			'image'    => 'post-block-patterns-contract.jpg',
			'reading'  => '11 min read',
			'excerpt'  => 'Keeping theme.json, the design tokens and the pattern library in step, so a rebrand is one change rather than a hunt through stylesheets.',
			'body'     => array(
				array( 'lede' => 'A block theme has three places a colour could live: theme.json, a pattern, and a stylesheet. Only one of them should win, and it should be the same one every time.' ),
				array( 'h2' => 'One direction of travel' ),
				array( 'p' => 'Tokens are authored once, in the design tool, and exported into theme.json. Patterns reference presets and never literal values. The stylesheet holds compositions that theme.json cannot express — a frame, a rail, a component with two states — and every value inside it resolves back to a preset variable.' ),
				array( 'p' => 'The test is simple: change the accent colour in the Styles panel and see whether anything in the site fails to follow. If something does, it is hard-coded and it is a bug.' ),
				array( 'code' => "/* Wrong: a value that no longer follows Styles. */\n.nl-tag-accent { background: #eef6ff; }\n\n/* Right: the same design, still following the palette. */\n.nl-tag-accent { background: var(--wp--preset--color--accent-tint); }" ),
				array( 'h2' => 'Constrain what the editor can reach' ),
				array( 'p' => 'theme.json is where you decide how much rope the editor gets. Turning off custom colours and custom font sizes is not a hostile act; it is the difference between a site that still looks designed in a year and one that does not. Editors keep the controls that matter — words, images, order — and lose the ones that only cause harm.' ),
				array( 'columns' => array(
					array( 'Leave open', array( 'Text and headings', 'Images and alt text', 'Block order', 'Adding and removing sections' ) ),
					array( 'Lock down', array( 'Custom colour pickers', 'Arbitrary font sizes', 'Custom spacing values', 'Structural blocks inside a pattern' ) ),
				) ),
				array( 'h2' => 'Patterns are the contract' ),
				array( 'p' => 'A pattern is the agreement between the designer and the editor about what a section is. It should be complete on insertion — real headings, plausible copy length, a working image — because a pattern that arrives empty gets filled in badly.' ),
				array( 'p' => 'We register patterns as PHP files rather than in the database. That way the library is in version control, reviewable in a pull request, and identical on every environment. A synced pattern in the database is the right tool for content that repeats, not for the design system.' ),
				array( 'h2' => 'Where it usually goes wrong' ),
				array( 'list' => array( 'A designer adds a shade that is not in the palette, and it enters the theme as a literal hex.', 'A pattern sets a pixel font size to fix one page, and the type scale quietly forks.', 'A plugin ships its own stylesheet with higher specificity than the theme.', 'Nobody deletes patterns, so the inserter grows until editors stop scrolling.' ) ),
				array( 'p' => 'All four are process problems rather than technical ones. The fix is a review step: a pattern pull request lists which presets it uses, and anything new has to be justified as a token first.' ),
			),
		),
		array(
			'title'    => 'The discovery questions that change the scope',
			'slug'     => 'the-discovery-questions-that-change-the-scope',
			'date'     => '2025-09-21 09:00:00',
			'category' => 'strategy',
			'tags'     => array( 'Discovery', 'Process', 'Content strategy' ),
			'image'    => 'post-discovery-questions.jpg',
			'reading'  => '8 min read',
			'excerpt'  => 'Nine questions we ask in week one, and what the answers usually reveal about the project that was actually briefed.',
			'body'     => array(
				array( 'lede' => 'Most redesign briefs describe a symptom. Discovery is the fortnight in which you find out whether the symptom is the problem, and it comes down to about nine questions.' ),
				array( 'h2' => 'The nine' ),
				array( 'list' => array(
					'<strong>Who publishes to this site, and how often?</strong> If the answer is &#8220;a developer, when we ask&#8221;, the project is a content model, not a redesign.',
					'<strong>What happened the last time you tried to change something?</strong> The story you get back is the real scope document.',
					'<strong>Which pages would you be sorry to lose?</strong> Usually a much shorter list than the sitemap.',
					'<strong>What do people phone you to ask?</strong> The site is failing to answer those questions; they are the navigation.',
					'<strong>Who signs this off, and have they seen the brief?</strong> The person absent from discovery is the person who reopens design in week nine.',
					'<strong>What is already decided?</strong> Brand, stack, deadline, a platform someone has already bought.',
					'<strong>How will we know this worked?</strong> If nobody can answer, agree a measure now rather than argue about one later.',
					'<strong>What else launches at the same time?</strong> Conferences and funding rounds move dates more than any technical risk.',
					'<strong>What is the worst outcome?</strong> Sometimes it is losing rankings, sometimes it is embarrassing a regulator. It changes the whole plan.',
				) ),
				array( 'h2' => 'What the answers usually change' ),
				array( 'p' => 'On roughly a third of projects, discovery turns a redesign into a content model plus a much smaller design job. On another third it moves the deadline, because something nobody mentioned turns out to be on the critical path. On the rest it confirms the brief, which is worth two weeks on its own: everyone signs the scope knowing what is in it.' ),
				array( 'quote' => array( 'The brief we were given was a redesign. The brief we agreed after two weeks of discovery was a content model.', 'From the Northgate Health case study' ) ),
				array( 'h2' => 'Talk to the people who answer the phone' ),
				array( 'p' => 'Marketing knows what the site says. Support knows what it fails to say. An hour with whoever handles enquiries reliably produces two or three navigation changes that no amount of analytics would have suggested.' ),
			),
		),
		array(
			'title'    => 'Web fonts without the layout shift',
			'slug'     => 'web-fonts-without-the-layout-shift',
			'date'     => '2025-09-02 09:00:00',
			'category' => 'performance',
			'tags'     => array( 'Performance', 'Typography', 'Core Web Vitals' ),
			'image'    => 'post-web-fonts-layout-shift.jpg',
			'reading'  => '6 min read',
			'excerpt'  => 'Metric-matched fallbacks, subsetting, and when a system stack is the right answer after all.',
			'body'     => array(
				array( 'lede' => 'Cumulative Layout Shift caused by fonts is almost entirely avoidable, and the fix is four decisions rather than a plugin.' ),
				array( 'h2' => 'Host them yourself' ),
				array( 'p' => 'A third-party font host is an extra DNS lookup, an extra TLS handshake and an extra origin you do not control, in exchange for a cache that browsers no longer share between sites. Copy the files into the theme. It is faster and it removes a privacy question you would otherwise have to answer.' ),
				array( 'h2' => 'Subset to what you actually use' ),
				array( 'p' => 'A full Latin-Extended face is often three times the size of the subset a site needs. Split by unicode-range so the extended block only downloads when a page contains those characters. Two weights of a subset face is usually 40&#8211;50 KB in total, which fits inside any sane budget.' ),
				array( 'code' => "@font-face {\n  font-family: 'Barlow';\n  src: url('barlow-400-latin.woff2') format('woff2');\n  font-weight: 400;\n  font-display: swap;\n  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+2000-206F;\n}" ),
				array( 'h2' => 'Match the fallback&#8217;s metrics' ),
				array( 'p' => 'The shift comes from the fallback face and the web font occupying different amounts of space. Modern CSS lets you correct that on the fallback with <code>size-adjust</code>, <code>ascent-override</code> and <code>descent-override</code>, so the swap is invisible rather than a jolt.' ),
				array( 'code' => "@font-face {\n  font-family: 'Barlow fallback';\n  src: local('Arial');\n  size-adjust: 96.4%;\n  ascent-override: 98%;\n  descent-override: 22%;\n}" ),
				array( 'h2' => 'And sometimes: do not use one' ),
				array( 'p' => 'On a documentation site read mostly on phones over poor connections, a system stack is a legitimate design decision rather than a surrender. We have shipped it twice. Nobody noticed, and both sites got faster.' ),
			),
		),
		array(
			'title'    => 'What editor training actually needs to cover',
			'slug'     => 'what-editor-training-actually-needs-to-cover',
			'date'     => '2025-08-12 09:00:00',
			'category' => 'design',
			'tags'     => array( 'Handover', 'WordPress', 'Process' ),
			'image'    => 'post-editor-training.jpg',
			'reading'  => '6 min read',
			'excerpt'  => 'An hour, a recording, and a written page. What we cover, what we deliberately leave out, and why the recording matters more than the session.',
			'body'     => array(
				array( 'lede' => 'Training that walks through every block in the inserter teaches nothing. Training that walks through the four tasks a team actually does teaches everything.' ),
				array( 'h2' => 'Find the four tasks first' ),
				array( 'p' => 'Ask the team what they published in the last three months. It is almost always the same handful of jobs: add a post, add a service page, change the details in the footer, put a banner up for an event. Those are the session. Everything else is a reference page they will read when they need it.' ),
				array( 'h2' => 'Teach patterns, not blocks' ),
				array( 'p' => 'Editors do not need to know what a Group block is. They need to know that a page is built by inserting sections, that sections come from the Patterns tab, and that anything they insert can be deleted without consequence. That is three sentences and it covers ninety per cent of the work.' ),
				array( 'h2' => 'Say what is safe' ),
				array( 'p' => 'The most useful thing in an hour of training is permission. We show what is locked, what reverts, and where the undo is. People experiment freely once they know the floor is not going to give way, and they publish more confidently for years afterwards.' ),
				array( 'list' => array( 'Templates can be reset to the theme version from their options menu.', 'Page revisions go back as far as you need.', 'Structural blocks inside a pattern are locked and cannot be dragged out by accident.', 'Nothing an editor can reach changes the design system.' ) ),
				array( 'h2' => 'Record it' ),
				array( 'p' => 'Half the people who need the training have not been hired yet. A recorded walkthrough with chapters outlasts the session, and it is the artefact clients thank us for most often — usually eighteen months later, when the person who attended has moved on.' ),
			),
		),
	);
}

/* ---------------------------------------------------------------- projects */

/**
 * Case studies.
 *
 * @return array
 */
function northline_demo_projects() {
	return array(
		array(
			'title'   => 'A 400-page site cut to 90 without losing traffic',
			'slug'    => 'northgate-health',
			'types'   => array( 'wordpress', 'design' ),
			'image'   => 'project-northgate-health.jpg',
			'excerpt' => 'Content model rebuilt around services and locations rather than the org chart. Organic sessions up 34% in two quarters.',
			'meta'    => array(
				'nl_client'     => 'Northgate Health',
				'nl_sector'     => 'Private healthcare',
				'nl_year'       => '2025',
				'nl_engagement' => 'Full build',
				'nl_duration'   => '11 weeks',
				'nl_stack'      => 'WordPress, ACF, Cloudflare',
				'nl_outcome'    => '+34% organic sessions',
			),
			'body'    => array(
				array( 'stats' => array( array( '34', 'Organic sessions', '%' ), array( '78', 'Fewer pages to maintain', '%' ), array( '1.1', 'Largest contentful paint', 's' ), array( '19', 'More enquiry form starts', '%' ) ) ),
				array( 'h2' => 'Every department had built its own website inside the website' ),
				array( 'p' => 'Northgate had 412 published pages, 38 of which carried 91% of the traffic. Patients searching for a treatment landed on a departmental overview written for referring GPs, then gave up. Nobody could publish anything without a developer, so pages were duplicated rather than edited.' ),
				array( 'p' => 'The brief we were given was a redesign. The brief we agreed after two weeks of discovery was a content model.' ),
				array( 'h2' => 'Three content types instead of four hundred pages' ),
				array( 'p' => 'We modelled the site as treatments, consultants and locations, each with a fixed set of fields, and let the relationships between them generate the rest. A treatment page now assembles its own consultant list, its locations and its related conditions with no manual linking.' ),
				array( 'p' => 'Editors got twelve block patterns, each with constrained options. The design system was built alongside them so that a new treatment page takes fifteen minutes and cannot come out looking wrong.' ),
				array( 'image' => array( 'case-detail-template.jpg', '4/3', 'Plan drawing of the treatment page template' ) ),
				array( 'image' => array( 'case-detail-editor.jpg', '4/3', 'The constrained editor view built for the marketing team' ) ),
				array( 'h2' => 'Ninety pages, and rankings held through the migration' ),
				array( 'p' => '322 URLs were retired behind a redirect map checked against a full crawl of the old site. Organic sessions dipped 4% in week one and were up 34% by the end of the second quarter. The marketing team has published 60 pages since launch without asking us for anything.' ),
				array( 'quote' => array( 'They rebuilt the site around how our patients actually search, not how our departments are organised. Enquiries went up without us spending more on ads.', 'Ruth Adeyemi · Marketing Director, Northgate Health' ) ),
			),
		),
		array(
			'title'   => 'Editorial platform for a team of four writers',
			'slug'    => 'fieldnote',
			'types'   => array( 'headless' ),
			'image'   => 'project-fieldnote.jpg',
			'excerpt' => 'WordPress kept as the editor, Next.js in front. Publish time down from 40 minutes to 6.',
			'meta'    => array(
				'nl_client'     => 'Fieldnote',
				'nl_sector'     => 'Media',
				'nl_year'       => '2025',
				'nl_engagement' => 'Platform',
				'nl_duration'   => '18 weeks',
				'nl_stack'      => 'WordPress, Next.js, Vercel',
				'nl_outcome'    => 'Publish time 40 min → 6 min',
			),
			'body'    => array(
				array( 'stats' => array( array( '6', 'Minutes to publish', ' min' ), array( '92', 'Lighthouse, article template' ), array( '3', 'Editors, no developer' ), array( '48', 'Hours to full re-render', 'h' ) ) ),
				array( 'h2' => 'A newsroom waiting on a build' ),
				array( 'p' => 'Fieldnote publishes eight long pieces a month, each with pull quotes, footnotes and data figures. Their previous static setup meant every correction was a pull request. A typo took forty minutes and a developer, so typos stayed.' ),
				array( 'h2' => 'Keep the editor, replace the front end' ),
				array( 'p' => 'WordPress stayed as the editing surface, because it is the best writing environment their team had used and there was no reason to relitigate that. In front of it we put Next.js, reading through the REST API, with on-demand revalidation triggered on save.' ),
				array( 'p' => 'The interesting work was the preview path. Editors see draft content at a signed URL rendered by the same components as production, so what they approve is what ships.' ),
				array( 'h2' => 'Six minutes, and nobody files a ticket' ),
				array( 'p' => 'Publishing now takes as long as it takes the writer to press the button and reload. Corrections are live in under a minute. Three of the four writers have never spoken to a developer about the site.' ),
				array( 'quote' => array( 'The editor training took an hour and we have not needed a developer to publish anything since. That was the whole point for us.', 'Tom Vasquez · Head of Content, Fieldnote' ) ),
			),
		),
		array(
			'title'   => 'Ticketing storefront rebuilt for mobile first',
			'slug'    => 'kelso-rail',
			'types'   => array( 'commerce', 'wordpress' ),
			'image'   => 'project-kelso-rail.jpg',
			'excerpt' => 'Checkout reduced to two steps. Mobile conversion improved 21% against the previous quarter.',
			'meta'    => array(
				'nl_client'     => 'Kelso Rail',
				'nl_sector'     => 'Transport',
				'nl_year'       => '2024',
				'nl_engagement' => 'Platform',
				'nl_duration'   => '16 weeks',
				'nl_stack'      => 'WordPress, WooCommerce, Cloudflare',
				'nl_outcome'    => '+21% mobile conversion',
			),
			'body'    => array(
				array( 'stats' => array( array( '21', 'Mobile conversion', '%' ), array( '2', 'Checkout steps' ), array( '38', 'Fewer support calls', '%' ), array( '1.4', 'Largest contentful paint', 's' ) ) ),
				array( 'h2' => 'Designed for a desk, sold on a platform' ),
				array( 'p' => 'Seventy-one per cent of Kelso&#8217;s ticket sales started on a phone, usually at a station, often on a poor connection. The checkout was five steps built for a desktop browser, and the drop-off between step two and step three was the whole problem.' ),
				array( 'h2' => 'Two steps, and the journey picker rebuilt' ),
				array( 'p' => 'We rebuilt the journey picker as a single view with sensible defaults — today, now, return — and collapsed checkout to two steps: who is travelling, and how you are paying. Everything optional moved to after payment, including account creation, which had been the largest single point of abandonment.' ),
				array( 'p' => 'On the technical side, the catalogue is WooCommerce with a heavily cut template set, sitting behind Cloudflare with a rules layer that keeps the basket uncached while everything around it is served from the edge.' ),
				array( 'h2' => 'Fewer calls, as well as more sales' ),
				array( 'p' => 'Mobile conversion improved 21% quarter on quarter, and the station team reported a 38% fall in &#8220;I cannot buy a ticket&#8221; calls, which was the outcome the operations team actually cared about.' ),
				array( 'quote' => array( 'Scope was fixed, the estimate held, and they flagged the two things that would have blown the timeline in week one instead of week nine.', 'Ellie Fraser · Operations Lead, Kelso Rail' ) ),
			),
		),
		array(
			'title'   => 'Product marketing site on a two-day publish cycle',
			'slug'    => 'halcyon',
			'types'   => array( 'wordpress' ),
			'image'   => 'project-halcyon.jpg',
			'excerpt' => 'Twelve reusable patterns replaced 60 one-off pages, and marketing stopped queuing behind engineering.',
			'meta'    => array(
				'nl_client'     => 'Halcyon',
				'nl_sector'     => 'B2B SaaS',
				'nl_year'       => '2024',
				'nl_engagement' => 'Full build',
				'nl_duration'   => '9 weeks',
				'nl_stack'      => 'WordPress, block theme, Vercel edge cache',
				'nl_outcome'    => '60 pages → 12 patterns',
			),
			'body'    => array(
				array( 'stats' => array( array( '12', 'Patterns in the library' ), array( '2', 'Days from brief to live', ' days' ), array( '60', 'One-off pages retired' ), array( '94', 'Median Lighthouse' ) ) ),
				array( 'h2' => 'Every campaign needed a developer' ),
				array( 'p' => 'Halcyon&#8217;s marketing team was shipping a landing page a week, and each one was a ticket. By the time we arrived there were sixty pages, no two of them built the same way, and a design that had drifted so far that the newest pages and the oldest shared almost nothing.' ),
				array( 'h2' => 'A pattern library with edges' ),
				array( 'p' => 'We designed twelve sections that could assemble every campaign page the team had built in the previous year, then locked the options: two hero variants, one feature grid, one comparison table, one pricing block, one proof band. Anything genuinely new goes through design, which happens about twice a year rather than weekly.' ),
				array( 'h2' => 'Two days, no ticket' ),
				array( 'p' => 'A campaign page now takes a marketer an afternoon and goes live the next day. Engineering has not touched the marketing site in seven months.' ),
			),
		),
		array(
			'title'   => 'Design system for an in-house team of nine',
			'slug'    => 'merrick-co',
			'types'   => array( 'design' ),
			'image'   => 'project-merrick-co.jpg',
			'excerpt' => 'Handover in six weeks; they have built everything since without us.',
			'meta'    => array(
				'nl_client'     => 'Merrick &amp; Co',
				'nl_sector'     => 'Professional services',
				'nl_year'       => '2024',
				'nl_engagement' => 'Design only',
				'nl_duration'   => '6 weeks',
				'nl_stack'      => 'Figma, Tokens Studio, theme.json',
				'nl_outcome'    => 'Nine developers, one system',
			),
			'body'    => array(
				array( 'stats' => array( array( '6', 'Weeks to handover', ' wks' ), array( '9', 'Developers on the team' ), array( '41', 'Documented components' ), array( '0', 'Follow-up engagements needed' ) ) ),
				array( 'h2' => 'A capable team without a shared vocabulary' ),
				array( 'p' => 'Merrick had nine developers and no designer. Everything worked; nothing matched. Four button styles, three type scales, and a spacing system that existed only in the mind of whoever wrote the last component.' ),
				array( 'h2' => 'Tokens first, components second, documentation throughout' ),
				array( 'p' => 'We built the token layer in Figma with Tokens Studio, exported it straight into theme.json, and then designed the forty-one components their product actually used — no more. Each one shipped with its states, its breakpoints and a written note on when not to use it.' ),
				array( 'p' => 'Two of their developers paired with us for the last fortnight, which is the part that made the handover stick.' ),
				array( 'h2' => 'They own it now' ),
				array( 'p' => 'Eighteen months on, the library has grown by eleven components, none of them ours, all of them consistent with the originals. That is the only measure of a handed-over design system that means anything.' ),
			),
		),
		array(
			'title'   => 'Subscription coffee shop on a headless stack',
			'slug'    => 'sablefield',
			'types'   => array( 'headless', 'commerce' ),
			'image'   => 'project-sablefield.jpg',
			'excerpt' => 'Checkout latency halved on 3G connections, and the roastery got a dashboard it can actually read.',
			'meta'    => array(
				'nl_client'     => 'Sablefield',
				'nl_sector'     => 'Food &amp; drink',
				'nl_year'       => '2023',
				'nl_engagement' => 'Platform',
				'nl_duration'   => '14 weeks',
				'nl_stack'      => 'WordPress, WooCommerce Subscriptions, Next.js',
				'nl_outcome'    => 'Checkout latency halved',
			),
			'body'    => array(
				array( 'stats' => array( array( '52', 'Faster checkout on 3G', '%' ), array( '2.3', 'Seconds to interactive', 's' ), array( '17', 'More subscriptions started', '%' ), array( '4', 'Roasts, one catalogue' ) ) ),
				array( 'h2' => 'Subscriptions on a shop built for one-off sales' ),
				array( 'p' => 'Sablefield sells a rotating subscription and a small retail catalogue. The two had been bolted together, and the subscription flow inherited a checkout designed for someone buying a single bag.' ),
				array( 'h2' => 'Separate the front end from the shop' ),
				array( 'p' => 'WooCommerce stayed as the commerce engine and the roastery&#8217;s order desk. The storefront became a Next.js application talking to it over the Store API, which let us design a subscription flow that asks the four questions that matter — roast, grind, frequency, first delivery — and nothing else.' ),
				array( 'h2' => 'Half the wait, on the connections that matter' ),
				array( 'p' => 'Time to interactive on a throttled 3G profile fell from 4.8 seconds to 2.3. Subscription starts rose 17% in the first quarter, and the roastery&#8217;s weekly planning moved from a spreadsheet export to a screen they trust.' ),
			),
		),
		array(
			'title'   => 'Archive of 12,000 records made searchable',
			'slug'    => 'ordnance-trust',
			'types'   => array( 'wordpress' ),
			'image'   => 'project-ordnance-trust.jpg',
			'excerpt' => 'Faceted search over a custom post type, fast enough to browse rather than query.',
			'meta'    => array(
				'nl_client'     => 'Ordnance Trust',
				'nl_sector'     => 'Heritage',
				'nl_year'       => '2023',
				'nl_engagement' => 'Full build',
				'nl_duration'   => '12 weeks',
				'nl_stack'      => 'WordPress, custom indexes, Cloudflare',
				'nl_outcome'    => '12,000 records, 180 ms search',
			),
			'body'    => array(
				array( 'stats' => array( array( '12', 'Thousand records', 'k' ), array( '180', 'Millisecond median search', 'ms' ), array( '7', 'Facets' ), array( '3', 'Volunteer cataloguers' ) ) ),
				array( 'h2' => 'A catalogue nobody could get into' ),
				array( 'p' => 'The Trust holds twelve thousand catalogued items, previously published as a downloadable spreadsheet. Researchers used it. Nobody else could.' ),
				array( 'h2' => 'Model the record, then index it properly' ),
				array( 'p' => 'Each item became a custom post type with seven controlled facets: period, place, material, maker, collection, condition and access. WordPress&#8217;s default meta queries would have folded at this size, so the facets are maintained in their own index table and kept in sync on save.' ),
				array( 'p' => 'Volunteers catalogue through a deliberately narrow admin screen. The fields that matter are required; the fields that do not exist are not there.' ),
				array( 'h2' => 'Browsing, not querying' ),
				array( 'p' => 'Median search latency is 180 ms across the full catalogue, which is fast enough that people explore. Traffic to the archive tripled in the year after launch, and the reading-room enquiry form now arrives pre-filled with the record reference.' ),
				array( 'p' => 'The indexing layer became <a href="/downloads/">Faceted Search Pro</a>.' ),
			),
		),
		array(
			'title'   => 'Docs and marketing site sharing one system',
			'slug'    => 'loom-analytics',
			'types'   => array( 'design', 'headless' ),
			'image'   => 'project-loom-analytics.jpg',
			'excerpt' => 'One component set, two very different audiences, and a docs search that works on static hosting.',
			'meta'    => array(
				'nl_client'     => 'Loom Analytics',
				'nl_sector'     => 'B2B SaaS',
				'nl_year'       => '2023',
				'nl_engagement' => 'Full build',
				'nl_duration'   => '13 weeks',
				'nl_stack'      => 'WordPress, Next.js, MDX, Pagefind',
				'nl_outcome'    => 'One system, two sites',
			),
			'body'    => array(
				array( 'stats' => array( array( '1', 'Component library' ), array( '2', 'Sites, one deploy' ), array( '340', 'Documentation pages' ), array( '60', 'Faster docs search', '%' ) ) ),
				array( 'h2' => 'Two sites drifting apart' ),
				array( 'p' => 'Loom&#8217;s marketing site was WordPress and its documentation was a separate static site. They shared a logo and nothing else, and the gap widened every quarter.' ),
				array( 'h2' => 'One token layer, two shells' ),
				array( 'p' => 'We built a single component library consumed by both, with tokens exported to theme.json for the marketing site and to CSS custom properties for the docs. Marketing pages are edited in WordPress; documentation stays in MDX next to the code, where the engineers who write it already live.' ),
				array( 'h2' => 'Search without a service' ),
				array( 'p' => 'Documentation search is a static index built at deploy time, so it needs no search service and no ongoing cost. Median query time fell 60% against the hosted search it replaced.' ),
			),
		),
		array(
			'title'   => 'Bike configurator that sales actually uses',
			'slug'    => 'brayton-cycles',
			'types'   => array( 'commerce' ),
			'image'   => 'project-brayton-cycles.jpg',
			'excerpt' => 'Quote requests up 3× against the PDF price list it replaced.',
			'meta'    => array(
				'nl_client'     => 'Brayton Cycles',
				'nl_sector'     => 'Manufacturing',
				'nl_year'       => '2022',
				'nl_engagement' => 'Custom order',
				'nl_duration'   => '7 weeks',
				'nl_stack'      => 'WordPress, vanilla JavaScript, PDF export',
				'nl_outcome'    => '3× quote requests',
			),
			'body'    => array(
				array( 'stats' => array( array( '3', 'Times more quote requests', '×' ), array( '14', 'Configurable options' ), array( '0', 'JavaScript dependencies' ), array( '7', 'Weeks to launch', ' wks' ) ) ),
				array( 'h2' => 'A price list nobody finished reading' ),
				array( 'p' => 'Brayton builds frames to order across fourteen options. That was published as a nine-page PDF, and the sales team spent their mornings turning emailed questions about it into quotes by hand.' ),
				array( 'h2' => 'Fourteen options, no framework' ),
				array( 'p' => 'The configurator is about 8 KB of vanilla JavaScript over server-rendered HTML, so it works before it hydrates and keeps working if it never does. Every combination has a shareable URL, which turned out to be the feature the sales team valued most: they send a link rather than describe a build.' ),
				array( 'p' => 'Submitting produces a formatted PDF quote and an enquiry with the configuration attached, so nothing is retyped.' ),
				array( 'h2' => 'Three times the quotes' ),
				array( 'p' => 'Quote requests tripled in the first quarter and the sales team&#8217;s morning admin disappeared. Four years on, it runs unchanged.' ),
			),
		),
	);
}

/* --------------------------------------------------------------- downloads */

/**
 * The catalogue: themes, plugins, scripts and browser tools.
 *
 * @return array
 */
function northline_demo_downloads() {
	return array_merge(
		northline_demo_themes(),
		northline_demo_plugins(),
		northline_demo_scripts(),
		northline_demo_tools()
	);
}

/**
 * Themes.
 *
 * @return array
 */
function northline_demo_themes() {
	$items = array(
		array(
			'title'    => 'Ledger',
			'slug'     => 'ledger',
			'tags'     => array( 'free', 'block-theme' ),
			'image'    => 'theme-ledger.jpg',
			'excerpt'  => 'A block theme for professional services. Nine patterns, a services archive and a genuinely simple contact layout.',
			'meta'     => array( 'nl_price' => 'Free', 'nl_version' => 'v2.4', 'nl_installs' => '12,400 installs', 'nl_requires' => 'WP 6.4+', 'nl_release' => '28 July 2026', 'nl_rating' => '4.8 / 5 · 212 reviews', 'nl_licence' => 'GPL v2+' ),
			'templates' => array( 'Front page', 'Services single &amp; archive', 'Journal index &amp; post', 'Contact', 'Search &amp; 404' ),
			'patterns'  => array( 'Nine block patterns', 'Two hero variants', 'Figure row and logo strip', 'Pricing pattern', 'Locked-down option sets' ),
			'dev'       => array( 'theme.json token sheet', 'No build step', 'Child theme friendly', 'Demo content import' ),
			'intro'     => 'Ledger came out of a professional-services build where the client needed to publish service pages without a developer. It is the free version of Ledger Pro: the same theme, with the core pattern set.',
		),
		array(
			'title'    => 'Ledger Pro',
			'slug'     => 'ledger-pro',
			'tags'     => array( 'pro', 'block-theme', 'commerce' ),
			'image'    => 'theme-ledger-pro.jpg',
			'excerpt'  => 'Everything in Ledger plus WooCommerce templates, a team directory, 28 patterns and a year of updates.',
			'meta'     => array( 'nl_price' => '£69', 'nl_version' => 'v2.4', 'nl_installs' => '1,850 licences', 'nl_requires' => 'WP 6.4+', 'nl_release' => '28 July 2026', 'nl_rating' => '4.8 / 5 · 212 reviews', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'templates' => array( 'Front page, two variants', 'Service single &amp; archive', 'Location single &amp; archive', 'Team directory', 'Case study single', 'Journal index &amp; post', 'Shop, product, cart, checkout', 'Contact, pricing, 404, search' ),
			'patterns'  => array( '28 block patterns', 'Six hero variants', 'Figure row and logo strip', 'Pricing table pattern', 'Accordion and tab sections', 'Testimonial carousel', 'Locked-down option sets' ),
			'dev'       => array( 'Child theme starter', 'theme.json token sheet', 'Sass source, no build required', 'ACF field group exports', 'WP-CLI demo content import', 'Figma library included' ),
			'intro'     => 'A block theme for professional services firms: 28 patterns, a services and locations content model, WooCommerce templates and a child theme starter. The free version of Ledger is the same theme with the core pattern set.',
		),
		array(
			'title'    => 'Wharf',
			'slug'     => 'wharf',
			'tags'     => array( 'free', 'editorial' ),
			'image'    => 'theme-wharf.jpg',
			'excerpt'  => 'An editorial theme built for long reads. Real typographic scale, footnotes, and an archive that handles 2,000 posts.',
			'meta'     => array( 'nl_price' => 'Free', 'nl_version' => 'v1.9', 'nl_installs' => '8,100 installs', 'nl_requires' => 'WP 6.2+', 'nl_release' => '11 June 2026', 'nl_rating' => '4.7 / 5 · 96 reviews', 'nl_licence' => 'GPL v2+' ),
			'templates' => array( 'Article single', 'Archive with year grouping', 'Author page', 'Category and tag', 'Search &amp; 404' ),
			'patterns'  => array( 'Article opener, three variants', 'Pull quote and aside', 'Footnote list', 'Related reading', 'Newsletter band' ),
			'dev'       => array( 'Fluid type scale in theme.json', 'Locally hosted fonts', 'Print stylesheet', 'No JavaScript on the article template' ),
			'intro'     => 'Wharf is for publications where the article is the product. The type scale is fluid, footnotes are a first-class block, and the archive stays fast past two thousand posts.',
		),
		array(
			'title'    => 'Kelpie',
			'slug'     => 'kelpie',
			'tags'     => array( 'free', 'commerce' ),
			'image'    => 'theme-kelpie.jpg',
			'excerpt'  => 'A small WooCommerce storefront for catalogues under 200 products. Two-step checkout, no bundled page builder.',
			'meta'     => array( 'nl_price' => 'Free', 'nl_version' => 'v1.4', 'nl_installs' => '5,600 installs', 'nl_requires' => 'WP 6.3+', 'nl_release' => '2 May 2026', 'nl_rating' => '4.6 / 5 · 71 reviews', 'nl_licence' => 'GPL v2+' ),
			'templates' => array( 'Shop and category', 'Product single', 'Cart and checkout', 'Account', 'Search &amp; 404' ),
			'patterns'  => array( 'Product grid, two densities', 'Collection banner', 'Size and delivery notes', 'Cross-sell row' ),
			'dev'       => array( 'WooCommerce block templates', 'No page builder dependency', 'Cart fragments kept small', 'theme.json token sheet' ),
			'intro'     => 'Kelpie is a storefront for shops that sell a considered range rather than a warehouse. Checkout is two steps, and everything optional happens after payment.',
		),
		array(
			'title'    => 'Wharf Pro',
			'slug'     => 'wharf-pro',
			'tags'     => array( 'pro', 'editorial' ),
			'image'    => 'theme-wharf-pro.jpg',
			'excerpt'  => 'Memberships, paywalled posts, a newsletter archive and multi-author bylines for publications that earn money.',
			'meta'     => array( 'nl_price' => '£89', 'nl_version' => 'v1.9', 'nl_installs' => '740 licences', 'nl_requires' => 'WP 6.2+', 'nl_release' => '11 June 2026', 'nl_rating' => '4.9 / 5 · 58 reviews', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'templates' => array( 'Everything in Wharf', 'Membership landing', 'Paywalled article', 'Newsletter archive', 'Contributor directory' ),
			'patterns'  => array( 'Paywall prompt, three tones', 'Membership pricing table', 'Issue index', 'Multi-author byline' ),
			'dev'       => array( 'Child theme starter', 'Membership plugin adapters', 'Metered paywall rules', 'Figma library included' ),
			'intro'     => 'Wharf Pro adds the parts a publication needs once readers start paying: memberships, a metered paywall, an issue archive and bylines that credit more than one person.',
		),
		array(
			'title'    => 'Signal',
			'slug'     => 'signal',
			'tags'     => array( 'free', 'block-theme' ),
			'image'    => 'theme-signal.jpg',
			'excerpt'  => 'A one-page theme for product launches. Anchored sections, a pricing pattern and a form that validates without a plugin.',
			'meta'     => array( 'nl_price' => 'Free', 'nl_version' => 'v3.1', 'nl_installs' => '9,900 installs', 'nl_requires' => 'WP 6.4+', 'nl_release' => '19 August 2026', 'nl_rating' => '4.7 / 5 · 134 reviews', 'nl_licence' => 'GPL v2+' ),
			'templates' => array( 'One-page front', 'Standalone page', 'Post single', '404' ),
			'patterns'  => array( 'Anchored hero', 'Feature rows, three rhythms', 'Pricing pattern', 'FAQ accordion', 'Sign-up band' ),
			'dev'       => array( 'Scroll-spy navigation, 1 KB', 'Native form validation', 'theme.json token sheet', 'No external requests' ),
			'intro'     => 'Signal is a single scrolling page for a product that has one thing to say. The navigation tracks the section you are in, and the sign-up form validates without a forms plugin.',
		),
		array(
			'title'    => 'Kelpie Pro',
			'slug'     => 'kelpie-pro',
			'tags'     => array( 'pro', 'commerce' ),
			'image'    => 'theme-kelpie-pro.jpg',
			'excerpt'  => 'Subscriptions, variable products, wishlists and a faceted catalogue that stays fast past a thousand SKUs.',
			'meta'     => array( 'nl_price' => '£119', 'nl_version' => 'v1.4', 'nl_installs' => '410 licences', 'nl_requires' => 'WP 6.3+', 'nl_release' => '2 May 2026', 'nl_rating' => '4.8 / 5 · 44 reviews', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'templates' => array( 'Everything in Kelpie', 'Faceted catalogue', 'Variable product', 'Subscription management page', 'Wishlist' ),
			'patterns'  => array( 'Facet rail', 'Subscription picker', 'Bundle builder', 'Restock notice' ),
			'dev'       => array( 'Child theme starter', 'Indexed facet tables', 'WooCommerce Subscriptions support', 'Figma library included' ),
			'intro'     => 'Kelpie Pro is for catalogues that outgrew a simple shop: subscriptions, variable products and faceted browsing that stays under 200 ms past a thousand SKUs.',
		),
		array(
			'title'    => 'Fieldbook',
			'slug'     => 'fieldbook',
			'tags'     => array( 'free', 'editorial', 'block-theme' ),
			'image'    => 'theme-fieldbook.jpg',
			'excerpt'  => 'A documentation theme with sidebar navigation, versioned pages and search that works on static hosting.',
			'meta'     => array( 'nl_price' => 'Free', 'nl_version' => 'v0.9', 'nl_installs' => '3,200 installs', 'nl_requires' => 'WP 6.4+', 'nl_release' => '30 September 2026', 'nl_rating' => '4.5 / 5 · 27 reviews', 'nl_licence' => 'GPL v2+' ),
			'templates' => array( 'Documentation page', 'Section index', 'Version switcher', 'Search results' ),
			'patterns'  => array( 'Callout, four tones', 'Step list', 'API reference table', 'Copy-to-clipboard code block' ),
			'dev'       => array( 'Static search index', 'Anchored contents rail', 'Versioned page trees', 'System font stack option' ),
			'intro'     => 'Fieldbook is a documentation theme that assumes your readers are in a hurry: a contents rail that tracks the page, a search index built at deploy time, and no JavaScript that is not doing a job.',
		),
		array(
			'title'    => 'Atlas',
			'slug'     => 'atlas',
			'tags'     => array( 'pro', 'block-theme' ),
			'image'    => 'theme-atlas.jpg',
			'excerpt'  => 'A multi-site framework theme: shared patterns, per-site palettes and a locations content type. For groups and franchises.',
			'meta'     => array( 'nl_price' => '£149', 'nl_version' => 'v4.0', 'nl_installs' => '190 licences', 'nl_requires' => 'WP 6.5+', 'nl_release' => '14 October 2026', 'nl_rating' => '4.9 / 5 · 22 reviews', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'templates' => array( 'Group front page', 'Site front page', 'Location single &amp; archive', 'Staff directory', 'Shared journal' ),
			'patterns'  => array( '34 block patterns', 'Location finder', 'Opening hours, synced', 'Group-wide notice band' ),
			'dev'       => array( 'Per-site style variations', 'Shared pattern library across the network', 'Multisite-aware demo import', 'Child theme starter' ),
			'intro'     => 'Atlas is built for groups: one design system, one pattern library, and a palette per site. Locations are a first-class content type, shared across the network and edited once.',
		),
	);

	return array_map(
		function ( $item ) {
			$item['type'] = 'themes';
			$item['body'] = northline_demo_product_body( $item );
			return $item;
		},
		$items
	);
}

/**
 * Body markup shared by every theme in the catalogue.
 *
 * @param array $item Theme definition.
 * @return array Content nodes.
 */
function northline_demo_product_body( $item ) {
	return array(
		array( 'lede' => $item['intro'] ),
		array( 'h2' => 'What is included' ),
		array( 'columns' => array(
			array( 'Templates', $item['templates'] ),
			array( 'Patterns &amp; blocks', $item['patterns'] ),
			array( 'For developers', $item['dev'] ),
		) ),
		array( 'h2' => 'Requirements' ),
		array( 'table' => array(
			array( 'Requirement', 'Minimum' ),
			array(
				array( 'WordPress', str_replace( array( 'WP ', '+' ), '', $item['meta']['nl_requires'] ) ),
				array( 'PHP', '8.1' ),
				array( 'MySQL / MariaDB', '5.7 / 10.4' ),
				array( 'Memory limit', '128 MB' ),
			),
		) ),
		array( 'p' => 'This is a block theme and needs the Site Editor, so classic-theme page builders are not supported. It works with any caching plugin and has been tested on Kinsta, Cloudways and stock LiteSpeed hosting.' ),
		array( 'h2' => 'Changelog' ),
		array( 'table' => array(
			array( 'Version', 'Changes' ),
			array(
				array( $item['meta']['nl_version'], 'Fixed a spacing regression in the pricing pattern on narrow viewports. Archives now respect the Site Editor query loop settings.' ),
				array( 'Previous minor', 'Added patterns, including a two-column case study opener. Dropped unused CSS from the shop templates.' ),
				array( 'Previous patch', 'Accessibility pass on the navigation block: focus order and escape handling. PHP 8.4 compatibility.' ),
			),
		) ),
		array( 'h2' => 'Support and licence' ),
		array( 'p' => 'Licensed under the GNU General Public Licence v2 or later. You may modify it, use it on client work within your site allowance, and keep every version released during your licence term. Bug reports are welcome from free users too, through GitHub issues.' ),
		array( 'p' => 'Paid licences include email support and automatic updates for twelve months, answered within two working days by the people who wrote the theme. After that the theme keeps working; renew at 60% to continue receiving updates. Refunds within fourteen days, no questions asked.' ),
	);
}

/**
 * Plugins.
 *
 * @return array
 */
function northline_demo_plugins() {
	$items = array(
		array(
			'title'   => 'Formwork',
			'slug'    => 'formwork',
			'tags'    => array( 'free', 'editor' ),
			'mark'    => 'FW',
			'excerpt' => 'Accessible contact forms as block patterns. Server-side validation, honeypot spam handling, no third-party service.',
			'meta'    => array( 'nl_price' => 'Free', 'nl_version' => 'v3.2', 'nl_installs' => '31,000 installs', 'nl_requires' => 'WP 6.2+', 'nl_licence' => 'GPL v2+' ),
			'intro'   => 'Formwork exists because every forms plugin we tried either phoned home, or produced markup a screen reader could not follow. It does one thing: renders an accessible form, validates it on the server, and emails you the result.',
			'does'    => array( 'Forms inserted as block patterns, edited like any other block.', 'Validation server-side first, with native constraints layered on top.', 'Honeypot and timing checks instead of a captcha.', 'Submissions stored privately in WordPress as well as emailed.', 'Per-form recipients, subjects and reply-to headers.' ),
			'not'     => array( 'No third-party endpoint and no account.', 'No bundled analytics or tracking pixels.', 'No admin dashboard widget.', 'No upsell notices in the editor.' ),
		),
		array(
			'title'   => 'Formwork Pro',
			'slug'    => 'formwork-pro',
			'tags'    => array( 'pro', 'editor', 'commerce' ),
			'mark'    => 'FP',
			'excerpt' => 'Multi-step forms, conditional logic, file uploads, Stripe payments and an entries screen your team can actually read.',
			'meta'    => array( 'nl_price' => '£49', 'nl_version' => 'v3.2', 'nl_installs' => '2,400 licences', 'nl_requires' => 'WP 6.2+', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'intro'   => 'Everything in Formwork, plus the things a form eventually needs once it is doing real work: more than one step, fields that appear only when they are relevant, uploads, and payment.',
			'does'    => array( 'Multi-step forms with progress saved between steps.', 'Conditional logic on any field, evaluated server-side as well as in the browser.', 'File uploads with type and size limits, stored outside the web root.', 'Stripe payments, one-off or recurring.', 'An entries screen with filters, notes and CSV export.' ),
			'not'     => array( 'No per-submission fees.', 'No hosted form builder to log in to.', 'Entries stay in your database.', 'Uninstalls cleanly, taking its tables with it.' ),
		),
		array(
			'title'   => 'Redirect Desk',
			'slug'    => 'redirect-desk',
			'tags'    => array( 'free', 'ops' ),
			'mark'    => 'RD',
			'excerpt' => 'Bulk redirect management with CSV import, 404 logging and a crawl diff for migrations. Built during the Northgate rebuild.',
			'meta'    => array( 'nl_price' => 'Free', 'nl_version' => 'v2.0', 'nl_installs' => '14,700 installs', 'nl_requires' => 'WP 6.0+', 'nl_licence' => 'GPL v2+' ),
			'intro'   => 'We wrote this in the middle of migrating a 412-page site and retiring three quarters of it. Everything in it is something we needed that week.',
			'does'    => array( 'Import and export redirect maps as CSV.', 'Regex and wildcard rules, tested against a live URL before saving.', 'Redirect chain detection, so nothing takes two hops.', '404 logging with referrers, grouped and sortable.', 'Crawl diff: paste two URL lists and see what lost a destination.' ),
			'not'     => array( 'No per-request database query on cached pages.', 'No rewrite rule bloat.', 'Rules exportable, so you can move them into nginx later.', 'Logging can be switched off entirely.' ),
		),
		array(
			'title'   => 'Meta Bench',
			'slug'    => 'meta-bench',
			'tags'    => array( 'free', 'seo' ),
			'mark'    => 'MB',
			'excerpt' => 'Titles, descriptions, Open Graph and JSON-LD schema, editable per template. About 90 KB, no dashboard takeover.',
			'meta'    => array( 'nl_price' => 'Free', 'nl_version' => 'v1.8', 'nl_installs' => '9,300 installs', 'nl_requires' => 'WP 6.2+', 'nl_licence' => 'GPL v2+' ),
			'intro'   => 'The SEO plugin we install on client sites, because the popular ones are ten megabytes of dashboard for four tags of output.',
			'does'    => array( 'Title and description templates per post type, overridable per post.', 'Open Graph and Twitter card tags, with a per-post image.', 'JSON-LD for organisation, article, product, breadcrumb and FAQ.', 'XML sitemaps that extend the core ones rather than replacing them.', 'A readable preview of what a search result will look like.' ),
			'not'     => array( 'No content scoring or traffic-light widgets.', 'No dashboard notices.', 'No redirect manager — that is Redirect Desk.', 'Around 90 KB, and nothing loads on the front end that is not a tag.' ),
		),
		array(
			'title'   => 'Care Monitor',
			'slug'    => 'care-monitor',
			'tags'    => array( 'pro', 'seo', 'ops' ),
			'mark'    => 'CM',
			'excerpt' => 'Uptime, Core Web Vitals and PHP error tracking for the sites you look after, in one screen with weekly email digests.',
			'meta'    => array( 'nl_price' => '£79/yr', 'nl_version' => 'v1.5', 'nl_installs' => '620 licences', 'nl_requires' => 'WP 6.2+', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'intro'   => 'We run care plans for around thirty sites. This is the screen we built so that a problem on any of them reaches us before it reaches the client.',
			'does'    => array( 'Uptime checks from three regions, with escalation after two failures.', 'Field Core Web Vitals collected from real visits, not a lab run.', 'PHP error and deprecation tracking, grouped by file and release.', 'Plugin and core update status across every connected site.', 'A weekly digest you can white-label and forward to a client.' ),
			'not'     => array( 'No agent installed on the monitored site beyond a small mu-plugin.', 'No visitor-level data collected.', 'Data stays on your own dashboard install.', 'Uninstalls cleanly.' ),
		),
		array(
			'title'   => 'Block Kit',
			'slug'    => 'block-kit',
			'tags'    => array( 'free', 'editor' ),
			'mark'    => 'BK',
			'excerpt' => 'Fourteen editor blocks we kept rebuilding: accordion, tabs, stat row, logo strip, timeline. Locked-down options by design.',
			'meta'    => array( 'nl_price' => 'Free', 'nl_version' => 'v2.6', 'nl_installs' => '12,100 installs', 'nl_requires' => 'WP 6.4+', 'nl_licence' => 'GPL v2+' ),
			'intro'   => 'Every project needed an accordion. After the fourth time, we made one properly and stopped writing it again.',
			'does'    => array( 'Accordion, tabs, stat row with counters, logo strip, timeline, comparison table.', 'Every block inherits your theme.json palette and type scale.', 'Keyboard and screen-reader behaviour tested against WCAG 2.2 AA.', 'Options deliberately narrow, so a page cannot come out looking wrong.', 'No block styles that duplicate what core already does.' ),
			'not'     => array( 'No page builder mode.', 'No block library upsell tab.', 'Around 18 KB of front-end JavaScript, only on pages that use a block that needs it.', 'Blocks degrade to readable content with JavaScript off.' ),
		),
		array(
			'title'   => 'Faceted Search Pro',
			'slug'    => 'faceted-search-pro',
			'tags'    => array( 'pro', 'commerce' ),
			'mark'    => 'FS',
			'excerpt' => 'Indexed filtering for large catalogues and archives. Stays under 200 ms on 50,000 posts without an external search service.',
			'meta'    => array( 'nl_price' => '£99', 'nl_version' => 'v2.1', 'nl_installs' => '340 licences', 'nl_requires' => 'WP 6.2+', 'nl_licence' => 'GPL v2+ · 12 months of updates' ),
			'intro'   => 'Built for a heritage archive of twelve thousand records, then hardened on a catalogue of fifty thousand. Meta queries do not scale; an index does.',
			'does'    => array( 'Maintains its own index tables, kept in sync on save.', 'Facets from taxonomies, meta fields or derived values.', 'Counts shown per facet, calculated in the same query.', 'URL state, so a filtered view is shareable and cacheable.', 'Works as a block, so the filter rail is placed in the Site Editor.' ),
			'not'     => array( 'No external search service and no monthly fee.', 'No JavaScript framework on the front end.', 'Rebuildable index — nothing is lost if it drifts.', 'Uninstalls cleanly, dropping its tables.' ),
		),
		array(
			'title'   => 'Snapshot Vault',
			'slug'    => 'snapshot-vault',
			'tags'    => array( 'free', 'ops' ),
			'mark'    => 'SV',
			'excerpt' => 'Scheduled database and uploads backups to S3 or Backblaze, with a one-click restore that has been tested on real sites.',
			'meta'    => array( 'nl_price' => 'Free', 'nl_version' => 'v1.3', 'nl_installs' => '5,400 installs', 'nl_requires' => 'WP 6.0+', 'nl_licence' => 'GPL v2+' ),
			'intro'   => 'A backup you have never restored is a hypothesis. This one has a restore path we use, on purpose, on staging, every month.',
			'does'    => array( 'Scheduled database and uploads backups, incremental after the first.', 'S3, Backblaze B2 or any S3-compatible endpoint.', 'Restore to the same site or into a fresh install.', 'Integrity check after every upload, with an email when one fails.', 'WP-CLI commands for backup, list and restore.' ),
			'not'     => array( 'No hosted storage to buy from us.', 'No file size limits beyond your own bucket.', 'Credentials read from wp-config, not stored in the database.', 'Backups are plain archives you can open yourself.' ),
		),
	);

	return array_map(
		function ( $item ) {
			$item['type']            = 'plugins';
			$item['meta']['nl_mark'] = $item['mark'];
			$item['body']            = array(
				array( 'lede' => $item['intro'] ),
				array( 'h2' => 'What it does' ),
				array( 'list' => $item['does'] ),
				array( 'h2' => 'What it does not do' ),
				array( 'list' => $item['not'] ),
				array( 'h2' => 'Requirements' ),
				array( 'table' => array(
					array( 'Requirement', 'Minimum' ),
					array(
						array( 'WordPress', str_replace( array( 'WP ', '+' ), '', $item['meta']['nl_requires'] ) ),
						array( 'PHP', '8.0' ),
						array( 'Multisite', 'Supported' ),
					),
				) ),
				array( 'h2' => 'Licence' ),
				array( 'p' => 'GNU General Public Licence v2 or later. Free plugins are supported through the community forum and GitHub issues. Paid licences include email support and automatic updates for twelve months, answered within two working days.' ),
			);
			return $item;
		},
		$items
	);
}

/**
 * Scripts.
 *
 * @return array
 */
function northline_demo_scripts() {
	$items = array(
		array(
			'title'   => 'scroll-cue.js',
			'slug'    => 'scroll-cue-js',
			'tags'    => array( 'motion' ),
			'mark'    => 'SC',
			'size'    => '2.1 KB',
			'usage'   => '<div data-cue="fade-up" data-cue-delay="120">',
			'excerpt' => 'Reveal-on-scroll with a single data attribute. Respects prefers-reduced-motion and never leaves content hidden if the observer fails.',
			'intro'   => 'Reveal animations are the easiest way to hide your content from someone permanently. This one is written so that every failure mode ends with the content visible.',
			'does'    => array( 'One data attribute per element; no configuration object.', 'Honours prefers-reduced-motion by showing everything immediately.', 'Falls back to visible if IntersectionObserver is missing or throttled.', 'Staggering by delay attribute rather than by index maths.' ),
		),
		array(
			'title'   => 'tablekit.js',
			'slug'    => 'tablekit-js',
			'tags'    => array( 'ui' ),
			'mark'    => 'TK',
			'size'    => '4.8 KB',
			'usage'   => "tablekit('#prices', { sort: true, filter: true })",
			'excerpt' => 'Sort, filter and paginate an ordinary HTML table. Keyboard accessible, announces changes to screen readers, keeps your markup.',
			'intro'   => 'Your table is already correct HTML. This adds behaviour to it without rewriting it into divs.',
			'does'    => array( 'Sorting by column, with the type inferred or declared.', 'Filtering across all columns or a named one.', 'Pagination that degrades to a full table without JavaScript.', 'aria-sort and a live region, so changes are announced.' ),
		),
		array(
			'title'   => 'lazyframe.js',
			'slug'    => 'lazyframe-js',
			'tags'    => array( 'performance' ),
			'mark'    => 'LF',
			'size'    => '1.6 KB',
			'usage'   => '<div data-lazyframe="https://youtu.be/…">',
			'excerpt' => 'Replaces embedded video and map iframes with a facade until clicked. Typically saves 900 KB on a page with one YouTube embed.',
			'intro'   => 'A YouTube embed costs roughly a megabyte and several third-party cookies before anyone presses play. A facade costs a thumbnail.',
			'does'    => array( 'Facades for YouTube, Vimeo and map embeds.', 'Loads the real iframe on click or on keyboard activation.', 'Sets no third-party cookies until the visitor asks for the content.', 'Thumbnail served from your own origin if you provide one.' ),
		),
		array(
			'title'   => 'formguard.js',
			'slug'    => 'formguard-js',
			'tags'    => array( 'forms' ),
			'mark'    => 'FG',
			'size'    => '3.4 KB',
			'usage'   => "formguard(document.querySelector('form'))",
			'excerpt' => 'Progressive form validation on top of native constraints. Inline messages, error summary, focus management, no styling opinions.',
			'intro'   => 'The browser already knows whether an email address is valid. This makes the browser say so politely, in the right place, at the right time.',
			'does'    => array( 'Builds on the Constraint Validation API rather than replacing it.', 'Inline messages tied to the field with aria-describedby.', 'An error summary at the top of the form, focused on submit.', 'No styles shipped — it adds classes and gets out of the way.' ),
		),
		array(
			'title'   => 'popover.js',
			'slug'    => 'popover-js',
			'tags'    => array( 'ui' ),
			'mark'    => 'PO',
			'size'    => '2.9 KB',
			'usage'   => '<button data-popover="#menu" data-placement="bottom">',
			'excerpt' => 'Dropdowns, menus and tooltips on the native popover API, with a fallback for older browsers. Handles focus trapping and escape.',
			'intro'   => 'Browsers grew a popover API. This is a thin layer over it that adds placement and a fallback, and nothing else.',
			'does'    => array( 'Uses the native popover attribute where it exists.', 'Placement with the anchor positioning API, falling back to a small calculation.', 'Focus trapping and restoration, escape to close, click outside to dismiss.', 'Works for menus, tooltips and disclosure widgets from the same code.' ),
		),
		array(
			'title'   => 'counterup.js',
			'slug'    => 'counterup-js',
			'tags'    => array( 'motion', 'performance' ),
			'mark'    => 'CU',
			'size'    => '1.2 KB',
			'usage'   => '<span data-count-to="9.4" data-decimals="1">',
			'excerpt' => 'Number counters that animate once when scrolled into view, format with Intl, and degrade to the final value without JavaScript.',
			'intro'   => 'The counter animation everyone asks for, written so that the final number is in the HTML and the animation is the enhancement.',
			'does'    => array( 'Final value lives in the markup; the script counts up to it.', 'Formats with Intl.NumberFormat, so locales and currencies are handled.', 'Animates once, then stops observing.', 'Skips the animation entirely under prefers-reduced-motion.' ),
		),
	);

	return array_map(
		function ( $item ) {
			$item['type']             = 'scripts';
			$item['meta']             = array(
				'nl_price'    => $item['size'],
				'nl_version'  => 'v1.0',
				'nl_installs' => 'MIT licensed',
				'nl_requires' => 'No dependencies',
				'nl_licence'  => 'MIT',
				'nl_mark'     => $item['mark'],
				'nl_usage'    => $item['usage'],
			);
			$item['body']             = array(
				array( 'lede' => $item['intro'] ),
				array( 'h2' => 'Usage' ),
				array( 'code' => $item['usage'] ),
				array( 'h2' => 'What it does' ),
				array( 'list' => $item['does'] ),
				array( 'h2' => 'Install' ),
				array( 'code' => "npm i @northline/" . str_replace( '-js', '', $item['slug'] ) . "\n# or drop the file in and add a script tag" ),
				array( 'h2' => 'Licence' ),
				array( 'p' => 'MIT. Use it anywhere, including commercially, with or without attribution. Issues and pull requests are welcome.' ),
			);
			return $item;
		},
		$items
	);
}

/**
 * Browser tools.
 *
 * @return array
 */
function northline_demo_tools() {
	$items = array(
		array(
			'title'   => 'Redirect map builder',
			'slug'    => 'redirect-map-builder',
			'mark'    => 'T/01',
			'excerpt' => 'Paste two URL lists, get a matched redirect map as CSV, .htaccess or nginx rules.',
			'intro'   => 'Paste the old site&#8217;s URLs and the new site&#8217;s URLs. It matches them on path similarity, shows you what it is unsure about, and exports the map in whichever format your server wants.',
			'does'    => array( 'Fuzzy path matching with a confidence score per row.', 'Unmatched URLs listed separately so nothing is quietly dropped.', 'Export as CSV, .htaccess, nginx or a Redirect Desk import.', 'Everything happens in your browser; neither list is uploaded.' ),
		),
		array(
			'title'   => 'Type scale calculator',
			'slug'    => 'type-scale-calculator',
			'mark'    => 'T/02',
			'excerpt' => 'Modular scales with fluid clamp() output and a live specimen in your own font.',
			'intro'   => 'Choose a base size, a ratio and a viewport range, and get a fluid type scale as clamp() declarations — plus a theme.json fontSizes block you can paste straight into a theme.',
			'does'    => array( 'Any ratio, including custom ones.', 'Fluid clamp() output with the maths shown.', 'theme.json export for block themes.', 'Live specimen using a font from your own machine.' ),
		),
		array(
			'title'   => 'Schema builder',
			'slug'    => 'schema-builder',
			'mark'    => 'T/03',
			'excerpt' => 'JSON-LD for organisations, articles, products and FAQs, validated as you type.',
			'intro'   => 'A form for each of the schema types that actually affect search results, with validation as you type and a copyable JSON-LD block at the end.',
			'does'    => array( 'Organisation, LocalBusiness, Article, Product, FAQ and Breadcrumb.', 'Required and recommended fields marked separately.', 'Warnings for the mistakes that cause rich results to be withheld.', 'Copyable JSON-LD, or a Meta Bench import.' ),
		),
		array(
			'title'   => 'Favicon forge',
			'slug'    => 'favicon-forge',
			'mark'    => 'T/04',
			'excerpt' => 'One SVG in, the full icon set and web manifest out. Nothing leaves your machine.',
			'intro'   => 'Drop in an SVG and get every icon a browser or platform asks for, plus the manifest and the markup, generated locally with canvas.',
			'does'    => array( 'ICO, PNG and maskable variants at every size in use.', 'A web app manifest with the fields filled in.', 'The exact head markup to paste.', 'Runs offline; nothing is uploaded.' ),
		),
		array(
			'title'   => 'WP salt generator',
			'slug'    => 'wp-salt-generator',
			'mark'    => 'T/05',
			'excerpt' => 'Fresh authentication keys for wp-config.php, generated locally on each load.',
			'intro'   => 'The same output as the official service, generated in your own browser with the Web Crypto API rather than fetched from a remote endpoint.',
			'does'    => array( 'Eight keys and salts, correctly formatted for wp-config.php.', 'Generated with crypto.getRandomValues, never sent anywhere.', 'Regenerates on every load, and on demand.', 'Copy button that copies the whole block.' ),
		),
		array(
			'title'   => 'Image budget checker',
			'slug'    => 'image-budget-checker',
			'mark'    => 'T/06',
			'excerpt' => 'Drop a folder of images and see what they cost against a page weight budget.',
			'intro'   => 'Drag in a folder of images and set a budget. It shows the total, the worst offenders, and what each one would weigh re-encoded as AVIF or WebP at a sensible quality.',
			'does'    => array( 'Total weight against a budget you set.', 'Per-file re-encode estimates for AVIF and WebP.', 'Flags images larger than the dimensions they are displayed at.', 'Decodes locally; no image is uploaded.' ),
		),
	);

	return array_map(
		function ( $item ) {
			$item['type'] = 'tools';
			$item['tags'] = array( 'free' );
			$item['meta'] = array(
				'nl_price'    => 'Free',
				'nl_version'  => 'Browser tool',
				'nl_installs' => 'No account needed',
				'nl_requires' => 'A modern browser',
				'nl_licence'  => 'MIT',
				'nl_mark'     => $item['mark'],
			);
			$item['body'] = array(
				array( 'lede' => $item['intro'] ),
				array( 'h2' => 'What it does' ),
				array( 'list' => $item['does'] ),
				array( 'note' => 'This tool runs entirely in your browser. Nothing you drop into it is uploaded, logged or seen by us.' ),
				array( 'h2' => 'Licence' ),
				array( 'p' => 'MIT, and the source is on GitHub. If it is useful, take it and put it on your own intranet.' ),
			);
			return $item;
		},
		$items
	);
}

/* ------------------------------------------------------------------- menus */

/**
 * The primary navigation, as block markup.
 *
 * @return string
 */
function northline_demo_navigation() {
	$link = function ( $label, $url, $kind = 'custom' ) {
		return sprintf(
			'<!-- wp:navigation-link {"label":"%s","url":"%s","kind":"%s"} /-->',
			esc_attr( $label ),
			esc_url( $url ),
			esc_attr( $kind )
		);
	};

	$submenu = sprintf(
		'<!-- wp:navigation-submenu {"label":"Downloads","url":"%s","kind":"custom"} -->%s<!-- /wp:navigation-submenu -->',
		esc_url( northline_archive_url( 'download' ) ),
		$link( 'Free WordPress themes', northline_page_url( 'themes' ) )
		. $link( 'Free WordPress plugins', northline_page_url( 'plugins' ) )
		. $link( 'JavaScripts &amp; tools', northline_page_url( 'scripts-and-tools' ) )
		. $link( 'The whole catalogue', northline_archive_url( 'download' ) )
		. $link( 'Custom orders', northline_page_url( 'custom-orders' ) )
	);

	return $submenu
		. $link( 'Docs', northline_page_url( 'tutorials-and-docs' ) )
		. $link( 'Custom orders', northline_page_url( 'custom-orders' ) )
		. $link( 'Work', northline_archive_url( 'project' ) )
		. $link( 'Services', northline_page_url( 'services' ) )
		. $link( 'Studio', northline_page_url( 'studio' ) )
		. $link( 'Journal', northline_page_url( 'journal' ) );
}
