<?php
/** Journal post template. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container"><div class="reading-layout">
<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'reading-article' ); ?>>
<?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'FROM THE JOURNAL', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1><?php daraz_post_meta(); ?></header>
<?php if ( has_post_thumbnail() ) : ?><figure class="single-featured"><?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?></figure><?php endif; ?>
<div class="entry-content"><?php the_content(); wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'daraz-law-shop' ), 'after' => '</div>' ) ); ?></div>
<footer class="article-footer"><?php the_tags( '<div class="post-tags">', ' · ', '</div>' ); ?></footer>
</article>
<div class="post-navigation"><?php the_post_navigation( array( 'prev_text' => '← %title', 'next_text' => '%title →' ) ); ?></div>
<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; endwhile; ?>
</div></main>
<?php get_footer(); ?>
