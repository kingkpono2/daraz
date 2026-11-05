<?php
/** Search results for articles or WooCommerce products. @package Daraz_Law_Shop */
get_header();
$is_product_search = 'product' === get_query_var( 'post_type' ) || ( isset( $_GET['post_type'] ) && 'product' === sanitize_key( wp_unslash( $_GET['post_type'] ) ) );
?>
<main id="primary" class="site-main container content-container<?php echo $is_product_search ? ' woocommerce' : ''; ?>">
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'SEARCH RESULTS', 'daraz-law-shop' ); ?></p><h1><?php printf( esc_html__( 'Results for “%s”', 'daraz-law-shop' ), esc_html( get_search_query() ) ); ?></h1></header>
<?php if ( have_posts() ) :
	if ( $is_product_search && function_exists( 'woocommerce_product_loop_start' ) ) :
		wc_set_loop_prop( 'columns', 3 );
		woocommerce_product_loop_start();
		while ( have_posts() ) : the_post(); wc_get_template_part( 'content', 'product' ); endwhile;
		woocommerce_product_loop_end();
	else : ?>
	<div class="journal-grid"><?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?></div>
	<?php endif;
	the_posts_pagination( array( 'mid_size' => 1 ) );
else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
</main>
<?php get_footer(); ?>
