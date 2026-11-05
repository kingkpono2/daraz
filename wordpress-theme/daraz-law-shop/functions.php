<?php
/**
 * Daraz Law Shop theme bootstrap.
 *
 * @package Daraz_Law_Shop
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'DARAZ_THEME_VERSION', '1.3.0' );

function daraz_theme_setup() {
	load_theme_textdomain( 'daraz-law-shop', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 100, 'width' => 340, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 520,
		'single_image_width'    => 960,
		'product_grid'          => array( 'default_rows' => 4, 'min_rows' => 2, 'max_rows' => 8, 'default_columns' => 3, 'min_columns' => 2, 'max_columns' => 4 ),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Main navigation', 'daraz-law-shop' ),
		'footer'  => __( 'Footer navigation', 'daraz-law-shop' ),
	) );
}
add_action( 'after_setup_theme', 'daraz_theme_setup' );

function daraz_enqueue_assets() {
	$css = get_theme_file_path( '/style.css' );
	$js  = get_theme_file_path( '/assets/js/theme.js' );
	wp_enqueue_style( 'daraz-theme', get_stylesheet_uri(), array(), file_exists( $css ) ? (string) filemtime( $css ) : DARAZ_THEME_VERSION );
	wp_enqueue_script( 'daraz-theme', get_theme_file_uri( '/assets/js/theme.js' ), array(), file_exists( $js ) ? (string) filemtime( $js ) : DARAZ_THEME_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'daraz_enqueue_assets' );

function daraz_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Shop filters', 'daraz-law-shop' ),
		'id'            => 'shop-filters',
		'description'   => __( 'WooCommerce filters and widgets for the shop.', 'daraz-law-shop' ),
		'before_widget' => '<section class="shop-widget widget %2$s" id="%1$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'daraz_register_sidebars' );

require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/woocommerce.php';
require_once get_template_directory() . '/inc/setup-pages.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/conversion.php';

/** Print a decorative excerpt from the existing approved editorial artwork. */
function daraz_editorial_crop( $box, $class = '' ) {
	$art_path = file_exists( get_theme_file_path( '/assets/images/editorial-home.webp' ) ) ? '/assets/images/editorial-home.webp' : '/assets/images/editorial-home.png';
	$asset = get_theme_file_uri( $art_path );
	printf(
		'<svg class="editorial-crop %1$s" viewBox="%2$s" preserveAspectRatio="xMidYMid slice" role="img" aria-label="%3$s"><image href="%4$s" width="1024" height="1536" /></svg>',
		esc_attr( $class ),
		esc_attr( $box ),
		esc_attr__( 'Daraz Law Shop legalwear editorial imagery', 'daraz-law-shop' ),
		esc_url( $asset )
	);
}

/** Logo fallback retains branding without requiring any uploaded assets. */
function daraz_brand() {
	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		printf(
			'<a class="wordmark" href="%1$s" rel="home"><span class="wordmark-name">DARAZ</span><span class="wordmark-sub">LAW SHOP</span></a>',
			esc_url( home_url( '/' ) )
		);
	}
}

function daraz_post_meta() {
	printf(
		'<span class="post-meta"><time datetime="%1$s">%2$s</time><span aria-hidden="true"> / </span>%3$s</span>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_html( get_the_author() )
	);
}
