<?php
/** Static page template. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container"><div class="reading-layout">
<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'reading-article' ); ?>>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'DARAZ LAW SHOP', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1></header>
<div class="entry-content"><?php the_content(); wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'daraz-law-shop' ), 'after' => '</div>' ) ); ?></div>
</article>
<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; endwhile; ?>
</div></main>
<?php get_footer(); ?>
