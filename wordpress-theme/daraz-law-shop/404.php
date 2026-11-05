<?php
/** Missing page template. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container not-found"><p class="eyebrow">404 / <?php esc_html_e( 'PAGE NOT FOUND', 'daraz-law-shop' ); ?></p><h1><?php esc_html_e( 'This page has moved on.', 'daraz-law-shop' ); ?></h1><p><?php esc_html_e( 'The page you were looking for could not be found. Explore the collection instead.', 'daraz-law-shop' ); ?></p><a class="button button-dark" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return home', 'daraz-law-shop' ); ?> ↗</a></main>
<?php get_footer(); ?>
