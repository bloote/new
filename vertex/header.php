<?php
/**
 * The header for our theme.
 *
 * @package Vertex
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'vertex' ); ?></a>

<?php if ( $topbar = get_theme_mod( 'vertex_topbar_text', '' ) ) : ?>
	<div class="vx-topbar">
		<div class="vx-container"><?php echo wp_kses_post( $topbar ); ?></div>
	</div>
<?php endif; ?>

<header id="masthead" class="site-header" data-header>
	<div class="vx-container site-header__inner">

		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php vertex_logo_mark(); ?>
						<span><?php bloginfo( 'name' ); ?></span>
					</a>
				</p>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'vertex' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => 'vertex_primary_menu_fallback',
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="header-actions">
			<?php if ( get_theme_mod( 'vertex_header_search', true ) ) : ?>
				<button class="vx-icon-btn" data-search-toggle aria-label="<?php esc_attr_e( 'Search', 'vertex' ); ?>">
					<?php vertex_icon( 'search' ); ?>
				</button>
			<?php endif; ?>

			<?php
			$cta_text = get_theme_mod( 'vertex_header_cta_text', __( "Let's Talk", 'vertex' ) );
			$cta_url  = get_theme_mod( 'vertex_header_cta_url', '#contact' );
			if ( $cta_text ) :
				?>
				<a class="vx-btn vx-btn--primary" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
			<?php endif; ?>

			<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'vertex' ); ?>">
				<span class="bars"></span>
			</button>
		</div>
	</div>

	<?php if ( get_theme_mod( 'vertex_header_search', true ) ) : ?>
		<div class="vx-search-panel" data-search-panel hidden>
			<div class="vx-container">
				<?php get_search_form(); ?>
			</div>
		</div>
	<?php endif; ?>
</header>

<div id="content" class="site-content">
