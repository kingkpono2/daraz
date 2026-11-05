<?php
/** Global header. @package Daraz_Law_Shop */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#171a17">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'daraz-law-shop' ); ?></a>
<div id="page" class="site">
<div class="announcement"><div class="container announcement-inner"><span><?php esc_html_e( 'PROFESSIONAL LEGALWEAR • MADE FOR THE MOMENTS THAT MATTER', 'daraz-law-shop' ); ?></span><a href="<?php echo esc_url( get_theme_mod( 'daraz_phone', '+2348033910334' ) ? 'tel:' . preg_replace( '/[^+0-9]/', '', get_theme_mod( 'daraz_phone', '+2348033910334' ) ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Talk to an expert', 'daraz-law-shop' ); ?> <span aria-hidden="true">↗</span></a></div></div>
<header id="masthead" class="site-header">
<div class="container header-inner">
<div class="site-branding"><?php daraz_brand(); ?></div>
<button class="nav-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'daraz-law-shop' ); ?>"><span></span><span></span><span></span></button>
<nav id="site-navigation" class="primary-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'daraz-law-shop' ); ?>">
<?php if ( has_nav_menu( 'primary' ) ) :
	wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'depth' => 2 ) );
else : ?>
<ul class="nav-list"><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'daraz-law-shop' ); ?></a></li>
<li><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Shop collection', 'daraz-law-shop' ); ?></a></li>
<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'Our story', 'daraz-law-shop' ); ?></a></li>
<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'daraz-law-shop' ); ?></a></li></ul>
<?php endif; ?>
</nav>
<div class="header-actions">
<form role="search" method="get" class="product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<label class="screen-reader-text" for="header-search"><?php esc_html_e( 'Search products', 'daraz-law-shop' ); ?></label>
<svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 5 5"/></svg>
<input id="header-search" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search legalwear', 'daraz-law-shop' ); ?>">
<input type="hidden" name="post_type" value="product">
</form>
<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
<a class="account-link" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'My account', 'daraz-law-shop' ); ?>"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 22c0-5 3-7 8-7s8 2 8 7"/></svg></a>
<?php endif; ?>
<?php daraz_cart_button(); ?>
</div>
</div>
</header>
