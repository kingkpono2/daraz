<?php
/**
 * Editable, database-backed storefront. No prototype products or mock payments.
 *
 * @package Daraz_Law_Shop
 */
get_header();
$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
/*
 * Curated, genuine photographs from darazlawshop.com. The same hero split
 * remains 46% typography / 54% image. Build script creates optimized,
 * subject-aware desktop/mobile crops; uploaded WP images can override each.
 */
$slide_images = array(
	array(
		'asset' => 'hero-legalwear',
		'alt' => __( 'Three Daraz Law Shop legal professionals in court gowns and bands with barrister wigs', 'daraz-law-shop' ),
		'caption' => __( 'Legalwear with distinction', 'daraz-law-shop' ),
		'source' => 'https://www.darazlawshop.com/wp-content/uploads/2024/01/406201635_936988071199897_5211724824284611170_n.jpg',
	),
	array(
		'asset' => 'hero-professional',
		'alt' => __( 'Legal professional in a Daraz gown with court bands and a barrister wig', 'daraz-law-shop' ),
		'caption' => __( 'Crafted for the profession', 'daraz-law-shop' ),
		'source' => 'https://www.darazlawshop.com/wp-content/uploads/2024/01/405773936_934089611489743_1822998598057115461_n.jpg',
	),
	array(
		'asset' => 'hero-community',
		'alt' => __( 'Two legal professionals holding Daraz Law Shop branded shopping bags', 'daraz-law-shop' ),
		'caption' => __( 'Meet the Daraz community', 'daraz-law-shop' ),
		'source' => 'https://www.darazlawshop.com/wp-content/uploads/2024/01/294799034_5696098660402172_2739760369760199759_n-1.jpg',
	),
);
?>
<main id="primary" class="site-main">
<section class="home-hero" aria-labelledby="hero-title">
<div class="hero-copy">
<div class="hero-copy-inner">
<p class="eyebrow hero-eyebrow"><?php echo esc_html( get_theme_mod( 'daraz_hero_kicker', 'LEGALWEAR FOR A HIGHER STANDARD' ) ); ?></p>
<h1 id="hero-title"><?php echo esc_html( get_theme_mod( 'daraz_hero_title', 'Distinction in every detail.' ) ); ?></h1>
<p class="hero-lede"><?php echo esc_html( get_theme_mod( 'daraz_hero_text', 'Professional legalwear. Impeccable craftsmanship. For those who uphold more.' ) ); ?></p>
<div class="hero-cta-row"><a class="button button-dark" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop the collection', 'daraz-law-shop' ); ?><span aria-hidden="true">↗</span></a><a class="hero-help-cta" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Need guidance?', 'daraz-law-shop' ); ?> ↗</a></div>
<div class="hero-micro"><span>01 — <?php esc_html_e( 'THE COLLECTION', 'daraz-law-shop' ); ?></span><span><?php esc_html_e( 'CRAFTED FOR DISTINCTION', 'daraz-law-shop' ); ?></span></div>
</div>
</div>
<div class="hero-visual hero-gallery" data-daraz-slider data-interval="6800" role="region" aria-roledescription="<?php esc_attr_e( 'carousel', 'daraz-law-shop' ); ?>" aria-label="<?php esc_attr_e( 'Daraz Law Shop real customer and product photography', 'daraz-law-shop' ); ?>">
<div class="hero-gallery-track">
<?php foreach ( $slide_images as $index => $slide ) :
	$number = $index + 1;
	$slide['caption'] = get_theme_mod( 'daraz_slide_' . $number . '_caption', $slide['caption'] );
	$desktop_file = '/assets/images/hero/' . $slide['asset'] . '.webp';
	$mobile_file  = '/assets/images/hero/' . $slide['asset'] . '-mobile.webp';
	$desktop_url = file_exists( get_theme_file_path( $desktop_file ) ) ? get_theme_file_uri( $desktop_file ) : $slide['source'];
	$mobile_url = file_exists( get_theme_file_path( $mobile_file ) ) ? get_theme_file_uri( $mobile_file ) : '';
	$custom_url = get_theme_mod( 'daraz_slide_' . $number . '_image', '' );
	if ( 1 === $number && ! $custom_url ) {
		$custom_url = get_theme_mod( 'daraz_hero_image', '' );
	}
	$asset = $custom_url ? $custom_url : $desktop_url;
	$is_initial = 0 === $index;
	?>
