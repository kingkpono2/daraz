<?php
/** Global footer. @package Daraz_Law_Shop */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$phone = get_theme_mod( 'daraz_phone', '+2348033910334' );
$email = get_theme_mod( 'daraz_email', 'info@darazlawshop.com' );
$wa    = daraz_sanitize_digits( get_theme_mod( 'daraz_whatsapp', '2348033910334' ) );
?>
<footer id="colophon" class="site-footer">
<div class="container footer-main">
<div class="footer-brand"><div class="footer-mark"><?php daraz_brand(); ?></div><p><?php esc_html_e( 'For those who uphold more. Thoughtfully crafted legalwear, delivered with care.', 'daraz-law-shop' ); ?></p></div>
<div class="footer-column"><h2><?php esc_html_e( 'Explore', 'daraz-law-shop' ); ?></h2>
<ul><li><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>"><?php esc_html_e( 'All legalwear', 'daraz-law-shop' ); ?></a></li>
<?php if ( taxonomy_exists( 'product_cat' ) ) :
	$categories = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 3, 'orderby' => 'count', 'order' => 'DESC' ) );
	if ( ! is_wp_error( $categories ) ) :
		foreach ( $categories as $category ) : ?>
			<li><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></li>
		<?php endforeach;
	endif;
endif; ?>
</ul></div>
<div class="footer-column"><h2><?php esc_html_e( 'Information', 'daraz-law-shop' ); ?></h2>
<?php if ( has_nav_menu( 'footer' ) ) :
	wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-menu', 'depth' => 1 ) );
else : ?>
<ul><li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'Our story', 'daraz-law-shop' ); ?></a></li>
<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'daraz-law-shop' ); ?></a></li>
<?php
$help_links = array(
	'faq'                  => __( 'FAQs', 'daraz-law-shop' ),
	'size-guide'           => __( 'Size guide', 'daraz-law-shop' ),
	'delivery-returns'     => __( 'Delivery & returns', 'daraz-law-shop' ),
	'track-order'          => __( 'Track an order', 'daraz-law-shop' ),
	'privacy-policy'       => __( 'Privacy policy', 'daraz-law-shop' ),
	'terms-and-conditions' => __( 'Terms & conditions', 'daraz-law-shop' ),
);
foreach ( $help_links as $slug => $label ) :
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page instanceof WP_Post && 'publish' === $page->post_status ) :
	?>
<li><a href="<?php echo esc_url( get_permalink( $page ) ); ?>"><?php echo esc_html( $label ); ?></a></li>
<?php endif; endforeach; ?>
<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?><li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My account', 'daraz-law-shop' ); ?></a></li><?php endif; ?></ul>
<?php endif; ?></div>
<div class="footer-column"><h2><?php esc_html_e( 'Get in touch', 'daraz-law-shop' ); ?></h2>
<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
<?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
<div class="footer-social">
<?php foreach ( array( 'instagram' => 'Instagram', 'facebook' => 'Facebook' ) as $field => $label ) :
	$url = get_theme_mod( 'daraz_' . $field, '' );
	if ( $url ) : ?><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $label ); ?> ↗</a><?php endif; ?>
<?php endforeach; ?>
</div></div>
</div>
<div class="container footer-bottom"><span>© <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.</span><span><?php esc_html_e( 'Made for the profession. Built to last.', 'daraz-law-shop' ); ?></span></div>
</footer>
<?php if ( $wa ) : ?>
<a class="wa-pill" href="<?php echo esc_url( 'https://wa.me/' . $wa ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat via WhatsApp', 'daraz-law-shop' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.5 11.6a8.5 8.5 0 0 1-12.7 7.3L3 20.3l1.4-4.6A8.5 8.5 0 1 1 20.5 11.6Z"/><path d="M8 7.5c-.8.4-1 1.3-.5 2.7 1 2.6 3.3 4.8 5.9 5.4 1.4.4 2.4-.3 2.6-1.5l-2.7-1.3-1 1c-1.8-.8-2.7-1.8-3.2-3.1l.8-1L8.8 7.5Z"/></svg><span><?php esc_html_e( 'Need help?', 'daraz-law-shop' ); ?></span></a>
<?php endif; ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
