<?php
/** About page (automatically used for the /about/ page slug). @package Daraz_Law_Shop */
get_header();
?>
<main id="primary" class="site-main container content-container">
<?php while ( have_posts() ) : the_post(); ?>
<?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'THE BRAND', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1></header>
<div class="info-page-grid">
<div class="entry-content"><?php if ( trim( get_the_content() ) ) : the_content(); else : ?>
<p class="lead"><?php echo esc_html( get_theme_mod( 'daraz_story_text', 'We combine heritage and modern craftsmanship to create legalwear that commands respect—in and out of court.' ) ); ?></p>
<p><?php esc_html_e( 'At Daraz Law Shop, our focus is purposeful professional wear: considered details, a confident fit and pieces made for the practice of law.', 'daraz-law-shop' ); ?></p>
<?php endif; ?></div>
<aside class="info-aside"><p class="eyebrow"><?php esc_html_e( 'DISCOVER', 'daraz-law-shop' ); ?></p><h2><?php esc_html_e( 'Made for the profession.', 'daraz-law-shop' ); ?></h2>
<p><?php esc_html_e( 'Explore the collection or speak with us about sizing.', 'daraz-law-shop' ); ?></p>
<a class="text-link" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'Shop legalwear', 'daraz-law-shop' ); ?> ↗</a></aside>
</div>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