<div class="hero-gallery-slide<?php echo $is_initial ? ' is-active' : ''; ?>" role="group" aria-roledescription="<?php esc_attr_e( 'slide', 'daraz-law-shop' ); ?>" aria-label="<?php echo esc_attr( sprintf( __( '%1$d of %2$d', 'daraz-law-shop' ), $number, count( $slide_images ) ) ); ?>" aria-hidden="<?php echo $is_initial ? 'false' : 'true'; ?>" data-slide-caption="<?php echo esc_attr( $slide['caption'] ); ?>">
<?php if ( $custom_url ) :
	$attachment_id = attachment_url_to_postid( $custom_url );
	if ( $attachment_id ) {
		echo wp_get_attachment_image( $attachment_id, 'daraz_hero', false, array(
			'class' => 'hero-gallery-photo',
			'alt' => $slide['alt'],
			'loading' => $is_initial ? 'eager' : 'lazy',
			'fetchpriority' => $is_initial ? 'high' : 'low',
			'decoding' => 'async',
			'sizes' => '(max-width: 700px) 100vw, 54vw',
		) );
	} else {
		printf( '<img class="hero-gallery-photo" src="%1$s" alt="%2$s" width="1300" height="1040" loading="%3$s" decoding="async"%4$s>', esc_url( $custom_url ), esc_attr( $slide['alt'] ), $is_initial ? 'eager' : 'lazy', $is_initial ? ' fetchpriority="high"' : '' );
	}
