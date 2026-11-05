<?php
/** Delivery and returns; intentionally avoids invented policy promises. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container">
<?php while ( have_posts() ) : the_post(); ?>
<?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'ORDERS & AFTERCARE', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1></header>
<div class="info-page-grid"><div class="entry-content">
<?php if ( trim( get_the_content() ) ) : the_content(); else : ?>
<p><?php esc_html_e( 'For the latest delivery destinations, charges, dispatch estimates and return conditions, please contact our team before ordering. Details at checkout depend on the shipping methods configured for your address.', 'daraz-law-shop' ); ?></p>
<?php endif; ?>
</div><aside class="info-aside"><h2><?php esc_html_e( 'Questions about an order?', 'daraz-law-shop' ); ?></h2><p><?php esc_html_e( 'We can help with delivery and product enquiries.', 'daraz-law-shop' ); ?></p><a class="text-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact us', 'daraz-law-shop' ); ?> ↗</a></aside></div>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
