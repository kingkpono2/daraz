<?php
/** Frequently asked questions page. @package Daraz_Law_Shop */
get_header();
?>
<main id="primary" class="site-main container content-container">
<?php while ( have_posts() ) : the_post(); ?>
<?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'HELP & GUIDANCE', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1><p><?php esc_html_e( 'A few helpful answers before you order.', 'daraz-law-shop' ); ?></p></header>
<div class="info-page-grid"><div>
<?php if ( trim( get_the_content() ) ) : ?><div class="entry-content"><?php the_content(); ?></div><?php else : ?>
<div class="faq-list">
<details><summary><?php esc_html_e( 'How do I choose the right size?', 'daraz-law-shop' ); ?></summary><p><?php esc_html_e( 'Check the measurements in each product description. If you need guidance, contact our team before ordering.', 'daraz-law-shop' ); ?></p></details>
<details><summary><?php esc_html_e( 'How do I know whether an item is available?', 'daraz-law-shop' ); ?></summary><p><?php esc_html_e( 'Product pages show the current availability entered in our shop. Contact us if you need a specific size.', 'daraz-law-shop' ); ?></p></details>
<details><summary><?php esc_html_e( 'Can I view my order?', 'daraz-law-shop' ); ?></summary><p><?php esc_html_e( 'If you checked out with an account, you can review your orders in My Account.', 'daraz-law-shop' ); ?></p></details>
<details><summary><?php esc_html_e( 'What about shipping and returns?', 'daraz-law-shop' ); ?></summary><p><?php esc_html_e( 'Please review our published Delivery & Returns page or contact us for up-to-date details before placing an order.', 'daraz-law-shop' ); ?></p></details>
</div>
<?php endif; ?>
</div><aside class="info-aside"><h2><?php esc_html_e( 'Need another answer?', 'daraz-law-shop' ); ?></h2><p><?php esc_html_e( 'Speak directly with us for help finding the right legalwear.', 'daraz-law-shop' ); ?></p><a class="text-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact our team', 'daraz-law-shop' ); ?> ↗</a></aside></div>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
