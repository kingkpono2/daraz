<?php
/**
 * WooCommerce compatibility: stock, cart, checkout, orders, taxes and payments
 * remain controlled by WooCommerce and installed payment/shipping extensions.
 *
 * @package Daraz_Law_Shop
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function daraz_cart_quantity() {
	return function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
}

function daraz_cart_link() {
	if ( function_exists( 'wc_get_cart_url' ) ) {
		return wc_get_cart_url();
	}
	return home_url( '/' );
}

function daraz_cart_button() {
	printf(
		'<a class="header-bag" href="%1$s" aria-label="%2$s"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M5 8h14l2 13H3L5 8Z"/><path d="M8 9V6a4 4 0 0 1 8 0v3"/></svg><span class="cart-quantity">%3$d</span></a>',
		esc_url( daraz_cart_link() ),
		esc_attr__( 'View shopping bag', 'daraz-law-shop' ),
		absint( daraz_cart_quantity() )
	);
}

function daraz_cart_fragments( $fragments ) {
	ob_start();
	daraz_cart_button();
	$fragments['a.header-bag'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'daraz_cart_fragments' );

function daraz_shop_wrapper_start() {
	echo '<main id="primary" class="site-main shop-main"><div class="container">';
}
function daraz_shop_wrapper_end() {
	echo '</div></main>';
}

/** WooCommerce's template hooks are preferred to brittle template overrides. */
function daraz_woocommerce_hooks() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_before_main_content', 'daraz_shop_wrapper_start', 10 );
	add_action( 'woocommerce_after_main_content', 'daraz_shop_wrapper_end', 10 );
}
add_action( 'wp', 'daraz_woocommerce_hooks' );

function daraz_products_per_page( $number ) {
	return 12;
}
add_filter( 'loop_shop_per_page', 'daraz_products_per_page', 20 );

function daraz_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'daraz_woocommerce_loop_columns' );

/** Add contextual shop filters without replacing WooCommerce product archives. */
function daraz_shop_sidebar() {
	if ( ! is_active_sidebar( 'shop-filters' ) || ! function_exists( 'is_shop' ) ) {
		return;
	}
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		echo '<aside class="shop-filters" aria-label="' . esc_attr__( 'Shop filters', 'daraz-law-shop' ) . '">';
		dynamic_sidebar( 'shop-filters' );
		echo '</aside>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'daraz_shop_sidebar', 8 );
