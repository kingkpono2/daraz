<?php
/**
 * Conversion improvements built exclusively on live WooCommerce products,
 * stock, prices, variations and links. Never simulate orders or payments.
 *
 * @package Daraz_Law_Shop
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Pre-filled product assistance link, not a bypass for the real checkout. */
function daraz_product_whatsapp_url( $product ) {
	if ( ! is_a( $product, 'WC_Product' ) ) {
		return '';
	}
	$number = daraz_sanitize_digits( get_theme_mod( 'daraz_whatsapp', '2348033910334' ) );
	if ( ! $number ) {
		return '';
	}
	$message = sprintf(
		/* translators: 1: product name, 2: product URL */
		__( "Hello Daraz Law Shop, I'd like guidance on %1\$s.\n%2\$s\nPlease confirm available options, sizing and delivery details.", 'daraz-law-shop' ),
		$product->get_name(),
		get_permalink( $product->get_id() )
	);
	return 'https://wa.me/' . $number . '?text=' . rawurlencode( $message );
}

function daraz_product_whatsapp_enabled() {
	return (bool) get_theme_mod( 'daraz_whatsapp_products', true );
}

function daraz_loop_whatsapp_assistance() {
	if ( ! daraz_product_whatsapp_enabled() ) {
		return;
	}
	global $product;
	$url = daraz_product_whatsapp_url( $product );
	if ( ! $url ) {
		return;
	}
	printf(
		'<a class="daraz-ask-whatsapp" href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s <span aria-hidden="true">↗</span></a>',
		esc_url( $url ),
		esc_attr( sprintf( __( 'Ask about %s on WhatsApp', 'daraz-law-shop' ), $product->get_name() ) ),
		esc_html__( 'Questions? Ask on WhatsApp', 'daraz-law-shop' )
	);
}
add_action( 'woocommerce_after_shop_loop_item', 'daraz_loop_whatsapp_assistance', 20 );

function daraz_single_product_assistance() {
	if ( ! daraz_product_whatsapp_enabled() ) {
		return;
	}
	global $product;
	$url = daraz_product_whatsapp_url( $product );
	if ( ! $url ) {
		return;
	}
	printf(
		'<div class="daraz-product-help"><a class="daraz-help-link" href="%1$s" target="_blank" rel="noopener noreferrer">%2$s <span aria-hidden="true">↗</span></a><p>%3$s</p>',
		esc_url( $url ),
		esc_html__( 'Need help choosing? Chat about this item', 'daraz-law-shop' ),
		esc_html__( 'Ask us about sizing and availability before ordering. Complete payment securely through checkout.', 'daraz-law-shop' )
	);
	$pages = array(
		'size-guide'       => __( 'Size guide', 'daraz-law-shop' ),
		'delivery-returns' => __( 'Delivery & returns', 'daraz-law-shop' ),
	);
	echo '<div class="daraz-purchase-links">';
	foreach ( $pages as $slug => $label ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			printf( '<a href="%1$s">%2$s <span aria-hidden="true">↗</span></a>', esc_url( get_permalink( $page ) ), esc_html( $label ) );
		}
	}
	echo '</div></div>';
}
add_action( 'woocommerce_single_product_summary', 'daraz_single_product_assistance', 36 );

/**
 * Working category and price filters for native WooCommerce archives.
 * WooCommerce itself applies min_price/max_price via its product query;
 * product_cat is its registered public taxonomy query variable.
 */
function daraz_catalogue_filters() {
	if ( ! function_exists( 'is_shop' ) || ! ( is_shop() || is_product_category() || is_product_tag() ) ) {
		return;
	}
	$shop_url = wc_get_page_permalink( 'shop' );
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'exclude'    => array( (int) get_option( 'default_product_cat', 0 ) ),
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );
	if ( is_wp_error( $terms ) ) {
		$terms = array();
	}
	$current_category = isset( $_GET['product_cat'] ) && is_scalar( $_GET['product_cat'] )
		? sanitize_title( wp_unslash( $_GET['product_cat'] ) )
		: ( is_product_category() ? get_queried_object()->slug : '' );
	$min = isset( $_GET['min_price'] ) && is_scalar( $_GET['min_price'] ) ? wc_format_decimal( wp_unslash( $_GET['min_price'] ), 0 ) : '';
	$max = isset( $_GET['max_price'] ) && is_scalar( $_GET['max_price'] ) ? wc_format_decimal( wp_unslash( $_GET['max_price'] ), 0 ) : '';
	?>
	<form class="daraz-archive-filters" method="get" action="<?php echo esc_url( $shop_url ); ?>" role="search" aria-label="<?php esc_attr_e( 'Refine products', 'daraz-law-shop' ); ?>">
		<div class="daraz-filter-heading"><strong><?php esc_html_e( 'Find what fits your practice', 'daraz-law-shop' ); ?></strong><span><?php esc_html_e( 'Filter the collection', 'daraz-law-shop' ); ?></span></div>
		<div class="daraz-filter-fields">
			<label><span><?php esc_html_e( 'Collection', 'daraz-law-shop' ); ?></span>
			<select name="product_cat"><option value=""><?php esc_html_e( 'All products', 'daraz-law-shop' ); ?></option>
			<?php foreach ( $terms as $term ) : ?><option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $term->slug, $current_category ); ?>><?php echo esc_html( $term->name ); ?></option><?php endforeach; ?>
			</select></label>
			<label><span><?php esc_html_e( 'Min. price (₦)', 'daraz-law-shop' ); ?></span><input type="number" min="0" step="1" inputmode="numeric" name="min_price" value="<?php echo esc_attr( $min ); ?>" placeholder="0"></label>
			<label><span><?php esc_html_e( 'Max. price (₦)', 'daraz-law-shop' ); ?></span><input type="number" min="0" step="1" inputmode="numeric" name="max_price" value="<?php echo esc_attr( $max ); ?>" placeholder="—"></label>
			<button type="submit"><?php esc_html_e( 'Apply filters', 'daraz-law-shop' ); ?> ↗</button>
			<a class="daraz-clear-filters" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Clear', 'daraz-law-shop' ); ?></a>
		</div>
	</form>
	<?php
}
add_action( 'woocommerce_before_shop_loop', 'daraz_catalogue_filters', 7 );
add_action( 'woocommerce_no_products_found', 'daraz_catalogue_filters', 7 );

/**
 * No forced default-order links. Honor WooCommerce's configured shipping,
 * payment, coupon, guest checkout and variations handling.
 */
