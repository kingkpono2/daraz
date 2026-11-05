<?php
/** Post archives. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container">
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'THE JOURNAL', 'daraz-law-shop' ); ?></p><h1><?php the_archive_title(); ?></h1><?php the_archive_description( '<div class="archive-description">', '</div>' ); ?></header>
<?php if ( have_posts() ) : ?><div class="journal-grid"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?></div><?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
</main>
<?php get_footer(); ?>