else : ?>
<picture>
<?php if ( $mobile_url ) : ?><source media="(max-width: 700px)" srcset="<?php echo esc_url( $mobile_url ); ?>" type="image/webp"><?php endif; ?>
<img class="hero-gallery-photo" src="<?php echo esc_url( $asset ); ?>" alt="<?php echo esc_attr( $slide['alt'] ); ?>" width="1300" height="1040" loading="<?php echo $is_initial ? 'eager' : 'lazy'; ?>" decoding="async"<?php echo $is_initial ? ' fetchpriority="high"' : ''; ?>>
</picture>
<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<div class="hero-gallery-gradient" aria-hidden="true"></div>
<div class="hero-gallery-eyebrow" aria-hidden="true"><span class="hero-gallery-rule"></span><?php esc_html_e( 'THE DARAZ EDIT', 'daraz-law-shop' ); ?></div>
<div class="hero-caption"><span class="hero-gallery-caption"><?php echo esc_html( get_theme_mod( 'daraz_slide_1_caption', $slide_images[0]['caption'] ) ); ?></span><span>DARAZ LAW SHOP</span></div>
<div class="hero-gallery-controls" aria-label="<?php esc_attr_e( 'Slideshow controls', 'daraz-law-shop' ); ?>">
<button class="hero-gallery-arrow" type="button" data-slide-prev aria-label="<?php esc_attr_e( 'Previous photograph', 'daraz-law-shop' ); ?>" title="<?php esc_attr_e( 'Previous', 'daraz-law-shop' ); ?>"><span aria-hidden="true">←</span></button>
<div class="hero-gallery-dots" role="group" aria-label="<?php esc_attr_e( 'Choose photograph', 'daraz-law-shop' ); ?>">
<?php foreach ( $slide_images as $index => $slide ) : ?>
<button type="button" class="hero-gallery-dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide-to="<?php echo esc_attr( $index ); ?>" aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show photograph %d', 'daraz-law-shop' ), $index + 1 ) ); ?>"><span></span></button>
<?php endforeach; ?>
</div>
<button class="hero-gallery-arrow" type="button" data-slide-next aria-label="<?php esc_attr_e( 'Next photograph', 'daraz-law-shop' ); ?>" title="<?php esc_attr_e( 'Next', 'daraz-law-shop' ); ?>"><span aria-hidden="true">→</span></button>
<span class="hero-gallery-counter" aria-hidden="true"><span data-slide-current>01</span><span class="hero-gallery-counter-slash">/</span><?php echo esc_html( sprintf( '%02d', count( $slide_images ) ) ); ?></span>
</div>
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
<?php
if ( ! $thumbnail ) {
	$sample_images = get_posts( array(
		'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 1,
		'fields' => 'ids', 'no_found_rows' => true,
		'tax_query' => array( array( 'taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => (int) $category->term_id ) ),
		'meta_query' => array( array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ) ),
	) );
	if ( $sample_images ) {
		$thumbnail = (int) get_post_thumbnail_id( $sample_images[0] );
	}
}
if ( $thumbnail ) {
	echo wp_get_attachment_image( $thumbnail, 'medium_large', false, array(
		'loading' => 'lazy',
		'alt' => $category->name . ' — ' . __( 'browse collection', 'daraz-law-shop' ),
		'sizes' => '(max-width: 980px) 50vw, 25vw',
	) );
} else {
	echo '<div class="category-no-photo" aria-hidden="true"><span>DARAZ</span><small>LAW SHOP</small></div>';
}
?>
</div>
<div class="category-meta"><span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span><h3><?php echo esc_html( $category->name ); ?></h3><span aria-hidden="true">↗</span></div>
</a>
<?php endforeach; ?>
</div>
</section>
<?php endif; endif; ?>

<section class="container editorial-section featured-section woocommerce" aria-labelledby="featured-heading">
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

<section class="container search-intent-section" aria-labelledby="legalwear-guide-heading">
<div class="search-intent-copy">
<p class="eyebrow"><?php esc_html_e( 'THE PRACTICE / THE DETAILS', 'daraz-law-shop' ); ?></p>
<h2 id="legalwear-guide-heading"><?php esc_html_e( 'Legalwear for the Nigerian bar.', 'daraz-law-shop' ); ?></h2>
<p><?php esc_html_e( 'Explore essential legalwear and professional resources in Nigeria, from barrister wigs and gowns to court bands, legal books and courtroom accessories. Each product page provides available options, prices and details to help you choose what suits your practice.', 'daraz-law-shop' ); ?></p>
<a class="text-link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse professional legalwear', 'daraz-law-shop' ); ?> ↗</a>
</div>
<div class="search-intent-aside">
<h3><?php esc_html_e( 'A considered fit starts here.', 'daraz-law-shop' ); ?></h3>
<p><?php esc_html_e( 'Choosing a gown or another essential? Review our size guidance, explore the catalogue, or ask a question before placing your order.', 'daraz-law-shop' ); ?></p>
<?php
$size_guide = get_page_by_path( 'size-guide', OBJECT, 'page' );
$faq_page = get_page_by_path( 'faq', OBJECT, 'page' );
?>
<?php if ( $size_guide && 'publish' === $size_guide->post_status ) : ?><a href="<?php echo esc_url( get_permalink( $size_guide ) ); ?>"><?php esc_html_e( 'Size guide', 'daraz-law-shop' ); ?> ↗</a><?php endif; ?>
<?php if ( $faq_page && 'publish' === $faq_page->post_status ) : ?><a href="<?php echo esc_url( get_permalink( $faq_page ) ); ?>"><?php esc_html_e( 'Frequently asked questions', 'daraz-law-shop' ); ?> ↗</a><?php endif; ?>
</div>
</section>

<section class="story-panel" aria-labelledby="story-heading">
<div class="story-copy"><div class="story-copy-inner"><p class="eyebrow"><?php esc_html_e( '03 / OUR APPROACH', 'daraz-law-shop' ); ?></p><h2 id="story-heading"><?php echo esc_html( get_theme_mod( 'daraz_story_title', 'Rooted in tradition. Tailored for today.' ) ); ?></h2><p><?php echo esc_html( get_theme_mod( 'daraz_story_text', 'We combine heritage and modern craftsmanship to create legalwear that commands respect—in and out of court.' ) ); ?></p><a class="text-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'Discover our story', 'daraz-law-shop' ); ?> <span aria-hidden="true">↗</span></a></div></div>
<div class="story-visual"><?php daraz_editorial_crop( '437 1073 415 268', 'story-editorial-image' ); ?></div>
</section>

<?php
$daraz_testimonials = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$quote = trim( (string) get_theme_mod( 'daraz_testimonial_' . $i . '_quote', '' ) );
	$name = trim( (string) get_theme_mod( 'daraz_testimonial_' . $i . '_name', '' ) );
	if ( $quote && $name ) {
		$daraz_testimonials[] = array( 'quote' => $quote, 'name' => $name );
	}
}
if ( $daraz_testimonials ) : ?>
<section class="customer-voices" aria-labelledby="customer-voices-heading">
<div class="container">
<div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( 'REAL CUSTOMER STORIES', 'daraz-law-shop' ); ?></p><h2 id="customer-voices-heading"><?php echo esc_html( get_theme_mod( 'daraz_testimonials_heading', 'Trusted for the moments that matter.' ) ); ?></h2></div></div>
<div class="voice-grid"><?php foreach ( $daraz_testimonials as $testimonial ) : ?>
<figure class="voice-card"><blockquote>“<?php echo esc_html( $testimonial['quote'] ); ?>”</blockquote><figcaption><?php echo esc_html( $testimonial['name'] ); ?></figcaption></figure>
<?php endforeach; ?></div>
</div></section>
<?php endif; ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	if ( trim( get_the_content() ) && ! preg_match( '/\[(?:vc_row|vc_column|nectar_|rev_slider|salient_)/i', get_the_content() ) ) : ?>
<section class="container home-page-content entry-content"><?php the_content(); ?></section>
<?php endif; endwhile; endif; ?>
</main>
<?php get_footer(); ?>
