<?php
/** Contact page. @package Daraz_Law_Shop */
get_header();
$phone = get_theme_mod( 'daraz_phone', '+2348033910334' );
$email = sanitize_email( get_theme_mod( 'daraz_email', 'info@darazlawshop.com' ) );
$whatsapp = daraz_sanitize_digits( get_theme_mod( 'daraz_whatsapp', '2348033910334' ) );
?>
<main id="primary" class="site-main container content-container">
<?php while ( have_posts() ) : the_post(); ?>
<header class="page-intro"><p class="eyebrow"><?php esc_html_e( 'WE ARE HERE TO HELP', 'daraz-law-shop' ); ?></p><h1><?php the_title(); ?></h1><p><?php esc_html_e( 'Questions about a product, sizing or an existing order? Get in touch.', 'daraz-law-shop' ); ?></p></header>
<div class="contact-cards">
<?php if ( $phone ) : ?><section class="contact-card"><h2><?php esc_html_e( 'Call us', 'daraz-law-shop' ); ?></h2><a href="tel:<?php echo esc_attr( preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></section><?php endif; ?>
<?php if ( $email ) : ?><section class="contact-card"><h2><?php esc_html_e( 'Send an email', 'daraz-law-shop' ); ?></h2><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></section><?php endif; ?>
<?php if ( $whatsapp ) : ?><section class="contact-card"><h2><?php esc_html_e( 'WhatsApp', 'daraz-law-shop' ); ?></h2><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Start a conversation', 'daraz-law-shop' ); ?> ↗</a></section><?php endif; ?>
<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?><section class="contact-card"><h2><?php esc_html_e( 'Your orders', 'daraz-law-shop' ); ?></h2><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'View your account', 'daraz-law-shop' ); ?> ↗</a></section><?php endif; ?>
</div>
<?php if ( trim( get_the_content() ) ) : ?><div class="entry-content reading-layout"><?php the_content(); ?></div><?php endif; ?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
