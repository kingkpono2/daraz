<?php
/** Full-width WooCommerce my-account template. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container woocommerce commerce-page commerce-my-account">
<?php while ( have_posts() ) : the_post(); ?>
<header class="page-intro commerce-page-intro">
<p class="eyebrow"><?php esc_html_e( 'YOUR DARAZ ACCOUNT', 'daraz-law-shop' ); ?></p>
<h1><?php the_title(); ?></h1>
<p class="commerce-page-hint"><?php esc_html_e( 'View orders, account details and saved addresses.', 'daraz-law-shop' ); ?></p>
</header>
<div class="commerce-content entry-content"><?php the_content(); wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>' ) ); ?></div>
<?php endwhile; ?></main>
<?php get_footer(); ?>
