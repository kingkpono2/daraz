<?php
/**
 * Simple, native WordPress Customizer controls for editable storefront copy.
 *
 * @package Daraz_Law_Shop
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function daraz_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'daraz_homepage', array(
		'title'       => __( 'Daraz homepage', 'daraz-law-shop' ),
		'priority'    => 35,
		'description' => __( 'Edit editorial homepage messaging and imagery without touching code.', 'daraz-law-shop' ),
	) );

	$fields = array(
		'hero_kicker' => array( 'label' => __( 'Hero eyebrow', 'daraz-law-shop' ), 'default' => 'LEGALWEAR FOR A HIGHER STANDARD', 'type' => 'text' ),
		'hero_title'  => array( 'label' => __( 'Hero headline', 'daraz-law-shop' ), 'default' => 'Distinction in every detail.', 'type' => 'text' ),
		'hero_text'   => array( 'label' => __( 'Hero introduction', 'daraz-law-shop' ), 'default' => 'Professional legalwear. Impeccable craftsmanship. For those who uphold more.', 'type' => 'textarea' ),
		'story_title' => array( 'label' => __( 'Story heading', 'daraz-law-shop' ), 'default' => 'Rooted in tradition. Tailored for today.', 'type' => 'text' ),
		'story_text'  => array( 'label' => __( 'Story paragraph', 'daraz-law-shop' ), 'default' => 'We combine heritage and modern craftsmanship to create legalwear that commands respect—in and out of court.', 'type' => 'textarea' ),
	);
	foreach ( $fields as $key => $field ) {
		$id = 'daraz_' . $key;
		$wp_customize->add_setting( $id, array(
			'default'           => $field['default'],
			'sanitize_callback' => 'textarea' === $field['type'] ? 'sanitize_textarea_field' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $field['label'],
			'section' => 'daraz_homepage',
			'type'    => $field['type'],
		) );
	}
	$wp_customize->add_setting( 'daraz_hero_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'daraz_hero_image', array(
		'label' => __( 'Hero photograph (recommended 1600 × 1200)', 'daraz-law-shop' ),
		'section' => 'daraz_homepage',
	) ) );

	$wp_customize->add_section( 'daraz_contact', array(
		'title' => __( 'Daraz contact details', 'daraz-law-shop' ),
		'priority' => 36,
	) );
	$contacts = array(
		'phone'     => array( __( 'Phone (international format)', 'daraz-law-shop' ), '+2348033910334', 'sanitize_text_field' ),
		'email'     => array( __( 'Contact email', 'daraz-law-shop' ), 'info@darazlawshop.com', 'sanitize_email' ),
		'whatsapp'  => array( __( 'WhatsApp number (digits only)', 'daraz-law-shop' ), '2348033910334', 'daraz_sanitize_digits' ),
		'instagram' => array( __( 'Instagram page URL', 'daraz-law-shop' ), 'https://www.instagram.com/darazlawshop/', 'esc_url_raw' ),
		'facebook'  => array( __( 'Facebook page URL', 'daraz-law-shop' ), 'https://web.facebook.com/porthase', 'esc_url_raw' ),
		'x' => array( __( 'X / Twitter profile URL', 'daraz-law-shop' ), 'https://twitter.com/darazlawshop', 'esc_url_raw' ),
	);
	foreach ( $contacts as $key => $values ) {
		$id = 'daraz_' . $key;
		$wp_customize->add_setting( $id, array( 'default' => $values[1], 'sanitize_callback' => $values[2] ) );
		$wp_customize->add_control( $id, array(
			'label' => $values[0],
			'section' => 'daraz_contact',
			'type' => 'text',
		) );
	}

	$wp_customize->add_setting( 'daraz_announcement_message', array(
		'default' => 'Professional legalwear for the Nigerian bar',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'daraz_announcement_message', array(
		'label' => __( 'Announcement bar message', 'daraz-law-shop' ),
		'section' => 'daraz_homepage',
		'type' => 'text',
		'description' => __( 'Mention free shipping or returns only if genuinely offered.', 'daraz-law-shop' ),
	) );

	$wp_customize->add_setting( 'daraz_whatsapp_products', array(
		'default' => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
	) );
	$wp_customize->add_control( 'daraz_whatsapp_products', array(
		'label' => __( 'Product WhatsApp assistance links', 'daraz-law-shop' ),
		'section' => 'daraz_contact',
		'type' => 'checkbox',
		'description' => __( 'Disable if another plugin already shows WhatsApp product buttons.', 'daraz-law-shop' ),
	) );

	$wp_customize->add_section( 'daraz_customer_stories', array(
		'title' => __( 'Verified testimonials', 'daraz-law-shop' ),
		'priority' => 38,
		'description' => __( 'Enter only real customer feedback with permission. Empty testimonials are never shown.', 'daraz-law-shop' ),
	) );
	$wp_customize->add_setting( 'daraz_testimonials_heading', array(
		'default' => 'Trusted for the moments that matter.',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'daraz_testimonials_heading', array(
		'label' => __( 'Testimonials section heading', 'daraz-law-shop' ),
		'section' => 'daraz_customer_stories',
		'type' => 'text',
	) );
	for ( $i = 1; $i <= 3; $i++ ) {
		foreach ( array(
			'quote' => array( __( 'Verified customer quote', 'daraz-law-shop' ), 'sanitize_textarea_field', 'textarea' ),
			'name'  => array( __( 'Approved customer attribution', 'daraz-law-shop' ), 'sanitize_text_field', 'text' ),
		) as $suffix => $field ) {
			$id = 'daraz_testimonial_' . $i . '_' . $suffix;
			$wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => $field[1] ) );
			$wp_customize->add_control( $id, array(
				'label' => sprintf( '%s %d — %s', __( 'Testimonial', 'daraz-law-shop' ), $i, $field[0] ),
				'section' => 'daraz_customer_stories',
				'type' => $field[2],
			) );
		}
	}
	/* Public retail locations retained from the existing Daraz contact page. */
	$wp_customize->add_setting( 'daraz_store_locations', array(
		'default' => "Kano | Shop 1, Maami Market, inside Nigerian Law School, Bagauda, Kano\nIkot Ekpene | 1 Aba Road, opposite Four Points Hotel, Ikot Ekpene, Akwa Ibom\nAbuja (Jabi) | 4th Floor, Room 5, Shashilga Court, Jabi, Abuja\nAbuja (Bwari) | Jegede Market, opposite Nigerian Law School, Bwari, Abuja\nLagos | Hostel Area, Nigerian Law School, Victoria Island, Lagos\nPort Harcourt | 1 Agip Road, opposite Kilimanjaro, near Nigerian Law School, Port Harcourt\nEnugu (Agbani) | Glass Shop, Ojukwu Market, inside Nigerian Law School, Agbani, Enugu",
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'daraz_store_locations', array(
		'label' => __( 'Store locations (one City | Address per line)', 'daraz-law-shop' ),
		'description' => __( 'Initial addresses reflect the previous Daraz website. Confirm and edit before launch; delete unavailable locations.', 'daraz-law-shop' ),
		'section' => 'daraz_contact',
		'type' => 'textarea',
	) );
}
add_action( 'customize_register', 'daraz_customize_register' );

function daraz_sanitize_digits( $number ) {
	return preg_replace( '/[^0-9]/', '', (string) $number );
}
