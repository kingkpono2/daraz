<?php
/** Posts index. @package Daraz_Law_Shop */
get_header(); ?>
<main id="primary" class="site-main container content-container">
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'THE JOURNAL', 'daraz-law-shop' ); ?></p><h1><?php echo esc_html( is_home() && ! is_front_page() ? single_post_title( '', false ) : __( 'Insights & stories', 'daraz-law-shop' ) ); ?></h1></header>
<?php if ( have_posts() ) : ?><div class="journal-grid">
<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?>
</div><?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→' ) ); ?>
<?php else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
</main>
<?php get_footer(); ?>
