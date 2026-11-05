<?php
/** Terms page; merchant-authored approved legal content. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container"><div class="reading-layout">
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'reading-article' ); ?>><?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'POLICIES', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1></header><div class="entry-content"><?php if ( trim( get_the_content() ) ) { the_content(); } else { esc_html_e( 'Please contact the shop for its current terms of sale. The merchant should add approved terms here before launch.', 'daraz-law-shop' ); } ?></div></article>
<?php endwhile; ?></div></main>
<?php get_footer(); ?>
