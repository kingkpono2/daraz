<?php
/** Contact page. @package Daraz_Law_Shop */
get_header();
$phone = get_theme_mod( 'daraz_phone', '+2348033910334' );
$email = sanitize_email( get_theme_mod( 'daraz_email', 'info@darazlawshop.com' ) );
$whatsapp = daraz_sanitize_digits( get_theme_mod( 'daraz_whatsapp', '2348033910334' ) );
?>
<main id="primary" class="site-main container content-container">
<?php while ( have_posts() ) : the_post(); ?>
<?php daraz_seo_breadcrumbs(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'WE ARE HERE TO HELP', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1><p><?php esc_html_e( 'Questions about a product, sizing or an existing order? Get in touch.', 'daraz-law-shop' ); ?></p></header>
<div class="contact-cards">
<?php if ( $phone ) : ?><section class="contact-card"><h2><?php esc_html_e( 'Call us', 'daraz-law-shop' ); ?></h2><a href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></section><?php endif; ?>
<?php if ( $email ) : ?><section class="contact-card"><h2><?php esc_html_e( 'Send an email', 'daraz-law-shop' ); ?></h2><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></section><?php endif; ?>
<?php if ( $whatsapp ) : ?><section class="contact-card"><h2><?php esc_html_e( 'WhatsApp', 'daraz-law-shop' ); ?></h2><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Start a conversation', 'daraz-law-shop' ); ?> ↗</a></section><?php endif; ?>
<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?><section class="contact-card"><h2><?php esc_html_e( 'Your orders', 'daraz-law-shop' ); ?></h2><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'View your account', 'daraz-law-shop' ); ?> ↗</a></section><?php endif; ?>
</div>

<?php
$raw_locations = get_theme_mod( 'daraz_store_locations', "Kano | Shop 1, Maami Market, inside Nigerian Law School, Bagauda, Kano\nIkot Ekpene | 1 Aba Road, opposite Four Points Hotel, Ikot Ekpene, Akwa Ibom\nAbuja (Jabi) | 4th Floor, Room 5, Shashilga Court, Jabi, Abuja\nAbuja (Bwari) | Jegede Market, opposite Nigerian Law School, Bwari, Abuja\nLagos | Hostel Area, Nigerian Law School, Victoria Island, Lagos\nPort Harcourt | 1 Agip Road, opposite Kilimanjaro, near Nigerian Law School, Port Harcourt\nEnugu (Agbani) | Glass Shop, Ojukwu Market, inside Nigerian Law School, Agbani, Enugu" );
$locations = array();
foreach ( preg_split( '/\r\n|\r|\n/', (string) $raw_locations ) as $line ) {
	$parts = array_map( 'trim', explode( '|', $line, 2 ) );
	if ( count( $parts ) === 2 && $parts[0] && $parts[1] ) {
		$locations[] = $parts;
	}
}
if ( $locations ) : ?>
<section class="locations-section" aria-labelledby="locations-heading">
<div class="section-heading"><div><p class="eyebrow"><?php esc_html_e( 'VISIT US', 'daraz-law-shop' ); ?></p><h2 id="locations-heading"><?php esc_html_e( 'Find Daraz near you.', 'daraz-law-shop' ); ?></h2></div></div>
<div class="locations-grid">
<?php foreach ( $locations as $location ) : ?>
<article class="location-card">
<span class="eyebrow"><?php esc_html_e( 'STORE LOCATION', 'daraz-law-shop' ); ?></span>
<h3><?php echo esc_html( $location[0] ); ?></h3>
<address><?php echo esc_html( $location[1] ); ?></address>
<a href="<?php echo esc_url( 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $location[1] ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Find on Google Maps', 'daraz-law-shop' ); ?> ↗</a>
</article>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<?php if ( trim( get_the_content() ) && ! preg_match( '/\[(?:vc_row|vc_column|nectar_|rev_slider|salient_)/i', get_the_content() ) ) : ?><div class="entry-content reading-layout"><?php the_content(); ?></div><?php endif; ?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
