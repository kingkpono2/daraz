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
		'instagram' => array( __( 'Instagram page URL', 'daraz-law-shop' ), '', 'esc_url_raw' ),
		'facebook'  => array( __( 'Facebook page URL', 'daraz-law-shop' ), '', 'esc_url_raw' ),
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
}
add_action( 'customize_register', 'daraz_customize_register' );

function daraz_sanitize_digits( $number ) {
	return preg_replace( '/[^0-9]/', '', (string) $number );
}
