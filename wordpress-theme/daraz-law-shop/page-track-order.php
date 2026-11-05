<?php
/** WooCommerce order tracking, with guarded fallback. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container"><div class="reading-layout">
<?php while ( have_posts() ) : the_post(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'YOUR PURCHASE', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1></header>
<div class="entry-content"><?php if ( trim( get_the_content() ) ) { the_content(); } elseif ( class_exists( 'WooCommerce' ) ) { echo do_shortcode( '[woocommerce_order_tracking]' ); } else { esc_html_e( 'Order tracking will be available when the store is configured.', 'daraz-law-shop' ); } ?></div>
<?php endwhile; ?></div></main>
<?php get_footer(); ?>
