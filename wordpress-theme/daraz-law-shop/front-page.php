<?php
/**
 * Editable, database-backed storefront. No prototype products or mock payments.
 *
 * @package Daraz_Law_Shop
 */
get_header();
$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$hero_url = get_theme_mod( 'daraz_hero_image', '' );
?>
<main id="primary" class="site-main">
<section class="home-hero" aria-labelledby="hero-title">
<div class="hero-copy">
<div class="hero-copy-inner">
<p class="eyebrow hero-eyebrow"><?php echo esc_html( get_theme_mod( 'daraz_hero_kicker', 'LEGALWEAR FOR A HIGHER STANDARD' ) ); ?></p>
<h1 id="hero-title"><?php echo esc_html( get_theme_mod( 'daraz_hero_title', 'Distinction in every detail.' ) ); ?></h1>
<p class="hero-lede"><?php echo esc_html( get_theme_mod( 'daraz_hero_text', 'Professional legalwear. Impeccable craftsmanship. For those who uphold more.' ) ); ?></p>
<a class="button button-dark" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop the collection', 'daraz-law-shop' ); ?><span aria-hidden="true">↗</span></a>
<div class="hero-micro"><span>01 — <?php esc_html_e( 'THE COLLECTION', 'daraz-law-shop' ); ?></span><span><?php esc_html_e( 'CRAFTED FOR DISTINCTION', 'daraz-law-shop' ); ?></span></div>
</div>
</div>
<div class="hero-visual">
<?php if ( $hero_url ) : ?>
<img class="hero-uploaded-image" src="<?php echo esc_url( $hero_url ); ?>" alt="<?php esc_attr_e( 'Daraz Law Shop collection', 'daraz-law-shop' ); ?>" fetchpriority="high">
<?php else : ?>
<?php daraz_editorial_crop( '470 59 554 430', 'hero-editorial-image' ); ?>
<?php endif; ?>
<div class="hero-caption"><span><?php esc_html_e( 'THE ART OF APPEARING WELL', 'daraz-law-shop' ); ?></span><span>EST. DARAZ</span></div>
</div>
</section>

<section class="promise-strip" aria-label="<?php esc_attr_e( 'What we stand for', 'daraz-law-shop' ); ?>">
<div class="container promises">
<div class="promise"><span class="promise-icon" aria-hidden="true">◇</span><div><b><?php esc_html_e( 'Purposeful craftsmanship', 'daraz-law-shop' ); ?></b><small><?php esc_html_e( 'Considered in every detail', 'daraz-law-shop' ); ?></small></div></div>
<div class="promise"><span class="promise-icon" aria-hidden="true">✦</span><div><b><?php esc_html_e( 'Professional essentials', 'daraz-law-shop' ); ?></b><small><?php esc_html_e( 'For every stage of practice', 'daraz-law-shop' ); ?></small></div></div>
<div class="promise"><span class="promise-icon" aria-hidden="true">↗</span><div><b><?php esc_html_e( 'Personal assistance', 'daraz-law-shop' ); ?></b><small><?php esc_html_e( 'Sizing and product guidance', 'daraz-law-shop' ); ?></small></div></div>
</div>
</section>

<?php
if ( taxonomy_exists( 'product_cat' ) ) :
	$categories = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => true,
		'number' => 4,
		'orderby' => 'count',
		'order' => 'DESC',
		'exclude' => array( (int) get_option( 'default_product_cat', 0 ) ),
	) );
	if ( ! is_wp_error( $categories ) && $categories ) : ?>
<section class="container editorial-section categories-section" aria-labelledby="categories-heading">
<div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( '01 / THE EDIT', 'daraz-law-shop' ); ?></p><h2 id="categories-heading"><?php esc_html_e( 'Find your distinction.', 'daraz-law-shop' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Discover everything', 'daraz-law-shop' ); ?> <span aria-hidden="true">↗</span></a></div>
<div class="category-grid">
<?php foreach ( $categories as $index => $category ) :
	$thumbnail = (int) get_term_meta( $category->term_id, 'thumbnail_id', true );
	$link = get_term_link( $category );
	if ( is_wp_error( $link ) ) { continue; }
	?>
<a class="category-tile" href="<?php echo esc_url( $link ); ?>">
<div class="category-image">
<?php if ( $thumbnail ) :
	echo wp_get_attachment_image( $thumbnail, 'medium_large', false, array( 'loading' => 'lazy', 'alt' => $category->name ) );
else :
	$boxes = array( '43 507 230 182', '290 507 214 182', '520 507 216 182', '752 507 229 182' );
	daraz_editorial_crop( $boxes[ $index % 4 ], 'category-editorial' );
endif; ?>
</div>
<div class="category-meta"><span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span><h3><?php echo esc_html( $category->name ); ?></h3><span aria-hidden="true">↗</span></div>
</a>
<?php endforeach; ?>
</div>
</section>
<?php endif; endif; ?>

<section class="container editorial-section featured-section" aria-labelledby="featured-heading">
<div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( '02 / THE ESSENTIALS', 'daraz-law-shop' ); ?></p><h2 id="featured-heading"><?php esc_html_e( 'Selected for the profession.', 'daraz-law-shop' ); ?></h2></div><a class="text-link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop all products', 'daraz-law-shop' ); ?> <span aria-hidden="true">↗</span></a></div>
<?php if ( class_exists( 'WooCommerce' ) ) :
	$ids = function_exists( 'wc_get_featured_product_ids' ) ? array_slice( array_map( 'absint', wc_get_featured_product_ids() ), 0, 12 ) : array();
	$args = array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 3, 'no_found_rows' => true );
	if ( $ids ) {
		$args['post__in'] = $ids;
		$args['orderby'] = 'post__in';
	} else {
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	}
	$featured = new WP_Query( $args );
	if ( $featured->have_posts() ) :
		wc_set_loop_prop( 'columns', 3 );
		woocommerce_product_loop_start();
		while ( $featured->have_posts() ) :
			$featured->the_post();
			wc_get_template_part( 'content', 'product' );
		endwhile;
		woocommerce_product_loop_end();
	else : ?>
	<p class="empty-products"><?php esc_html_e( 'The collection is being prepared. Explore our shop or contact us for availability.', 'daraz-law-shop' ); ?></p>
	<?php endif;
	wp_reset_postdata();
else : ?>
<p class="empty-products"><?php esc_html_e( 'Install and activate WooCommerce to display your products here.', 'daraz-law-shop' ); ?></p>
<?php endif; ?>
</section>

<section class="story-panel" aria-labelledby="story-heading">
<div class="story-copy"><div class="story-copy-inner"><p class="eyebrow"><?php esc_html_e( '03 / OUR APPROACH', 'daraz-law-shop' ); ?></p><h2 id="story-heading"><?php echo esc_html( get_theme_mod( 'daraz_story_title', 'Rooted in tradition. Tailored for today.' ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'daraz_story_text', 'We combine heritage and modern craftsmanship to create legalwear that commands respect—in and out of court.' ) ); ?></p><a class="text-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'Discover our story', 'daraz-law-shop' ); ?> <span aria-hidden="true">↗</span></a></div></div>
<div class="story-visual"><?php daraz_editorial_crop( '437 1073 415 268', 'story-editorial-image' ); ?></div>
</section>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	if ( trim( get_the_content() ) ) : ?>
<section class="container home-page-content entry-content"><?php the_content(); ?></section>
<?php endif; endwhile; endif; ?>
</main>
<?php get_footer(); ?>
