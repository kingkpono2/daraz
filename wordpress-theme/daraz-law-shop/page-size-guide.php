<?php
/** Size-guide page; measurements are merchant-owned WordPress content. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container">
<?php while ( have_posts() ) : the_post(); ?>
<?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'THE FIT GUIDE', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1></header>
<div class="info-page-grid"><div class="entry-content">
<?php if ( trim( get_the_content() ) ) : the_content(); else : ?>
<p><?php esc_html_e( 'Sizing can vary by garment. Please check the measurements and size options on each product page. For advice on a particular item, contact our team before placing an order.', 'daraz-law-shop' ); ?></p>
<?php endif; ?>
</div><aside class="info-aside"><h2><?php esc_html_e( 'A considered fit', 'daraz-law-shop' ); ?></h2><p><?php esc_html_e( 'Ask us about fabric, fit and available sizes.', 'daraz-law-shop' ); ?></p><a class="text-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Get sizing help', 'daraz-law-shop' ); ?> ↗</a></aside></div>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
